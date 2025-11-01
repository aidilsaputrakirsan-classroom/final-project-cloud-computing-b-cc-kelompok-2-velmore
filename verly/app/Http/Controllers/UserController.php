<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    // 📋 Daftar semua pengguna
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

    // 🧩 Simpan pengguna baru
    public function store(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'password' => 'required|min:3',
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        // ambil nilai checkbox secara eksplisit
        $isadmin = $request->has('isadmin') && $request->input('isadmin') == '1';

        $payload = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'isadmin' => $isadmin ? true : false, // pastikan boolean literal
        ];

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ])->withBody(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'application/json')
          ->post($url);

        if ($response->successful()) {
            return redirect('/pengguna')->with('success', 'Pengguna baru berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Gagal menambahkan pengguna. ' . $response->body());
        }
    }

    // 🧩 Form edit pengguna
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

    // 🧩 Update pengguna
    public function update(Request $request, $id)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama' => 'required|string|max:45',
            'email' => 'required|email|max:45',
            'password' => 'nullable|min:3',
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users?id=eq.' . $id;
        $key = env('SUPABASE_KEY');

        // ✅ ambil nilai checkbox dari form name="isadmin"
        $isadmin = $request->has('isadmin') && $request->input('isadmin') == '1';

        // ✅ buat data payload
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'isadmin' => $isadmin ? true : false, // kirim boolean murni
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        // ✅ kirim ke Supabase dengan JSON body yang valid
        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation', // biar Supabase commit perubahan & return data
        ])->withBody(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'application/json')
        ->patch($url);

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
