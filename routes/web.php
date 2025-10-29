<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


// ✅ Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ Dashboard Admin
Route::get('/dashboard-admin', function () {
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Silakan login sebagai admin!');
    }
    return view('dashboard-admin');
})->name('dashboard.admin');

// ✅ Dashboard Pengguna
Route::get('/dashboard-user', function () {
    if (!session()->has('user')) {
        return redirect('/')->with('error', 'Silakan login sebagai pengguna!');
    }
    return view('dashboard-user');
})->name('dashboard.user');

// ✅ Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard-admin', function () {
    if (!session()->has('admin')) return redirect('/')->with('error', 'Silakan login sebagai admin.');
    return view('dashboard.admin');
});

Route::get('/dashboard-user', function () {
    if (!session()->has('user')) return redirect('/')->with('error', 'Silakan login sebagai pengguna.');
    return view('dashboard.user');
});

Route::get('/pengguna', function () {
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Akses ditolak! Hanya admin yang boleh.');
    }
    return view('admin.data-pengguna');
});

Route::middleware([])->group(function () {
Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('pengguna.create');
Route::post('/pengguna/tambah', [UserController::class, 'store'])->name('pengguna.store');
Route::get('/pengguna/edit/{id}', [UserController::class, 'edit'])->name('pengguna.edit');
Route::post('/pengguna/update/{id}', [UserController::class, 'update'])->name('pengguna.update');
Route::delete('/pengguna/delete/{id}', [UserController::class, 'destroy'])->name('pengguna.delete');
});

