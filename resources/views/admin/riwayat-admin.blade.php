@extends('layouts.admin')

@section('title', 'CosRent — Rental History')

@push('styles')
    @vite(['resources/css/admin/riwayat.css', 'resources/js/admin/riwayat.js'])
@endpush

@section('content')
  <!-- ── MAIN ── -->
  <main class="main">
    <div class="main-inner" style="display:flex;flex-direction:column;height:100%;">

      <h1 class="page-title">Rental History</h1>
      <p class="page-subtitle">Monitor all customer rental activity with clear details</p>

      <!-- SEARCH -->
      <div class="search-row">
        <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search customer name, email, or phone number..."/>
        <button class="btn-cari">SEARCH DATA</button>
      </div>

      <!-- STAT CARDS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon-wrap blue">👥</div>
          <div>
            <div class="stat-label">Total Active Customers</div>
            <div class="stat-value">234</div>
          </div>
          <div class="stat-bg-icon">👥</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap green">📦</div>
          <div>
            <div class="stat-label">Total Orders This Month</div>
            <div class="stat-value">89</div>
          </div>
          <div class="stat-bg-icon">📦</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap yellow">🏆</div>
          <div>
            <div class="stat-label">Most Active Customer</div>
            <div class="stat-value highlight">Asep Sulaiman (12 orders)</div>
          </div>
          <div class="stat-bg-icon">🏆</div>
        </div>
      </div>

      <!-- CONTENT ROW -->
      <div class="content-row">

        <!-- CUSTOMER LIST -->
        <div class="panel">
          <div class="panel-header">
            <div class="panel-title">Latest Customer List</div>
          </div>
          <div class="list-head">
            <span>Customer</span>
            <span>Total Orders</span>
            <span>Last Rental</span>
            <span>Total Paid</span>
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
            <div class="empty-title">Select a Customer</div>
            <div class="empty-desc">Click a customer from the list on the left to view complete rental history details.</div>
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
                  <span class="cust-join">Joined: <span id="custJoin">January 2025</span></span>
                  <span class="badge-aktif">ACTIVE CUSTOMER</span>
                </div>
              </div>
            </div>

            <div class="timeline-header">
              <span class="timeline-title">Rental Timeline</span>
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

@endsection
