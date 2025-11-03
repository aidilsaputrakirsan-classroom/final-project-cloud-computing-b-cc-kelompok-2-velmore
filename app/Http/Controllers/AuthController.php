<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Kalau sudah login, arahkan ke dashboard sesuai role
        if (session()->has('admin')) {
            return redirect('/dashboard.admin');
        }

        if (session()->has('user')) {
            return redirect('/dashboard.user');
        }

        // Jika belum login, tampilkan halaman login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        // 🔹 Ambil data user dari Supabase (pastikan Supabase terhubung)
        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ])->get($url . '?email=eq.' . $request->email);

        $user = $response->json();

        // 🔹 Cek apakah user ditemukan
        if (!empty($user)) {
            $data = $user[0];

            // 🔐 Cek password secara manual (jika hash disimpan)
            if (!password_verify($request->password, $data['password'])) {
                return back()->with('error', 'Password salah!');
            }

            // 🧠 Tentukan role
            $role = strtolower($data['role'] ?? 'user');

            if ($role === 'admin') {
                session(['admin' => $data]);
                return redirect('/dashboard.admin')->with('success', 'Login Admin berhasil!');
            } else {
                session(['user' => $data]);
                return redirect('/dashboard.user')->with('success', 'Login Pengguna berhasil!');
            }
        }

        // ❌ Kalau email/password salah
        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        session()->forget(['admin', 'user']);
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
