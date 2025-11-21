<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        // URL dasar Supabase
        $this->supabaseUrl = rtrim(env('SUPABASE_URL'), '/') . '/rest/v1';
        $this->supabaseKey = env('SUPABASE_KEY');
    }

    /**
     * 🔹 Dashboard User (semua tab)
     */
    public function dashboard(Request $request)
    {
        if (!session()->has('user')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
        }

        $id_pengguna = session('user')['id'];
        $tab = $request->get('tab', 'peminjaman');

        $headers = [
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ];

        // Ambil semua data buku
        $bukuResponse = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/buku?select=*');
        $bukuList = $bukuResponse->json() ?? [];

        // Ambil semua data peminjaman user DENGAN RELASI BUKU
        $pinjamResponse = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/peminjaman?id_pengguna=eq.' . $id_pengguna . '&select=*,buku(*)');
        $data = $pinjamResponse->json() ?? [];

        $peminjaman = collect($data)->where('status', 'Dipinjam');
        $pengembalian = collect($data)->where('status', 'Sedang Diverifikasi');
        $riwayat = collect($data)->where('status', 'Terverifikasi');

        return view('dashboard.user', compact('tab', 'bukuList', 'peminjaman', 'pengembalian', 'riwayat'));
    }

    /**
     * 🔹 Aksi Pinjam Buku (Tambah Peminjaman)
     */
    public function create($id_buku, Request $request)
    {
        if (!session()->has('user')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
        }

        $id_pengguna = session('user')['id'];
        $due = $request->query('rencana_kembali');
        $kontak = $request->query('kontak');

        $headers = [
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ];

        try {
            // 1️⃣ Cek status buku
            $bukuCheck = Http::withHeaders($headers)
                ->get($this->supabaseUrl . '/buku?id=eq.' . $id_buku . '&select=status');

            $buku = $bukuCheck->json()[0] ?? null;

            if (!$buku || $buku['status'] !== 'Tersedia') {
                Alert::error('Gagal', 'Buku tidak tersedia atau sudah dipinjam!');
                return redirect()->route('dashboard.user');
            }

            // 2️⃣ Buat record peminjaman
            $pinjamResponse = Http::withHeaders($headers)
                ->post($this->supabaseUrl . '/peminjaman', [
                    'id_pengguna' => $id_pengguna,
                    'id_buku' => $id_buku,
                    'tanggal_pinjam' => now()->format('Y-m-d'),
                    'tanggal_kembali' => $due,
                    'kontak' => $kontak,
                    'status' => 'Dipinjam',
                    'created_at' => now()->toIso8601String(),
                ]);

            if ($pinjamResponse->failed()) {
                Alert::error('Gagal', 'Terjadi kesalahan saat meminjam buku!');
                return redirect()->route('dashboard.user');
            }

            // 3️⃣ Update status buku menjadi "Dipinjam"
            $updateBuku = Http::withHeaders($headers)
                ->patch($this->supabaseUrl . '/buku?id=eq.' . $id_buku, [
                    'status' => 'Dipinjam'
                ]);

            if ($updateBuku->failed()) {
                // Rollback jika gagal update buku
                $peminjaman = $pinjamResponse->json()[0] ?? null;
                if ($peminjaman && isset($peminjaman['id'])) {
                    Http::withHeaders($headers)
                        ->delete($this->supabaseUrl . '/peminjaman?id=eq.' . $peminjaman['id']);
                }

                Alert::error('Gagal', 'Gagal mengupdate status buku!');
                return redirect()->route('dashboard.user');
            }

            Alert::success('Berhasil', 'Buku berhasil dipinjam!');
            return redirect()->route('dashboard.user');

        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->route('dashboard.user');
        }
    }

    /**
     * 🔹 Daftar Peminjaman Aktif untuk Admin
     */
    public function adminIndex()
{
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
    }

    $headers = [
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
    ];

    try {
        // 🔹 Ambil semua peminjaman yang statusnya "Dipinjam"
        $pinjamResponse = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/peminjaman?status=eq.Dipinjam&select=*');
        $dataPinjam = $pinjamResponse->json() ?? [];

        // 🔹 Ambil semua buku (judul)
        $bukuResponse = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/buku?select=id,judul');
        $dataBuku = collect($bukuResponse->json() ?? [])->keyBy('id');

        // 🔹 Ambil semua user (nama)
        $userResponse = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/users?select=id,nama');
        $dataUser = collect($userResponse->json() ?? [])->keyBy('id');

        // 🔹 Gabungkan data jadi satu array untuk view
        $peminjamanAktif = collect($dataPinjam)->map(function ($item) use ($dataBuku, $dataUser) {
            $tanggalKembali = \Carbon\Carbon::parse($item['tanggal_kembali'] ?? now());
            $hariSisa = now()->diffInDays($tanggalKembali, false);

            $idUser = $item['id_pengguna'] ?? null;
            $idBuku = $item['id_buku'] ?? null;

            return [
                'id' => $item['id'] ?? null,
                'buku' => [
                    'judul' => $dataBuku[$idBuku]['judul'] ?? 'Tidak ditemukan',
                ],
                'pengguna' => [
                    'nama' => $dataUser[$idUser]['nama'] ?? 'Tidak diketahui',
                ],
                'kontak' => $item['kontak'] ?? '-',
                'tanggal_pinjam' => $item['tanggal_pinjam'] ?? '-',
                'tanggal_kembali' => $item['tanggal_kembali'] ?? '-',
                'sisa_hari' => $hariSisa,
            ];
        });

        return view('admin.peminjaman-aktif', compact('peminjamanAktif'));

    } catch (\Throwable $e) {
        return response()->view('errors.custom', [
            'message' => 'Gagal mengambil data dari Supabase: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * 🔹 Data Pengembalian Buku untuk Admin
 */
public function adminPengembalian()
{
    if (!session()->has('admin')) {
        return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
    }

    $headers = [
        'apikey' => $this->supabaseKey,
        'Authorization' => 'Bearer ' . $this->supabaseKey,
    ];

    try {
        // 🔹 Ambil data pengembalian (status Terverifikasi & Sedang Diverifikasi)
        $res = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/peminjaman?or=(status.eq.Terverifikasi,status.eq."Sedang Diverifikasi")&select=*');
        $data = $res->json() ?? [];

        // 🔹 Ambil buku & pengguna
        $bukuRes = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/buku?select=id,judul');
        $bukuList = collect($bukuRes->json() ?? [])->keyBy('id');

        $userRes = Http::withHeaders($headers)
            ->get($this->supabaseUrl . '/users?select=id,nama');
        $userList = collect($userRes->json() ?? [])->keyBy('id');

        // 🔹 Gabungkan data
        $pengembalianList = collect($data)->map(function ($row) use ($bukuList, $userList) {
            $idBuku = $row['id_buku'] ?? null;
            $idUser = $row['id_pengguna'] ?? null;
            return [
                'id' => $row['id'],
                'buku' => $bukuList[$idBuku]['judul'] ?? 'Tidak ditemukan',
                'peminjam' => $userList[$idUser]['nama'] ?? 'Tidak diketahui',
                'tanggal_pinjam' => $row['tanggal_pinjam'] ?? '-',
                'tanggal_kembali' => $row['tanggal_kembali'] ?? '-',
                'denda' => $row['denda'] ?? 0,
                'status' => $row['status'] ?? '-',
            ];
        });

        return view('admin.pengembalian', compact('pengembalianList'));

    } catch (\Throwable $e) {
        return response()->view('errors.custom', [
            'message' => 'Gagal memuat data pengembalian: ' . $e->getMessage()
        ], 500);
    }
}


    // Placeholder untuk fungsi CRUD tambahan
    public function edit($id) { /* ... */ }
    public function update(Request $request, $id) { /* ... */ }
}
