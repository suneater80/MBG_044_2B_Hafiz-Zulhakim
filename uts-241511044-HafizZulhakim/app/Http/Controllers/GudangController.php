<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GudangController extends Controller
{
    // Tampilkan daftar permintaan menunggu
    public function kelolaPermintaan()
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        $permintaanList = DB::table('permintaan as p')
            ->join('user as u', 'p.pemohon_id', '=', 'u.id')
            ->where('p.status', 'menunggu')
            ->select('p.*', 'u.name as nama_dapur')
            ->orderBy('p.created_at', 'desc')
            ->get();

        // Tambahkan detail bahan untuk setiap permintaan
        foreach ($permintaanList as $p) {
            $p->detail = DB::table('permintaan_detail as pd')
                ->join('bahan_baku as bb', 'pd.bahan_id', '=', 'bb.id')
                ->where('pd.permintaan_id', $p->id)
                ->select('bb.nama as nama_bahan', 'pd.jumlah_diminta', 'bb.satuan', 'bb.jumlah as stok_tersedia')
                ->get();
        }

        return view('gudang.kelola_permintaan', compact('permintaanList'));
    }

    // Proses ACC
    public function accPermintaan($id)
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        // Ambil detail permintaan
        $permintaan = DB::table('permintaan')->where('id', $id)->first();
        if (!$permintaan || $permintaan->status !== 'menunggu') {
            return back()->withErrors('Permintaan tidak valid.');
        }

        $detail = DB::table('permintaan_detail as pd')
            ->join('bahan_baku as bb', 'pd.bahan_id', '=', 'bb.id')
            ->where('pd.permintaan_id', $id)
            ->select('pd.bahan_id', 'pd.jumlah_diminta', 'bb.jumlah as stok_sekarang', 'bb.nama')
            ->get();

        // Validasi stok
        foreach ($detail as $d) {
            if ($d->stok_sekarang < $d->jumlah_diminta) {
                return back()->withErrors("Stok '{$d->nama}' tidak cukup! Tersedia: {$d->stok_sekarang}, Diminta: {$d->jumlah_diminta}");
            }
        }

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Kurangi stok
            foreach ($detail as $d) {
                $stokBaru = $d->stok_sekarang - $d->jumlah_diminta;
                DB::table('bahan_baku')->where('id', $d->bahan_id)->update([
                    'jumlah' => $stokBaru,
                ]);
            }

            // Update status permintaan
            DB::table('permintaan')->where('id', $id)->update([
                'status' => 'disetujui'
            ]);

            DB::commit();
            return redirect('/gudang/permintaan')->with('success', 'Permintaan berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Terjadi kesalahan saat memproses ACC.');
        }
    }

    // Proses Tolak
    public function tolakPermintaan($id)
    {
        if (session('role') !== 'gudang') {
            return redirect('/login');
        }

        DB::table('permintaan')->where('id', $id)->update([
            'status' => 'ditolak'
        ]);

        return redirect('/gudang/permintaan')->with('success', 'Permintaan ditolak.');
    }
}