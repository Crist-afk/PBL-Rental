<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>CostumeRent — Validasi Pembayaran</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    @vite(['resources/css/admin/layout.css', 'resources/css/admin/pembayaran.css', 'resources/js/admin/pembayaran.js'])
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
    <a class="nav-item active" href="{{ route('admin.pembayaran') }}">
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
      <a class="nav-item logout" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </a>
    </div>
  </aside>

  <!-- ── MAIN ── -->
  <main class="main">

    <h1 class="page-title">Validasi Pembayaran</h1>
    <p class="page-sub">Konfirmasi bukti transfer dari pelanggan baru</p>

    <!-- STAT CARDS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">⏳</span><span class="stat-lbl">Menunggu Validasi</span></div>
        <div class="stat-val amber">12</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">✅</span><span class="stat-lbl">Disetujui Hari Ini</span></div>
        <div class="stat-val green2">34</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">🚫</span><span class="stat-lbl">Ditolak</span></div>
        <div class="stat-val red">3</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">💵</span><span class="stat-lbl">Total Pendapatan Hari Ini</span></div>
        <div class="stat-subval">Rp 4.250.000</div>
      </div>
    </div>

    <!-- TABS -->
    <div class="tabs">
      <button class="tab active" onclick="selectTab(this)">Semua</button>
      <button class="tab" onclick="selectTab(this)">Menunggu Konfirmasi <span class="tab-badge">12</span></button>
      <button class="tab" onclick="selectTab(this)">Sudah Dikonfirmasi</button>
      <button class="tab" onclick="selectTab(this)">Ditolak</button>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
      <div class="search-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input class="search-input" type="text" placeholder="Cari nama pelanggan atau ID order..."/>
      </div>

      <!-- Date Range -->
      <div class="date-range" id="dateRangeBtn" onclick="openCalendar(event)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <span id="dateFrom">dd/mm/yyyy</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:12px;height:12px"><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span id="dateTo">dd/mm/yyyy</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </div>

      <button class="btn-filter">Filter</button>
    </div>

    <!-- TABLE -->
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID<br>ORDER</th>
            <th>PELANGGAN</th>
            <th>KOSTUM<br>DISEWA</th>
            <th>TANGGAL<br>SEWA</th>
            <th>DURASI</th>
            <th>TOTAL<br>BAYAR</th>
            <th>BUKTI<br>TRANSFER</th>
            <th>STATUS</th>
            <th>AKSI</th>
          </tr>
        </thead>
        <tbody>
          <!-- Row 1: Menunggu -->
          <tr>
            <td><span class="order-id-stacked">#ORD-<br>001</span></td>
            <td>
              <div class="cust-wrap">
                <div class="cust-av" style="background:#2563eb">A</div>
                <span class="cust-name">Asep<br>Sulaiman</span>
              </div>
            </td>
            <td><span class="kostum-name">Batman + Joker (2 kostum)</span></td>
            <td>
              <span class="date-stacked">
                <span class="date-day">20 Apr</span><br>
                <span class="date-year">2026</span>
              </span>
            </td>
            <td><span class="durasi-text">3 hari</span></td>
            <td>
              <div class="payment-wrap">
                <span class="payment-rp">Rp</span>
                <span class="payment-val">900.000</span>
              </div>
            </td>
            <td>
              <button class="btn-bukti" onclick="openModal('ORD-001','Asep Sulaiman','Batman + Joker (2 kostum)','900.000','BCA','ASEP SULAIMAN','menunggu')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                Lihat Bukti
              </button>
            </td>
            <td>
              <span class="status-badge waiting">
                <span class="status-dot"></span> MENUNGGU
              </span>
            </td>
            <td>
              <div class="act-btns">
                <button class="btn-approve" onclick="openModal('ORD-001','Asep Sulaiman','...','900.000','...','...','menunggu')">🟢 Setujui</button>
                <button class="btn-reject" onclick="openModal('ORD-001','Asep Sulaiman','...','900.000','...','...','menunggu')">🔴 Tolak</button>
              </div>
            </td>
          </tr>

          <!-- Row 2: Menunggu -->
          <tr>
            <td><span class="order-id-stacked">#ORD-<br>002</span></td>
            <td>
              <div class="cust-wrap">
                <div class="cust-av" style="background:#7c3aed">B</div>
                <span class="cust-name">Budi<br>Santoso</span>
              </div>
            </td>
            <td><span class="kostum-name">Gaun Cinderella</span></td>
            <td>
              <span class="date-stacked">
                <span class="date-day">21 Apr</span><br>
                <span class="date-year">2026</span>
              </span>
            </td>
            <td><span class="durasi-text">2 hari</span></td>
            <td>
              <div class="payment-wrap">
                <span class="payment-rp">Rp</span>
                <span class="payment-val">400.000</span>
              </div>
            </td>
            <td>
              <button class="btn-bukti" onclick="openModal('ORD-002','Budi Santoso','...','400.000','...','...','menunggu')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                Lihat Bukti
              </button>
            </td>
            <td>
              <span class="status-badge waiting">
                <span class="status-dot"></span> MENUNGGU
              </span>
            </td>
            <td>
              <div class="act-btns">
                <button class="btn-approve" onclick="openModal('ORD-002','...','...','400.000','...','...','menunggu')">🟢 Setujui</button>
                <button class="btn-reject" onclick="openModal('ORD-002','...','...','400.000','...','...','menunggu')">🔴 Tolak</button>
              </div>
            </td>
          </tr>

          <!-- Row 3: Dikonfirmasi -->
          <tr>
            <td><span class="order-id-stacked">#ORD-<br>003</span></td>
            <td>
              <div class="cust-wrap">
                <div class="cust-av" style="background:#0f766e">C</div>
                <span class="cust-name">Citra Dewi</span>
              </div>
            </td>
            <td><span class="kostum-name">Kostum Naruto</span></td>
            <td>
              <span class="date-stacked">
                <span class="date-day">19 Apr</span><br>
                <span class="date-year">2026</span>
              </span>
            </td>
            <td><span class="durasi-text">1 hari</span></td>
            <td>
              <div class="payment-wrap">
                <span class="payment-rp">Rp</span>
                <span class="payment-val">120.000</span>
              </div>
            </td>
            <td>
              <button class="btn-bukti" onclick="openModal('ORD-003','...','...','120.000','...','...','dikonfirmasi')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                Lihat Bukti
              </button>
            </td>
            <td>
              <span class="status-badge confirmed">
                <span class="status-dot"></span> DIKONFIRMASI
              </span>
            </td>
            <td>
              <div class="act-btns">
                <button class="btn-det" onclick="openModal('ORD-003','...','...','...','...','...','dikonfirmasi')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                  DETAIL
                </button>
              </div>
            </td>
          </tr>

          <!-- Row 4: Ditolak -->
          <tr>
            <td><span class="order-id-stacked">#ORD-<br>004</span></td>
            <td>
              <div class="cust-wrap">
                <div class="cust-av" style="background:#b45309">D</div>
                <span class="cust-name">Deni<br>Pratama</span>
              </div>
            </td>
            <td><span class="kostum-name">Baju Kimono</span></td>
            <td>
              <span class="date-stacked">
                <span class="date-day">18 Apr</span><br>
                <span class="date-year">2026</span>
              </span>
            </td>
            <td><span class="durasi-text">5 hari</span></td>
            <td>
              <div class="payment-wrap">
                <span class="payment-rp">Rp</span>
                <span class="payment-val">900.000</span>
              </div>
            </td>
            <td>
              <button class="btn-bukti" onclick="openModal('ORD-004','...','...','...','...','...','ditolak')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                Lihat Bukti
              </button>
            </td>
            <td>
              <span class="status-badge rejected">
                <span class="status-dot"></span> DITOLAK
              </span>
            </td>
            <td>
              <div class="act-btns">
                <button class="btn-det" onclick="openModal('ORD-004','...','...','...','...','...','ditolak')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                  DETAIL
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </main>
</div>

<!-- ── CALENDAR POPUP ── -->
<div class="cal-overlay" id="calOverlay" onclick="closeCalendar(event)">
  <div class="cal-popup" id="calPopup">
    <div class="cal-header">
      <button class="cal-nav" id="calPrev" onclick="changeMonth(-1)">&#8249;</button>
      <span class="cal-title" id="calTitle"></span>
      <button class="cal-nav" id="calNext" onclick="changeMonth(1)">&#8250;</button>
    </div>
    <div class="cal-grid" id="calGrid"></div>
    <div class="cal-label" id="calHint">Pilih tanggal mulai</div>
    <div class="cal-footer">
      <button class="cal-btn reset" onclick="resetCalendar()">Reset</button>
      <button class="cal-btn apply" onclick="applyCalendar()">Terapkan</button>
    </div>
  </div>
</div>

<!-- ── DETAIL MODAL ── -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-order-id" id="mOrderId">#ORD-001</div>
        <div class="modal-sub">Validasi pembayaran oleh: <span id="mCustName">Asep Sulaiman</span></div>
      </div>
      <div class="modal-close" onclick="closeModal()">✕</div>
    </div>
    <div class="modal-body">
      <!-- LEFT -->
      <div>
        <div class="modal-section-title">Rangkuman Pesanan</div>
        <div class="order-item-card">
          <div class="order-item-icon" id="mItemIcon">🦇</div>
          <div>
            <div class="order-item-name" id="mKostum">Batman + Joker (2 kostum)</div>
            <div class="order-item-date" id="mDate">20 Apr 2026 (3 hari)</div>
          </div>
        </div>
        <div class="total-row">
          <span class="total-lbl">Total Tagihan</span>
          <span class="total-amt" id="mTotal">Rp 900.000</span>
        </div>

        <div style="margin-top:18px">
          <div class="modal-section-title">Detail Transfer</div>
          <div class="detail-grid">
            <div class="detail-item"><div class="detail-lbl">Nama Bank</div><div class="detail-val" id="mBank">BCA (Bank Central Asia)</div></div>
            <div class="detail-item"><div class="detail-lbl">Nama Pengirim</div><div class="detail-val" id="mPengirim">ASEP SULAIMAN</div></div>
          </div>
          <div class="detail-item"><div class="detail-lbl">Nominal Transfer</div><div class="detail-amt" id="mNominal">Rp 900.000</div></div>
        </div>

        <div style="margin-top:18px">
          <div class="modal-section-title">Catatan Admin</div>
          <textarea class="form-textarea" placeholder="Tambahkan catatan jika perlu (Contoh: Bukti buram, mohon upload ulang)..."></textarea>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="bukti-panel">
        <div class="modal-section-title">Bukti Transfer</div>
        <div class="bukti-img">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>BuktiTransfer.jpg</span>
        </div>
        <button class="btn-resolusi">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Lihat Resolusi Penuh
        </button>
      </div>
    </div>

    <div class="modal-footer" id="mFooter">
      <button class="btn-tolak-modal" onclick="closeModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        TOLAK PEMBAYARAN
      </button>
      <button class="btn-konfirmasi" onclick="closeModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        KONFIRMASI PEMBAYARAN
      </button>
    </div>
  </div>
</div>

</body>
</html>
