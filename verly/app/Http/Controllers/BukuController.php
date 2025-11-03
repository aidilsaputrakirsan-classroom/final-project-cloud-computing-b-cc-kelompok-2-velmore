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
     * 🔹 Daftar Buku dengan filter
     */
    public function index(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        $judul = $request->query('judul');
        $kode_buku = $request->query('kode_buku');
        $pengarang = $request->query('pengarang');
        $status = $request->query('status');

        // Build query Supabase
        $filters = [];
        if ($judul) $filters[] = "judul=ilike.%$judul%";
        if ($kode_buku) $filters[] = "kode_buku=ilike.%$kode_buku%";
        if ($pengarang) $filters[] = "pengarang=ilike.%$pengarang%";
        if ($status) $filters[] = "status=eq.$status";

        $queryString = '';
        if (!empty($filters)) {
            $queryString = '?' . implode('&', $filters);
        }

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
     * 🔹 Form Tambah Buku
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
     * 🔹 Simpan Buku Baru
     */
    public function store(Request $request)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/buku'), $namaGambar);
        }

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
            'Prefer' => 'return=representation'
        ])->post($this->supabaseUrl, $data);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Data buku berhasil ditambahkan!');
            return redirect('/buku');
        }

        return back()->with('error', 'Gagal menambahkan buku. ' . $response->body());
    }

    /**
     * 🔹 Form Edit Buku
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
     * 🔹 Update Buku
     */
    public function update(Request $request, $id)
    {
        if (!session()->has('admin')) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $oldDataResponse = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '?id=eq.' . $id);

        $oldData = $oldDataResponse->json();
        $namaGambar = $oldData[0]['gambar'] ?? null;

        if ($request->hasFile('gambar')) {
            if ($namaGambar && file_exists(public_path('img/buku/' . $namaGambar))) {
                unlink(public_path('img/buku/' . $namaGambar));
            }

            $file = $request->file('gambar');
            $namaGambar = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/buku'), $namaGambar);
        }

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
            'Content-Type' => 'application/json'
        ])->patch($this->supabaseUrl . '?id=eq.' . $id, $data);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Data buku berhasil diperbarui!');
            return redirect('/buku');
        }

        return back()->with('error', 'Gagal memperbarui buku. ' . $response->body());
    }

    /**
     * 🔹 Hapus Buku
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
            return redirect()->route('buku.index')->with('error', 'Data buku tidak ditemukan.');
        }

        $namaGambar = $buku[0]['gambar'] ?? null;

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

        return redirect()->route('buku.index')->with('error', 'Gagal menghapus buku. ' . $deleteResponse->body());
    }

    /**
     * 🔹 Detail Buku
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
}
