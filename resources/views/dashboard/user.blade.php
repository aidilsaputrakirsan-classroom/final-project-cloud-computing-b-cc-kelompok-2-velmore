@extends('layout.main')

@section('title', 'Dashboard Pengguna')

@section('sidebar')
  <a href="#" class="active"><i class="fa fa-home me-2"></i> Dashboard</a>
  <a href="#"><i class="fa fa-search me-2"></i> Cari Buku</a>
  <a href="#"><i class="fa fa-book-reader me-2"></i> Pinjam Buku</a>
  <a href="#"><i class="fa fa-undo me-2"></i> Kembalikan Buku</a>
  <a href="#"><i class="fa fa-history me-2"></i> Riwayat Peminjaman</a>
@endsection

@section('content')
  <h2>Hai, {{ session('user')['nama'] ?? 'Pengguna' }}!</h2>
  <p>Selamat datang di perpustakaan digital VERLY. Silakan cari buku yang ingin Anda baca atau pinjam.</p>

  <div class="mt-4">
    <form class="d-flex mb-4" role="search">
      <input class="form-control me-2" type="search" placeholder="Cari judul buku..." aria-label="Search">
      <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
    </form>
  </div>
@endsection
