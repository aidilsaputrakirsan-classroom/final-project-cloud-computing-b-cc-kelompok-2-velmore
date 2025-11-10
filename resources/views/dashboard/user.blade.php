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
  @if($tab === 'peminjaman')
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
      <h2 class="fw-bold mb-1">Halo, {{ session('user')['nama'] ?? 'Pengguna' }} 👋</h2>
      <p class="text-secondary mb-0">📚 Selamat datang di perpustakaan digital</p>
    </div>
    <span class="badge info-badge">
      <i class="fa fa-info-circle me-2"></i>Maksimal peminjaman 7 hari
    </span>
  </div>

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
  @endif

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
<input type="date" id="modalTanggal" class="input-theme">
<small class="form-text text-secondary" id="rentangText"></small>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const inputTanggal = document.getElementById("modalTanggal");
  const rentangText = document.getElementById("rentangText");

  // Ambil tanggal hari ini (tanpa jam)
  const today = new Date();
  const todayStr = today.toISOString().split("T")[0];

  // Buat batas maksimum 7 hari ke depan
  const maxDate = new Date(today);
  maxDate.setDate(today.getDate() + 7);
  const maxStr = maxDate.toISOString().split("T")[0];

  // Set atribut min dan max agar tanggal sebelum hari ini diblokir
  inputTanggal.min = todayStr;
  inputTanggal.max = maxStr;

  // Set nilai default ke hari ini
  inputTanggal.value = todayStr;

  // Format tampilan rentang (contoh: 05 Nov 2025)
  const formatTanggal = (dateObj) => {
    const options = { day: '2-digit', month: 'short', year: 'numeric' };
    return dateObj.toLocaleDateString('id-ID', options);
  };

  // Update teks keterangan
  rentangText.textContent = `Rentang: ${formatTanggal(today)} - ${formatTanggal(maxDate)}`;

  // Validasi jika user mencoba memilih tanggal sebelum hari ini
  inputTanggal.addEventListener("change", function () {
    const selected = new Date(this.value);
    if (selected < today) {
      alert("Tanggal tidak valid! Tidak boleh memilih sebelum hari ini.");
      this.value = todayStr;
    }
  });
});
</script>


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

  if (!kontak || !tanggal || !setuju)
    return alert('⚠️ Lengkapi semua data dan centang persetujuan.');

  try {
    // 🔹 Panggil backend Laravel
    const res = await fetch(`/peminjaman/create/${currentBookId}?rencana_kembali=${tanggal}&kontak=${encodeURIComponent(kontak)}`, {
      method: 'GET'
    });

    if (res.ok) {
      alert(`✅ Buku "${currentJudul}" berhasil dipinjam!\nKembalikan sebelum ${tanggal}.`);
      closeModal();
      setTimeout(() => location.reload(), 700);
    } else {
      alert('❌ Gagal meminjam buku.');
    }
  } catch (err) {
    alert('⚠️ Kesalahan koneksi: ' + err.message);
  }
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
document.addEventListener('click', e => { if (e.target.id === 'customModal') closeModal(); });
</script>
{{-- ====================== TAB: PENGEMBALIAN ====================== --}}
@if($tab === 'pengembalian')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
      <h2 class="fw-bold mb-1">📤 Pengembalian Buku</h2>
      <p class="text-secondary mb-0">Silakan kembalikan buku yang Anda pinjam.</p>
    </div>
  </div>

  @php
    $dipinjam = $peminjaman;
  @endphp

  <div class="row g-4">
    @forelse($dipinjam as $buku)
      @php
        $judul = $buku['buku']['judul'] ?? 'Tanpa Judul';
        $pengarang = $buku['buku']['pengarang'] ?? 'Tidak diketahui';
        $gambar = $buku['buku']['gambar'] ?? 'noImage.jpg';
        $tglPinjam = \Carbon\Carbon::parse($buku['tanggal_pinjam'] ?? now());
        $deadline = $tglPinjam->copy()->addDays(7)->format('Y-m-d');
        $id_buku_pinjam = $buku['id_buku'] ?? null;
      @endphp

      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card card-theme h-100 text-center shadow-sm">
          <div class="card-body d-flex flex-column">
            <img src="{{ asset('img/buku/' . $gambar) }}"
                 class="img-fluid rounded mb-3" style="height:180px;object-fit:contain;">
            <h5 class="fw-bold mb-2">{{ $judul }}</h5>
            <p class="text-muted small mb-3">{{ $pengarang }}</p>

            <button class="btn btn-warning w-100 mt-auto"
                    onclick="openReturnPopup('{{ $id_buku_pinjam }}','{{ addslashes($judul) }}','{{ $deadline }}')">
              <i class="fa fa-undo me-2"></i>Kembalikan Buku
            </button>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center py-5">
          <i class="fa fa-info-circle fa-3x mb-3 d-block"></i>
          <h5>Tidak Ada Buku yang Sedang Dipinjam</h5>
        </div>
      </div>
    @endforelse
  </div>
</div>
@endif

{{-- ======================= MODAL PENGEMBALIAN MODERN ======================= --}}
<div class="position-fixed top-0 start-0 w-100 h-100 d-none"
     style="z-index: 1050; background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px);"
     id="returnPopup"
     onclick="closeReturnPopupOutside(event)">
    <div class="modern-modal-wrapper" onclick="event.stopPropagation()">
        <div class="modern-modal-content">

            {{-- Header --}}
            <div class="modern-modal-header">
                <div class="header-decoration"></div>
                <div class="header-decoration-2"></div>
                <h5 class="modern-modal-title">
                    <i class="fa fa-undo-alt"></i>
                    <span>Pengembalian Buku</span>
                </h5>
                <button type="button" class="modern-close-btn" onclick="closeReturnPopup()">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="modern-modal-body">

                {{-- Book Info Card --}}
                <div class="book-info-card">
                    <p class="book-info-label">Anda akan mengembalikan:</p>
                    <h5 class="book-title" id="judulBuku"></h5>
                    <p class="deadline-info">
                        <i class="fa fa-clock"></i>
                        Batas pengembalian:
                        <span id="deadlineBuku" class="deadline-date"></span>
                    </p>
                </div>

               {{-- 📅 Tanggal Pengembalian --}}
          <div class="form-group-modern">
            <label for="tglKembali" class="form-label-modern">
              <i class="far fa-calendar-alt"></i>
              Tanggal Pengembalian Sebenarnya
              <span class="text-danger">*</span>
            </label>
            <input type="date"
                  class="form-control form-control-modern"
                  id="tglKembali"
                  onchange="checkDenda()">
            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
              const tglInput = document.getElementById("tglKembali");

              // Ambil tanggal hari ini (waktu lokal, bukan UTC)
              const today = new Date();
              const local = new Date(today.getTime() - today.getTimezoneOffset() * 60000);
              const todayStr = local.toISOString().split("T")[0];

              // Atur batas minimum agar tidak bisa pilih sebelum hari ini
              tglInput.min = todayStr;

              // Atur nilai default = hari ini (realtime)
              tglInput.value = todayStr;

              // Jika user coba pilih tanggal mundur → reset ke hari ini
              tglInput.addEventListener("change", function() {
                const selected = new Date(this.value);
                if (selected < local) {
                  alert("❌ Tidak bisa memilih tanggal sebelum hari ini!");
                  this.value = todayStr;
                }
              });
            });
            </script>

                {{-- Info Denda --}}
                <div id="infoDenda" class="denda-alert-wrapper"></div>

                {{-- Checkbox Persetujuan --}}
                <div class="checkbox-modern">
                    <input class="form-check-input checkbox-custom"
                           type="checkbox"
                           id="setujuKembali">
                    <label class="form-check-label checkbox-label" for="setujuKembali">
                        Saya mengkonfirmasi bahwa buku dikembalikan dalam kondisi baik dan lengkap.
                        <span class="text-danger">*</span>
                    </label>
                </div>

                {{-- Info Box --}}
                <div class="info-box-modern">
                    <i class="fa fa-info-circle"></i>
                    <span>Pastikan semua data terisi dengan benar sebelum menekan tombol <strong>konfirmasi</strong>.</span>
                </div>

            </div>

            {{-- Footer --}}
            <div class="modern-modal-footer">
                <button type="button"
                        class="btn-modern btn-modern-cancel"
                        onclick="closeReturnPopup()">
                    <i class="fa fa-times"></i>
                    Batal
                </button>
                <button type="button"
                        class="btn-modern btn-modern-submit"
                        onclick="submitReturn()">
                    <i class="fa fa-check"></i>
                    Konfirmasi Pengembalian
                </button>
            </div>

        </div>
    </div>
</div>

{{-- === SCRIPT Pengembalian === --}}
<script>
let selectedId = null, selectedDeadline = null;

// === Buka modal ===
function openReturnPopup(id, judul, deadline) {
  selectedId = id;
  selectedDeadline = deadline;
  document.getElementById('judulBuku').textContent = judul;
  document.getElementById('deadlineBuku').textContent = deadline;

  document.getElementById('tglKembali').value = new Date().toISOString().substring(0, 10);
  document.getElementById('infoDenda').innerHTML = '';
  document.getElementById('setujuKembali').checked = false;

  checkDenda();

  document.getElementById('returnPopup').classList.remove('d-none');
  document.body.style.overflow = 'hidden';
}

// === Tutup modal ===
function closeReturnPopup() {
  document.getElementById('returnPopup').classList.add('d-none');
  document.body.style.overflow = 'auto';
}

// === Tutup modal dengan klik di luar ===
function closeReturnPopupOutside(event) {
  if (event.target.id === 'returnPopup') {
    closeReturnPopup();
  }
}

// === Hitung denda (5000 per hari) ===
function hitungDenda(tanggal, deadline) {
  const d1 = new Date(deadline);
  const d2 = new Date(tanggal);

  d1.setHours(0, 0, 0, 0);
  d2.setHours(0, 0, 0, 0);

  const diffTime = d2.getTime() - d1.getTime();
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  return diffDays > 0 ? diffDays * 5000 : 0;
}

// === Check Denda dan Tampilkan Info ===
function checkDenda() {
    const tgl = document.getElementById('tglKembali').value;
    if (!tgl) return;

    const deadline = new Date(selectedDeadline);
    const tglKembali = new Date(tgl);
    const diffTime = tglKembali.getTime() - deadline.getTime();
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const denda = hitungDenda(tgl, selectedDeadline);
    const info = document.getElementById('infoDenda');

    if (denda > 0) {
        const dendaRupiah = denda.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
        info.innerHTML = `
            <div class="denda-alert show">
                <i class="fa fa-exclamation-triangle"></i>
                <div class="denda-content">
                    <div class="denda-title">Terlambat ${diffDays} Hari</div>
                    <div class="denda-text">
                        Denda keterlambatan: <strong>${dendaRupiah}</strong>
                    </div>
                </div>
            </div>
        `;
    } else {
        info.innerHTML = `
            <div class="success-alert show">
                <i class="fa fa-check-circle"></i>
                <div class="success-content">
                    <div class="success-text">
                        ✅ Tepat waktu, tidak ada denda.
                    </div>
                </div>
            </div>
        `;
    }
}

// === Submit Pengembalian (JSON Murni) ===
async function submitReturn() {
  const tgl = document.getElementById('tglKembali').value;
  const setuju = document.getElementById('setujuKembali').checked;

  if (!tgl) return alert('⚠️ Harap pilih tanggal pengembalian.');
  if (!setuju) return alert('⚠️ Centang konfirmasi bahwa buku dikembalikan dalam kondisi baik.');

  const denda = hitungDenda(tgl, selectedDeadline);

  if (denda > 0) {
    const dendaRupiah = denda.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
    const konfirmasi = confirm(`⚠️ Perhatian! Anda terlambat, total denda adalah ${dendaRupiah}. Lanjutkan pengembalian?`);
    if (!konfirmasi) return;
  }

  // 🔴 Ambil CSRF Token dari meta tag
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

  try {
    const res = await fetch('/pengembalian/simpan', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        // 🔴 Kirim CSRF Token via header
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        buku_id: selectedId,
        tanggal_kembali: tgl,
        denda: denda
      })
    });

    const result = await res.json();

    if (res.ok && result.ok) {
        alert('✅ Pengembalian berhasil dicatat.');
        closeReturnPopup();
        setTimeout(() => location.reload(), 700);
    } else {
        alert('❌ Gagal menyimpan pengembalian.\nDetail: ' + (result.error || result.msg || 'Server error.'));
    }

  } catch (e) {
    alert('⚠️ Kesalahan koneksi: ' + e.message);
  }
}

// Close dengan ESC key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    const popup = document.getElementById('returnPopup');
    if (popup && !popup.classList.contains('d-none')) {
      closeReturnPopup();
    }
  }
});

// Event listener untuk change tanggal
document.addEventListener('DOMContentLoaded', function() {
  const tglKembaliInput = document.getElementById('tglKembali');
  if (tglKembaliInput) {
    tglKembaliInput.addEventListener('change', checkDenda);
  }
});
</script>

{{-- === CSS MODERN === --}}
<style>
/* Modal Wrapper */
.modern-modal-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 20px;
}

/* Modal Content */
.modern-modal-content {
  background: white;
  border-radius: 24px;
  max-width: 600px;
  width: 100%;
  max-height: 90vh;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  animation: slideUp 0.4s ease;
}

/* Header */
.modern-modal-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 30px;
  position: relative;
  overflow: hidden;
}

.header-decoration {
  position: absolute;
  top: -50%;
  right: -10%;
  width: 200px;
  height: 200px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
}

.header-decoration-2 {
  position: absolute;
  bottom: -30%;
  left: -5%;
  width: 150px;
  height: 150px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
}

.modern-modal-title {
  color: white;
  font-size: 24px;
  font-weight: 700;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 12px;
  position: relative;
  z-index: 1;
}

.modern-close-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  background: rgba(255, 255, 255, 0.2);
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  color: white;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modern-close-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: rotate(90deg);
}

/* Body */
.modern-modal-body {
  padding: 30px;
  max-height: calc(90vh - 200px);
  overflow-y: auto;
}

/* Book Info Card */
.book-info-card {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 25px;
  border-left: 5px solid #667eea;
}

.book-info-label {
  color: #718096;
  font-size: 14px;
  margin-bottom: 8px;
}

.book-title {
  color: #2d3748;
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 10px;
}

.deadline-info {
  color: #e53e3e;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
}

.deadline-date {
  font-weight: 700;
}

/* Form Groups */
.form-group-modern {
  margin-bottom: 25px;
}

.form-label-modern {
  color: #2d3748;
  font-weight: 600;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-control-modern {
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 12px 16px;
  font-size: 15px;
  transition: all 0.3s ease;
  width: 100%;
}

.form-control-modern:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  outline: none;
}

/* Denda Alert */
.denda-alert-wrapper {
  margin-bottom: 20px;
}

.denda-alert {
  background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
  border-left: 4px solid #e53e3e;
  border-radius: 12px;
  padding: 16px;
  display: none;
  animation: slideDown 0.3s ease;
}

.denda-alert.show {
  display: flex;
  gap: 15px;
  align-items: start;
}

.denda-alert i {
  color: #e53e3e;
  font-size: 24px;
}

.denda-content {
  flex: 1;
}

.denda-title {
  font-weight: 700;
  font-size: 16px;
  margin-bottom: 5px;
  color: #c53030;
}

.denda-text {
  color: #742a2a;
}

/* Success Alert */
.success-alert {
  background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%);
  border-left: 4px solid #48bb78;
  border-radius: 12px;
  padding: 16px;
  display: none;
  animation: slideDown 0.3s ease;
}

.success-alert.show {
  display: flex;
  gap: 15px;
  align-items: start;
}

.success-alert i {
  color: #48bb78;
  font-size: 24px;
}

.success-content {
  flex: 1;
}

.success-text {
  color: #22543d;
  font-weight: 600;
}

/* Checkbox */
.checkbox-modern {
  display: flex;
  align-items: start;
  gap: 12px;
  background: #f7fafc;
  padding: 16px;
  border-radius: 12px;
  margin-bottom: 20px;
}

.checkbox-custom {
  width: 22px;
  height: 22px;
  margin-top: 2px;
  cursor: pointer;
  accent-color: #667eea;
}

.checkbox-label {
  color: #2d3748;
  font-weight: 500;
  cursor: pointer;
  line-height: 1.6;
  margin: 0;
}

/* Info Box */
.info-box-modern {
  background: linear-gradient(135deg, #ebf8ff 0%, #bee3f8 100%);
  border-left: 4px solid #4299e1;
  border-radius: 12px;
  padding: 16px;
  display: flex;
  gap: 12px;
  align-items: start;
}

.info-box-modern i {
  color: #4299e1;
  font-size: 20px;
  margin-top: 2px;
}

.info-box-modern span {
  color: #2c5282;
  font-size: 14px;
  line-height: 1.6;
}

/* Footer */
.modern-modal-footer {
  padding: 20px 30px;
  background: #f7fafc;
  display: flex;
  justify-content: space-between;
  gap: 15px;
}

.btn-modern {
  padding: 14px 30px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 16px;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-modern-cancel {
  background: white;
  color: #718096;
  border: 2px solid #e2e8f0;
}

.btn-modern-cancel:hover {
  background: #f7fafc;
  border-color: #cbd5e0;
}

.btn-modern-submit {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  flex: 1;
  justify-content: center;
}

.btn-modern-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

/* Animations */
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Scrollbar */
.modern-modal-body::-webkit-scrollbar {
  width: 8px;
}

.modern-modal-body::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.modern-modal-body::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 10px;
}

.modern-modal-body::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}

/* Responsive */
@media (max-width: 576px) {
  .modern-modal-content {
    border-radius: 16px;
  }

  .modern-modal-header {
    padding: 20px;
  }

  .modern-modal-title {
    font-size: 20px;
  }

  .modern-modal-body {
    padding: 20px;
  }

  .modern-modal-footer {
    padding: 15px 20px;
    flex-direction: column;
  }

  .btn-modern {
    width: 100%;
    justify-content: center;
  }
}
</style>
  {{-- ================= TAB RIWAYAT ================= --}}
  @if($tab === 'riwayat')
    {{-- ... isi kode riwayat ... --}}
  @endif  {{-- ⬅️ WAJIB ADA INI DI BAGIAN PALING AKHIR --}}
@endsection
