<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ✅ Saat buka root "/" langsung tampil login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

// ✅ Tampilkan halaman login kalau akses /login langsung
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.page');

// ✅ Proses form login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// ✅ Dashboard (hanya bisa diakses setelah login)
Route::get('/dashboard', function () {
    // ✅ Cek session admin
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
    }

    // ✅ Jika ada session admin, tampilkan dashboard
    return view('dashboard');
})->name('dashboard');

// ✅ Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
