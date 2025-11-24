<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    private $url;
    private $key;

    public function __construct()
    {
        $this->url = env('SUPABASE_URL') . '/rest/v1/kategori_buku';
        $this->key = env('SUPABASE_KEY');
    }

    private function headers()
    {
        return [
            'apikey' => $this->key,
            'Authorization' => "Bearer {$this->key}",
            "Content-Type" => "application/json"
        ];
    }

    public function index()
    {
        if (!session()->has('admin')) return redirect('/');

        $kategori = Http::withHeaders($this->headers())->get($this->url)->json();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        if (!session()->has('admin')) return redirect('/');

        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);

        $insert = Http::withHeaders($this->headers())
            ->post($this->url, ['nama' => $request->nama]);

        Alert::success('Berhasil', 'Kategori ditambahkan');

        return redirect()->route('kategori.index');
    }

    public function edit($id)
    {
        $kategori = Http::withHeaders($this->headers())
            ->get($this->url . "?id=eq.$id")
            ->json()[0];

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required']);

        Http::withHeaders($this->headers())
            ->patch($this->url . "?id=eq.$id", ['nama' => $request->nama]);

        Alert::success('Berhasil', 'Kategori diperbarui');

         return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        Http::withHeaders($this->headers())
            ->delete($this->url . "?id=eq.$id");

        Alert::success('Berhasil', 'Kategori dihapus');

       return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
}
}
