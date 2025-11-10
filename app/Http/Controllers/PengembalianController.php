<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PengembalianController extends Controller
{
    public function simpan(Request $request)
    {
        // Ambil data dari Body JSON
        $data = $request->json()->all() ?: $request->all();

        $id_buku  = $data['buku_id'] ?? null;
        $tanggal  = $data['tanggal_kembali'] ?? null;
        $denda    = $data['denda'] ?? 0;
        $id_user  = session('user')['id'] ?? null;

        if (!$id_buku || !$tanggal || !$id_user) {
            return response()->json(['ok' => false, 'error' => 'Data tidak lengkap'], 400);
        }

        // --- Setup Supabase ---
        $base = rtrim(env('SUPABASE_URL'), '/') . '/rest/v1';
        $key  = env('SUPABASE_KEY');
        $headers = [
            'apikey'        => $key,
            'Authorization' => "Bearer $key",
            'Content-Type'  => 'application/json',
            'Prefer'        => 'return=representation'
        ];

        // 1. 🔹 Update tabel peminjaman (ke Terverifikasi)
        $urlPeminjaman = "$base/peminjaman?id_buku=eq.$id_buku&id_pengguna=eq.$id_user&status=eq.Dipinjam";
        $updateDataPeminjaman = [
            'tanggal_kembali' => $tanggal,
            'denda'           => $denda,
            'status'          => 'Terverifikasi', // Status final
            // TIDAK ADA KOLOM bukti_pengembalian
        ];
        $resp1 = Http::withHeaders($headers)->patch($urlPeminjaman, $updateDataPeminjaman);


        // 2. 🔹 Update status buku (ke Tersedia)
        $urlBuku = "$base/buku?id=eq.$id_buku";
        $resp2 = Http::withHeaders($headers)->patch($urlBuku, [
            'status' => 'Tersedia' // Status buku final
        ]);


        // 3. Cek hasil
        if ($resp1->successful() && $resp2->successful()) {
            return response()->json(['ok' => true, 'msg' => '✅ Pengembalian berhasil dicatat.']);
        }

        // Jika ada kegagalan Supabase (resp2 = 400/401/500)
        return response()->json([
            'ok' => false,
            'msg' => 'Gagal mengupdate Supabase',
            'peminjaman_status' => $resp1->status(),
            'buku_status'       => $resp2->status(),
            'peminjaman_body'   => $resp1->body(),
            'buku_body'         => $resp2->body(),
        ], 500);
    }
}
