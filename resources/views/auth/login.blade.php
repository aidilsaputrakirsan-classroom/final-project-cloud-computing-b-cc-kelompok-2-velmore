<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - VERLY Library</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    /* Light Mode */
    body.light-mode {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    body.light-mode::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: -250px;
      right: -250px;
      animation: float 20s infinite ease-in-out;
    }

    body.light-mode::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 50%;
      bottom: -200px;
      left: -200px;
      animation: float 15s infinite ease-in-out reverse;
    }

    /* Dark Mode */
    body.dark-mode {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    }

    body.dark-mode::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: rgba(102, 126, 234, 0.1);
      border-radius: 50%;
      top: -250px;
      right: -250px;
      animation: float 20s infinite ease-in-out;
    }

    body.dark-mode::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: rgba(118, 75, 162, 0.08);
      border-radius: 50%;
      bottom: -200px;
      left: -200px;
      animation: float 15s infinite ease-in-out reverse;
    }

    @keyframes float {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      33% { transform: translate(30px, -30px) rotate(120deg); }
      66% { transform: translate(-20px, 20px) rotate(240deg); }
    }

    .login-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }

    .login-card {
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 35px 35px 30px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
      animation: slideUp 0.6s ease-out;
      position: relative;
    }

    .light-mode .login-card {
      background: rgba(255, 255, 255, 0.95);
      color: #333;
    }

    .dark-mode .login-card {
      background: rgba(30, 30, 46, 0.95);
      color: #e0e0e0;
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

    .library-icon {
      width: 70px;
      height: 70px;
      margin: 0 auto 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 18px;
      font-size: 36px;
      position: relative;
      animation: pulse 2s infinite;
    }

    .light-mode .library-icon {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .dark-mode .library-icon {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .login-title {
      font-size: 26px;
      font-weight: 700;
      margin-bottom: 8px;
      text-align: center;
    }

    .login-subtitle {
      text-align: center;
      margin-bottom: 30px;
      opacity: 0.7;
      font-size: 13px;
    }

    .form-label {
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .input-group-custom {
      position: relative;
      margin-bottom: 20px;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 68%;
      transform: translateY(-50%);
      opacity: 0.5;
      pointer-events: none;
      font-size: 16px;
    }

    .form-control {
      padding: 14px 50px 14px 45px;
      border-radius: 12px;
      border: 2px solid transparent;
      font-size: 15px;
      transition: all 0.3s ease;
      width: 100%;
    }

    .light-mode .form-control {
      background: rgba(240, 240, 245, 0.8);
      color: #333;
    }

    .light-mode .form-control:focus {
      background: white;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
      outline: none;
    }

    .dark-mode .form-control {
      background: rgba(40, 40, 60, 0.6);
      color: #e0e0e0;
      border-color: rgba(255, 255, 255, 0.1);
    }

    .dark-mode .form-control:focus {
      background: rgba(50, 50, 70, 0.8);
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
      outline: none;
    }

    .light-mode .form-control::placeholder {
      opacity: 0.5;
      color: #666;
    }

    .dark-mode .form-control::placeholder {
      opacity: 0.6;
      color: #a0a0a0;
    }

    .password-toggle {
      position: absolute;
      right: 16px;
      top: 68%;
      transform: translateY(-50%);
      cursor: pointer;
      opacity: 0.6;
      transition: opacity 0.3s ease;
      font-size: 16px;
      z-index: 10;
    }

    .password-toggle:hover {
      opacity: 1;
    }

    .btn-login {
      width: 100%;
      padding: 14px;
      border-radius: 12px;
      border: none;
      font-weight: 600;
      font-size: 16px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      position: relative;
      overflow: hidden;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login::before {
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

    .btn-login:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-login span {
      position: relative;
      z-index: 1;
    }

    .theme-toggle {
      position: absolute;
      top: 25px;
      right: 25px;
      width: 55px;
      height: 55px;
      border-radius: 50%;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      transition: all 0.3s ease;
      z-index: 100;
      backdrop-filter: blur(10px);
    }

    .light-mode .theme-toggle {
      background: rgba(255, 255, 255, 0.3);
      color: #fff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .dark-mode .theme-toggle {
      background: rgba(255, 255, 255, 0.1);
      color: #ffd700;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .theme-toggle:hover {
      transform: scale(1.1) rotate(15deg);
    }

    .alert {
      border-radius: 12px;
      padding: 12px 18px;
      margin-bottom: 20px;
      border: none;
      animation: slideDown 0.4s ease-out;
      font-size: 14px;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-danger {
      background: rgba(220, 53, 69, 0.15);
      color: #dc3545;
      border-left: 4px solid #dc3545;
    }

    .alert-success {
      background: rgba(40, 167, 69, 0.15);
      color: #28a745;
      border-left: 4px solid #28a745;
    }

    .decorative-books {
      position: relative;
      margin-top: 25px;
      display: flex;
      justify-content: center;
      gap: 6px;
      opacity: 0.25;
    }

    .book {
      width: 5px;
      border-radius: 2px;
      animation: bookFloat 3s infinite ease-in-out;
    }

    .book:nth-child(1) { height: 35px; background: #667eea; animation-delay: 0s; }
    .book:nth-child(2) { height: 42px; background: #764ba2; animation-delay: 0.2s; }
    .book:nth-child(3) { height: 38px; background: #667eea; animation-delay: 0.4s; }
    .book:nth-child(4) { height: 45px; background: #764ba2; animation-delay: 0.6s; }
    .book:nth-child(5) { height: 36px; background: #667eea; animation-delay: 0.8s; }

    @keyframes bookFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 30px 25px;
      }
      
      .theme-toggle {
        top: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 20px;
      }
    }
  </style>
</head>
<body class="light-mode">
  <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
    <i class="fas fa-moon" id="theme-icon"></i>
  </button>

  <div class="login-container">
    <div class="login-card">
      <div class="library-icon">
        <i class="fas fa-book-open"></i>
      </div>
      
      <h3 class="login-title">VERLY Library</h3>
      <p class="login-subtitle">Sistem Manajemen Perpustakaan Digital</p>
      
      @if(session('error'))
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif
      
      <form method="POST" action="/login">
        @csrf
        
        <div class="input-group-custom">
          <label class="form-label">
            <i class="fas fa-envelope"></i> Email
          </label>
          <i class="fas fa-user input-icon"></i>
          <input type="email" name="email" class="form-control" placeholder="admin@library.com" required>
        </div>

        <div class="input-group-custom">
          <label class="form-label">
            <i class="fas fa-lock"></i> Password
          </label>
          <i class="fas fa-key input-icon"></i>
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
          <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePasswordVisibility()"></i>
        </div>

        <button type="submit" class="btn-login">
          <span><i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard</span>
        </button>
      </form>
      
      <div class="decorative-books">
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
        <div class="book"></div>
      </div>
    </div>
  </div>

  <script>
    // Load saved theme on page load
    document.addEventListener('DOMContentLoaded', function() {
      const savedTheme = localStorage.getItem('theme') || 'light-mode';
      const body = document.body;
      const icon = document.getElementById('theme-icon');
      
      body.className = savedTheme;
      icon.className = savedTheme === 'dark-mode' ? 'fas fa-sun' : 'fas fa-moon';
    });

    // Theme Toggle
    function toggleTheme() {
      const body = document.body;
      const icon = document.getElementById('theme-icon');
      
      if (body.classList.contains('light-mode')) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        icon.className = 'fas fa-sun';
        localStorage.setItem('theme', 'dark-mode');
      } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        icon.className = 'fas fa-moon';
        localStorage.setItem('theme', 'light-mode');
      }
    }

    // Toggle Password Visibility
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('togglePassword');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash password-toggle';
      } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'fas fa-eye password-toggle';
      }
    }

    // Add ripple effect to button
    document.querySelector('.btn-login').addEventListener('click', function(e) {
      let ripple = document.createElement('span');
      ripple.classList.add('ripple');
      this.appendChild(ripple);
      
      setTimeout(() => ripple.remove(), 600);
    });
  </script>
</body>
</html>