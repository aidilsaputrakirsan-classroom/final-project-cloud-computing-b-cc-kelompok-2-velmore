@extends('layout.main')

@section('title', 'Dashboard Admin')

@section('sidebar')
  @include('partials.admin-sidebar')
@endsection

@section('content')
  <div class="content-header">
    <h2 class="dashboard-title">Selamat Datang, {{ session('admin')['nama'] ?? 'Admin' }} 👋</h2>
    <p class="dashboard-desc">Kelola seluruh data perpustakaan dari satu tempat.</p>
  </div>

  <div class="content-body">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card dashboard-card p-4 shadow-sm">
          <h5><i class="fa fa-users text-primary"></i> Total Pengguna</h5>
          <h3>{{ $totalPengguna ?? 12 }}</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card dashboard-card p-4 shadow-sm">
          <h5><i class="fa fa-book text-success"></i> Total Buku</h5>
          <h3>{{ $totalBuku ?? 120 }}</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card dashboard-card p-4 shadow-sm">
          <h5><i class="fa fa-history text-warning"></i> Total Transaksi</h5>
          <h3>{{ $totalTransaksi ?? 45 }}</h3>
        </div>
      </div>
    </div>
  </div>

  <style>
    .dashboard-title {
      color: #1f2937; /* abu tua elegan */
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .dashboard-desc {
      color: #4b5563; /* abu lembut */
      transition: color 0.3s ease;
    }

    .dashboard-card {
      background: #ffffff;
      border-radius: 18px;
      border: 1px solid rgba(0,0,0,0.08);
      color: #1f2937;
      transition: all 0.4s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    body.dark-mode .dashboard-title {
      color: #f9fafb; /* putih bersih */
    }

    body.dark-mode .dashboard-desc {
      color: #d1d5db; /* abu muda */
    }

    body.dark-mode .dashboard-card {
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      color: #f3f4f6;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    body.dark-mode .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(102,126,234,0.25);
    }

    body.dark-mode .dashboard-card h5 {
      color: #e5e7eb; /* abu terang */
    }

    body.dark-mode .dashboard-card h3 {
      color: #f9fafb; /* putih */
    }

    body.dark-mode .text-primary { color: #60a5fa !important; }
    body.dark-mode .text-success { color: #34d399 !important; }
    body.dark-mode .text-warning { color: #fbbf24 !important; }

  </style>
@endsection
