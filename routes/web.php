<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardAdminController;

/*
|--------------------------------------------------------------------------
| 🔐 AUTENTIKASI
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 📊 DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])
    ->name('dashboard.admin');

Route::get('/dashboard-user', [PeminjamanController::class, 'dashboard'])
    ->name('dashboard.user');

/*
|--------------------------------------------------------------------------
| 👥 MANAJEMEN PENGGUNA (ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| 📚 MANAJEMEN BUKU
|--------------------------------------------------------------------------
*/
Route::prefix('buku')->name('buku.')->group(function () {
    Route::get('/', [BukuController::class, 'index'])->name('index');
    Route::get('/tambah', [BukuController::class, 'create'])->name('tambah');
    Route::post('/', [BukuController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [BukuController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BukuController::class, 'update'])->name('update');
    Route::delete('/{id}', [BukuController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [BukuController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| 📖 PEMINJAMAN & PENGEMBALIAN
|--------------------------------------------------------------------------
*/
// User
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create/{id_buku}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');

// Admin
Route::get('/admin/peminjaman', [PeminjamanController::class, 'adminIndex'])->name('admin.peminjaman');
Route::get('/admin/pengembalian', [PeminjamanController::class, 'adminPengembalian'])->name('admin.pengembalian');
Route::post('/pengembalian/simpan', [PengembalianController::class, 'simpan'])->name('pengembalian.simpan');

/*
|--------------------------------------------------------------------------
| 🧪 DEBUG (SUPABASE CONNECTION)
|--------------------------------------------------------------------------
*/
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
