<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function create()
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        return view('admin.tambah-pengguna');
    }

    public function store(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'password' => 'required|min:3',
            'isAdmin' => 'nullable|boolean'
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->post($url, [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'isAdmin' => $request->boolean('isAdmin'),
        ]);

        if ($response->successful()) {
            return redirect('/pengguna')->with('success', 'Pengguna baru berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Gagal menambahkan pengguna. ' . $response->body());
        }
    }
    public function index()
        {
            if (!session()->has('admin')) {
                return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
            }

            $url = env('SUPABASE_URL') . '/rest/v1/users';
            $key = env('SUPABASE_KEY');

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'apikey' => $key,
                'Authorization' => 'Bearer ' . $key,
            ])->get($url);

            $users = $response->json() ?? [];

            return view('admin.data-pengguna', compact('users'));
        }
    // ✏️ Tampilkan form edit pengguna
public function edit($id)
{
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Akses ditolak!');
    }

    $url = env('SUPABASE_URL') . '/rest/v1/users?id=eq.' . $id;
    $key = env('SUPABASE_KEY');

    $response = Http::withHeaders([
        'apikey' => $key,
        'Authorization' => 'Bearer ' . $key,
    ])->get($url);

    $user = $response->json()[0] ?? null;

    if (!$user) {
        return redirect('/pengguna')->with('error', 'Data pengguna tidak ditemukan.');
    }

    return view('admin.edit-pengguna', compact('user'));
}

// 🔄 Proses update pengguna
public function update(Request $request, $id)
{
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Akses ditolak!');
    }

    $request->validate([
        'nama' => 'required|string|max:45',
        'email' => 'required|email|max:45',
        'password' => 'nullable|min:3',
        'isAdmin' => 'nullable|boolean'
    ]);

    $url = env('SUPABASE_URL') . '/rest/v1/users?id=eq.' . $id;
    $key = env('SUPABASE_KEY');

    $data = [
        'nama' => $request->nama,
        'email' => $request->email,
        'isAdmin' => $request->boolean('isAdmin'),
    ];

    if ($request->filled('password')) {
        $data['password'] = $request->password;
    }

    $response = Http::withHeaders([
        'apikey' => $key,
        'Authorization' => 'Bearer ' . $key,
        'Content-Type' => 'application/json',
    ])->patch($url, $data);

    if ($response->successful()) {
        return redirect('/pengguna')->with('success', 'Data pengguna berhasil diperbarui!');
    } else {
        return back()->with('error', 'Gagal mengupdate data. ' . $response->body());
    }
}

// 🗑️ Hapus pengguna
public function destroy($id)
{
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Akses ditolak!');
    }

    $url = env('SUPABASE_URL') . '/rest/v1/users?id=eq.' . $id;
    $key = env('SUPABASE_KEY');

    $response = Http::withHeaders([
        'apikey' => $key,
        'Authorization' => 'Bearer ' . $key,
    ])->delete($url);

    if ($response->successful()) {
        return redirect('/pengguna')->with('success', 'Pengguna berhasil dihapus!');
    } else {
        return back()->with('error', 'Gagal menghapus pengguna. ' . $response->body());
    }
}


}
