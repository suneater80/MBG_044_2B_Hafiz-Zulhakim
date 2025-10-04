<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PermintaanController;


Route::get('/', function () {
    return redirect('/login');
});
//Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
//Logot
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//tampilan awal Gudang
Route::get('/gudang', function () {
    if (!session('role') || session('role') !== 'gudang') {
        return redirect('/login');
    }
    return view('gudang.dashboard');
});

//menambahkan bahan baku pada gudang
Route::get('/gudang/bahan/tambah', [BahanBakuController::class, 'create']);
Route::post('/gudang/bahan/simpan', [BahanBakuController::class, 'store']);

//menampilkan bahan baku
Route::get('/gudang/bahan', [BahanBakuController::class, 'index']);

//update stock bahan baju
Route::get('/gudang/bahan/{id}/edit-stok', [BahanBakuController::class, 'editStok']);
Route::post('/gudang/bahan/{id}/update-stok', [BahanBakuController::class, 'updateStok']);

//menghapus stock yang kadaluarsa
Route::get('/gudang/bahan/{id}/hapus', [BahanBakuController::class, 'confirmHapus']);
Route::post('/gudang/bahan/{id}/proses-hapus', [BahanBakuController::class, 'hapus']);



//tampilan awal Dapur
Route::get('/dapur', function () {
    if (!session('role') || session('role') !== 'dapur') {
        return redirect('/login');
    }
    return view('dapur.dashboard');
});

//membuat permintaan bahan baku
Route::get('/dapur/permintaan/buat', [PermintaanController::class, 'create']);
Route::post('/dapur/permintaan/simpan', [PermintaanController::class, 'store']);

//melihat status permintaan
Route::get('/dapur/permintaan', [PermintaanController::class, 'index']);