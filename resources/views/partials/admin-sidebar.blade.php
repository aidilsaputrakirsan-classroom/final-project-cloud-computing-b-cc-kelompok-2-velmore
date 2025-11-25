<!-- Sidebar Admin -->

<div class="menu-section">
  <div class="menu-section-title">Manajemen</div>

  <a href="/dashboard-admin" class="{{ request()->is('dashboard-admin') ? 'active' : '' }}">
    <i class="fa fa-home"></i> <span>Dashboard</span>
  </a>

  <a href="/pengguna/tambah" class="{{ request()->is('pengguna/tambah') ? 'active' : '' }}">
    <i class="fa fa-user-plus"></i> <span>Tambah Pengguna</span>
  </a>

  <a href="/pengguna" class="{{ request()->is('pengguna') ? 'active' : '' }}">
    <i class="fa fa-users"></i> <span>Data Pengguna</span>
  </a>

  <a href="/buku" class="{{ request()->is('buku') ? 'active' : '' }}">
    <i class="fa fa-book"></i> <span>Data Buku</span>
  </a>

  {{-- ⭐ MENU KATEGORI BUKU --}}
  <a href="/kategori" class="{{ request()->is('kategori*') ? 'active' : '' }}">
    <i class="fa fa-tags"></i> <span>Kategori Buku</span>
  </a>

  {{-- ⭐ MENU ACTIVITY LOG (BARU) --}}
  <a href="/admin/activity-log" class="{{ request()->is('admin/activity-log') ? 'active' : '' }}">
    <i class="fa fa-list"></i> <span>Activity Log</span>
  </a>
</div>

<div class="menu-section">
  <div class="menu-section-title">Transaksi</div>

  <a href="/peminjaman" class="{{ request()->is('peminjaman') ? 'active' : '' }}">
    <i class="fa fa-exchange-alt"></i> <span>Peminjaman</span>
  </a>

  <a href="/pengembalian" class="{{ request()->is('pengembalian') ? 'active' : '' }}">
    <i class="fa fa-undo"></i> <span>Pengembalian</span>
  </a>
</div>
