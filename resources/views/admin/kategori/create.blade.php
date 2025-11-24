@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="page-title mb-4">Tambah Kategori Buku</h1>
@endsection

@section('content')

{{-- ========== CSS THEME-AWARE ========== --}}
@include('admin.kategori.partials.style')

<div class="category-card">

    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <span>Kategori digunakan untuk mengelompokkan buku berdasarkan jenisnya.</span>
    </div>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label-custom">Nama Kategori</label>
            <input 
                type="text" 
                name="nama" 
                class="form-input" 
                placeholder="Contoh: Teknologi, Novel, Komik, Biografi..."
                required 
                autofocus
            >

            <div class="form-helper">
                <i class="fas fa-lightbulb" style="color:#667eea;"></i>
                Buat nama kategori yang jelas dan mudah dipahami.
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Simpan
            </button>

            <a href="{{ route('kategori.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

    </form>
</div>

@endsection
