<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PermintaanController extends Controller
{
    // Tampilkan form permintaan
    public function create()
    {
        if (session('role') !== 'dapur') {
            return redirect('/login');
        }

        // Ambil daftar bahan yang layak dengan aturan stok > 0 dan tidak kadaluarsa, yang dihitung secara real time
        $allBahan = DB::table('bahan_baku')->get();
        $today = date('Y-m-d');
        $bahanLayak = [];

        foreach ($allBahan as $b) {
            $stok = $b->jumlah;
            $exp = $b->tanggal_kadaluarsa;

            if ($stok <= 0) continue;
            if ($today >= $exp) continue; // kadaluarsa

            $bahanLayak[] = $b;
        }

        return view('dapur.buat_permintaan', compact('bahanLayak'));
    }

    // Simpan permintaan
    public function store(Request $request)
    {
        if (session('role') !== 'dapur') {
            return redirect('/login');
        }

        $request->validate([
            'tgl_masak' => 'required|date',
            'menu_makan' => 'required',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan_id' => 'required|array',
            'jumlah_diminta' => 'required|array',
            'jumlah_diminta.*' => 'required|integer|min:1',
        ]);

        // Simpan header permintaan
        $permintaanId = DB::table('permintaan')->insertGetId([
            'pemohon_id' => session('user_id'),
            'tgl_masak' => $request->tgl_masak,
            'menu_makan' => $request->menu_makan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'status' => 'menunggu',
            'created_at' => now(),
        ]);

        // Simpan detail
        foreach ($request->bahan_id as $index => $bahanId) {
            $jumlah = $request->jumlah_diminta[$index];
            DB::table('permintaan_detail')->insert([
                'permintaan_id' => $permintaanId,
                'bahan_id' => $bahanId,
                'jumlah_diminta' => $jumlah,
            ]);
        }

        return redirect('/dapur')->with('success', 'Permintaan bahan berhasil diajukan.');
    }

    // Lihat Status permintaan
    public function index()
    {
        if (session('role') !== 'dapur') {
            return redirect('/login');
        }

        // Ambil semua permintaan milik user (dapur)
        $permintaanList = DB::table('permintaan')
            ->where('pemohon_id', session('user_id'))
            ->orderBy('created_at', 'desc')
            ->get();

        // Untuk setiap permintaan, ambil detail bahannya
        foreach ($permintaanList as $permintaan) {
            $permintaan->detail = DB::table('permintaan_detail as pd')
                ->join('bahan_baku as bb', 'pd.bahan_id', '=', 'bb.id')
                ->where('pd.permintaan_id', $permintaan->id)
                ->select('bb.nama as nama_bahan', 'pd.jumlah_diminta', 'bb.satuan')
                ->get();
        }

        return view('dapur.lihat_status', compact('permintaanList'));
    }
}