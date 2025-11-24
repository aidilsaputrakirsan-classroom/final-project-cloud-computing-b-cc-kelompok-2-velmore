@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="theme-title mb-4">{{ $buku->judul }}</h1>
@endsection

@section('content')
<style>
/* 🌗 THEME-AWARE DETAIL STYLE */
.detail-card {
    border-radius: 25px;
    padding: 40px;
    backdrop-filter: blur(10px);
    transition: all 0.4s ease;
    border: 1px solid transparent;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
}
body.light-mode .detail-card {
    background: linear-gradient(135deg, rgba(250,250,250,0.8), rgba(240,240,240,0.7));
    border-color: rgba(200,200,200,0.4);
    color: #1a1a1a;
}
body.dark-mode .detail-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03));
    border-color: rgba(255,255,255,0.15);
    color: white;
}

.buku-image {
    border-radius: 15px;
    max-height: 420px;
    width: 100%;
    object-fit: contain;
    box-shadow: 0 5px 25px rgba(0,0,0,0.25);
    transition: transform 0.3s ease;
}
.buku-image:hover {
    transform: scale(1.02);
}

.detail-info strong {
    color: #667eea;
}
body.dark-mode .detail-info strong {
    color: #a5b4fc;
}

.btn-futuristic {
    padding: 12px 35px;
    border-radius: 50px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    border: none;
    transition: all 0.3s ease;
}
.btn-primary-futuristic {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.btn-primary-futuristic:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102,126,234,0.4);
}
</style>

<div class="detail-card">
    <div class="row g-4 align-items-center">
        {{-- Kolom Gambar --}}
        <div class="col-lg-4 text-center">
            @php
                $path = public_path('img/buku/' . $buku->gambar);
            @endphp

            @if($buku->gambar && file_exists($path))
                <img src="{{ asset('img/buku/' . $buku->gambar) }}"
                     alt="{{ $buku->judul }}"
                     class="buku-image">
            @else
                <img src="{{ asset('img/buku/noImage.jpg') }}"
                     alt="No Image"
                     class="buku-image">
            @endif
        </div>

        {{-- Kolom Detail --}}
        <div class="col-lg-8">
            <div class="card-body">
                <h2 class="mb-3 fw-bold" style="font-size: 1.8rem;">
                    {{ $buku->judul }}
                </h2>

                <div class="detail-info mb-2">
                    <strong><i class="fas fa-user-edit me-2"></i>Pengarang:</strong>
                    <span>{{ $buku->pengarang }}</span>
                </div>
                <div class="detail-info mb-2">
                    <strong><i class="fas fa-building me-2"></i>Penerbit:</strong>
                    <span>{{ $buku->penerbit }}</span>
                </div>
                <div class="detail-info mb-3">
                    <strong><i class="fas fa-calendar-alt me-2"></i>Tahun Terbit:</strong>
                    <span>{{ $buku->tahun_terbit }}</span>
                </div>

                <div class="mb-4">
                    <strong><i class="fas fa-align-left me-2"></i>Deskripsi:</strong>
                    <p style="text-align: justify; text-indent: 1rem; letter-spacing: .05rem; line-height: 1.6;">
                        {{ $buku->deskripsi }}
                    </p>
                </div>
                <div class="detail-info">
                    <strong>Kategori: </strong> {{ $buku->kategori_nama }}
                </div>
                <a href="/buku" class="btn-futuristic btn-primary-futuristic">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
