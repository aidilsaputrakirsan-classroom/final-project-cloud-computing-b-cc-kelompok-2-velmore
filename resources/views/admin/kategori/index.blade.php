@extends('layout.main')
@section('sidebar')
    @include('partials.admin-sidebar')
@endsection
@section('judul')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="theme-title">Daftar Kategori Buku</h1>
        <button id="themeToggle" class="theme-toggle" onclick="toggleTheme()">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>
    </div>
@endsection
@section('content')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --danger-gradient: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
}

/* Light Theme */
[data-theme="light"] {
    --bg-primary: #f8f9fa;
    --bg-card: rgba(255, 255, 255, 0.9);
    --border-color: rgba(203, 213, 225, 0.6);
    --shadow-color: rgba(0, 0, 0, 0.08);
    --hover-bg: #f7fafc;
    --table-stripe: rgba(237, 242, 247, 0.5);
}

/* Dark Theme */
[data-theme="dark"] {
    --bg-primary: #0f172a;
    --bg-card: rgba(255, 255, 255, 0.95);
    --border-color: rgba(203, 213, 225, 0.6);
    --shadow-color: rgba(0, 0, 0, 0.3);
    --hover-bg: rgba(240, 240, 240, 0.8);
    --table-stripe: rgba(237, 242, 247, 0.5);
}

body {
    background: var(--bg-primary);
    transition: background 0.3s ease;
}

.theme-toggle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid var(--border-color);
    background: var(--bg-card);
    color: #2d3748;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px var(--shadow-color);
}

.theme-toggle:hover {
    transform: rotate(180deg) scale(1.1);
    box-shadow: 0 6px 20px var(--shadow-color);
}

.category-card {
    padding: 30px;
    border-radius: 24px;
    background: var(--bg-card);
    backdrop-filter: blur(16px);
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 40px var(--shadow-color);
    animation: fadeInUp 0.5s ease-out;
    transition: all 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.category-table {
    margin: 0;
}

.category-table thead {
    border-bottom: 2px solid var(--border-color);
}

.category-table th {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.75rem;
    font-weight: 800;
    padding: 16px 12px;
    border: none;
}

.category-table tbody tr {
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.category-table tbody tr:hover {
    background: var(--hover-bg);
    transform: scale(1.01);
}

.category-table tbody tr:nth-child(even) {
    background: var(--table-stripe);
}

.category-table td {
    color: #000000 !important;
    vertical-align: middle;
    font-weight: 600;
    padding: 18px 12px;
    border: none;
}

.category-table td:first-child {
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
}

.btn-add {
    background: var(--success-gradient);
    color: white !important;
    padding: 12px 28px;
    border-radius: 16px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 15px rgba(56, 239, 125, 0.3);
    text-decoration: none;
    font-size: 0.95rem;
}

.btn-add:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(56, 239, 125, 0.4);
    color: white !important;
}

.btn-add i {
    font-size: 1rem;
}

.btn-edit {
    background: var(--warning-gradient);
    border: none;
    color: white !important;
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(250, 112, 154, 0.25);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(250, 112, 154, 0.35);
    color: white !important;
}

.btn-delete {
    background: var(--danger-gradient);
    border: none;
    color: white !important;
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(238, 9, 121, 0.25);
    cursor: pointer;
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(238, 9, 121, 0.35);
}

.empty-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: #718096 !important;
    opacity: 0.5;
    margin-bottom: 20px;
    display: block;
}

.empty-state p {
    color: #000000 !important;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

/* Animasi untuk actions buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

/* Badge style untuk ID */
.id-badge {
    display: inline-block;
    padding: 4px 12px;
    background: var(--primary-gradient);
    color: white !important;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .category-card {
        padding: 20px;
        border-radius: 18px;
    }
    
    .btn-add {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
    
    .category-table th,
    .category-table td {
        padding: 12px 8px;
        font-size: 0.85rem;
    }
    
    .btn-edit,
    .btn-delete {
        padding: 6px 12px;
        font-size: 0.8rem;
    }
}
</style>

{{-- ====================== TAMBAH KATEGORI ====================== --}}
<div class="mb-4">
    <a href="{{ route('kategori.create') }}" class="btn-add">
        <i class="fas fa-plus"></i>
        <span>Tambah Kategori</span>
    </a>
</div>

{{-- ====================== TABLE LIST ====================== --}}
<div class="category-card">
    <table class="table category-table align-middle">
        <thead>
            <tr>
                <th width="100px">No</th>
                <th>Nama Kategori</th>
                <th width="200px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori as $k)
                <tr>
                    <td>
                        <span class="id-badge">#{{ $loop->iteration }}</span>
                    </td>
                    <td>{{ $k['nama'] }}</td>
                    <td>
                        <div class="action-buttons">
                            {{-- tombol edit --}}
                            <a href="{{ route('kategori.edit', $k['id']) }}" class="btn-edit">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>
                            {{-- tombol delete wajib pakai form --}}
                            <form action="{{ route('kategori.destroy', $k['id']) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <p>Belum ada kategori yang tersedia</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
// Theme Toggle Function
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme') || 'light';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Update icon
    const icon = document.getElementById('themeIcon');
    icon.className = newTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
}

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    const icon = document.getElementById('themeIcon');
    if (icon) {
        icon.className = savedTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
    }
});
</script>
@endsection