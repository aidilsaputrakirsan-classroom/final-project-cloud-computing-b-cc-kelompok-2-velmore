<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use RealRashid\SweetAlert\Facades\Alert;

class BukuController extends Controller
{
    private $url;
    private $key;

    public function __construct()
    {
        $this->url = env('SUPABASE_URL') . '/rest/v1/buku';
        $this->key = env('SUPABASE_KEY');
    }

    private function headers()
    {
        return [
            'apikey' => $this->key,
            'Authorization' => "Bearer {$this->key}",
        ];
    }

    private function uploadToSupabase($file)
    {
        $bucket = 'buku';
        $filename = time() . '_' . $file->getClientOriginalName();
        $content = file_get_contents($file->getRealPath());

        $upload = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => "Bearer {$this->key}",
            'Content-Type' => 'application/octet-stream'
        ])->put(env('SUPABASE_URL') . "/storage/v1/object/$bucket/$filename", $content);

        if ($upload->successful()) {
            return env('SUPABASE_URL') . "/storage/v1/object/public/$bucket/$filename";
        }
        return null;
    }

    public function index(Request $request)
{
    if (!session()->has('admin')) return redirect('/');

    // Base query + join kategori
    $query = "?select=*,kategori_buku(nama)";

    // ===============================
    // 🔍 FILTER PENCARIAN
    // ===============================

    // Filter judul
    if ($request->filled('judul')) {
        $judul = $request->judul;
        $query .= "&judul=ilike.%{$judul}%";
    }

    // Filter kode buku
    if ($request->filled('kode_buku')) {
        $kode = $request->kode_buku;
        $query .= "&kode_buku=ilike.%{$kode}%";
    }

    // Filter pengarang
    if ($request->filled('pengarang')) {
        $pengarang = $request->pengarang;
        $query .= "&pengarang=ilike.%{$pengarang}%";
    }

    // Filter status
    if ($request->filled('status')) {
        $status = $request->status;
        $query .= "&status=eq.{$status}";
    }

    // Filter kategori
    if ($request->filled('id_kategori')) {
        $kategori = $request->id_kategori;
        $query .= "&id_kategori=eq.{$kategori}";
    }

    // ===============================
    // 🔥 EXECUTE QUERY SUPABASE
    // ===============================
    $response = Http::withHeaders($this->headers())
        ->get($this->url . $query);

    $items = $response->json() ?? [];

    // Mapping kategori
    foreach ($items as &$i) {
        $i['kategori_nama'] = $i['kategori_buku']['nama'] ?? '-';
    }

    // ===============================
    // 📌 Pagination manual
    // ===============================
    $perPage = 12;
    $page = LengthAwarePaginator::resolveCurrentPage();
    $collection = collect($items);

    $current = $collection
        ->slice(($page - 1) * $perPage, $perPage)
        ->values();

    $buku = new LengthAwarePaginator(
        $current,
        $collection->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    // ===============================
    // 📌 Ambil kategori (untuk filter)
    // ===============================
    $kategori = Http::withHeaders($this->headers())
        ->get(env('SUPABASE_URL') . '/rest/v1/kategori_buku')
        ->json();

    return view('buku.tampil', compact('buku', 'kategori'));
}


    public function create()
    {
        if (!session()->has('admin')) return redirect('/');

        $kategori = Http::withHeaders($this->headers())
            ->get(env('SUPABASE_URL') . '/rest/v1/kategori_buku')
            ->json();

        return view('buku.tambah', compact('kategori'));
    }

    public function store(Request $request)
    {
        if (!session()->has('admin')) return redirect('/');

        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'id_kategori' => 'required',
            'gambar' => 'nullable|image|max:4096'
        ]);

        $gambarUrl = null;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadToSupabase($request->file('gambar'));
        }

        $data = [
            'judul' => $request->judul,
            'kode_buku' => $request->kode_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'id_kategori' => $request->id_kategori,
            'gambar' => $gambarUrl
        ];

        $save = Http::withHeaders($this->headers())
            ->post($this->url, $data);

        if ($save->successful()) {
            Alert::success('Berhasil', 'Buku berhasil ditambahkan!');
            return redirect()->route('buku.index');
        }

        return back()->with('error', $save->body());
    }

    public function edit($id)
    {
        if (!session()->has('admin')) return redirect('/');

        $data = Http::withHeaders($this->headers())
            ->get($this->url . "?id=eq.$id&select=*,kategori_buku(nama)")
            ->json();

        $buku = (object) $data[0];
        $buku->kategori_nama = $buku->kategori_buku['nama'] ?? '-';

        $kategori = Http::withHeaders($this->headers())
            ->get(env('SUPABASE_URL') . '/rest/v1/kategori_buku')
            ->json();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        if (!session()->has('admin')) return redirect('/');

        $request->validate([
            'judul' => 'required',
            'kode_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'id_kategori' => 'required',
            'gambar' => 'nullable|image|max:4096'
        ]);

        $old = Http::withHeaders($this->headers())
            ->get($this->url . "?id=eq.$id")
            ->json();

        $oldImage = $old[0]['gambar'];

        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadToSupabase($request->file('gambar'));
        } else {
            $gambarUrl = $oldImage;
        }

        $data = [
            'judul' => $request->judul,
            'kode_buku' => $request->kode_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'id_kategori' => $request->id_kategori,
            'gambar' => $gambarUrl
        ];

        $update = Http::withHeaders($this->headers())
            ->patch($this->url . "?id=eq.$id", $data);

        if ($update->successful()) {
            Alert::success('Berhasil', 'Data buku berhasil diperbarui!');
            return redirect()->route('buku.index');
        }

        return back()->with('error', $update->body());
    }

    public function destroy($id)
    {
        if (!session()->has('admin')) return redirect('/');

        $delete = Http::withHeaders($this->headers())
            ->delete($this->url . "?id=eq.$id");

        if ($delete->successful()) {
            Alert::success('Berhasil', 'Buku berhasil dihapus!');
        }

        return redirect()->route('buku.index');
    }

    public function show($id)
    {
        $data = Http::withHeaders($this->headers())
            ->get($this->url . "?id=eq.$id&select=*,kategori_buku(nama)")
            ->json();

        $buku = (object) $data[0];
        $buku->kategori_nama = $buku->kategori_buku['nama'] ?? '-';

        return view('buku.detail', compact('buku'));
    }
}
