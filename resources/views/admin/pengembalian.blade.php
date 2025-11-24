@extends('layout.main')
@section('title', 'Data Pengembalian Buku')
@section('sidebar')
  {{-- 🔹 Sidebar Admin --}}
  @include('partials.admin-sidebar')
@endsection
@section('content')
<div class="container py-4">
  <div class="admin-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 p-4 rounded-4 shadow-sm">
    <div>
      <h2 class="fw-bold mb-2 admin-title">
        <i class="fa fa-undo me-2"></i>Daftar Pengembalian Buku
      </h2>
      <p class="admin-subtitle mb-0">Daftar semua buku yang sudah dikembalikan oleh pengguna</p>
    </div>
  </div>

  {{-- 🔍 Pencarian --}}
  <form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" class="form-control rounded-pill"
           placeholder="Cari berdasarkan judul atau nama peminjam..."
           value="{{ request('search') }}">
    <button class="btn btn-accent rounded-pill px-4"><i class="fa fa-search me-1"></i>Cari</button>
  </form>

  {{-- 📋 Tabel --}}
  <div class="table-responsive">
    <table class="table table-striped align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Judul Buku</th>
          <th>Peminjam</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Denda</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @php
          $search = strtolower(request('search', ''));
          $filtered = collect($pengembalianList)->filter(function($item) use ($search) {
              return str_contains(strtolower($item['buku']), $search)
                  || str_contains(strtolower($item['peminjam']), $search);
          });
        @endphp

        @forelse($filtered as $row)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row['buku'] }}</td>
            <td>{{ $row['peminjam'] }}</td>
            <td>{{ $row['tanggal_pinjam'] }}</td>
            <td>{{ $row['tanggal_kembali'] }}</td>
            <td>
              @if($row['denda'] > 0)
                <span class="badge bg-danger">Rp{{ number_format($row['denda'], 0, ',', '.') }}</span>
              @else
                <span class="badge bg-success">Tidak Ada</span>
              @endif
            </td>
            <td>
              <span class="badge {{ $row['status'] === 'Terverifikasi' ? 'bg-primary' : 'bg-warning' }}">
                {{ $row['status'] }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-muted py-4">Tidak ada data pengembalian 📭</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<style>
body.light-mode .admin-header {
  background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
  color: #1e293b;
}
body.dark-mode .admin-header {
  background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
  color: #f8fafc;
}
.admin-title { font-weight: 700; }
.admin-subtitle { font-size: .95rem; opacity: .85; }
.btn-accent {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: #fff; border: none; transition: .3s;
}
.btn-accent:hover { transform: translateY(-2px); box-shadow: 0 0 10px rgba(102,126,234,0.4); }
</style>
@endsection
