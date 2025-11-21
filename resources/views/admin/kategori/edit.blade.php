@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="page-title mb-4">Edit Kategori Buku</h1>
@endsection

@section('content')

{{-- ========== CSS THEME-AWARE ========== --}}
@include('admin.kategori.partials.style')

<div class="category-card">

    <div class="info-box">
        <i class="fas fa-edit"></i>
        <span>Edit nama kategori buku sesuai kebutuhan perpustakaan.</span>
    </div>

    <span class="id-badge">ID: {{ $kategori['id'] }}</span>

    <form action="{{ route('kategori.update', $kategori['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label-custom">Nama Kategori</label>
            <input 
                type="text" 
                name="nama" 
                class="form-input"
                value="{{ $kategori['nama'] }}"
                required 
            >

            <div class="form-helper">
                <i class="fas fa-info-circle"></i>
                Perbarui nama kategori agar lebih rapi dan konsisten.
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-update">
                <i class="fas fa-save"></i> Perbarui
            </button>

            <a href="{{ route('kategori.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

    </form>

</div>

@endsection
