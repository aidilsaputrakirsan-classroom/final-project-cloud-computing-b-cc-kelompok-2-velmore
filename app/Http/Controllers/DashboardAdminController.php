<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // 🔒 Guard admin
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Silakan login sebagai admin!');
        }

        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $supabaseKey = env('SUPABASE_KEY');

        $headers = [
            'apikey'        => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
        ];

        // === Ambil data dasar ===
        $buku         = Http::withHeaders($headers)->get("$supabaseUrl/rest/v1/buku?select=*")->json() ?? [];
        $users        = Http::withHeaders($headers)->get("$supabaseUrl/rest/v1/users?select=*")->json() ?? [];
        $peminjaman   = Http::withHeaders($headers)->get("$supabaseUrl/rest/v1/peminjaman?select=*")->json() ?? [];
        // pengembalian opsional, kalau kamu memang punya tabel ini
        $pengembalian = Http::withHeaders($headers)->get("$supabaseUrl/rest/v1/pengembalian?select=*")->json() ?? [];

        // === Statistik ===
        $totalPengguna = count($users);
        $totalBuku     = count($buku);

        // hanya yang benar2 "Dipinjam"
        $totalDipinjam = collect($peminjaman)->where('status', 'Dipinjam')->count();

        // denda dari tabel pengembalian + peminjaman terverifikasi (kalau kolom denda disimpan di situ)
        $totalDendaPengembalian = collect($pengembalian)->sum(function ($row) {
            return (int) ($row['denda'] ?? 0);
        });
        $totalDendaPeminjamanTerverifikasi = collect($peminjaman)->sum(function ($row) {
            $status = strtolower($row['status'] ?? '');
            if ($status === 'terverifikasi') {
                return (int) ($row['denda'] ?? 0);
            }
            return 0;
        });
        $totalDenda = $totalDendaPengembalian + $totalDendaPeminjamanTerverifikasi;

        // === Data grafik 7 hari terakhir (dummy yang rapi; nanti bisa ganti hitung nyata kalau mau) ===
        $grafikData = collect(range(1, 7))->map(function ($i) {
            return [
                'tanggal' => now()->subDays(7 - $i)->format('d M'),
                'jumlah'  => rand(3, 15),
            ];
        });

        // === Aktivitas terbaru (gabung peminjaman & pengembalian seadanya) ===
        // Fokus ke peminjaman terbaru (maks 5), mapping judul & nama user
        $aktivitas = collect($peminjaman)
            ->sortByDesc(function ($row) {
                // fallback kalau tanggal_pinjam kosong
                return $row['tanggal_pinjam'] ?? $row['created_at'] ?? '1970-01-01';
            })
            ->take(5)
            ->map(function ($row) use ($buku, $users) {
                // ⚠️ Kunci penting: gunakan id_pengguna (BUKAN id_user)
                $user = collect($users)->firstWhere('id', $row['id_pengguna'] ?? null);
                $book = collect($buku)->firstWhere('id', $row['id_buku'] ?? null);

                // format tanggal sedikit manis
                $tanggal = $row['tanggal_pinjam'] ?? ($row['created_at'] ?? null);
                if ($tanggal) {
                    try {
                        $tanggal = \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d M Y');
                    } catch (\Throwable $e) {
                        // biarkan apa adanya kalau gagal parse
                    }
                } else {
                    $tanggal = '-';
                }

                return [
                    'nama'    => $user['nama']   ?? 'Tidak diketahui',
                    'buku'    => $book['judul']  ?? 'Tanpa Judul',
                    'status'  => $row['status']  ?? 'Dipinjam',
                    'tanggal' => $tanggal,
                ];
            })
            ->values()
            ->all();

        return view('dashboard.admin', compact(
            'totalPengguna',
            'totalBuku',
            'totalDipinjam',
            'totalDenda',
            'grafikData',
            'aktivitas'
        ));
    }
}
