<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LogController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = rtrim(env('SUPABASE_URL'), '/') . '/rest/v1/activity_logs';
        $this->supabaseKey = env('SUPABASE_KEY');
    }

    /**
     * ======================================================================
     * 🔹 1. Halaman Activity Log Admin
     * ======================================================================
     */
    public function index(Request $request)
    {
        // Cek apakah admin login
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Silakan login sebagai admin!');
        }

        // Ambil filter
        $userId = $request->get('user_id');
        $date   = $request->get('date');

        // Query dasar
        $query = [
            'select' => '*',
            'order'  => 'created_at.desc'
        ];

        // Filter berdasarkan user_id
        if ($userId) {
            $query['user_id'] = "eq.$userId";
        }

        // Filter tanggal (created_at >= date)
        if ($date) {
            $query['created_at'] = "gte.$date 00:00:00";
        }

        // Request ke Supabase
        $response = Http::withHeaders([
            'apikey'       => $this->supabaseKey,
            'Authorization'=> "Bearer {$this->supabaseKey}",
        ])->get($this->supabaseUrl, $query);

        if ($response->failed()) {
            return back()->with('error', 'Gagal memuat activity log.');
        }

        $logs = $response->json();

        return view('admin.activity-log', compact('logs'));
    }


    /**
     * ======================================================================
     * 🔹 2. Mengambil Log via AJAX (Opsional)
     * ======================================================================
     */
    public function getData()
    {
        $response = Http::withHeaders([
            'apikey'       => $this->supabaseKey,
            'Authorization'=> "Bearer {$this->supabaseKey}",
        ])->get($this->supabaseUrl, [
            'select' => '*',
            'order'  => 'created_at.desc'
        ]);

        return $response->json();
    }


    /**
     * ======================================================================
     * 🔹 3. Simpan Log Aktivitas (Dipanggil dari Controller lain)
     * ======================================================================
     */
    public static function add($userId, $action)
    {
        $instance = new self;
        return $instance->store($userId, $action);
    }


    /**
     * 🔹 Simpan Log ke Supabase
     */
    private function store($userId, $action)
    {
        $response = Http::withHeaders([
            'apikey'        => $this->supabaseKey,
            'Authorization' => "Bearer {$this->supabaseKey}",
            'Content-Type'  => 'application/json'
        ])->post($this->supabaseUrl, [
            'user_id'     => $userId,
            'action'      => $action,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'created_at'  => now(),
        ]);

        return $response->successful();
    }
}
