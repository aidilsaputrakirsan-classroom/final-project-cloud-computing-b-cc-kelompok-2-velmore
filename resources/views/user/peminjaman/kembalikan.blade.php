@extends('layout.main')

@section('sidebar')
  @include('partials.user-sidebar')
@endsection

@section('judul')
  <h1 class="text-primary fw-bold mb-4">📦 Kembalikan Buku</h1>
@endsection

@section('content')
<style>
.form-card {
    background: var(--bg-card);
    border-radius: 15px;
    border: 1px solid var(--border-color);
    padding: 30px;
    color: var(--text-primary);
    box-shadow: 0 4px 20px var(--shadow-color);
}
.btn-submit {
    background: linear-gradient(135deg, #38ef7d, #11998e);
    border: none;
    color: white;
    font-weight: 700;
    padding: 10px 25px;
    border-radius: 10px;
    transition: 0.3s;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(56,239,125,0.4);
}
</style>

@if(!$peminjaman)
  <div class="alert alert-danger">Data peminjaman tidak ditemukan.</div>
@else
  <div class="form-card">
    <h4 class="fw-bold mb-3">{{ $peminjaman['judul'] ?? 'Judul Buku Tidak Diketahui' }}</h4>
    <p>Silakan unggah bukti pengembalian buku di bawah ini.</p>

    <form action="{{ url('/peminjaman/' . $peminjaman['id']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="bukti_pengembalian" class="form-label fw-bold">📁 Bukti Pengembalian (jpg/png)</label>
        <input type="file" name="bukti_pengembalian" id="bukti_pengembalian"
               class="form-control" accept="image/*" required>
        @error('bukti_pengembalian')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <button type="submit" class="btn-submit">
        <i class="fa fa-upload me-2"></i> Upload Bukti
      </button>
      <a href="{{ url('/peminjaman') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
  </div>
@endif
@endsection
