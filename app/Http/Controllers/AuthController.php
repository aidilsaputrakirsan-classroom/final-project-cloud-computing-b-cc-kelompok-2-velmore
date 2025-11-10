<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        // ✅ Kalau sudah login, arahkan ke dashboard sesuai role
        if (session()->has('admin')) {
            return redirect()->route('dashboard.admin');
        }

        if (session()->has('user')) {
            return redirect()->route('dashboard.user');
        }

        // Jika belum login, tampilkan halaman login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $url = env('SUPABASE_URL') . '/rest/v1/users';
        $key = env('SUPABASE_KEY');

        // 🔹 Ambil data user dari Supabase
        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ])->get($url . '?email=eq.' . $request->email);

        $user = $response->json();

        // 🔹 Cek apakah user ditemukan
        if (!empty($user)) {
            $data = $user[0];

            // 🔐 Cek password (sementara tanpa hash)
            if ($request->password !== $data['password']) {
                return back()->with('error', 'Password salah!');
            }

            // 🧠 Cek role dan simpan session
            if (!empty($data['isadmin']) && $data['isadmin'] === true) {
                session(['admin' => $data]);
                return redirect()->route('dashboard.admin')
                                 ->with('success', 'Login Admin berhasil!');
            } else {
                session(['user' => $data]);
                return redirect()->route('dashboard.user')
                                 ->with('success', 'Login Pengguna berhasil!');
            }
        }

        // ❌ Kalau email tidak ditemukan
        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        // 🔹 Hapus session
        session()->forget(['admin', 'user']);
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
