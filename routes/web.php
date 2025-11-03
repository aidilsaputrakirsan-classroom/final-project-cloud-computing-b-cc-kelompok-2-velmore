<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi, termasuk login, dashboard, pengguna, dan buku.
|--------------------------------------------------------------------------
*/

// =========================
// 🔐 AUTHENTIKASI
// =========================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// =========================
// 🧩 DASHBOARD
// =========================
Route::get('/dashboard.admin', function () {
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Silakan login sebagai admin!');
    }
    return view('dashboard.admin');
})->name('dashboard.admin');

Route::get('/dashboard.user', function () {
    if (!session()->has('user')) {
        return redirect('/')->with('error', 'Silakan login sebagai pengguna!');
    }
    return view('dashboard.user');
})->name('dashboard.user');


// =========================
// 👥 PENGELOLAAN PENGGUNA (ADMIN SAJA)
// =========================
Route::middleware([])->group(function () {
    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna/tambah', [UserController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/edit/{id}', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::post('/pengguna/update/{id}', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/delete/{id}', [UserController::class, 'destroy'])->name('pengguna.delete');
});


// 📚 MANAJEMEN BUKU (ADMIN SAJA)
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.tambah');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show'); // 🟢 penting!
Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

