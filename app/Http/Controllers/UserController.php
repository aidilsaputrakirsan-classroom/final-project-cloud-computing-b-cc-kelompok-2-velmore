<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    // 📋 Daftar pengguna
    public function index()
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ])->get($url);

        $users = $response->json() ?? [];

        return view('admin.data-pengguna', compact('users'));
    }

    // 🧩 Form tambah pengguna
    public function create()
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        return view('admin.tambah-pengguna');
    }

    // ➕ Simpan pengguna baru
    public function store(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'password' => 'required|min:3',
            'isadmin' => 'nullable|boolean'
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'isadmin' => $request->boolean('isadmin'),
        ];

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->send('POST', $url, [
            'body' => json_encode($data)
        ]);

        if ($response->successful()) {
            return redirect('/pengguna')->with('success', 'Pengguna baru berhasil ditambahkan!');
        }

        return back()->with('error', 'Gagal menambahkan pengguna. ' . $response->body());
    }

    // ✏️ Form edit
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

    // 🔄 Update pengguna
    public function update(Request $request, $id)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'password' => 'nullable|min:3',
            'isadmin' => 'nullable|boolean'
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users?id=eq.' . $id;
        $key = env('SUPABASE_KEY');

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'isadmin' => $request->boolean('isadmin'),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->send('PATCH', $url, [
            'body' => json_encode($data)
        ]);

        if ($response->successful()) {
            return redirect('/pengguna')->with('success', 'Data pengguna berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal mengupdate data. ' . $response->body());
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
        }

        return back()->with('error', 'Gagal menghapus pengguna. ' . $response->body());
    }
}
