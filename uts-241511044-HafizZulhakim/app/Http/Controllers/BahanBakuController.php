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

}
