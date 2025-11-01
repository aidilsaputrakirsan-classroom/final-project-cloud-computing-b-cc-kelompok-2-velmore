<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // 🧩 Tampilkan halaman login
    public function showLogin()
    {
        // Kalau sudah login, arahkan sesuai role
        if (session()->has('admin')) {
            return redirect('/dashboard-admin');
        }

        if (session()->has('user')) {
            return redirect('/dashboard-user');
        }

        // Jika belum login, tampilkan halaman login
        return view('auth.login');
    }

    // 🧩 Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        // 🔹 Ambil data user dari Supabase berdasarkan email & password
        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ])->get($url . '?email=eq.' . $request->email . '&password=eq.' . $request->password);

        // Ambil hasil JSON
        $user = $response->json();

        // 🔹 Cek apakah user ditemukan
        if (!empty($user) && isset($user[0])) {
            $data = $user[0];

            // 🔹 Ambil status admin dari kolom 'isadmin'
            $isAdmin = isset($data['isadmin']) ? (bool)$data['isadmin'] : false;

            // 🧠 Cek role pengguna
            if ($isAdmin) {
                session(['admin' => $data]);
                return redirect('/dashboard-admin')->with('success', 'Login Admin berhasil!');
            } else {
                session(['user' => $data]);
                return redirect('/dashboard-user')->with('success', 'Login Pengguna berhasil!');
            }
        }

        // ❌ Kalau email/password salah
        return back()->with('error', 'Email atau password salah!');
    }

    // 🧩 Logout
    public function logout()
    {
        session()->forget(['admin', 'user']);
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
