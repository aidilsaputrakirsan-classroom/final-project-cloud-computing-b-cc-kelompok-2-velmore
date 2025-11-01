<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - VERLY Library</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-gradient-start: #667eea;
      --bg-gradient-end: #764ba2;
      --sidebar-bg: rgba(255, 255, 255, 0.95);
      --sidebar-text: #495057;
      --sidebar-hover: rgba(102, 126, 234, 0.1);
      --content-bg: rgba(255, 255, 255, 0.95);
      --card-border: rgba(255, 255, 255, 0.5);
      --section-title: #999;
    }
    
    body.dark-mode {
    --bg-gradient-start: #0f172a;      /* Biru navy gelap */
    --bg-gradient-end: #1e293b;
    --sidebar-bg: rgba(30, 30, 46, 0.95);
    --sidebar-text: #f1f5f9;           /* Lebih terang */
    --sidebar-hover: rgba(102, 126, 234, 0.3);
    --content-bg: rgba(30, 30, 46, 0.95);
    --card-border: rgba(102, 126, 234, 0.4);
    --section-title: #cbd5e1;          /* Biru keabu yang jelas */
    }
    body.dark-mode .card {
    background-color: rgba(255,255,255,0.05);
    color: #f8fafc;
    }
    .sidebar a i {
  color: #667eea;
}

.sidebar a.active i {
  color: #fff;
}

.sidebar a:hover {
  background: rgba(102, 126, 234, 0.15);
}

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
      transition: background 0.5s ease;
    }
    
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
      animation: backgroundPulse 10s ease-in-out infinite;
    }
    
    @keyframes backgroundPulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }
    
    .sidebar {
      height: 100vh;
      width: 280px;
      background: var(--sidebar-bg);
      backdrop-filter: blur(10px);
      box-shadow: 4px 0 30px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      z-index: 1000;
      border-right: 1px solid var(--card-border);
      transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .sidebar.collapsed {
      width: 80px;
    }
    
    .toggle-btn {
      position: absolute;
      top: 25px;
      right: -15px;
      width: 30px;
      height: 30px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
      z-index: 1001;
      transition: all 0.3s ease;
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0%, 100% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
      }
      50% {
        box-shadow: 0 4px 25px rgba(102, 126, 234, 0.6);
      }
    }
    
    .toggle-btn:hover {
      transform: scale(1.1) rotate(180deg);
      animation: none;
    }
    
    .toggle-btn i {
      color: white;
      font-size: 14px;
      transition: transform 0.3s ease;
    }
    
    .sidebar.collapsed .toggle-btn i {
      transform: rotate(180deg);
    }
    
    .sidebar-header {
      padding: 35px 25px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100px;
    }
    
    .sidebar-header::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 200px;
      height: 200px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
      }
      50% {
        transform: translateY(-20px) rotate(180deg);
      }
    }
    
    .logo-wrapper {
      position: relative;
      z-index: 1;
      text-align: center;
      width: 100%;
    }
    
    .logo-icon {
      font-size: 40px;
      color: white;
      margin-bottom: 10px;
      animation: bookFloat 3s ease-in-out infinite;
      display: block;
    }
    
    @keyframes bookFloat {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    .sidebar.collapsed .logo-text,
    .sidebar.collapsed .menu-section-title,
    .sidebar.collapsed .sidebar a span {
    display: none !important;
    }

    .sidebar.collapsed .sidebar a {
    justify-content: center;
    padding: 16px 0;
    }

    .sidebar.collapsed .sidebar a i {
    margin: 0;
    font-size: 20px;
    }

    .sidebar.collapsed .logo-text {
      opacity: 0;
      max-height: 100px;
      margin: 0;
      padding: 0;
    }
    
    .sidebar.collapsed .logo-icon {
      margin-bottom: 0;
    }
    
    .sidebar-header h4 {
      color: white;
      font-weight: 700;
      font-size: 28px;
      margin: 0;
      letter-spacing: 1px;
    }
    
    .sidebar-header p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 13px;
      margin: 5px 0 0 0;
      font-weight: 300;
    }
    
    .sidebar-menu {
      flex: 1;
      padding: 20px 0;
      overflow-y: auto;
    }
    
    .sidebar-menu::-webkit-scrollbar {
      width: 6px;
    }
    
    .sidebar-menu::-webkit-scrollbar-track {
      background: transparent;
    }
    
    .sidebar-menu::-webkit-scrollbar-thumb {
      background: rgba(102, 126, 234, 0.3);
      border-radius: 10px;
    }
    
    .menu-section {
      margin-bottom: 25px;
      animation: fadeInUp 0.6s ease-out backwards;
    }
    
    .menu-section:nth-child(1) { animation-delay: 0.1s; }
    .menu-section:nth-child(2) { animation-delay: 0.2s; }
    .menu-section:nth-child(3) { animation-delay: 0.3s; }
    
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
    
    .menu-section-title {
      padding: 0 25px 10px;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--section-title);
      font-weight: 600;
      transition: all 0.3s ease;
      white-space: nowrap;
      overflow: hidden;
    }
    
    .sidebar.collapsed .menu-section-title {
      opacity: 0;
      padding: 0;
      margin: 0;
      height: 0;
    }
    
    .sidebar a {
      color: var(--sidebar-text);
      padding: 14px 25px;
      display: flex;
      align-items: center;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      font-weight: 500;
      font-size: 15px;
      position: relative;
      margin: 0 10px;
      border-radius: 12px;
      overflow: hidden;
    }
    
    .sidebar.collapsed .sidebar a {
      justify-content: center;
      padding: 14px;
    }
    
    .sidebar a::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 0;
      background: var(--sidebar-hover);
      transition: width 0.4s ease;
    }
    
    .sidebar a span {
      transition: all 0.3s ease;
      white-space: nowrap;
    }
    
    .sidebar.collapsed .sidebar a span {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }
    
    .sidebar a i {
      margin-right: 15px;
      font-size: 18px;
      min-width: 25px;
      text-align: center;
      transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      position: relative;
      z-index: 1;
    }
    
    .sidebar.collapsed .sidebar a i {
      margin-right: 0;
    }
    
    .sidebar a:hover {
      color: #667eea;
      transform: translateX(5px) scale(1.02);
    }
    
    .sidebar.collapsed .sidebar a:hover {
      transform: scale(1.1);
    }
    
    .sidebar a:hover::before {
      width: 100%;
    }
    
    .sidebar a:hover i {
      transform: scale(1.2) rotate(5deg);
      animation: bounce 0.6s ease;
    }
    
    @keyframes bounce {
      0%, 100% {
        transform: scale(1.2) rotate(5deg) translateY(0);
      }
      50% {
        transform: scale(1.2) rotate(5deg) translateY(-5px);
      }
    }
    
    .sidebar a.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
      animation: activeGlow 2s ease-in-out infinite;
    }
    
    @keyframes activeGlow {
      0%, 100% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
      }
      50% {
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
      }
    }
    
    .sidebar a.active::before {
      display: none;
    }
    
    .sidebar a.active i {
      transform: scale(1.1);
    }
    
    .logout-section {
      padding: 20px;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
      animation: fadeInUp 1s ease-out;
    }
    
    .logout {
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      color: white;
      text-align: center;
      padding: 14px;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    
    .sidebar.collapsed .logout {
      padding: 14px;
    }
    
    .logout::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    
    .logout:hover::before {
      width: 300px;
      height: 300px;
    }
    
    .logout i {
      margin-right: 10px;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
    }
    
    .sidebar.collapsed .logout i {
      margin-right: 0;
    }
    
    .logout span {
      position: relative;
      z-index: 1;
      transition: all 0.3s ease;
      white-space: nowrap;
    }
    
    .sidebar.collapsed .logout span {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }
    
    .logout:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 8px 25px rgba(245, 87, 108, 0.5);
    }
    
    .sidebar.collapsed .logout:hover {
      transform: scale(1.1);
    }
    
    .logout:hover i {
      transform: rotate(-15deg);
    }
    
    /* Theme Toggle Button */
    .theme-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
      z-index: 1002;
      transition: all 0.3s ease;
      animation: pulse 2s infinite;
    }
    
    .theme-toggle:hover {
      transform: scale(1.1) rotate(180deg);
      box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
      animation: none;
    }
    
    .theme-toggle i {
      color: white;
      font-size: 24px;
      transition: all 0.3s ease;
    }
    
    .theme-icon {
      position: absolute;
      transition: all 0.3s ease;
    }
    
    .theme-icon.sun {
      opacity: 1;
      transform: rotate(0deg) scale(1);
    }
    
    .theme-icon.moon {
      opacity: 0;
      transform: rotate(180deg) scale(0);
    }
    
    body.dark-mode .theme-icon.sun {
      opacity: 0;
      transform: rotate(-180deg) scale(0);
    }
    
    body.dark-mode .theme-icon.moon {
      opacity: 1;
      transform: rotate(0deg) scale(1);
    }
    
    .content {
      margin-left: 280px;
      padding: 40px;
      min-height: 100vh;
      position: relative;
      z-index: 1;
      transition: margin-left 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .sidebar.collapsed + .content {
      margin-left: 80px;
    }
    
    .content-header {
      background: var(--content-bg);
      backdrop-filter: blur(10px);
      padding: 25px 30px;
      border-radius: 20px;
      margin-bottom: 30px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--card-border);
      animation: slideInDown 0.6s ease-out;
      transition: all 0.5s ease;
    }
    
    @keyframes slideInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .content-body {
      background: var(--content-bg);
      backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--card-border);
      min-height: 500px;
      animation: fadeIn 0.8s ease-out;
      transition: all 0.5s ease;
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }
    
    /* Particle Animation */
    .particles {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }
    
    .particle {
      position: absolute;
      width: 4px;
      height: 4px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      animation: floatParticle 15s infinite ease-in-out;
    }
    
    @keyframes floatParticle {
      0%, 100% {
        transform: translateY(0) translateX(0) scale(1);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100vh) translateX(100px) scale(0);
        opacity: 0;
      }
    }
    
    .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
    .particle:nth-child(2) { left: 20%; animation-delay: 2s; }
    .particle:nth-child(3) { left: 30%; animation-delay: 4s; }
    .particle:nth-child(4) { left: 40%; animation-delay: 6s; }
    .particle:nth-child(5) { left: 50%; animation-delay: 8s; }
    .particle:nth-child(6) { left: 60%; animation-delay: 10s; }
    .particle:nth-child(7) { left: 70%; animation-delay: 12s; }
    .particle:nth-child(8) { left: 80%; animation-delay: 14s; }
    
    @media (max-width: 768px) {
      .sidebar {
        width: 280px;
        transform: translateX(-100%);
      }
      
      .sidebar.show {
        transform: translateX(0);
      }
      
      .sidebar.collapsed {
        width: 280px;
        transform: translateX(-100%);
      }
      
      .content {
        margin-left: 0;
      }
      
      .mobile-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        animation: fadeIn 0.3s ease;
      }
      
      .mobile-overlay.show {
        display: block;
      }
      
      .mobile-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        z-index: 1001;
        animation: pulse 2s infinite;
      }
      
      .mobile-toggle i {
        color: white;
        font-size: 20px;
      }
      
      .theme-toggle {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
      }
      
      .theme-toggle i {
        font-size: 20px;
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
<body>
  <!-- Particle Animation -->
  <div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>

  <!-- Mobile Toggle -->
  <div class="mobile-toggle" onclick="toggleMobileSidebar()">
    <i class="fas fa-bars"></i>
  </div>

  <!-- Mobile Overlay -->
  <div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>
  
  <!-- Theme Toggle Button -->
  <div class="theme-toggle" onclick="toggleTheme()">
    <i class="fas fa-sun theme-icon sun"></i>
    <i class="fas fa-moon theme-icon moon"></i>
  </div>
  
  <div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">
      <i class="fas fa-chevron-left"></i>
    </div>
    
    <div class="sidebar-header">
      <div class="logo-wrapper">
        <i class="fas fa-book-reader logo-icon"></i>
        <div class="logo-text">
          <h4>VERLY</h4>
          <p>Digital Library System</p>
        </div>
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
      
      // Save state to localStorage
      if (sidebar.classList.contains('collapsed')) {
        localStorage.setItem('sidebarCollapsed', 'true');
      } else {
        localStorage.setItem('sidebarCollapsed', 'false');
      }
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
      body.classList.toggle('dark-mode');
      
      // Save theme to localStorage
      if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
      } else {
        localStorage.setItem('theme', 'light');
      }
    }
    
    // Restore states on page load
    window.addEventListener('DOMContentLoaded', () => {
      const sidebar = document.getElementById('sidebar');
      const collapsed = localStorage.getItem('sidebarCollapsed');
      const theme = localStorage.getItem('theme');
      
      // Restore sidebar state
      if (collapsed === 'true') {
        sidebar.classList.add('collapsed');
      }
      
      // Restore theme
      if (theme === 'dark') {
        document.body.classList.add('dark-mode');
      }
    });
    
    // Add ripple effect to menu items
    document.querySelectorAll('.sidebar a').forEach(link => {
      link.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(255, 255, 255, 0.5)';
        ripple.style.transform = 'scale(0)';
        ripple.style.animation = 'ripple 0.6s ease-out';
        ripple.style.pointerEvents = 'none';
        
        this.appendChild(ripple);
        
        setTimeout(() => {
          ripple.remove();
        }, 600);
      });
    });
    
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
      @keyframes ripple {
        to {
          transform: scale(2);
          opacity: 0;
        }
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>