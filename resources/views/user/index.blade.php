@extends('layout.main')

@section('sidebar')
  @include('partials.user-sidebar')
@endsection

@section('judul')
  <h1 class="text-primary fw-bold mb-4">📚 Daftar Peminjaman</h1>
@endsection

@section('content')
<style>
.card-peminjaman {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 15px;
    box-shadow: 0 4px 20px var(--shadow-color);
    padding: 20px;
    color: var(--text-primary);
    transition: 0.3s;
}
.card-peminjaman:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(79,172,254,0.4);
}
.status-badge {
    padding: 6px 15px;
    border-radius: 20px;
    font-weight: 700;
    text-transform: uppercase;
}
.status-dipinjam { background: linear-gradient(135deg, #38ef7d, #11998e); color:white; }
.status-verifikasi { background: linear-gradient(135deg, #f7971e, #ffd200); color:white; }
.status-terverifikasi { background: linear-gradient(135deg, #00c6ff, #0072ff); color:white; }
</style>

@if(empty($data))
  <div class="alert alert-info text-center py-5">
    <i class="fa fa-info-circle fa-2x mb-3"></i><br>
    Belum ada peminjaman yang tercatat.
  </div>
@else
  <div class="row g-4">
    @foreach($data as $p)
      <div class="col-md-4">
        <div class="card-peminjaman">
          <div class="text-center mb-3">
            <img src="{{ asset('img/buku/' . ($p['gambar'] ?? 'noImage.jpg')) }}"
                 class="img-fluid rounded" style="max-height:200px;">
          </div>

          <h5 class="fw-bold">{{ $p['judul'] ?? 'Judul Tidak Diketahui' }}</h5>
          <p class="mb-1"><strong>Tanggal Pinjam:</strong> {{ $p['tanggal_pinjam'] ?? '-' }}</p>
          <p class="mb-2"><strong>Tanggal Kembali:</strong> {{ $p['tanggal_kembali'] ?? '-' }}</p>

          <p><strong>Status:</strong>
            <span class="status-badge
              {{ $p['status'] == 'Dipinjam' ? 'status-dipinjam' :
                 ($p['status'] == 'Sedang Diverifikasi' ? 'status-verifikasi' : 'status-terverifikasi') }}">
              {{ $p['status'] }}
            </span>
          </p>

          @if($p['status'] == 'Dipinjam')
            <a href="{{ url('/peminjaman/' . $p['id'] . '/edit') }}" class="btn btn-warning w-100 mt-2">
              <i class="fa fa-upload me-2"></i> Kembalikan Buku
            </a>
          @elseif($p['status'] == 'Sedang Diverifikasi')
            <div class="alert alert-warning text-center mt-2">Menunggu Verifikasi Admin</div>
          @else
            <div class="alert alert-success text-center mt-2">Terverifikasi ✓</div>
          @endif
        </div>
      </div>
    @endforeach
  </div>
@endif
@endsection
