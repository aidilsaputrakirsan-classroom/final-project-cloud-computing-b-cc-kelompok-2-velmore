@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="text-primary">{{ $buku->judul }}</h1>
@endsection

@section('content')
<div class="card mb-4 shadow-sm">
    <div class="row g-0 p-4 align-items-center">
        {{-- Kolom Gambar --}}
        <div class="col-md-4 text-center mb-3 mb-md-0">
            @php
                $path = public_path('img/buku/'.$buku->gambar);
            @endphp

            @if($buku->gambar && file_exists($path))
                <img src="{{ asset('img/buku/'.$buku->gambar) }}"
                     alt="{{ $buku->judul }}"
                     class="img-fluid rounded"
                     style="max-height: 400px; width: 100%; object-fit: contain;">
            @else
                <img src="{{ asset('img/buku/noImage.jpg') }}"
                     alt="No Image"
                     class="img-fluid rounded"
                     style="max-height: 400px; width: 100%; object-fit: contain;">
            @endif
        </div>

        {{-- Kolom Detail --}}
        <div class="col-md-8">
            <div class="card-body">
                <h3 class="card-title text-primary mb-3">{{ $buku->judul }}</h3>

                <div class="mb-2">
                    <strong>Pengarang:</strong> <span class="text-secondary">{{ $buku->pengarang }}</span>
                </div>
                <div class="mb-2">
                    <strong>Penerbit:</strong> <span class="text-secondary">{{ $buku->penerbit }}</span>
                </div>
                <div class="mb-2">
                    <strong>Tahun Terbit:</strong> <span class="text-secondary">{{ $buku->tahun_terbit }}</span>
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p style="text-align: justify; text-indent: 1rem; letter-spacing: .05rem;">
                        {{ $buku->deskripsi }}
                    </p>
                </div>

                <a href="/buku" class="btn btn-primary px-4">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
