<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;

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
Route::get('/gudang/bahan', [BahanBakuController::class, 'index']);

//tampilan awal Dapur
Route::get('/dapur', function () {
    if (!session('role') || session('role') !== 'dapur') {
        return redirect('/login');
    }
    return view('dapur.dashboard');
});