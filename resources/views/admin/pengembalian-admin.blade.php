<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>CostumeRent — Pengembalian & Denda</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    @vite(['resources/css/admin/layout.css', 'resources/css/admin/pengembalian.css', 'resources/js/admin/pengembalian.js'])
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
    <a class="nav-item active" href="{{ route('admin.pengembalian') }}">
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
      <a class="nav-item" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 1 1 4.93 19.07"/></svg>
        Pengaturan
      </a>
      <a class="nav-item" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Bantuan &amp; Dukungan
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

  <!-- MAIN -->
  <main class="main">
    <div class="main-inner">

      <h1 class="page-title">Catat Pengembalian &amp; Denda</h1>
      <p class="page-subtitle">Pantau jadwal pengembalian dan kelola keterlambatan penyewa</p>

      <!-- STAT CARDS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div>
            <div class="stat-label">Harus Dikembalikan Hari Ini</div>
            <div class="stat-value red">7</div>
          </div>
          <div class="stat-icon red">⚠️</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Sudah Dikembalikan</div>
            <div class="stat-value green">23</div>
          </div>
          <div class="stat-icon green">✅</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Terlambat</div>
            <div class="stat-value orange">4</div>
          </div>
          <div class="stat-icon orange">🕐</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Total Denda Bulan Ini</div>
            <div class="stat-value purple" style="font-size:24px">Rp 850.000</div>
          </div>
          <div class="stat-icon purple">💲</div>
        </div>
      </div>

      <!-- FILTER TABS -->
      <div class="filter-tabs">
        <button class="tab active" onclick="setTab(this)">SEMUA</button>
        <button class="tab" onclick="setTab(this)">BELUM DIKEMBALIKAN</button>
        <button class="tab" onclick="setTab(this)">TEPAT WAKTU</button>
        <button class="tab" onclick="setTab(this)">TERLAMBAT</button>
        <button class="tab" onclick="setTab(this)">DENDA BELUM DIBAYAR</button>
      </div>

      <!-- SEARCH ROW -->
      <div class="search-row">
        <div class="search-wrap">
          <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Cari nama pelanggan atau ID order..."/>
        </div>
        <select class="select-period">
          <option value="hari">Hari ini</option>
          <option value="minggu">Minggu ini</option>
          <option value="bulan">Bulan ini</option>
        </select>
        <button class="btn-export">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Export
        </button>
      </div>

      <!-- TABLE -->
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID<br>ORDER</th>
              <th>PELANGGAN</th>
              <th>KOSTUM</th>
              <th>TGL<br>MULAI SEWA</th>
              <th>TGL WAJIB<br>KEMBALI</th>
              <th>TGL AKTUAL<br>KEMBALI</th>
              <th>KETERLAMBATAN</th>
              <th>DENDA</th>
              <th>STATUS</th>
              <th>AKSI</th>
            </tr>
          </thead>
          <tbody>
            <!-- Row 1: Tepat Waktu -->
            <tr>
              <td><span class="order-id">#ORD-<br>010</span></td>
              <td><strong class="customer-name">Asep<br>Sulaiman</strong></td>
              <td><span class="kostum-cell">Batman</span></td>
              <td><span class="date-normal">15 Apr</span></td>
              <td><span class="date-warn">18 Apr</span></td>
              <td><span class="date-normal">18 Apr</span></td>
              <td style="color:#4b5a7a">–</td>
              <td><span class="fine-zero">Rp 0</span></td>
              <td>
                <span class="badge-status tepat">
                  <span class="bico">✅</span>TEPAT<br>WAKTU
                </span>
              </td>
              <td><button class="btn-action detail">LIHAT DETAIL</button></td>
            </tr>

            <!-- Row 2: Terlambat -->
            <tr>
              <td><span class="order-id">#ORD-<br>011</span></td>
              <td><strong class="customer-name">Budi<br>Santoso</strong></td>
              <td><span class="kostum-cell">Gaun<br>Cinderella</span></td>
              <td><span class="date-normal">16 Apr</span></td>
              <td><span class="date-warn">18 Apr</span></td>
              <td><span class="date-normal">20 Apr</span></td>
              <td><span class="late-days red">2 hari</span></td>
              <td>
                <div class="fine-amount">
                  <span class="fine-rp">Rp</span>
                  <span class="fine-val">400.000</span>
                </div>
              </td>
              <td>
                <span class="badge-status terlambat">
                  <span class="bico">🔴</span>TERLAMBAT
                </span>
              </td>
              <td>
                <button class="btn-action denda" onclick="openModalDenda('ORD-011','Budi Santoso','Gaun Cinderella','18/04/2026',2,50000)">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">CATAT<br>DENDA</span>
                </button>
              </td>
            </tr>

            <!-- Row 3: Belum Kembali -->
            <tr>
              <td><span class="order-id">#ORD-<br>012</span></td>
              <td><strong class="customer-name">Citra Dewi</strong></td>
              <td><span class="kostum-cell">Naruto</span></td>
              <td><span class="date-normal">17 Apr</span></td>
              <td><span class="date-warn">20 Apr</span></td>
              <td><span class="date-muted">Belum<br>Kembali</span></td>
              <td style="color:#4b5a7a">–</td>
              <td style="color:#4b5a7a">–</td>
              <td>
                <span class="badge-status belum">
                  <span class="bico">🟡</span>BELUM<br>KEMBALI
                </span>
              </td>
              <td>
                <button class="btn-action kembali" onclick="openModalKembali('ORD-012','Citra Dewi','Naruto','20/04/2026')">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">CATAT<br>KEMBALI</span>
                </button>
              </td>
            </tr>

            <!-- Row 4: Tepat Waktu -->
            <tr>
              <td><span class="order-id">#ORD-<br>013</span></td>
              <td><strong class="customer-name">Deni<br>Pratama</strong></td>
              <td><span class="kostum-cell">Kimono</span></td>
              <td><span class="date-normal">14 Apr</span></td>
              <td><span class="date-warn">17 Apr</span></td>
              <td><span class="date-normal">17 Apr</span></td>
              <td style="color:#4b5a7a">–</td>
              <td><span class="fine-zero">Rp 0</span></td>
              <td>
                <span class="badge-status tepat">
                  <span class="bico">✅</span>TEPAT<br>WAKTU
                </span>
              </td>
              <td><button class="btn-action detail">LIHAT DETAIL</button></td>
            </tr>

            <!-- Row 5: Terlambat -->
            <tr>
              <td><span class="order-id">#ORD-<br>014</span></td>
              <td><strong class="customer-name">Eka Putri</strong></td>
              <td><span class="kostum-cell">Drakula</span></td>
              <td><span class="date-normal">15 Apr</span></td>
              <td><span class="date-warn">17 Apr</span></td>
              <td><span class="date-muted">Belum<br>Kembali</span></td>
              <td><span class="late-days red">3 hari</span></td>
              <td>
                <div class="fine-amount">
                  <span class="fine-rp">Rp</span>
                  <span class="fine-val">390.000</span>
                </div>
              </td>
              <td>
                <span class="badge-status terlambat">
                  <span class="bico">🔴</span>TERLAMBAT
                </span>
              </td>
              <td>
                <button class="btn-action denda" onclick="openModalDenda('ORD-014','Eka Putri','Drakula','17/04/2026',3,130000)">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">CATAT<br>DENDA</span>
                </button>
              </td>
            </tr>

            <!-- Row 6: Belum Kembali -->
            <tr>
              <td><span class="order-id">#ORD-<br>015</span></td>
              <td><strong class="customer-name">Fajar<br>Nugroho</strong></td>
              <td><span class="kostum-cell">Spiderman</span></td>
              <td><span class="date-normal">13 Apr</span></td>
              <td><span class="date-warn">16 Apr</span></td>
              <td><span class="date-muted">Belum<br>Kembali</span></td>
              <td style="color:#4b5a7a">–</td>
              <td style="color:#4b5a7a">–</td>
              <td>
                <span class="badge-status belum">
                  <span class="bico">🟡</span>BELUM<br>KEMBALI
                </span>
              </td>
              <td>
                <button class="btn-action kembali" onclick="openModalKembali('ORD-015','Fajar Nugroho','Spiderman','16/04/2026')">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">CATAT<br>KEMBALI</span>
                </button>
              </td>
              </button></td>
            </tr>
          </tbody>
        </table>
      </div>


    </div>
  </main>
</div>

<!-- ===== MODAL CATAT DENDA ===== -->
<div class="modal-overlay" id="modalDenda">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Catat Pengembalian &amp; Denda</span>
      <button class="modal-close" onclick="closeModal('modalDenda')">✕</button>
    </div>
    <div class="modal-body">
      <div class="field-row">
        <div class="field">
          <label>ID Order</label>
          <div class="field-val highlight" id="denda-order-id">#ORD-011</div>
        </div>
        <div class="field">
          <label>Penyewa</label>
          <div class="field-val" id="denda-penyewa">Budi Santoso</div>
        </div>
      </div>
      <div class="field">
        <label>Kostum</label>
        <div class="field-val" id="denda-kostum">Gaun Cinderella</div>
      </div>
      <div class="field">
        <label>Tanggal Aktual Pengembalian</label>
        <input type="date" id="denda-tgl" value="2026-04-20"/>
      </div>
      <div class="field">
        <label>Kondisi Kostum</label>
        <div class="kondisi-row">
          <button class="kondisi-btn baik selected" onclick="selectKondisi(this,'baik')">BAIK</button>
          <button class="kondisi-btn lecet" onclick="selectKondisi(this,'lecet')">LECET</button>
          <button class="kondisi-btn rusak" onclick="selectKondisi(this,'rusak')">RUSAK</button>
        </div>
      </div>
      <div class="kalkulasi">
        <div class="kalk-row">
          <span>Hari Terlambat</span>
          <span class="red" id="denda-hari">3 HARI</span>
        </div>
        <div class="kalk-row">
          <span>Denda per Hari</span>
          <span id="denda-perhari">Rp 50.000</span>
        </div>
        <div class="kalk-total">
          <span>TOTAL DENDA</span>
          <span id="denda-total">Rp 150.000</span>
        </div>
      </div>
      <div class="status-payment-row">
        <span class="status-payment-label">Status Pembayaran Denda</span>
        <span class="badge-belum">💲 BELUM DIBAYAR</span>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-batal" onclick="closeModal('modalDenda')">BATAL</button>
      <button class="btn-simpan" onclick="simpanDenda()">SIMPAN PENGEMBALIAN</button>
    </div>
  </div>
</div>

<!-- ===== MODAL CATAT KEMBALI ===== -->
<div class="modal-overlay" id="modalKembali">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Catat Pengembalian Kostum</span>
      <button class="modal-close" onclick="closeModal('modalKembali')">✕</button>
    </div>
    <div class="modal-body">
      <div class="field-row">
        <div class="field">
          <label>ID Order</label>
          <div class="field-val highlight" id="kembali-order-id">#ORD-012</div>
        </div>
        <div class="field">
          <label>Penyewa</label>
          <div class="field-val" id="kembali-penyewa">Citra Dewi</div>
        </div>
      </div>
      <div class="field">
        <label>Kostum</label>
        <div class="field-val" id="kembali-kostum">Naruto</div>
      </div>
      <div class="field">
        <label>Tanggal Wajib Kembali</label>
        <div class="field-val" id="kembali-wajib">20/04/2026</div>
      </div>
      <div class="field">
        <label>Tanggal Aktual Pengembalian</label>
        <input type="date" id="kembali-tgl" value="2026-04-19" onchange="hitungKembaliDenda()"/>
      </div>
      <div class="field">
        <label>Kondisi Kostum</label>
        <div class="kondisi-row">
          <button class="kondisi-btn baik selected" onclick="selectKondisiK(this,'baik')">BAIK</button>
          <button class="kondisi-btn lecet" onclick="selectKondisiK(this,'lecet')">LECET</button>
          <button class="kondisi-btn rusak" onclick="selectKondisiK(this,'rusak')">RUSAK</button>
        </div>
      </div>
      <div class="kalkulasi" id="kembali-kalk" style="display:none">
        <div class="kalk-row">
          <span>Hari Terlambat</span>
          <span class="red" id="kembali-hari">0 HARI</span>
        </div>
        <div class="kalk-row">
          <span>Denda per Hari</span>
          <span>Rp 50.000</span>
        </div>
        <div class="kalk-total">
          <span>TOTAL DENDA</span>
          <span id="kembali-total">Rp 0</span>
        </div>
      </div>
      <div class="field">
        <label>Catatan</label>
        <input type="text" placeholder="Opsional: kondisi, keterangan tambahan..."/>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-batal" onclick="closeModal('modalKembali')">BATAL</button>
      <button class="btn-simpan" onclick="simpanKembali()">SIMPAN PENGEMBALIAN</button>
    </div>
  </div>
</div>

</body>
</html>
