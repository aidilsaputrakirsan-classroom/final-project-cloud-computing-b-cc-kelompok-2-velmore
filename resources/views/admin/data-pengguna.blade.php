@extends('layout.main')

@section('title', 'Data Pengguna')

@section('sidebar')
  @include('partials.admin-sidebar')
@endsection

@section('content')
  <div class="content-header">
    <h2 class="dashboard-title">Daftar Pengguna</h2>
    <p class="dashboard-desc">Berikut adalah seluruh pengguna yang terdaftar dalam sistem VERLY.</p>
  </div>

  <div class="content-body">
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive mt-3">
      <table class="table table-bordered table-striped pengguna-table align-middle">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
            <tr>
              <td>{{ $user['nama'] ?? '-' }}</td>
              <td>{{ $user['email'] ?? '-' }}</td>
              <td>
                @if (!empty($user['isAdmin']) && $user['isAdmin'])
                  <span class="badge bg-primary">Admin</span>
                @else
                  <span class="badge bg-secondary">User</span>
                @endif
              </td>
              <td>
                <a href="{{ route('pengguna.edit', $user['id']) }}" class="btn btn-warning btn-sm">
                  <i class="fa fa-edit"></i> Edit
                </a>
                <form action="{{ route('pengguna.delete', $user['id']) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pengguna ini?')">
                    <i class="fa fa-trash"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">Belum ada pengguna</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

   <style>
    /* ⚙️ Transisi umum */
    .pengguna-table {
      border-collapse: separate;
      border-spacing: 0;
      overflow: hidden;
      border-radius: 12px;
      transition: all 0.4s ease;
      box-shadow: 0 0 25px rgba(0,0,0,0.1);
    }

    /* 🌞 Light mode */
    .pengguna-table thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .pengguna-table tbody tr {
      background: #ffffff;
      color: #1f2937;
      transition: all 0.3s ease;
    }

    .pengguna-table tbody tr:hover {
      background: #eef2ff;
      transform: scale(1.01);
    }

    /* 🌙 Dark futuristic mode */
    body.dark-mode .pengguna-table {
      background: rgba(17, 24, 39, 0.6);
      border: 1px solid rgba(102,126,234,0.25);
      box-shadow:
        0 0 10px rgba(102,126,234,0.15),
        inset 0 0 20px rgba(118,75,162,0.15);
      backdrop-filter: blur(12px);
    }

    body.dark-mode .pengguna-table thead {
      background: linear-gradient(135deg, rgba(102,126,234,0.4) 0%, rgba(118,75,162,0.5) 100%);
      color: #f9fafb;
      text-shadow: 0 0 8px rgba(255,255,255,0.4);
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    body.dark-mode .pengguna-table tbody tr {
      background: rgba(255,255,255,0.04);
      color: #e5e7eb;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      transition: all 0.4s ease;
    }

    body.dark-mode .pengguna-table tbody tr:hover {
      background: rgba(102,126,234,0.12);
      box-shadow: 0 0 15px rgba(102,126,234,0.25);
      transform: translateY(-2px) scale(1.01);
    }

    body.dark-mode .pengguna-table th,
    body.dark-mode .pengguna-table td {
      border-color: rgba(255,255,255,0.08);
    }

    /* 🟢 Badge & Button adjustments */
    body.dark-mode .badge.bg-primary {
      background: linear-gradient(135deg,#667eea,#764ba2);
      box-shadow: 0 0 10px rgba(118,75,162,0.5);
    }
    body.dark-mode .badge.bg-secondary {
      background: rgba(107,114,128,0.6);
    }

    body.dark-mode .btn-warning {
      background: linear-gradient(135deg,#fcd34d,#fbbf24);
      border: none;
      color: #111827;
      box-shadow: 0 0 10px rgba(251,191,36,0.4);
    }
    body.dark-mode .btn-danger {
      background: linear-gradient(135deg,#f87171,#dc2626);
      border: none;
      color: #fff;
      box-shadow: 0 0 10px rgba(239,68,68,0.4);
    }

    /* 💡 Header & Desc harmonisasi */
    body.dark-mode .dashboard-title { color: #f9fafb; }
    body.dark-mode .dashboard-desc { color: #cbd5e1; }

  </style>

@endsection
