<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CosRent — Dashboard Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/admin/layout.css', 'resources/css/admin/dashboard.css', 'resources/js/admin/dashboard.js', 'resources/js/admin/theme.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
      </div>
      <span class="brand-name">CosRent</span>
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
    <a class="nav-item" href="{{ route('admin.pengguna') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      Kelola Akun Pengguna
    </a>

    <div class="nav-bottom">
      <a class="nav-item" id="themeToggle" href="#">
        <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <span id="themeLabel">Mode Gelap</span>
      </a>
      <a class="nav-item logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
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
        <!-- NOTIFICATION BELL -->
        <div class="notif-wrap" id="notifWrap">
          <button class="icon-btn notif-btn" id="notifBtn" title="Notifikasi Pesanan">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="notif-badge" id="notifBadge">5</span>
          </button>

          <!-- NOTIFICATION DROPDOWN -->
          <div class="notif-dropdown" id="notifDropdown">
            <!-- Header -->
            <div class="notif-header">
              <div class="notif-header-left">
                <span class="notif-header-title">Pesanan Masuk</span>
                <span class="notif-header-count">5 menunggu konfirmasi</span>
              </div>
              <a href="{{ route('admin.pembayaran') }}" class="notif-see-all">Lihat Semua →</a>
            </div>

            <!-- Order List -->
            <div class="notif-list">

              <!-- Order 1 -->
              <a href="{{ route('admin.pembayaran') }}" class="notif-item unread">
                <div class="notif-avatar" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">R</div>
                <div class="notif-info">
                  <div class="notif-item-top">
                    <span class="notif-user">Ridho Pratama</span>
                    <span class="notif-time">2 mnt lalu</span>
                  </div>
                  <div class="notif-kostum">🦸 Kostum Batman</div>
                  <div class="notif-item-bot">
                    <span class="notif-id">#ORD-2401</span>
                    <span class="notif-rp">Rp 150.000</span>
                  </div>
                </div>
                <div class="notif-unread-dot"></div>
              </a>

              <!-- Order 2 -->
              <a href="{{ route('admin.pembayaran') }}" class="notif-item unread">
                <div class="notif-avatar" style="background: linear-gradient(135deg, #f43f5e, #fb7185);">A</div>
                <div class="notif-info">
                  <div class="notif-item-top">
                    <span class="notif-user">Asep Sudrajat</span>
                    <span class="notif-time">8 mnt lalu</span>
                  </div>
                  <div class="notif-kostum">👗 Gaun Cinderella</div>
                  <div class="notif-item-bot">
                    <span class="notif-id">#ORD-2400</span>
                    <span class="notif-rp">Rp 200.000</span>
                  </div>
                </div>
                <div class="notif-unread-dot"></div>
              </a>

              <!-- Order 3 -->
              <a href="{{ route('admin.pembayaran') }}" class="notif-item unread">
                <div class="notif-avatar" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8);">S</div>
                <div class="notif-info">
                  <div class="notif-item-top">
                    <span class="notif-user">Siti Aminah</span>
                    <span class="notif-time">23 mnt lalu</span>
                  </div>
                  <div class="notif-kostum">🥷 Kostum Naruto</div>
                  <div class="notif-item-bot">
                    <span class="notif-id">#ORD-2399</span>
                    <span class="notif-rp">Rp 120.000</span>
                  </div>
                </div>
                <div class="notif-unread-dot"></div>
              </a>

              <!-- Order 4 -->
              <a href="{{ route('admin.pembayaran') }}" class="notif-item unread">
                <div class="notif-avatar" style="background: linear-gradient(135deg, #10b981, #34d399);">B</div>
                <div class="notif-info">
                  <div class="notif-item-top">
                    <span class="notif-user">Budi Santoso</span>
                    <span class="notif-time">1 jam lalu</span>
                  </div>
                  <div class="notif-kostum">🧛 Kostum Drakula</div>
                  <div class="notif-item-bot">
                    <span class="notif-id">#ORD-2398</span>
                    <span class="notif-rp">Rp 130.000</span>
                  </div>
                </div>
                <div class="notif-unread-dot"></div>
              </a>

              <!-- Order 5 -->
              <a href="{{ route('admin.pembayaran') }}" class="notif-item unread">
                <div class="notif-avatar" style="background: linear-gradient(135deg, #f97316, #fb923c);">D</div>
                <div class="notif-info">
                  <div class="notif-item-top">
                    <span class="notif-user">Dewi Lestari</span>
                    <span class="notif-time">2 jam lalu</span>
                  </div>
                  <div class="notif-kostum">🧝 Kostum Elf</div>
                  <div class="notif-item-bot">
                    <span class="notif-id">#ORD-2397</span>
                    <span class="notif-rp">Rp 160.000</span>
                  </div>
                </div>
                <div class="notif-unread-dot"></div>
              </a>

            </div><!-- /notif-list -->

            <!-- Footer -->
            <div class="notif-footer">
              <a href="{{ route('admin.pembayaran') }}" class="notif-footer-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Validasi Semua Pembayaran
              </a>
            </div>
          </div><!-- /notif-dropdown -->
        </div><!-- /notif-wrap -->

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

        <a href="{{ route('admin.pembayaran') }}" class="activity-item" style="text-decoration: none;">
          <div class="activity-icon" style="background:rgba(34,211,165,0.12)">💵</div>
          <div class="activity-info">
            <div class="activity-title">Pembayaran dikonfirmasi</div>
            <div class="activity-sub">Order #1234 oleh Asep</div>
          </div>
          <div class="activity-time">2 menit lalu</div>
        </a>

        <a href="{{ route('admin.pengguna') }}" class="activity-item" style="text-decoration: none;">
          <div class="activity-icon" style="background:rgba(59,130,246,0.12)">👤</div>
          <div class="activity-info">
            <div class="activity-title">Pelanggan baru mendaftar</div>
            <div class="activity-sub">budi@email.com bergabung</div>
          </div>
          <div class="activity-time">5 menit lalu</div>
        </a>

        <a href="{{ route('admin.kostum') }}" class="activity-item" style="text-decoration: none;">
          <div class="activity-icon" style="background:rgba(167,139,250,0.12)">👚</div>
          <div class="activity-info">
            <div class="activity-title">Kostum diperbarui</div>
            <div class="activity-sub">Stok Kostum Superhero diupdate</div>
          </div>
          <div class="activity-time">10 menit lalu</div>
        </a>

        <a href="{{ route('admin.pengembalian') }}" class="activity-item" style="text-decoration: none;">
          <div class="activity-icon" style="background:rgba(251,146,60,0.12)">↩️</div>
          <div class="activity-info">
            <div class="activity-title">Pengembalian dicatat</div>
            <div class="activity-sub">Order #1230 dikembalikan tepat waktu</div>
          </div>
          <div class="activity-time">1 jam lalu</div>
        </a>

        <a href="{{ route('admin.pengembalian') }}" class="activity-item" style="text-decoration: none;">
          <div class="activity-icon" style="background:rgba(248,113,113,0.12)">⚠️</div>
          <div class="activity-info">
            <div class="activity-title">Denda dikenakan</div>
            <div class="activity-sub">Order #1228 terlambat 2 hari</div>
          </div>
          <div class="activity-time">2 jam lalu</div>
        </a>
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

        <!-- POPULAR COSTUMES CHART -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">Kostum Terpopuler</span>
          </div>

          <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
            <canvas id="popularCostumesChart"></canvas>
          </div>
        </div>

      </div>
    </div>
    </div>
  </main>
</div>

</body>
</html>
