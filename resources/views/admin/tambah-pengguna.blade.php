@extends('layout.main')

@section('title', 'Tambah Pengguna')

@section('sidebar')
  @include('partials.admin-sidebar')
@endsection

@section('content')
  <div class="content-header">
    <h2 class="dashboard-title">Tambah Pengguna Baru</h2>
    <p class="dashboard-desc">Gunakan form ini untuk menambahkan pengguna baru ke sistem VERLY.</p>
  </div>

  <div class="content-body">
    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pengguna.store') }}" method="POST" class="p-4 rounded-4 shadow-sm user-form">
      @csrf

      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap pengguna" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="********" required>
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" name="isadmin" class="form-check-input" id="isadmin">
        <label class="form-check-label" for="isadmin">Jadikan Admin</label>
      </div>

      <button type="submit" class="btn btn-gradient">
        <i class="fa fa-save me-2"></i> Simpan Pengguna
      </button>
    </form>
  </div>

  <style>
    /* --------------------------- */
    /* 🌞 LIGHT MODE DEFAULT STYLE */
    /* --------------------------- */
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

    /* --------------------------- */
    /* 🌙 DARK FUTURISTIC MODE     */
    /* --------------------------- */
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

    /* 🌟 Alert styles for both modes */
    .alert {
      border-radius: 10px;
      font-weight: 500;
      animation: fadeIn 0.4s ease;
    }

    body.dark-mode .alert-success {
      background: rgba(34,197,94,0.15);
      border: 1px solid rgba(34,197,94,0.3);
      color: #a7f3d0;
    }

    body.dark-mode .alert-danger {
      background: rgba(239,68,68,0.15);
      border: 1px solid rgba(239,68,68,0.3);
      color: #fecaca;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
@endsection
