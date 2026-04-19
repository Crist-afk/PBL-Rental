<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>CostumeRent — Riwayat Penyewaan</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
@vite(['resources/css/admin/layout.css', 'resources/css/admin/riwayat.css', 'resources/js/admin/riwayat.js'])
</head>
<body>
<div class="layout">

  <!-- ── SIDEBAR ── -->
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

    <a class="nav-item" href="{{ route('admin.dashboard') }}">
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
    <a class="nav-item active" href="{{ route('admin.riwayat') }}">
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

  <!-- ── MAIN ── -->
  <main class="main">
    <div class="main-inner" style="display:flex;flex-direction:column;height:100%;">

      <h1 class="page-title">Riwayat Penyewaan</h1>
      <p class="page-subtitle">Pantau seluruh aktivitas sewa per pelanggan dengan detail presisi</p>

      <!-- SEARCH -->
      <div class="search-row">
        <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Cari nama pelanggan, email, atau nomor HP..."/>
        <button class="btn-cari">CARI DATA</button>
      </div>

      <!-- STAT CARDS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon-wrap blue">👥</div>
          <div>
            <div class="stat-label">Total Pelanggan Aktif</div>
            <div class="stat-value">234</div>
          </div>
          <div class="stat-bg-icon">👥</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap green">📦</div>
          <div>
            <div class="stat-label">Total Order Bulan Ini</div>
            <div class="stat-value">89</div>
          </div>
          <div class="stat-bg-icon">📦</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap yellow">🏆</div>
          <div>
            <div class="stat-label">Pelanggan Paling Aktif</div>
            <div class="stat-value highlight">Asep Sulaiman (12 order)</div>
          </div>
          <div class="stat-bg-icon">🏆</div>
        </div>
      </div>

      <!-- CONTENT ROW -->
      <div class="content-row">

        <!-- PELANGGAN LIST -->
        <div class="panel">
          <div class="panel-header">
            <div class="panel-title">Daftar Pelanggan Terbaru</div>
          </div>
          <div class="list-head">
            <span>Pelanggan</span>
            <span>Total Order</span>
            <span>Terakhir Sewa</span>
            <span>Total Bayar</span>
            <span></span>
          </div>
          <div class="pelanggan-list">

            <div class="pelanggan-item" onclick="selectPelanggan(this, 0)">
              <div class="p-info">
                <div class="p-avatar" style="background:#2563eb">A</div>
                <div>
                  <div class="p-name">Asep Sulaiman</div>
                  <div class="p-email">asep@email.com</div>
                </div>
              </div>
              <div><span class="order-badge">12 ORDER</span></div>
              <div class="p-date">20 Apr 2026</div>
              <div class="p-total">Rp 2.400.000</div>
              <div class="p-arrow">›</div>
            </div>

            <div class="pelanggan-item" onclick="selectPelanggan(this, 1)">
              <div class="p-info">
                <div class="p-avatar" style="background:#1d4ed8">B</div>
                <div>
                  <div class="p-name">Budi Santoso</div>
                  <div class="p-email">budi@email.com</div>
                </div>
              </div>
              <div><span class="order-badge">8 ORDER</span></div>
              <div class="p-date">19 Apr 2026</div>
              <div class="p-total">Rp 1.600.000</div>
              <div class="p-arrow">›</div>
            </div>

            <div class="pelanggan-item" onclick="selectPelanggan(this, 2)">
              <div class="p-info">
                <div class="p-avatar" style="background:#0f766e">C</div>
                <div>
                  <div class="p-name">Citra Dewi</div>
                  <div class="p-email">citra@email.com</div>
                </div>
              </div>
              <div><span class="order-badge">5 ORDER</span></div>
              <div class="p-date">17 Apr 2026</div>
              <div class="p-total">Rp 750.000</div>
              <div class="p-arrow">›</div>
            </div>

            <div class="pelanggan-item" onclick="selectPelanggan(this, 3)">
              <div class="p-info">
                <div class="p-avatar" style="background:#7c3aed">D</div>
                <div>
                  <div class="p-name">Deni Pratama</div>
                  <div class="p-email">deni@email.com</div>
                </div>
              </div>
              <div><span class="order-badge">3 ORDER</span></div>
              <div class="p-date">15 Apr 2026</div>
              <div class="p-total">Rp 540.000</div>
              <div class="p-arrow">›</div>
            </div>

            <div class="pelanggan-item" onclick="selectPelanggan(this, 4)">
              <div class="p-info">
                <div class="p-avatar" style="background:#b45309">E</div>
                <div>
                  <div class="p-name">Eka Putri</div>
                  <div class="p-email">eka@email.com</div>
                </div>
              </div>
              <div><span class="order-badge">7 ORDER</span></div>
              <div class="p-date">21 Apr 2026</div>
              <div class="p-total">Rp 1.120.000</div>
              <div class="p-arrow">›</div>
            </div>

          </div>
        </div>

        <!-- DETAIL PANEL -->
        <div class="detail-panel" id="detailPanel">

          <!-- Empty state -->
          <div class="empty-state" id="emptyState">
            <div class="empty-icon">👥</div>
            <div class="empty-title">Pilih Pelanggan</div>
            <div class="empty-desc">Klik salah satu pelanggan di daftar sebelah kiri untuk melihat detail riwayat penyewaan secara lengkap.</div>
          </div>

          <!-- Customer detail -->
          <div id="customerDetail" style="display:none; flex-direction:column; height:100%;">
            <div class="cust-profile">
              <div class="cust-avatar" id="custAvatar">AS</div>
              <div>
                <div class="cust-name" id="custName">Asep Sulaiman</div>
                <div class="cust-contacts">
                  <span class="cust-contact">✉ <span id="custEmail">asep@email.com</span></span>
                  <span class="cust-contact">📞 <span id="custPhone">0812-XXXX-XXXX</span></span>
                </div>
                <div class="cust-meta">
                  <span class="cust-join">Bergabung: <span id="custJoin">Januari 2025</span></span>
                  <span class="badge-aktif">PELANGGAN AKTIF</span>
                </div>
              </div>
            </div>

            <div class="timeline-header">
              <span class="timeline-title">Timeline Penyewaan</span>
              <div class="timeline-actions">
                <div class="btn-tl-icon" title="Download" onclick="exportPDF()">⬇</div>
                <div class="btn-tl-icon" title="Export Excel" onclick="exportExcel()">📄</div>
              </div>
            </div>

            <div class="timeline-scroll" id="timelineScroll">
              <div class="timeline-list" id="timelineList"></div>
            </div>

            <div class="export-footer">
              <button class="btn-export-foot" onclick="exportPDF()">⬇ Export PDF</button>
              <button class="btn-export-foot" onclick="exportExcel()">📄 Export Excel</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

</div>
</body>
</html>
