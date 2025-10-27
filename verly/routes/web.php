<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
