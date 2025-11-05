<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use RealRashid\SweetAlert\Facades\Alert;

class BukuController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL') . '/rest/v1/buku';
        $this->supabaseKey = env('SUPABASE_KEY');
    }

    /**
     * 🔹 Tampilkan daftar buku (dengan filter & pagination)
     */
    public function index(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        // Filter pencarian
        $filters = [];
        if ($request->filled('judul')) $filters[] = "judul=ilike.%{$request->judul}%";
        if ($request->filled('kode_buku')) $filters[] = "kode_buku=ilike.%{$request->kode_buku}%";
        if ($request->filled('pengarang')) $filters[] = "pengarang=ilike.%{$request->pengarang}%";
        if ($request->filled('status')) $filters[] = "status=eq.{$request->status}";

        $queryString = !empty($filters) ? '?' . implode('&', $filters) : '';

        // Ambil data dari Supabase
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . $queryString);

        $items = $response->json() ?? [];

        // Pagination manual
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = collect($items);
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $buku = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('buku.tampil', compact('buku'));
    }

    /**
     * 🔹 Form tambah buku baru
     */
    public function create()
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $kategoriResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get(env('SUPABASE_URL') . '/rest/v1/kategori_buku');

        $kategori = $kategoriResponse->json() ?? [];

        return view('buku.tambah', compact('kategori'));
    }

    /**
     * 🔹 Simpan buku ke Supabase
     */
    public function store(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kode_buku' => 'required|string|max:50',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar ke public/img/buku
        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/buku'), $namaGambar);
        }

        // Data buku yang akan dikirim ke Supabase
        $data = [
            'judul' => $request->judul,
            'kode_buku' => $request->kode_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaGambar,
        ];

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ])->post($this->supabaseUrl, $data);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Data buku berhasil ditambahkan!');
            return redirect()->route('buku.index');
        }

        Alert::error('Gagal', 'Terjadi kesalahan saat menambahkan buku!');
        return back()->with('error', $response->body());
    }

    /**
     * 🔹 Form edit buku
     */
    public function edit($id)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $bukuResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?id=eq.' . $id);

        $data = $bukuResponse->json();
        if (!$bukuResponse->successful() || empty($data)) {
            abort(404, 'Buku tidak ditemukan');
        }

        $buku = (object) $data[0];

        $kategoriResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get(env('SUPABASE_URL') . '/rest/v1/kategori_buku');

        $kategori = $kategoriResponse->json() ?? [];

        return view('buku.edit', compact('buku', 'kategori'));
    }

    /**
     * 🔹 Update data buku
     */
    public function update(Request $request, $id)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kode_buku' => 'required|string|max:50',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data lama dari Supabase
        $oldDataResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?id=eq.' . $id);

        $oldData = $oldDataResponse->json();
        $namaGambar = $oldData[0]['gambar'] ?? null;

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('gambar')) {
            if ($namaGambar && file_exists(public_path('img/buku/' . $namaGambar))) {
                unlink(public_path('img/buku/' . $namaGambar));
            }

            $file = $request->file('gambar');
            $namaGambar = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/buku'), $namaGambar);
        }

        // Kirim update ke Supabase
        $data = [
            'judul' => $request->judul,
            'kode_buku' => $request->kode_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaGambar,
        ];

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
        ])->patch($this->supabaseUrl . '?id=eq.' . $id, $data);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Data buku berhasil diperbarui!');
            return redirect()->route('buku.index');
        }

        Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui buku!');
        return back()->with('error', $response->body());
    }

    /**
     * 🔹 Hapus buku
     */
    public function destroy($id)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $getResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?id=eq.' . $id);

        $buku = $getResponse->json();
        if (empty($buku)) {
            Alert::error('Gagal', 'Data buku tidak ditemukan.');
            return redirect()->route('buku.index');
        }

        $namaGambar = $buku[0]['gambar'] ?? null;

        // Hapus dari Supabase
        $deleteResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($this->supabaseUrl . '?id=eq.' . $id);

        if ($deleteResponse->successful()) {
            if ($namaGambar && File::exists(public_path('img/buku/' . $namaGambar))) {
                File::delete(public_path('img/buku/' . $namaGambar));
            }

            Alert::success('Berhasil', 'Buku berhasil dihapus!');
            return redirect()->route('buku.index');
        }

        Alert::error('Gagal', 'Terjadi kesalahan saat menghapus buku!');
        return redirect()->route('buku.index')->with('error', $deleteResponse->body());
    }

    /**
     * 🔹 Detail buku
     */
    public function show($id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?id=eq.' . $id);

        $data = $response->json();
        if (!$response->successful() || empty($data)) {
            abort(404, 'Buku tidak ditemukan');
        }

        $buku = (object) $data[0];
        return view('buku.detail', compact('buku'));
    }
    public function userDashboard()
{
    $supabaseUrl = env('SUPABASE_URL') . '/rest/v1';
    $supabaseKey = env('SUPABASE_KEY');
    $idUser = session('user')['id'] ?? null;

    if (!$idUser) {
        return '⚠️ Session user kosong!';
    }

    $response = Http::withHeaders([
        'apikey' => $supabaseKey,
        'Authorization' => "Bearer $supabaseKey",
    ])->get("$supabaseUrl/peminjaman?select=*,buku(*)&id_pengguna=eq.$idUser");

    // 🧠 Debug dulu
    dd([
        'status' => $response->status(),
        'body' => $response->json(),
        'id_user_session' => $idUser
    ]);
}
}
