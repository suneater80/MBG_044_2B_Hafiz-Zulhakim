<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//tampilan awal Dapur
Route::get('/dapur', function () {
    if (!session('role') || session('role') !== 'dapur') {
        return redirect('/login');
    }
    return view('dapur.dashboard');
});