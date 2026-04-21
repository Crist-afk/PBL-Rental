<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>CostumeRent — Kelola Akun Pengguna</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    @vite(['resources/css/admin/layout.css', 'resources/css/admin/pengguna.css', 'resources/js/admin/pengguna.js'])
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
    <a class="nav-item" href="{{ route('admin.riwayat') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><polyline points="3 3 3 8 8 8"></polyline><polyline points="12 7 12 12 15 15"></polyline></svg>
      Riwayat Penyewaan
    </a>
    <a class="nav-item active" href="{{ route('admin.pengguna') }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      Kelola Akun Pengguna
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

      <!-- PAGE HEADER -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Kelola Akun Pengguna</h1>
          <p class="page-sub">Kelola data pengguna, status akun, dan riwayat pesanan</p>
        </div>
      </div>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <div class="search-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input class="search-input" type="text" placeholder="Cari nama atau email pengguna..." />
        </div>

        <div class="toolbar-right">
          <!-- SORT DROPDOWN -->
          <div class="dropdown-wrap" id="sortDrop">
            <div class="dropdown-btn" id="sortBtn" onclick="toggleDrop('sortDrop')">
              <span id="sortLabel">Urutkan: Akun Terbaru</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="sortMenu">
              <div class="drop-item selected" onclick="selectDrop('sortDrop','Urutkan: Akun Terbaru',this)">Akun Terbaru</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Urutkan: Akun Terlama',this)">Akun Terlama</div>
            </div>
          </div>
        </div>
      </div>

      <!-- USER TABLE -->
      <div class="user-table-wrapper">
        <table class="user-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Pengguna</th>
              <th>Email &amp; No. HP</th>
              <th>Tanggal Bergabung</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <!-- Row 1 -->
            <tr>
              <td><span class="user-id">#USR-001</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6)">R</div>
                  <div class="user-name">Ridho</div>
                </div>
              </td>
              <td>
                <div class="user-contact">ridho@example.com</div>
                <div class="user-phone">0812-3456-7890</div>
              </td>
              <td>12 Jan 2026</td>
              <td><span class="status-badge active">Aktif</span></td>
              <td>
                <button class="act-btn katalog" onclick="openModal('usr1')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Katalog Pesanan
                </button>
              </td>
            </tr>
            <!-- Row 2 -->
            <tr>
              <td><span class="user-id">#USR-002</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #831843, #ec4899)">A</div>
                  <div class="user-name">Asep Sudrajat</div>
                </div>
              </td>
              <td>
                <div class="user-contact">asep.sudrajat@email.com</div>
                <div class="user-phone">0856-1234-5678</div>
              </td>
              <td>05 Feb 2026</td>
              <td><span class="status-badge active">Aktif</span></td>
              <td>
                <button class="act-btn katalog" onclick="openModal('usr2')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Katalog Pesanan
                </button>
              </td>
            </tr>
            <!-- Row 3 -->
            <tr>
              <td><span class="user-id">#USR-003</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #7c2d12, #f97316)">S</div>
                  <div class="user-name">Siti Aminah</div>
                </div>
              </td>
              <td>
                <div class="user-contact">siti.aminah@mail.com</div>
                <div class="user-phone">0811-9876-5432</div>
              </td>
              <td>20 Mar 2026</td>
              <td><span class="status-badge suspended">Ditangguhkan</span></td>
              <td>
                <button class="act-btn katalog" onclick="openModal('usr3')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Katalog Pesanan
                </button>
              </td>
            </tr>
            <!-- Row 4 -->
            <tr>
              <td><span class="user-id">#USR-004</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #14532d, #16a34a)">B</div>
                  <div class="user-name">Budi Santoso</div>
                </div>
              </td>
              <td>
                <div class="user-contact">budisantoso@gmail.com</div>
                <div class="user-phone">0821-3344-5566</div>
              </td>
              <td>15 Apr 2026</td>
              <td><span class="status-badge active">Aktif</span></td>
              <td>
                <button class="act-btn katalog" onclick="openModal('usr4')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                  Katalog Pesanan
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="pagination-bar">
        <span class="pagination-info">Menampilkan 1-4 dari 45 pengguna</span>
        <div class="page-btns">
          <button class="page-btn arrow">Prev</button>
          <button class="page-btn active">1</button>
          <button class="page-btn">2</button>
          <button class="page-btn">3</button>
          <span class="page-dots">…</span>
          <button class="page-btn">8</button>
          <button class="page-btn arrow">Next</button>
        </div>
      </div>
      
    </div>
  </main>
</div>

<!-- ── MODAL KATALOG PESANAN ── -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal modal-wide" id="modalBox">
    <div class="modal-header">
      <div class="modal-header-left">
        <div class="modal-user-avatar" id="modalAvatar">R</div>
        <div>
          <div class="modal-title" id="modalTitle">Katalog Pesanan</div>
          <div class="modal-subtitle" id="modalSubtitle">ridho@example.com</div>
        </div>
      </div>
      <div class="modal-close" id="closeModalBtn">✕</div>
    </div>
    <div class="modal-body">

      <!-- STATS STRIP -->
      <div class="modal-stats" id="modalStats">
        <div class="mstat">
          <div class="mstat-icon">📦</div>
          <div>
            <div class="mstat-val" id="mstatTotal">0</div>
            <div class="mstat-label">Total Pesanan</div>
          </div>
        </div>
        <div class="mstat">
          <div class="mstat-icon">✅</div>
          <div>
            <div class="mstat-val" id="mstatSelesai">0</div>
            <div class="mstat-label">Selesai</div>
          </div>
        </div>
        <div class="mstat">
          <div class="mstat-icon">🔄</div>
          <div>
            <div class="mstat-val" id="mstatBerjalan">0</div>
            <div class="mstat-label">Berjalan</div>
          </div>
        </div>
        <div class="mstat">
          <div class="mstat-icon">💰</div>
          <div>
            <div class="mstat-val" id="mstatTotal2">Rp 0</div>
            <div class="mstat-label">Total Bayar</div>
          </div>
        </div>
      </div>

      <!-- ORDER TABLE -->
      <div class="riwayat-section-title">Riwayat Lengkap Pesanan</div>
      <div class="riwayat-table-wrap">
        <table class="riwayat-table">
          <thead>
            <tr>
              <th>No. Order</th>
              <th>Kostum</th>
              <th>Tgl Sewa</th>
              <th>Tgl Kembali</th>
              <th>Durasi</th>
              <th>Harga/Hari</th>
              <th>Total</th>
              <th>Denda</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="riwayatTableBody">
            <!-- Diisi oleh JavaScript -->
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

</body>
</html>
