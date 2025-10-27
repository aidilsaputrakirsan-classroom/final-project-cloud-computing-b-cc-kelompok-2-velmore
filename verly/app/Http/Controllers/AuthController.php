<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Kalau sudah login, langsung ke dashboard
        if (session()->has('admin')) {
            return redirect('/dashboard');
        }

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

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ])->get($url . '?email=eq.' . $request->email . '&password=eq.' . $request->password);

        $user = $response->json();

        // Jika user ditemukan dan admin
        if (!empty($user) && isset($user[0]['isadmin']) && $user[0]['isadmin'] == true) {
            session(['admin' => $user[0]]);
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
