<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CostumeRent — Dashboard Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    @vite(['resources/css/admin/layout.css', 'resources/css/admin/dashboard.css', 'resources/js/admin/dashboard.js'])
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
      </div>
      <span class="brand-name">CostumeRent</span>
    </div>

    <div class="user-card">
      <div class="avatar">A</div>
      <div>
        <div class="user-name">Admin</div>
        <div class="user-role">Super Admin</div>
      </div>
    </div>

    <a class="nav-item active" href="{{ route('admin.dashboard') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </a>
    <a class="nav-item" href="{{ route('admin.kostum') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
      Kelola Kostum &amp; Kategori
    </a>
    <a class="nav-item" href="{{ route('admin.pembayaran') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
      Validasi Pembayaran
      <span class="badge">5</span>
    </a>
    <a class="nav-item" href="{{ route('admin.pengembalian') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><polyline points="3 3 3 8 8 8"></polyline></svg>
      Pengembalian &amp; Denda
    </a>
    <a class="nav-item" href="{{ route('admin.riwayat') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><polyline points="3 3 3 8 8 8"></polyline><polyline points="12 7 12 12 15 15"></polyline></svg>
      Riwayat Penyewaan
    </a>

    <div class="nav-bottom">
      <a class="nav-item" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 1 1 4.93 19.07"/></svg>
        Pengaturan
      </a>
      <a class="nav-item" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Bantuan &amp; Dukungan
      </a>
      <a class="nav-item logout" href="{{ route('home') }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </a>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main">
    <div class="main-inner">

    <!-- HEADER -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Selamat datang kembali, Admin 👋</p>
      </div>
      <div class="header-actions">
        <div class="icon-btn" title="Notifikasi">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          <div class="notif-dot"></div>
        </div>
        <div class="icon-btn" title="Mode Gelap">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </div>
        <div class="user-avatar">A</div>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon green">💰</div>
          <span class="stat-growth">↑ +12%</span>
        </div>
        <div class="stat-value">Rp 24.567.000</div>
        <div class="stat-label">Total Pendapatan</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon blue">👕</div>
          <span class="stat-growth">↑ +5%</span>
        </div>
        <div class="stat-value">1.234</div>
        <div class="stat-label">Kostum Aktif Disewa</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon purple">🛍️</div>
          <span class="stat-growth">↑ +8%</span>
        </div>
        <div class="stat-value">456</div>
        <div class="stat-label">Order Berjalan</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon orange">📦</div>
          <span class="stat-growth amber">+3 baru</span>
        </div>
        <div class="stat-value">89</div>
        <div class="stat-label">Total Kostum</div>
      </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">

      <!-- ACTIVITY -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Aktivitas Terbaru</span>
          <a class="card-link" href="#">Lihat Semua →</a>
        </div>

        <div class="activity-item">
          <div class="activity-icon" style="background:rgba(34,211,165,0.12)">💵</div>
          <div class="activity-info">
            <div class="activity-title">Pembayaran dikonfirmasi</div>
            <div class="activity-sub">Order #1234 oleh Asep</div>
          </div>
          <div class="activity-time">2 menit lalu</div>
        </div>

        <div class="activity-item">
          <div class="activity-icon" style="background:rgba(59,130,246,0.12)">👤</div>
          <div class="activity-info">
            <div class="activity-title">Pelanggan baru mendaftar</div>
            <div class="activity-sub">budi@email.com bergabung</div>
          </div>
          <div class="activity-time">5 menit lalu</div>
        </div>

        <div class="activity-item">
          <div class="activity-icon" style="background:rgba(167,139,250,0.12)">👚</div>
          <div class="activity-info">
            <div class="activity-title">Kostum diperbarui</div>
            <div class="activity-sub">Stok Kostum Superhero diupdate</div>
          </div>
          <div class="activity-time">10 menit lalu</div>
        </div>

        <div class="activity-item">
          <div class="activity-icon" style="background:rgba(251,146,60,0.12)">↩️</div>
          <div class="activity-info">
            <div class="activity-title">Pengembalian dicatat</div>
            <div class="activity-sub">Order #1230 dikembalikan tepat waktu</div>
          </div>
          <div class="activity-time">1 jam lalu</div>
        </div>

        <div class="activity-item">
          <div class="activity-icon" style="background:rgba(248,113,113,0.12)">⚠️</div>
          <div class="activity-info">
            <div class="activity-title">Denda dikenakan</div>
            <div class="activity-sub">Order #1228 terlambat 2 hari</div>
          </div>
          <div class="activity-time">2 jam lalu</div>
        </div>
      </div>

      <!-- RIGHT PANEL -->
      <div class="right-panel">

        <!-- QUICK STATS -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">Statistik Cepat</span>
          </div>

          <div class="stat-bar-item">
            <div class="stat-bar-header">
              <span>Conversion Rate</span>
              <strong>3.2%</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill blue" style="width: 32%" id="bar1"></div>
            </div>
          </div>

          <div class="stat-bar-item">
            <div class="stat-bar-header">
              <span>Tingkat Keterlambatan</span>
              <strong>12%</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill orange" style="width: 12%" id="bar2"></div>
            </div>
          </div>

          <div class="stat-bar-item">
            <div class="stat-bar-header">
              <span>Kepuasan Pelanggan</span>
              <strong>8.7k</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill green" style="width: 87%" id="bar3"></div>
            </div>
          </div>
        </div>

        <!-- POPULAR COSTUMES -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">Kostum Terpopuler</span>
          </div>

          <div class="costume-item">
            <div class="costume-thumb" style="background:rgba(59,130,246,0.15)">🦸</div>
            <div class="costume-info">
              <div class="costume-name">Kostum Superhero...</div>
              <div class="costume-price">Rp 1.106/hari</div>
            </div>
            <span class="costume-chevron">›</span>
          </div>

          <div class="costume-item">
            <div class="costume-thumb" style="background:rgba(251,146,60,0.15)">👗</div>
            <div class="costume-info">
              <div class="costume-name">Gaun Cinderella</div>
              <div class="costume-price">Rp 582/hari</div>
            </div>
            <span class="costume-chevron">›</span>
          </div>

          <div class="costume-item">
            <div class="costume-thumb" style="background:rgba(167,139,250,0.15)">⚔️</div>
            <div class="costume-info">
              <div class="costume-name">Kostum Samurai</div>
              <div class="costume-price">Rp 896/hari</div>
            </div>
            <span class="costume-chevron">›</span>
          </div>
        </div>

      </div>
    </div>
    </div>
  </main>
</div>

</body>
</html>
