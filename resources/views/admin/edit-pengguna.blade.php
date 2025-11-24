@extends('layout.main')

@section('title', 'Edit Pengguna')

@section('sidebar')
  @include('partials.admin-sidebar')
@endsection

@section('content')
  <div class="content-header">
    <h2 class="dashboard-title">Edit Pengguna</h2>
    <p class="dashboard-desc">Perbarui data pengguna berikut sesuai kebutuhan.</p>
  </div>

  <div class="content-body">
    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pengguna.update', $user['id']) }}" method="POST" class="p-4 rounded-4 shadow-sm user-form">
      @csrf

      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="{{ $user['nama'] }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user['email'] }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password (opsional)</label>
        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti">
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" name="isadmin" class="form-check-input" id="isadmin" value="1"
              {{ !empty($user['isadmin']) && filter_var($user['isadmin'], FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}>
        <label class="form-check-label" for="isadmin">Jadikan Admin</label>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-gradient">
          <i class="fa fa-save me-2"></i> Perbarui Pengguna
        </button>
        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary">
          <i class="fa fa-arrow-left me-2"></i> Kembali
        </a>
      </div>
    </form>
  </div>

  <style>
    /* 🌞 Light Mode Default */
    .dashboard-title {
      color: #1f2937;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .dashboard-desc {
      color: #4b5563;
      transition: color 0.3s ease;
    }

    .user-form {
      background: #ffffff;
      border: 1px solid rgba(0,0,0,0.08);
      transition: all 0.4s ease;
    }

    .form-label {
      font-weight: 500;
      color: #1f2937;
    }

    .form-control {
      background: #f9fafb;
      border: 1px solid #d1d5db;
      color: #111827;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
    }

    .btn-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 10px 22px;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(118,75,162,0.3);
    }

    .btn-gradient:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(102,126,234,0.4);
    }

    .btn-outline-secondary {
      border: 1px solid #9ca3af;
      color: #374151;
      background: transparent;
      transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
      background: #f3f4f6;
      color: #111827;
    }

    /* 🌙 Dark Mode Futuristic */
    body.dark-mode .dashboard-title {
      color: #f9fafb;
    }

    body.dark-mode .dashboard-desc {
      color: #cbd5e1;
    }

    body.dark-mode .user-form {
      background: rgba(17, 24, 39, 0.6);
      border: 1px solid rgba(102,126,234,0.3);
      box-shadow: 
        0 0 15px rgba(102,126,234,0.25),
        inset 0 0 25px rgba(118,75,162,0.15);
      backdrop-filter: blur(12px);
      color: #e5e7eb;
    }

    body.dark-mode .form-label {
      color: #e5e7eb;
    }

    body.dark-mode .form-control {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.15);
      color: #f9fafb;
    }

    body.dark-mode .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 10px rgba(102,126,234,0.4);
    }

    body.dark-mode .btn-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 0 15px rgba(118,75,162,0.5);
    }

    body.dark-mode .btn-gradient:hover {
      transform: scale(1.03);
      box-shadow: 0 0 25px rgba(102,126,234,0.6);
    }

    body.dark-mode .btn-outline-secondary {
      border: 1px solid rgba(156,163,175,0.4);
      color: #e5e7eb;
      background: transparent;
    }

    body.dark-mode .btn-outline-secondary:hover {
      background: rgba(255,255,255,0.1);
      color: #fff;
    }

    body.dark-mode .alert-danger {
      background: rgba(239,68,68,0.15);
      border: 1px solid rgba(239,68,68,0.3);
      color: #fecaca;
    }

    /* ✨ Animasi */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .alert {
      border-radius: 10px;
      animation: fadeIn 0.4s ease;
    }
  </style>
@endsection
