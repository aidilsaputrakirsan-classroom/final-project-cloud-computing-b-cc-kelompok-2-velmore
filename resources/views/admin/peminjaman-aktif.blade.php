@extends('layout.main')
@section('title', 'Peminjaman Aktif')

@section('sidebar')
  {{-- 🔹 Sidebar Admin --}}
  @include('partials.admin-sidebar')
@endsection

@section('content')
<div class="container py-4">

  {{-- 🔹 Header Section --}}
  <div class="admin-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 p-4 rounded-4 shadow-sm">
    <div>
      <h2 class="fw-bold mb-2 admin-title">
        <i class="fa fa-book me-2"></i>Daftar Peminjaman Aktif
      </h2>
      <p class="admin-subtitle mb-0">
        Pantau status dan durasi semua buku yang sedang dipinjam oleh pengguna
      </p>
    </div>
    <div class="text-end">
      <span class="badge rounded-pill admin-badge px-3 py-2">
        <i class="fa fa-clock me-1"></i> Pembaruan Otomatis Harian
      </span>
    </div>
  </div>

  {{-- 🔍 Form Pencarian --}}
  <form method="GET" action="{{ route('admin.peminjaman') }}" class="mb-4">
    <div class="row g-2 align-items-center">
      <div class="col-md-4 col-sm-6">
        <input type="text" name="search" class="form-control input-theme"
              placeholder="Cari berdasarkan judul, peminjam, atau kontak..."
              value="{{ request('search') }}">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-accent w-100">
          <i class="fa fa-search me-1"></i> Cari
        </button>
      </div>
    </div>
  </form>

  {{-- 🔹 Tabel Data --}}
  <div class="table-responsive">
    <table class="table table-striped align-middle text-center table-theme">
      <thead class="table-header">
        <tr>
          <th>#</th>
          <th>Judul Buku</th>
          <th>Peminjam</th>
          <th>Kontak</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Sisa Waktu</th>
        </tr>
      </thead>
      <tbody>
        @php
          $filtered = collect($peminjamanAktif ?? [])->filter(function ($row) {
              $q = strtolower(request('search', ''));
              return !$q
                  || str_contains(strtolower($row['buku']['judul'] ?? ''), $q)
                  || str_contains(strtolower($row['pengguna']['nama'] ?? ''), $q)
                  || str_contains(strtolower($row['kontak'] ?? ''), $q);
          });
        @endphp

        @forelse($filtered as $row)
          @php
            $hari = round($row['sisa_hari'] ?? 0);
            $warna = $hari < 0 ? 'danger' : ($hari <= 2 ? 'warning' : 'success');
          @endphp
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row['buku']['judul'] ?? '-' }}</td>
            <td>{{ $row['pengguna']['nama'] ?? 'Tidak diketahui' }}</td>
            <td>{{ $row['kontak'] ?? '-' }}</td>
            <td>{{ $row['tanggal_pinjam'] }}</td>
            <td>{{ $row['tanggal_kembali'] }}</td>
            <td>
              @if($hari < 0)
                <span class="badge bg-danger">Terlambat {{ abs($hari) }} hari</span>
              @else
                <span class="badge bg-{{ $warna }}">Sisa {{ $hari }} hari</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center py-4 text-muted">
              Tidak ada peminjaman aktif 📭
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

{{-- ==================== STYLE ==================== --}}
<style>
/* === Header Container === */
.admin-header {
  transition: background-color 0.3s ease, color 0.3s ease;
  border-left: 6px solid transparent;
}

/* === Light Mode === */
body.light-mode {
  color: #1a202c;
  background-color: #f8fafc;
}
body.light-mode .admin-header {
  background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
  border-left-color: #6366f1;
  color: #1e293b;
}
body.light-mode .admin-title {
  color: #1e293b;
  font-weight: 700;
}
body.light-mode .admin-subtitle {
  color: #475569;
  font-size: 0.95rem;
}
body.light-mode .admin-badge {
  background: #e0e7ff;
  color: #312e81;
  box-shadow: 0 0 8px rgba(99,102,241,0.3);
}

/* === Dark Mode === */
body.dark-mode {
  color: #f8fafc;
  background-color: #0f172a;
}
body.dark-mode .admin-header {
  background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
  border-left-color: #8b5cf6;
  color: #f8fafc;
}
body.dark-mode .admin-title {
  color: #f8fafc;
}
body.dark-mode .admin-subtitle {
  color: #cbd5e1;
  font-size: 0.95rem;
}
body.dark-mode .admin-badge {
  background: #4338ca;
  color: #e0e7ff;
  box-shadow: 0 0 10px rgba(99,102,241,0.5);
}

/* === Table === */
.table-theme {
  border-radius: 12px;
  overflow: hidden;
  transition: background-color 0.3s ease, color 0.3s ease;
}
.table-theme th, .table-theme td {
  vertical-align: middle;
  font-size: 0.95rem;
  transition: color 0.3s ease;
}
body.light-mode .table-header {
  background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
  color: white;
}
body.light-mode .table-theme {
  background: white;
  color: #1e293b;
}
body.light-mode .table-theme tbody tr:nth-child(even) {
  background-color: #f8fafc;
}
body.dark-mode .table-header {
  background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
  color: #e2e8f0;
}
body.dark-mode .table-theme {
  background-color: #0f172a;
  color: #e2e8f0;
}
body.dark-mode .table-theme tbody tr:nth-child(even) {
  background-color: #1e293b;
}

/* === Input & Button === */
.input-theme {
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 0.95rem;
  transition: all .3s ease;
}
body.light-mode .input-theme {
  background: #f7fafc;
  border: 2px solid #e2e8f0;
  color: #1a202c;
}
body.light-mode .input-theme:focus {
  background: #fff; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
}
body.dark-mode .input-theme {
  background: rgba(51,65,85,0.6);
  border: 2px solid rgba(255,255,255,0.2);
  color: #fff;
}
body.dark-mode .input-theme:focus {
  border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139,92,246,0.2);
}
.btn-accent {
  background: linear-gradient(135deg,#6a11cb 0%,#2575fc 100%);
  border:none; color:white; font-weight:600;
  padding:10px 24px; border-radius:10px;
  box-shadow:0 4px 15px rgba(102,126,234,0.4);
  transition:all .3s;
}
.btn-accent:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(102,126,234,0.6); }

@media (max-width: 576px) {
  .admin-header { padding: 1rem; }
  .admin-title { font-size: 1.25rem; }
  .admin-subtitle { font-size: 0.85rem; }
  .table-theme th, .table-theme td { font-size: 0.85rem; }
}
</style>
