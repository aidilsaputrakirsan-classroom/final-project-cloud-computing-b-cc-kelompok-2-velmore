@extends('layout.main')

@section('title', 'Dashboard Pengguna')

@section('sidebar')
  <a href="{{ route('dashboard.user') }}" 
     class="{{ !request()->has('tab') ? 'active' : '' }}"
     data-title="Peminjaman">
    <i class="fa fa-book-reader"></i>
    <span>Peminjaman</span>
  </a>
  <a href="{{ route('dashboard.user') }}?tab=pengembalian"
     class="{{ request()->get('tab') == 'pengembalian' ? 'active' : '' }}"
     data-title="Pengembalian">
    <i class="fa fa-undo"></i>
    <span>Pengembalian</span>
  </a>
  <a href="{{ route('dashboard.user') }}?tab=riwayat"
     class="{{ request()->get('tab') == 'riwayat' ? 'active' : '' }}"
     data-title="Riwayat">
    <i class="fa fa-history"></i>
    <span>Riwayat</span>
  </a>
@endsection

@section('content')
@php
  $tab = request('tab', 'peminjaman');
  $today = \Carbon\Carbon::today();
  $max = $today->copy()->addDays(7);
@endphp

<style>
/* === Card === */
.card-theme {
  border-radius: 16px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.card-theme:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.15); }
.card-theme .card-body { padding: 1.5rem; }
.card-theme img { transition: transform 0.3s ease; }
.card-theme:hover img { transform: scale(1.05); }

/* === Light Mode === */
body.light-mode .card-theme { background:white; color:#1a202c; border:1px solid rgba(0,0,0,0.1); }
body.light-mode .card-theme h5 { color:#1a202c; }
body.light-mode .card-theme .text-muted { color:#718096!important; }

/* === Dark Mode === */
body.dark-mode .card-theme { background:rgba(51,65,85,0.7); color:#f8fafc; border:1px solid rgba(255,255,255,0.1); }
body.dark-mode .card-theme h5 { color:#f8fafc; }
body.dark-mode .card-theme .text-muted { color:#94a3b8!important; }

/* === Input + Checkbox === */
.input-theme {
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 0.95rem;
  transition: all .3s ease;
}
body.dark-mode .input-theme {
  background: rgba(51,65,85,0.6);
  border: 2px solid rgba(255,255,255,0.2);
  color: #fff;
}
body.light-mode .input-theme {
  background: #f7fafc;
  border: 2px solid #e2e8f0;
  color: #1a202c;
}
body.light-mode .input-theme:focus {
  background: #fff; border-color: #667eea; box-shadow:0 0 0 3px rgba(102,126,234,0.15);
}
body.dark-mode .input-theme:focus {
  border-color: #8b5cf6; box-shadow:0 0 0 3px rgba(139,92,246,0.2);
}

/* === Checkbox custom (supaya terlihat di dark mode) === */
.form-check-input {
  width: 18px; height: 18px; border-radius: 4px;
  appearance: none; outline: none; cursor: pointer;
  border: 2px solid rgba(255,255,255,0.6);
  background: transparent; position: relative; transition: all .2s;
}
body.light-mode .form-check-input { border-color:#667eea; background:white; }
.form-check-input:checked {
  background: linear-gradient(135deg,#6366f1,#8b5cf6);
  border-color:#8b5cf6;
}
.form-check-input:checked::after {
  content:"✔"; color:white; position:absolute; top:-2px; left:2px;
  font-size:14px; font-weight:800;
}

/* === Button === */
.btn-accent {
  background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
  border:none; color:white; font-weight:600;
  padding:12px 24px; border-radius:10px;
  box-shadow:0 4px 15px rgba(102,126,234,0.4);
  transition:all .3s;
}
.btn-accent:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(102,126,234,0.6); }

/* === Custom Modal === */
.custom-modal {
  position:fixed; inset:0;
  background:rgba(0,0,0,0.6);
  backdrop-filter:blur(5px);
  display:flex; align-items:center; justify-content:center;
  z-index:9999;
}
.custom-modal.d-none { display:none; }
.modal-box {
  background:white; color:#111;
  border-radius:16px; padding:24px;
  width:90%; max-width:420px;
  box-shadow:0 8px 24px rgba(0,0,0,0.25);
  animation:fadeIn .3s ease;
}
.modal-box.dark { background:rgba(30,41,59,0.97); color:#f1f5f9; }
@keyframes fadeIn { from{transform:translateY(-10px);opacity:0;} to{transform:translateY(0);opacity:1;} }

/* === Sidebar collapsed behavior (tetap rapih) === */
.sidebar.collapsed .logo-text { opacity:0; width:0; overflow:hidden; }
.sidebar.collapsed .sidebar-header { justify-content:center; }
.sidebar.collapsed a span { display:none; }
.sidebar.collapsed a i { margin:0 auto; font-size:20px; }

/* === Header Text Adaptif === */
body.light-mode h2,
body.light-mode p.text-secondary {
  color: #1a202c !important; /* gelap untuk mode terang */
}

body.dark-mode h2,
body.dark-mode p.text-secondary {
  color: #f8fafc !important; /* terang untuk mode gelap */
}

/* === Badge adaptif === */
body.light-mode .info-badge {
  background: linear-gradient(135deg, #ebf4ff 0%, #c3dafe 100%);
  color: #1a202c;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

body.dark-mode .info-badge {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: #f8fafc;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

</style>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
      <h2 class="fw-bold mb-1">Halo, {{ session('user')['nama'] ?? 'Pengguna' }} 👋</h2>
      <p class="text-secondary mb-0">📚 Selamat datang di perpustakaan digital</p>
    </div>
    <span class="badge info-badge">
      <i class="fa fa-info-circle me-2"></i>Maksimal peminjaman 7 hari
    </span>
        {{-- 🔍 Form Pencarian Buku --}}
    <form method="GET" action="{{ route('dashboard.user') }}" class="mb-4">
      <div class="row g-2 align-items-center">
        <div class="col-md-4 col-sm-6">
          <input type="text" name="search" class="form-control input-theme"
                placeholder="Cari berdasarkan judul buku..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-3 col-sm-6">
          <select name="status" class="form-select input-theme">
            <option value="">Semua Status</option>
            <option value="Tersedia" {{ request('status')=='Tersedia'?'selected':'' }}>Tersedia</option>
            <option value="Dipinjam" {{ request('status')=='Dipinjam'?'selected':'' }}>Dipinjam</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-accent w-100">
            <i class="fa fa-search me-1"></i> Cari
          </button>
        </div>
      </div>
    </form>
  </div>


  {{-- === Tampilkan Buku === --}}
  @if($tab === 'peminjaman')
  <div class="row g-4">
    @php
    $search = strtolower(request('search', ''));
    $statusFilter = request('status', '');

    // 🔹 Filter berdasarkan judul dan status
    $filteredBuku = collect($bukuList)->filter(function($buku) use ($search, $statusFilter) {
        $judulMatch = !$search || str_contains(strtolower($buku['judul']), $search);
        $statusMatch = !$statusFilter || ($buku['status'] ?? 'Tersedia') === $statusFilter;
        return $judulMatch && $statusMatch;
    });

    // 🔹 Urutkan: buku "Tersedia" tampil dulu, "Dipinjam" di akhir
    $sortedBuku = $filteredBuku->sortBy(function($buku) {
        return ($buku['status'] ?? 'Tersedia') === 'Tersedia' ? 0 : 1;
    });
  @endphp

  @forelse($sortedBuku as $buku)
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card card-theme h-100 text-center">
          <div class="card-body d-flex flex-column">
            <div class="mb-3" style="height:180px;display:flex;align-items:center;justify-content:center;">
              <img src="{{ asset('img/buku/' . ($buku['gambar'] ?? 'noImage.jpg')) }}" 
                   class="img-fluid rounded" style="max-height:100%;object-fit:contain;"
                   alt="{{ $buku['judul'] }}" loading="lazy">
            </div>
            <h5 class="fw-bold mb-2">{{ $buku['judul'] }}</h5>
            <p class="text-muted small mb-2">
              <i class="fa fa-user me-1"></i>{{ $buku['pengarang'] ?? 'Tidak diketahui' }}
            </p>
            <span class="badge {{ ($buku['status'] ?? 'Tersedia')==='Tersedia'?'bg-success':'bg-danger' }} mb-3">
              {{ $buku['status'] ?? 'Tersedia' }}
            </span>
            <div class="mt-auto">
              @if(($buku['status'] ?? 'Tersedia')==='Tersedia')
                <button class="btn btn-accent w-100" onclick="openModal({{ $buku['id'] }}, '{{ $buku['judul'] }}')">
                  <i class="fa fa-book me-2"></i>Pinjam Buku
                </button>
              @else
                <button class="btn btn-secondary w-100" disabled>
                  <i class="fa fa-lock me-2"></i>Tidak Tersedia
                </button>
              @endif
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center py-5">
          <i class="fa fa-info-circle fa-3x mb-3 d-block"></i>
          <h5>Belum Ada Buku Tersedia</h5>
          <p class="mb-0">Saat ini belum ada buku yang dapat dipinjam. Silakan cek kembali nanti.</p>
        </div>
      </div>
    @endforelse
  </div>
  @endif
</div>

{{-- === Custom Modal === --}}
<div id="customModal" class="custom-modal d-none">
  <div class="modal-box" id="modalBox">
    <h4 class="fw-bold">Konfirmasi Peminjaman</h4>
    <p><strong>Judul Buku:</strong> <span id="modalJudul" class="text-primary"></span></p>

    <label class="form-label">Email / No. Telepon</label>
    <input type="text" id="modalKontak" class="input-theme" placeholder="contoh@email.com / 08123456789">

    <label class="form-label mt-2">Tanggal Pengembalian (≤ 7 hari)</label>
    <input type="date" id="modalTanggal" class="input-theme" 
           min="{{ $today->format('Y-m-d') }}" 
           max="{{ $max->format('Y-m-d') }}">
    <small class="form-text" id="rentangText">
      Rentang: {{ $today->format('d M Y') }} - {{ $max->format('d M Y') }}
    </small>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const rentang = document.getElementById('rentangText');
        const observer = new MutationObserver(() => {
          const isDark = document.body.classList.contains('dark-mode');
          rentang.style.color = isDark ? '#e2e8f0' : '#1a202c';
        });

        // jalankan langsung & pantau perubahan mode
        const isDark = document.body.classList.contains('dark-mode');
        rentang.style.color = isDark ? '#e2e8f0' : '#1a202c';
        observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });
      });
    </script>

    <div class="form-check mt-3 mb-3">
      <input class="form-check-input" type="checkbox" id="modalSetuju">
      <label class="form-check-label" for="modalSetuju">
        Saya siap dikenakan <strong>denda / ganti rugi</strong> jika buku rusak atau hilang.
      </label>
    </div>

    <div class="d-flex gap-2 mt-3">
      <button class="btn btn-outline-secondary w-50" onclick="closeModal()">Batal</button>
      <button class="btn btn-accent w-50" onclick="submitPinjam()">Pinjam</button>
    </div>
  </div>
</div>

<script>
let currentBookId = null;
let currentJudul = null;
const SUPABASE_URL = "{{ env('SUPABASE_URL') }}/rest/v1/buku";
const SUPABASE_KEY = "{{ env('SUPABASE_KEY') }}";

function openModal(id, judul) {
  currentBookId = id; currentJudul = judul;
  document.getElementById('modalJudul').textContent = judul;
  document.getElementById('modalKontak').value = '';
  document.getElementById('modalTanggal').value = '';
  document.getElementById('modalSetuju').checked = false;
  document.getElementById('customModal').classList.remove('d-none');

  if (document.body.classList.contains('dark-mode')) {
    document.getElementById('modalBox').classList.add('dark');
  } else {
    document.getElementById('modalBox').classList.remove('dark');
  }
}

function closeModal() {
  document.getElementById('customModal').classList.add('d-none');
}

async function submitPinjam() {
  const kontak = document.getElementById('modalKontak').value.trim();
  const tanggal = document.getElementById('modalTanggal').value;
  const setuju = document.getElementById('modalSetuju').checked;
  if (!kontak || !tanggal || !setuju) return alert('⚠️ Lengkapi semua data dan centang persetujuan.');

  try {
    const res = await fetch(`${SUPABASE_URL}?id=eq.${currentBookId}`, {
      method: 'PATCH',
      headers: {
        'apikey': SUPABASE_KEY,
        'Authorization': 'Bearer ' + SUPABASE_KEY,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ status: 'Dipinjam' })
    });
    if (res.ok) {
      alert(`✅ Buku "${currentJudul}" berhasil dipinjam!\nKembalikan sebelum ${tanggal}.`);
      closeModal();
      const card = [...document.querySelectorAll('.card')].find(c => c.innerText.includes(currentJudul));
      if (card) {
        const badge = card.querySelector('.badge');
        badge.textContent = 'Dipinjam'; badge.className = 'badge bg-danger';
        const btn = card.querySelector('.btn-accent');
        if (btn) { btn.classList.replace('btn-accent','btn-secondary'); btn.textContent='Sudah Dipinjam'; btn.disabled=true; }
      }
    } else alert('❌ Gagal memperbarui status buku.');
  } catch (err) { alert('⚠️ Kesalahan koneksi: ' + err.message); }
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
document.addEventListener('click', e => { if (e.target.id === 'customModal') closeModal(); });
</script>
@endsection
