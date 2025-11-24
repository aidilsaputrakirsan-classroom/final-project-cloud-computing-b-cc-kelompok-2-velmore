<!DOCTYPE html>
<html lang="id">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - VERLY Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --secondary: #8b5cf6;
      --success: #10b981;
      --danger: #ef4444;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }

    /* Light Mode */
    body.light-mode {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    body.light-mode::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.08) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }

    /* Dark Mode */
    body.dark-mode {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    body.dark-mode::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }
    
    .sidebar {
      height: 100vh;
      width: 280px;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      z-index: 1000;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 4px 0 30px rgba(0, 0, 0, 0.1);
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .light-mode .sidebar {
      background: rgba(255, 255, 255, 0.95);
      border-right: 1px solid rgba(255, 255, 255, 0.3);
    }

    .dark-mode .sidebar {
      background: rgba(30, 41, 59, 0.95);
      border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Toggle Button */
    .sidebar-toggle {
      position: absolute;
      top: 32px;
      right: -16px;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1001;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }

    .sidebar-toggle:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 16px rgba(99, 102, 241, 0.5);
    }

    .sidebar-toggle i {
      font-size: 14px;
      transition: transform 0.3s ease;
    }

    .sidebar.collapsed .sidebar-toggle i {
      transform: rotate(180deg);
    }
    
    .sidebar-header {
      padding: 28px 24px;
      display: flex;
      align-items: center;
      gap: 14px;
      border-bottom: 1px solid;
      transition: all 0.3s ease;
      min-height: 100px;
    }

    .sidebar.collapsed .sidebar-header {
      justify-content: center;
      padding: 28px 16px;
    }

    .light-mode .sidebar-header {
      border-bottom-color: rgba(0, 0, 0, 0.08);
    }

    .dark-mode .sidebar-header {
      border-bottom-color: rgba(255, 255, 255, 0.08);
    }
    
    .logo-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 24px;
      flex-shrink: 0;
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
      transition: transform 0.3s ease;
    }

    .logo-icon:hover {
      transform: translateY(-3px) scale(1.05);
    }

    .logo-text {
      transition: all 0.4s ease;
      overflow: hidden;
      white-space: nowrap;
    }

    .sidebar.collapsed .logo-text {
      opacity: 0;
      width: 0;
    }
    
    .logo-text h4 {
      font-size: 22px;
      font-weight: 700;
      margin: 0;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .logo-text p {
      font-size: 12px;
      margin: 2px 0 0 0;
      opacity: 0.7;
    }

    .light-mode .logo-text p {
      color: #64748b;
    }

    .dark-mode .logo-text p {
      color: #94a3b8;
    }
    
    .sidebar-menu {
      flex: 1;
      padding: 24px 0;
      overflow-y: auto;
      overflow-x: hidden;
    }
    
    .sidebar-menu::-webkit-scrollbar {
      width: 5px;
    }
    
    .sidebar-menu::-webkit-scrollbar-track {
      background: transparent;
    }
    
    .sidebar-menu::-webkit-scrollbar-thumb {
      background: rgba(99, 102, 241, 0.3);
      border-radius: 10px;
    }

    .sidebar-menu::-webkit-scrollbar-thumb:hover {
      background: rgba(99, 102, 241, 0.5);
    }
    
    .menu-section {
      margin-bottom: 28px;
    }
    
    .menu-section-title {
      padding: 0 24px 10px;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 600;
      opacity: 0.6;
      transition: all 0.3s ease;
      white-space: nowrap;
      overflow: hidden;
    }

    .sidebar.collapsed .menu-section-title {
      opacity: 0;
      padding: 0;
      height: 0;
      margin: 0;
    }

    .light-mode .menu-section-title {
      color: #64748b;
    }

    .dark-mode .menu-section-title {
      color: #94a3b8;
    }
    
    .sidebar a {
      padding: 13px 24px;
      display: flex;
      align-items: center;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
      font-size: 15px;
      position: relative;
      margin: 0 12px;
      border-radius: 12px;
      white-space: nowrap;
    }

    .sidebar.collapsed a {
      justify-content: center;
      padding: 13px;
      margin: 0 16px;
    }

    .light-mode .sidebar a {
      color: #334155;
    }

    .dark-mode .sidebar a {
      color: #e2e8f0;
    }
    
    .sidebar a i {
      width: 22px;
      margin-right: 14px;
      font-size: 19px;
      text-align: center;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      flex-shrink: 0;
    }

    .sidebar.collapsed a i {
      margin-right: 0;
    }

    .light-mode .sidebar a i {
      color: #64748b;
    }

    .dark-mode .sidebar a i {
      color: #94a3b8;
    }

    .sidebar a span {
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .sidebar.collapsed a span {
      opacity: 0;
      width: 0;
    }
    
    .sidebar a:hover {
      transform: translateX(5px);
    }

    .sidebar.collapsed a:hover {
      transform: scale(1.1);
    }

    .light-mode .sidebar a:hover {
      background: rgba(99, 102, 241, 0.08);
      color: var(--primary);
    }

    .dark-mode .sidebar a:hover {
      background: rgba(99, 102, 241, 0.15);
      color: #a5b4fc;
    }
    
    .sidebar a:hover i {
      transform: scale(1.15);
      color: var(--primary);
    }
    
    .sidebar a.active {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }
    
    .sidebar a.active i {
      color: white;
      transform: scale(1.1);
    }
    
    .logout-section {
      padding: 20px;
      border-top: 1px solid;
    }

    .sidebar.collapsed .logout-section {
      padding: 20px 16px;
    }

    .light-mode .logout-section {
      border-top-color: rgba(0, 0, 0, 0.08);
    }

    .dark-mode .logout-section {
      border-top-color: rgba(255, 255, 255, 0.08);
    }
    
    .logout {
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      text-align: center;
      padding: 13px;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      white-space: nowrap;
    }

    .sidebar.collapsed .logout {
      padding: 13px;
    }
    
    .logout i {
      margin-right: 10px;
      transition: transform 0.3s ease;
      flex-shrink: 0;
    }

    .sidebar.collapsed .logout i {
      margin-right: 0;
    }

    .logout span {
      transition: all 0.3s ease;
    }

    .sidebar.collapsed .logout span {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }
    
    .logout:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
    }

    .sidebar.collapsed .logout:hover {
      transform: scale(1.1);
    }

    .logout:hover i {
      transform: rotate(-10deg);
    }
    
    .theme-toggle {
      position: fixed;
      bottom: 28px;
      right: 28px;
      width: 56px;
      height: 56px;
      border-radius: 16px;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 1002;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .light-mode .theme-toggle {
      background: rgba(255, 255, 255, 0.9);
      color: #f59e0b;
    }

    .dark-mode .theme-toggle {
      background: rgba(30, 41, 59, 0.9);
      color: #fbbf24;
    }
    
    .theme-toggle:hover {
      transform: translateY(-5px) rotate(15deg);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
    }
    
    .theme-toggle i {
      font-size: 24px;
      transition: all 0.3s ease;
    }
    
    .content {
      margin-left: 280px;
      padding: 36px;
      min-height: 100vh;
      position: relative;
      z-index: 1;
      transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar.collapsed + .content {
      margin-left: 80px;
    }
    
    .content-header {
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      padding: 28px 32px;
      border-radius: 20px;
      margin-bottom: 28px;
      transition: all 0.3s ease;
      border: 1px solid;
    }

    .light-mode .content-header {
      background: rgba(255, 255, 255, 0.9);
      border-color: rgba(255, 255, 255, 0.3);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .dark-mode .content-header {
      background: rgba(30, 41, 59, 0.9);
      border-color: rgba(255, 255, 255, 0.05);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }
    
    .content-body {
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      padding: 32px;
      border-radius: 20px;
      min-height: 500px;
      transition: all 0.3s ease;
      border: 1px solid;
    }

    .light-mode .content-body {
      background: rgba(255, 255, 255, 0.9);
      border-color: rgba(255, 255, 255, 0.3);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .dark-mode .content-body {
      background: rgba(30, 41, 59, 0.9);
      border-color: rgba(255, 255, 255, 0.05);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }
    
    .card {
      border-radius: 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid;
    }

    .light-mode .card {
      background: rgba(255, 255, 255, 0.7);
      border-color: rgba(0, 0, 0, 0.08);
      color: #1e293b;
    }

    .dark-mode .card {
      background: rgba(51, 65, 85, 0.5);
      border-color: rgba(255, 255, 255, 0.08);
      color: #f1f5f9;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }

    .light-mode .card:hover {
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .dark-mode .card:hover {
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }

    /* Form Styles */
    .light-mode .form-control,
    .light-mode .form-select {
      background: rgba(248, 250, 252, 0.8);
      border: 1px solid rgba(0, 0, 0, 0.1);
      color: #1e293b;
    }

    .light-mode .form-control:focus,
    .light-mode .form-select:focus {
      background: white;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .dark-mode .form-control,
    .dark-mode .form-select {
      background: rgba(51, 65, 85, 0.5);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #f1f5f9;
    }

    .dark-mode .form-control:focus,
    .dark-mode .form-select:focus {
      background: rgba(51, 65, 85, 0.8);
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .dark-mode .form-control::placeholder {
      color: #94a3b8;
    }

    /* Table Styles */
    .light-mode .table {
      color: #1e293b;
    }

    .dark-mode .table {
      color: #f1f5f9;
    }

    .light-mode .table thead th {
      background: rgba(99, 102, 241, 0.1);
      color: #1e293b;
      border-bottom: 2px solid rgba(99, 102, 241, 0.2);
    }

    .dark-mode .table thead th {
      background: rgba(99, 102, 241, 0.15);
      color: #f1f5f9;
      border-bottom: 2px solid rgba(99, 102, 241, 0.3);
    }

    .light-mode .table tbody tr {
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .dark-mode .table tbody tr {
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .light-mode .table tbody tr:hover {
      background: rgba(99, 102, 241, 0.05);
    }

    .dark-mode .table tbody tr:hover {
      background: rgba(99, 102, 241, 0.1);
    }

    /* Button Styles */
    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border: none;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }
    
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.collapsed {
        transform: translateX(-100%);
        width: 280px;
      }
      
      .sidebar.show {
        transform: translateX(0);
      }
      
      .content {
        margin-left: 0;
        padding: 24px 16px;
      }

      .sidebar.collapsed + .content {
        margin-left: 0;
      }
      
      .mobile-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 999;
        backdrop-filter: blur(4px);
      }
      
      .mobile-overlay.show {
        display: block;
      }
      
      .mobile-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1001;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
      }

      .light-mode .mobile-toggle {
        background: rgba(255, 255, 255, 0.9);
        color: var(--primary);
      }

      .dark-mode .mobile-toggle {
        background: rgba(30, 41, 59, 0.9);
        color: #a5b4fc;
      }

      .mobile-toggle:hover {
        transform: translateY(-2px);
      }
      
      .mobile-toggle i {
        font-size: 20px;
      }

      .theme-toggle {
        width: 48px;
        height: 48px;
        bottom: 20px;
        right: 20px;
      }

      .theme-toggle i {
        font-size: 20px;
      }

      .sidebar-toggle {
        display: none;
      }
    }
    
    @media (min-width: 769px) {
      .mobile-toggle,
      .mobile-overlay {
        display: none !important;
      }
    }
  </style>
</head>
<body class="light-mode">
  <!-- Mobile Toggle -->
  <div class="mobile-toggle" onclick="toggleMobileSidebar()">
    <i class="fas fa-bars"></i>
  </div>

  <!-- Mobile Overlay -->
  <div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>
  
  <!-- Theme Toggle Button -->
  <div class="theme-toggle" onclick="toggleTheme()">
    <i class="fas fa-moon" id="theme-icon"></i>
  </div>
  
  <div class="sidebar" id="sidebar">
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
      <i class="fas fa-chevron-left"></i>
    </button>

    <div class="sidebar-header">
      <div class="logo-icon">
        <i class="fas fa-book-reader"></i>
      </div>
      <div class="logo-text">
        <h4>VERLY</h4>
        <p>Library System</p>
      </div>
    </div>
    
    <div class="sidebar-menu">
      @yield('sidebar')
    </div>
    
    <div class="logout-section">
      <a href="/logout" class="logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </div>
  </div>
  
  <div class="content">
    @yield('content')
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle Sidebar
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
      localStorage.setItem('verlySidebarCollapsed', sidebar.classList.contains('collapsed'));
    }

    // Toggle Mobile Sidebar
    function toggleMobileSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.querySelector('.mobile-overlay');
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show');
    }
    
    // Toggle Theme
    function toggleTheme() {
      const body = document.body;
      const icon = document.getElementById('theme-icon');
      
      if (body.classList.contains('light-mode')) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        icon.className = 'fas fa-sun';
        localStorage.setItem('verlyTheme', 'dark');
      } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        icon.className = 'fas fa-moon';
        localStorage.setItem('verlyTheme', 'light');
      }
    }
    
    // Restore states on page load
    window.addEventListener('DOMContentLoaded', () => {
      const savedTheme = localStorage.getItem('verlyTheme') || 'light';
      const sidebarCollapsed = localStorage.getItem('verlySidebarCollapsed') === 'true';
      const body = document.body;
      const icon = document.getElementById('theme-icon');
      const sidebar = document.getElementById('sidebar');
      
      // Restore theme
      body.className = savedTheme + '-mode';
      icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

      // Restore sidebar state
      if (sidebarCollapsed) {
        sidebar.classList.add('collapsed');
      }
    });
  </script>
</body>
</html>