@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="page-title mb-4">
        Perpustakaan Digital
    </h1>
@endsection

@section('content')
<style>
/* ==========================================================
   🌗 THEME-AWARE UI (FULL VERSION)
   ========================================================== */

/* === Default (Dark Mode) === */
:root {
    --bg-card: rgba(255, 255, 255, 0.1);
    --bg-card-secondary: rgba(255, 255, 255, 0.05);
    --border-color: rgba(255, 255, 255, 0.18);
    --text-primary: #ffffff;
    --text-secondary: rgba(255, 255, 255, 0.85);
    --text-tertiary: rgba(255, 255, 255, 0.5);
    --input-bg: rgba(255, 255, 255, 0.08);
    --input-bg-focus: rgba(255, 255, 255, 0.15);
    --shadow-color: rgba(31, 38, 135, 0.37);
    --book-body-bg: rgba(0, 0, 0, 0.2);
    --empty-icon-color: #667eea;
    --label-color: #a78bfa;
}

/* === Light Mode Auto (OS preference) === */
@media (prefers-color-scheme: light) {
    :root {
        --bg-card: rgba(255, 255, 255, 0.98);
        --bg-card-secondary: rgba(248, 250, 252, 0.95);
        --border-color: rgba(148, 163, 184, 0.3);
        --text-primary: #1e293b;
        --text-secondary: #334155;
        --text-tertiary: #64748b;
        --input-bg: #f8fafc;
        --input-bg-focus: #ffffff;
        --shadow-color: rgba(15, 23, 42, 0.08);
        --book-body-bg: rgba(248, 250, 252, 0.8);
        --empty-icon-color: #667eea;
        --label-color: #4f46e5;
    }
}

/* === Manual Theme Switch (via JS toggle) === */
[data-theme="dark"], body.dark-mode {
    --bg-card: rgba(255, 255, 255, 0.1);
    --bg-card-secondary: rgba(255, 255, 255, 0.05);
    --border-color: rgba(255, 255, 255, 0.18);
    --text-primary: #ffffff;
    --text-secondary: rgba(255, 255, 255, 0.85);
    --text-tertiary: rgba(255, 255, 255, 0.5);
    --input-bg: rgba(255, 255, 255, 0.08);
    --input-bg-focus: rgba(255, 255, 255, 0.15);
    --shadow-color: rgba(31, 38, 135, 0.37);
    --book-body-bg: rgba(0, 0, 0, 0.2);
    --empty-icon-color: #667eea;
    --label-color: #a5b4fc;
}

[data-theme="light"], body.light-mode {
    --bg-card: rgba(255, 255, 255, 0.98);
    --bg-card-secondary: rgba(248, 250, 252, 0.95);
    --border-color: rgba(148, 163, 184, 0.3);
    --text-primary: #1e293b;
    --text-secondary: #334155;
    --text-tertiary: #64748b;
    --input-bg: #f8fafc;
    --input-bg-focus: #ffffff;
    --shadow-color: rgba(15, 23, 42, 0.08);
    --book-body-bg: rgba(248, 250, 252, 0.8);
    --empty-icon-color: #667eea;
    --label-color: #1a1a1a;
}

/* === Page Title === */
.page-title {
    color: var(--text-primary);
    font-weight: 700;
    text-shadow: 0 0 20px rgba(79, 172, 254, 0.3);
}

/* === Search Card === */
.search-card {
    background: var(--bg-card);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 32px 0 var(--shadow-color);
    padding: 30px;
    margin-bottom: 30px;
    animation: fadeIn 0.6s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* === Search Input & Label === */
.search-label {
    color: var(--label-color);
    font-weight: 700;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
    display: block;
}

.search-input {
    background: var(--input-bg);
    border: 2px solid var(--border-color);
    border-radius: 15px;
    color: var(--text-primary);
    padding: 12px 20px;
    transition: all 0.3s ease;
    width: 100%;
}

.search-input:focus {
    background: var(--input-bg-focus);
    border-color: #667eea;
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
    color: var(--text-primary);
    outline: none;
}

.search-input::placeholder {
    color: var(--text-tertiary);
}
.search-input option {
    background: var(--input-bg);
    color: var(--text-primary);
}

/* === Buttons === */
.btn-add {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(56, 239, 125, 0.4);
    display: inline-block;
}
.btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(56, 239, 125, 0.6);
    color: white;
}
.btn-search {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 0;
    border-radius: 15px;
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}
.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
}

/* === Book Card === */
.book-card {
    background: var(--bg-card);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    height: 100%;
    box-shadow: 0 8px 25px var(--shadow-color);
    animation: slideUp 0.5s ease-out backwards;
}
.book-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 45px rgba(102, 126, 234, 0.4);
    border-color: rgba(102, 126, 234, 0.5);
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.book-image-wrapper {
    position: relative;
    height: 250px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    overflow: hidden;
}
.book-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.4s ease;
    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
}
.book-card:hover .book-image { transform: scale(1.1) rotate(2deg); }

.book-body {
    padding: 20px;
    background: var(--book-body-bg);
}
.book-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 15px;
    min-height: 55px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-decoration: none;
    transition: all 0.3s ease;
}
.book-title:hover {
    color: #667eea;
    text-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
}
.book-info {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 8px;
    font-weight: 500;
}
.book-info-label {
    color: #667eea;
    font-weight: 700;
}

/* === Status Badge === */
.status-badge {
    display: inline-block;
    padding: 6px 15px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 5px;
}
.status-tersedia {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(56, 239, 125, 0.3);
}
.status-dipinjam {
    background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(238, 9, 121, 0.3);
}

/* === Buttons in Card === */
.book-actions {
    display: flex;
    gap: 8px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid var(--border-color);
}
.btn-action {
    flex: 1;
    padding: 10px 5px;
    border-radius: 10px;
    border: none;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    transition: all 0.3s ease;
    color: white;
    text-decoration: none;
    text-align: center;
}
.btn-detail {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    box-shadow: 0 3px 10px rgba(79, 172, 254, 0.3);
}
.btn-detail:hover { transform: translateY(-2px); }
.btn-edit {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}
.btn-edit:hover { transform: translateY(-2px); }
.btn-delete {
    background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
}
.btn-delete:hover { transform: translateY(-2px); }
.btn-pinjam {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.btn-pinjam:hover { transform: translateY(-2px); }

/* === Pagination === */
.pagination-wrapper {
    background: var(--bg-card);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px 30px;
    border: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
}
.pagination-info {
    color: var(--text-secondary);
    font-weight: 700;
    font-size: 0.95rem;
}

/* === Empty State === */
.empty-state {
    background: var(--bg-card);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    border: 2px dashed var(--border-color);
    text-align: center;
    padding: 80px 40px;
    margin: 20px 0;
    animation: fadeIn 0.6s ease-out;
}
.empty-state i {
    font-size: 5rem;
    margin-bottom: 25px;
    color: var(--empty-icon-color);
    opacity: 0.7;
}
.empty-state h3 {
    color: var(--text-primary);
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1.5rem;
}
.empty-state p {
    color: var(--text-secondary);
    font-size: 1rem;
    margin: 0;
    font-weight: 500;
}

/* === Responsive Tweaks === */
@media (max-width: 768px) {
    .search-card { padding: 20px; }
    .empty-state { padding: 60px 20px; }
    .empty-state i { font-size: 4rem; }
    .empty-state h3 { font-size: 1.25rem; }
    .empty-state p { font-size: 0.95rem; }
}
</style>

{{-- Tombol Tambah Buku --}}
@if (session()->has('admin'))
    <div class="mb-4">
        <a href="{{ route('buku.tambah') }}" class="btn-add">
            <i class="fas fa-plus me-2"></i> Tambah Buku Baru
        </a>
    </div>
@endif

{{-- Form Pencarian --}}
<div class="search-card">
    <form action="{{ url('/buku') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="search-label"><i class="fas fa-book me-2"></i>Judul Buku</label>
                <input type="text" name="judul" class="form-control search-input"
                       placeholder="Cari judul..." value="{{ request('judul') }}">
            </div>
            <div class="col-md-2">
                <label class="search-label"><i class="fas fa-barcode me-2"></i>Kode Buku</label>
                <input type="text" name="kode_buku" class="form-control search-input"
                       placeholder="Kode buku..." value="{{ request('kode_buku') }}">
            </div>
            <div class="col-md-3">
                <label class="search-label"><i class="fas fa-user me-2"></i>Pengarang</label>
                <input type="text" name="pengarang" class="form-control search-input"
                       placeholder="Nama pengarang..." value="{{ request('pengarang') }}">
            </div>
            <div class="col-md-2">
                <label class="search-label"><i class="fas a-filter me-2"></i>Status</label>
                <select name="status" class="form-control search-input">
                    <option value="">Semua</option>
                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Dipinjam"  {{ request('status') == 'Dipinjam'  ? 'selected' : '' }}>Dipinjam</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="search-label" style="opacity:0;">Action</label>
                <button class="btn btn-search w-100" type="submit">
                    <i class="fas fa-search me-2"></i> Cari
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Grid Buku --}}
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
    @forelse ($buku as $item)
        @php
            $id         = $item['id'] ?? null;
            $judul      = $item['judul'] ?? '-';
            $kode_buku  = $item['kode_buku'] ?? '-';
            $pengarang  = $item['pengarang'] ?? '-';
            $gambar     = $item['gambar'] ?? null;
            $status     = $item['status'] ?? 'Tersedia';
        @endphp

        <div class="col">
            <div class="book-card">
                {{-- Gambar Buku --}}
                <div class="book-image-wrapper">
                    @if (!empty($gambar))
                        <img src="{{ asset('img/buku/' . $gambar) }}" alt="{{ $judul }}" class="book-image">
                    @else
                        <img src="{{ asset('images/noImage.jpg') }}" alt="No Image" class="book-image">
                    @endif
                </div>

                {{-- Body Card --}}
                <div class="book-body">
                    <a href="{{ url('/buku/' . $id) }}" class="book-title">
                        {{ $judul }}
                    </a>

                    <div class="book-info">
                        <span class="book-info-label">Kode:</span> {{ $kode_buku }}
                    </div>
                    <div class="book-info">
                        <span class="book-info-label">Pengarang:</span> {{ $pengarang }}
                    </div>
                    <div>
                        <span class="status-badge {{ $status == 'Tersedia' ? 'status-tersedia' : 'status-dipinjam' }}">
                            {{ $status }}
                        </span>
                    </div>

                    {{-- Tombol Aksi --}}
                    @if (session()->has('admin'))
                        <div class="book-actions">
                            <a href="{{ url('/buku/' . $id) }}" class="btn-action btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ url('/buku/' . $id . '/edit') }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('buku.destroy', $item['id']) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                                  style="flex:1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete w-100">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="book-actions">
                            <a href="{{ url('/buku/' . $id) }}" class="btn-action btn-detail">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ url('/peminjaman/create') }}" class="btn-action btn-pinjam">
                                <i class="fas fa-book-reader"></i> Pinjam
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h3>Tidak Ada Buku Ditemukan</h3>
                <p>Coba ubah kriteria pencarian Anda atau hapus filter yang diterapkan</p>
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if ($buku->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Halaman {{ $buku->currentPage() }} dari {{ $buku->lastPage() }}
        </div>
        <div>
            {{ $buku->links() }}
        </div>
    </div>
@endif
@endsection
