<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanBakuController extends Controller
{
    //membuat form menambah bahan baku
    public function create()
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }
        return view('gudang.tambah_bahan_baku');
    }

    //menyimpan data bahan baku
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_masuk',
        ]);

        //status awal adalah tersedia
        $status = 'tersedia';

        DB::table('bahan_baku')->insert([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => $status,
            'created_at' => now(),
        ]);

        return redirect('/gudang')->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function index()
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        //mengambil semua data bahan baku
        $bahanList = DB::table('bahan_baku')->get();

        //menentukan ulang status setiap bahan
        $bahanDenganStatus = [];
        $today = date('Y-m-d');

        foreach ($bahanList as $b) {
            $stok = $b->jumlah;
            $exp = $b->tanggal_kadaluarsa;

            if ($stok == 0) {
                $status = 'habis';
            } elseif ($today >= $exp) {
                $status = 'kadaluarsa';
            } elseif (strtotime($exp) - strtotime($today) <= 3 * 24 * 60 * 60) {
                $status = 'segera_kadaluarsa';
            } else {
                $status = 'tersedia';
            }

            //menambahkan properti status baru
            $b->status_real = $status;
            $bahanDenganStatus[] = $b;
        }

        return view('gudang.lihat_bahan', compact('bahanDenganStatus'));
    }

    //menampilkan form edit stok
    public function editStok($id)
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        $bahan = DB::table('bahan_baku')->where('id', $id)->first();
        if (!$bahan) {
            return redirect('/gudang/bahan')->withErrors('Bahan tidak ditemukan.');
        }

        return view('gudang.edit_stok', compact('bahan'));
    }

    //proses update stok
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:0',
        ]);

        $jumlahBaru = $request->jumlah;

        // Update hanya kolom jumlah
        DB::table('bahan_baku')->where('id', $id)->update([
            'jumlah' => $jumlahBaru,
        ]);

        return redirect('/gudang/bahan')->with('success', 'Stok berhasil diperbarui.');
    }

    //menampilkan konfirmasi hapus bahan baku
    public function confirmHapus($id)
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        $bahan = DB::table('bahan_baku')->where('id', $id)->first();
        if (!$bahan) {
            return redirect('/gudang/bahan')->withErrors('Bahan tidak ditemukan.');
        }

        // Hitung status real time status bahan baku 
        $today = date('Y-m-d');
        $stok = $bahan->jumlah;
        $exp = $bahan->tanggal_kadaluarsa;

        if ($stok == 0) {
            $status = 'habis';
        } elseif ($today >= $exp) {
            $status = 'kadaluarsa';
        } elseif (strtotime($exp) - strtotime($today) <= 3 * 24 * 60 * 60) {
            $status = 'segera_kadaluarsa';
        } else {
            $status = 'tersedia';
        }

        //jika tidak kadaluarsa, maka tolak
        if ($status !== 'kadaluarsa') {
            return redirect('/gudang/bahan')->withErrors('Hanya bahan kadaluarsa yang boleh dihapus.');
        }

        return view('gudang.hapus_bahan', compact('bahan'));
    }
    
    //proses penghapusan bahan baku
    public function hapus($id)
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        //memastikan bahan baku sudah kadaluarsa
        $bahan = DB::table('bahan_baku')->where('id', $id)->first();
        if (!$bahan) {
            return redirect('/gudang/bahan')->withErrors('Bahan tidak ditemukan.');
        }

        $today = date('Y-m-d');
        if ($today < $bahan->tanggal_kadaluarsa) {
            return redirect('/gudang/bahan')->withErrors('Hanya bahan kadaluarsa yang boleh dihapus.');
        }

        DB::table('bahan_baku')->where('id', $id)->delete();

        return redirect('/gudang/bahan')->with('success', 'Bahan baku berhasil dihapus.');
    }

}
