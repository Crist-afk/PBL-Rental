<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title', 'CosRent Admin')</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/css/admin/layout.css', 'resources/js/admin/theme.js'])
@stack('styles')
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark-mode');
    }
</script>
<style>
    /* ─── PAGE TRANSITION OVERLAY ─── */
    .page-transition-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, #443025 0%, #2d1f18 50%, #1a1210 100%);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: all;
        opacity: 1;
        transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .page-transition-overlay.fade-out {
        opacity: 0;
        pointer-events: none;
    }
    .page-transition-overlay.hidden {
        display: none;
    }
    .page-transition-overlay .loader-content {
        text-align: center;
        animation: loaderPulse 1.5s ease-in-out infinite;
    }
    .page-transition-overlay .loader-logo {
        width: 72px; height: 72px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 20px;
        border: 3px solid rgba(236, 156, 157, 0.7);
        box-shadow: 0 0 40px rgba(236, 156, 157, 0.4);
    }
    .page-transition-overlay .loader-logo img {
        width: 100%; height: 100%;
        object-fit: cover;
        object-position: center 18%;
    }
    .page-transition-overlay .loader-text {
        color: #FFE4E1;
        font-family: 'Sora', sans-serif;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }
    .page-transition-overlay .loader-dots span {
        display: inline-block;
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #EC9C9D;
        margin: 16px 4px 0;
        animation: loaderDot 1.4s ease-in-out infinite;
    }
    .page-transition-overlay .loader-dots span:nth-child(2) { animation-delay: 0.2s; }
    .page-transition-overlay .loader-dots span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes loaderPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.03); }
    }
    @keyframes loaderDot {
        0%, 80%, 100% { transform: scale(0.4); opacity: 0.3; }
        40% { transform: scale(1); opacity: 1; }
    }

    /* ─── CONTENT ENTRANCE ANIMATION ─── */
    .admin-content-wrapper {
        opacity: 0;
        transform: translateY(18px);
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        flex: 1;
        min-width: 0;
        overflow-x: hidden;
    }
    .admin-content-wrapper.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ─── LOGOUT OVERLAY ─── */
    .logout-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, #443025 0%, #2d1f18 50%, #1a1210 100%);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .logout-overlay.active {
        opacity: 1;
        pointer-events: all;
    }
    .logout-overlay .logout-content {
        text-align: center;
        animation: loaderPulse 1.5s ease-in-out infinite;
    }
    .logout-overlay .logout-icon {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: rgba(236, 156, 157, 0.15);
        border: 3px solid rgba(236, 156, 157, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 0 40px rgba(236, 156, 157, 0.3);
    }
    .logout-overlay .logout-icon svg {
        width: 32px; height: 32px;
        color: #EC9C9D;
    }
    .logout-overlay .logout-text {
        color: #FFE4E1;
        font-family: 'Sora', sans-serif;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .logout-overlay .loader-dots span {
        display: inline-block;
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #EC9C9D;
        margin: 16px 4px 0;
        animation: loaderDot 1.4s ease-in-out infinite;
    }
    .logout-overlay .loader-dots span:nth-child(2) { animation-delay: 0.2s; }
    .logout-overlay .loader-dots span:nth-child(3) { animation-delay: 0.4s; }
</style>
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-logo-circle">
        <img src="/images/Logo-CosRent.png" alt="Logo CosRent" class="brand-logo-img">
      </div>
      <span class="brand-name">CosRent</span>
    </div>

    <a href="{{ route('admin.profile') }}" class="user-card-link">
      <div class="user-card">
        <div class="avatar">
          @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
          @else
            {{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}
          @endif
        </div>
        <div>
          <div class="user-name">{{ Auth::user()->nama ?? 'Admin' }}</div>
          <div class="user-role">Super Admin</div>
        </div>
      </div>
    </a>

    <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dasbor
    </a>
    <a class="nav-item {{ request()->routeIs('admin.kostum') ? 'active' : '' }}" href="{{ route('admin.kostum') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
      Kelola Kostum &amp; Kategori
    </a>
    <a class="nav-item {{ request()->routeIs('admin.pembayaran') ? 'active' : '' }}" href="{{ route('admin.pembayaran') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
      Validasi Pembayaran
      <span class="badge">5</span>
    </a>
    <a class="nav-item {{ request()->routeIs('admin.pengembalian') ? 'active' : '' }}" href="{{ route('admin.pengembalian') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><polyline points="3 3 3 8 8 8"></polyline></svg>
      Pengembalian &amp; Denda
    </a>
    <a class="nav-item {{ request()->routeIs('admin.riwayat') ? 'active' : '' }}" href="{{ route('admin.riwayat') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><polyline points="3 3 3 8 8 8"></polyline><polyline points="12 7 12 12 15 15"></polyline></svg>
      Riwayat Penyewaan
    </a>
    <a class="nav-item {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}" href="{{ route('admin.pengguna') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      Kelola Akun Pengguna
    </a>

    <div class="nav-bottom">
      <a class="nav-item" id="themeToggle" href="#">
        <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <span id="themeLabel">Mode Gelap</span>
      </a>
      <a class="nav-item logout" href="#" id="logoutBtn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </aside>

  <!-- PAGE TRANSITION OVERLAY (Login Entrance) -->
  @if(session('admin_login'))
  <div class="page-transition-overlay" id="loginOverlay">
      <div class="loader-content">
          <div class="loader-logo">
              <img src="/images/Logo-CosRent.png" alt="CosRent">
          </div>
          <div class="loader-text">Selamat Datang, Admin!</div>
          <div class="loader-dots"><span></span><span></span><span></span></div>
      </div>
  </div>
  @endif

  <!-- LOGOUT OVERLAY -->
  <div class="logout-overlay" id="logoutOverlay">
      <div class="logout-content">
          <div class="logout-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                  <polyline points="16 17 21 12 16 7"/>
                  <line x1="21" y1="12" x2="9" y2="12"/>
              </svg>
          </div>
          <div class="logout-text">Sedang keluar...</div>
          <div class="loader-dots"><span></span><span></span><span></span></div>
      </div>
  </div>

  <!-- PAGE NAVIGATION OVERLAY -->
  <div class="page-transition-overlay hidden" id="navOverlay">
      <div class="loader-content">
          <div class="loader-logo">
              <img src="/images/Logo-CosRent.png" alt="CosRent">
          </div>
          <div class="loader-text" id="navOverlayText">Memuat halaman...</div>
          <div class="loader-dots"><span></span><span></span><span></span></div>
      </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="admin-content-wrapper" id="adminContentWrapper">
      @yield('content')
  </div>

</div>

@stack('scripts')

<script>
(function() {
    const contentWrapper = document.getElementById('adminContentWrapper');
    const loginOverlay = document.getElementById('loginOverlay');
    const logoutOverlay = document.getElementById('logoutOverlay');
    const navOverlay = document.getElementById('navOverlay');
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutForm = document.getElementById('logout-form');

    // ═══ LOGIN FADE-IN ═══
    if (loginOverlay) {
        // Show the overlay briefly, then fade it out to reveal the dashboard
        setTimeout(function() {
            loginOverlay.classList.add('fade-out');
            contentWrapper.classList.add('visible');
            setTimeout(function() {
                loginOverlay.classList.add('hidden');
            }, 700);
        }, 1200);
    } else {
        // Normal page load — just animate content in
        requestAnimationFrame(function() {
            contentWrapper.classList.add('visible');
        });
    }

    // ═══ LOGOUT FADE-OUT ═══
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Fade out the content
            contentWrapper.classList.remove('visible');
            // Show the logout overlay
            setTimeout(function() {
                logoutOverlay.classList.add('active');
            }, 200);
            // After the animation completes, submit the form
            setTimeout(function() {
                logoutForm.submit();
            }, 1400);
        });
    }

    // ═══ PAGE NAVIGATION TRANSITIONS ═══
    const navLabels = {
        'admin.dashboard': 'Dasbor',
        'admin.kostum': 'Kelola Kostum',
        'admin.pembayaran': 'Validasi Pembayaran',
        'admin.pengembalian': 'Pengembalian & Denda',
        'admin.riwayat': 'Riwayat Penyewaan',
        'admin.pengguna': 'Kelola Pengguna'
    };

    // Intercept admin sidebar navigation links
    const navItems = document.querySelectorAll('.sidebar .nav-item[href], a[href="{{ route("admin.profile") }}"]');
    navItems.forEach(function(link) {
        const href = link.getAttribute('href');
        // Skip non-navigation items (theme toggle, logout, # links)
        if (!href || href === '#' || link.id === 'themeToggle' || link.id === 'logoutBtn') return;
        // Skip if it's the current page
        if (link.classList.contains('active')) return;

        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetUrl = href;

            // Determine label from link text (strip badge numbers)
            let linkText = link.textContent.trim().replace(/\d+$/, '').trim();
            if (targetUrl === '{{ route("admin.profile") }}') {
                linkText = 'Profil Admin';
            }
            const navText = document.getElementById('navOverlayText');
            if (navText) navText.textContent = linkText;

            // Hide sidebar badge when navigating to Validasi Pembayaran
            const sidebarBadge = link.querySelector('.badge');
            if (sidebarBadge) {
                sidebarBadge.style.display = 'none';
            }

            // Fade out content
            contentWrapper.classList.remove('visible');

            // Show navigation overlay after brief delay
            setTimeout(function() {
                navOverlay.classList.remove('hidden');
                // Navigate to the new page
                setTimeout(function() {
                    window.location.href = targetUrl;
                }, 400);
            }, 250);
        });
    });
})();
</script>
</body>
</html>
