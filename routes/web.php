<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardAdminController;


// =====================================================
// 🔐 AUTENTIKASI
// =====================================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])
    ->name('dashboard.admin');

Route::get('/dashboard-user', [PeminjamanController::class, 'dashboard'])->name('dashboard.user');

// =====================================================
// 👥 MANAJEMEN PENGGUNA (ADMIN)
// =====================================================
Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('pengguna.tambah');
Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
Route::post('/pengguna/{id}/update', [UserController::class, 'update'])->name('pengguna.update');
Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

// =====================================================
// 📚 MANAJEMEN BUKU
// =====================================================
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.tambah');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');

// =====================================================
// 📖 PEMINJAMAN (USER)
// =====================================================
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create/{id_buku}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::post('/pengembalian/simpan', [PengembalianController::class, 'simpan']);

Route::get('/peminjaman', [PeminjamanController::class, 'adminIndex'])
    ->name('admin.peminjaman');
Route::get('/pengembalian', [PeminjamanController::class, 'adminPengembalian'])->name('admin.pengembalian');
// =====================================================
// 🧪 DEBUG
// =====================================================
Route::get('/debug/supabase', function () {
    $url = env('SUPABASE_URL');
    $key = env('SUPABASE_KEY');

    if (!$url || !$key) {
        return response('SUPABASE tidak terdeteksi di .env', 500);
    }

    $response = Http::withHeaders([
        'apikey' => $key,
        'Authorization' => 'Bearer ' . $key,
    ])->get($url . '/rest/v1/users');

    return $response->json();
});
