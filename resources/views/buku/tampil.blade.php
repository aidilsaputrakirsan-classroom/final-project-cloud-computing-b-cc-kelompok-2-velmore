@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="text-primary">Daftar Buku</h1>
@endsection

@section('content')
    {{-- Tombol Tambah Buku hanya untuk Admin --}}
    @if (session()->has('admin'))
        <a href="{{ route('buku.tambah') }}" class="btn btn-info mb-3">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    @endif

    {{-- Form Pencarian --}}
    <form class="navbar-search mb-3" action="{{ url('/buku') }}" method="GET">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="color: white;">Judul Buku</label>
                <input type="text" name="judul" class="form-control"
                    placeholder="Judul Buku"
                    value="{{ request('judul') }}">
            </div>
           <div class="col-md-2">
    <label class="form-label text-white">Kode Buku</label>
    <input type="text" name="kode_buku" class="form-control"
        placeholder="Kode Buku"
        value="{{ request('kode_buku') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">Pengarang</label>
                <input type="text" name="pengarang" class="form-control"
                    placeholder="Pengarang"
                    value="{{ request('pengarang') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label text-white">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>
    </form>

    <div class="card container-fluid mb-3">
        <div class="row d-flex flex-wrap justify-content-center">
            @forelse ($buku as $item)
                @php
                    $id = $item['id'] ?? null;
                    $judul = $item['judul'] ?? '-';
                    $kode_buku = $item['kode_buku'] ?? '-';
                    $pengarang = $item['pengarang'] ?? '-';
                    $gambar = $item['gambar'] ?? null;
                    $status = $item['status'] ?? 'Tersedia';
                @endphp

                <div class="col-auto my-2" style="width: 18rem;">
                    <div class="card mx-2 my-2 shadow-sm" style="min-height: 28rem; border-radius: 10px; overflow: hidden;">

                        {{-- Gambar Buku --}}
                        @if (!empty($gambar))
                            <img src="{{ asset('img/buku/' . $gambar) }}"
                                alt="Gambar Buku"
                                class="card-img-top"
                                style="height: 200px; width: 100%; object-fit: contain; background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
                        @else
                            <img src="{{ asset('images/noImage.jpg') }}"
                                alt="Tidak ada gambar"
                                class="card-img-top"
                                style="height: 200px; width: 100%; object-fit: contain; background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
                        @endif

                        <div class="card-body d-flex flex-column justify-content-between">
                            {{-- Detail Buku --}}
                            <div class="detail-buku mb-2">
                                <h5 class="card-title text-primary">
                                    <a href="{{ url('/buku/' . $id) }}" style="text-decoration: none; font-size: 1rem; font-weight: bold;">
                                        {{ $judul }}
                                    </a>
                                </h5>
                                <p class="card-text m-0">Kode Buku: {{ $kode_buku }}</p>
                                <p class="card-text m-0">Pengarang: <span class="text-dark">{{ $pengarang }}</span></p>
                                <p class="card-text m-0">Status: {{ $status }}</p>
                            </div>

                            {{-- Tombol Admin --}}
                            @if (session()->has('admin'))
                                <div class="button-area mt-2 d-flex justify-content-between">
                                    <a href="{{ url('/buku/' . $id) }}" class="btn btn-info btn-sm text-white">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ url('/buku/' . $id . '/edit') }}" class="btn btn-warning btn-sm text-white">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('buku.destroy', $item['id']) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                {{-- Tombol User --}}
                                <div class="button-area mt-2 d-flex justify-content-between">
                                    <a href="{{ url('/buku/' . $id) }}" class="btn btn-info btn-sm text-white">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ url('/peminjaman/create') }}" class="btn btn-danger btn-sm text-white">
                                        <i class="fas fa-book-reader"></i> Pinjam
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <h3 class="text-primary mt-3">Tidak ada buku</h3>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between mx-2 my-2">
            <p class="text-primary my-2">
                Menampilkan halaman {{ $buku->currentPage() }} dari {{ $buku->lastPage() }}
            </p>
            {{ $buku->links() }}
        </div>
    </div>
@endsection
