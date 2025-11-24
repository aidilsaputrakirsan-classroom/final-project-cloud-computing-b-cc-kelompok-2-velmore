@extends('layout.main')

@section('title', 'Dashboard Admin')

@section('sidebar')
  @include('partials.admin-sidebar')
@endsection

@section('content')
<div class="content-header mb-4">
  <h2 class="dashboard-title fw-bold">
    Selamat Datang, {{ session('admin')['nama'] ?? 'Admin' }} 👋
  </h2>
  <p class="dashboard-desc">Kelola seluruh data perpustakaan dan pantau aktivitas terbaru di sini.</p>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-3 col-sm-6">
    <div class="card dashboard-card p-4 shadow-sm">
      <h6 class="fw-bold mb-2"><i class="fa fa-users text-primary me-2"></i> Total Pengguna</h6>
      <h3 class="fw-bold">{{ $totalPengguna ?? 0 }}</h3>
      <p class="text-secondary small mb-0">Jumlah akun terdaftar</p>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="card dashboard-card p-4 shadow-sm">
      <h6 class="fw-bold mb-2"><i class="fa fa-book text-success me-2"></i> Total Buku</h6>
      <h3 class="fw-bold">{{ $totalBuku ?? 0 }}</h3>
      <p class="text-secondary small mb-0">Buku digital & fisik</p>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="card dashboard-card p-4 shadow-sm">
      <h6 class="fw-bold mb-2"><i class="fa fa-exchange-alt text-warning me-2"></i> Sedang Dipinjam</h6>
      <h3 class="fw-bold">{{ $totalDipinjam ?? 0 }}</h3>
      <p class="text-secondary small mb-0">Transaksi aktif</p>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="card dashboard-card p-4 shadow-sm">
      <h6 class="fw-bold mb-2"><i class="fa fa-wallet text-danger me-2"></i> Total Denda</h6>
      <h3 class="fw-bold">Rp{{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
      <p class="text-secondary small mb-0">Denda keterlambatan</p>
    </div>
  </div>
</div>

<div class="card p-4 mb-4 shadow-sm dashboard-card">
  <h5 class="fw-bold mb-3"><i class="fa fa-chart-line text-primary me-2"></i> Tren Peminjaman 7 Hari Terakhir</h5>
  <canvas id="loanChart" height="100"></canvas>
</div>

<div class="card p-4 shadow-sm dashboard-card bg-white table-static-light">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0 text-dark">
      <i class="fa fa-clock text-indigo me-2"></i> Aktivitas Terbaru
    </h5>
    <a href="/peminjaman" class="text-decoration-none small fw-semibold text-indigo">
      Lihat Semua <i class="fa fa-arrow-right"></i>
    </a>
  </div>

  <div class="table-responsive">
    <table class="table align-middle table-light-mode">
      <thead class="table-light">
        <tr>
          <th>#</th><th>Nama Pengguna</th><th>Judul Buku</th><th>Status</th><th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($aktivitas as $a)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a['nama'] ?? 'Tidak diketahui' }}</td>
            <td>{{ $a['buku'] ?? 'Tanpa Judul' }}</td>
            <td>
              @if($a['status'] === 'Dipinjam')
                <span class="badge bg-warning text-dark">Dipinjam</span>
              @elseif($a['status'] === 'Dikembalikan')
                <span class="badge bg-success">Dikembalikan</span>
              @elseif($a['status'] === 'Terverifikasi')
                <span class="badge bg-info text-dark">Terverifikasi</span>
              @else
                <span class="badge bg-secondary">{{ ucfirst($a['status'] ?? 'Tidak Diketahui') }}</span>
              @endif
            </td>
            <td>{{ $a['tanggal'] ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center py-4 text-muted"><i class="fa fa-info-circle me-1"></i> Tidak ada aktivitas terbaru 📭</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- CHART SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const ctx = document.getElementById('loanChart').getContext('2d');
  const labels = {!! json_encode(collect($grafikData)->pluck('tanggal')) !!};
  const values = {!! json_encode(collect($grafikData)->pluck('jumlah')) !!};

  const getChartColors = () => ({
    text: document.body.classList.contains('dark-mode') ? '#f9fafb' : '#1f2937',
    grid: document.body.classList.contains('dark-mode') ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)',
    line: document.body.classList.contains('dark-mode') ? '#a5b4fc' : '#667eea',
    fill: document.body.classList.contains('dark-mode') ? 'rgba(165,180,252,0.15)' : 'rgba(102,126,234,0.15)'
  });

  let chartColors = getChartColors();
  const loanChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Jumlah Peminjaman',
        data: values,
        borderColor: chartColors.line,
        backgroundColor: chartColors.fill,
        borderWidth: 3,
        pointBackgroundColor: chartColors.line,
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, ticks: { color: chartColors.text }, grid: { color: chartColors.grid } },
        x: { ticks: { color: chartColors.text }, grid: { color: chartColors.grid } }
      },
      plugins: { legend: { labels: { color: chartColors.text } } }
    }
  });

  const observer = new MutationObserver(() => {
    const newColors = getChartColors();
    loanChart.options.scales.x.ticks.color = newColors.text;
    loanChart.options.scales.y.ticks.color = newColors.text;
    loanChart.options.scales.x.grid.color = newColors.grid;
    loanChart.options.scales.y.grid.color = newColors.grid;
    loanChart.data.datasets[0].borderColor = newColors.line;
    loanChart.data.datasets[0].backgroundColor = newColors.fill;
    loanChart.data.datasets[0].pointBackgroundColor = newColors.line;
    loanChart.options.plugins.legend.labels.color = newColors.text;
    loanChart.update();
  });
  observer.observe(document.body, { attributes: true, attributeFilter: ['class'] });
});
</script>
<style>
/* === Global Dynamic Font Color === */
body.light-mode :not(.sidebar-admin, .sidebar-admin *) {
  color: #1a202c;
}
body.dark-mode :not(.sidebar-admin, .sidebar-admin *) {
  color: #f8fafc;
}

/* === Titles === */
.dashboard-title {
  color: #1f2937;
  font-weight: 700;
  transition: color 0.3s;
}
body.dark-mode .dashboard-title {
  color: #f9fafb;
}
.dashboard-desc {
  color: #4b5563;
  transition: color 0.3s;
}
body.dark-mode .dashboard-desc {
  color: #d1d5db;
}

/* === Cards === */
.dashboard-card {
  background: #ffffff;
  border-radius: 18px;
  border: 1px solid rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  color: #1a202c;
}
.dashboard-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}
body.dark-mode .dashboard-card {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  color: #f8fafc;
}
body.dark-mode .dashboard-card:hover {
  box-shadow: 0 8px 25px rgba(102,126,234,0.25);
}

/* === Keep Activity Table Always Light === */
.table-static-light {
  background: #ffffff !important;
  color: #1a202c !important;
}
.table-static-light table,
.table-static-light th,
.table-static-light td {
  background: #ffffff !important;
  color: #1a202c !important;
  border-color: #e5e7eb !important;
}
.table-static-light .table-light {
  background: #f8f9fa !important;
  color: #1a202c !important;
}
.table-static-light .text-muted {
  color: #6b7280 !important;
}

/* === Secondary Text === */
.text-secondary { color: #6b7280 !important; }
body.dark-mode .text-secondary { color: #d1d5db !important; }

/* === Custom Colors === */
.text-indigo { color: #6366f1 !important; }
body.dark-mode .text-indigo { color: #a5b4fc !important; }

/* === Sidebar Admin === */
.sidebar-admin {
  background: linear-gradient(180deg, #1e293b 0%, #111827 100%);
  color: #f8fafc;
  min-height: 100vh;
  width: 250px;
  padding: 20px 0;
}
.sidebar-admin a {
  color: #e5e7eb;
  display: flex;
  align-items: center;
  padding: 10px 20px;
  text-decoration: none;
  transition: all 0.2s ease;
}
.sidebar-admin a:hover {
  background: rgba(255,255,255,0.1);
  color: #ffffff;
}
.sidebar-admin a.active {
  background: #3b82f6;
  color: #fff;
  border-radius: 8px;
}
.sidebar-admin i {
  width: 20px;
  margin-right: 10px;
}

/* === Responsif === */
@media (max-width: 768px) {
  .dashboard-card { text-align: center; }
  .sidebar-admin { width: 100%; position: relative; }
}
</style>

@endsection
