@extends('layouts.admin')

@section('title', 'CosRent — Riwayat Penyewaan')

@push('styles')
    @vite(['resources/css/admin/riwayat.css', 'resources/js/admin/riwayat.js'])
    <style>
        /* Modern pagination custom styling to match the design */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }
        .pagination-container nav {
            display: flex;
            gap: 6px;
        }
        .pagination-container nav span, .pagination-container nav a {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-2);
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .pagination-container nav a:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(59, 130, 246, 0.05);
        }
        .pagination-container nav .active span {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }
        .pagination-container nav .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Ensure pagination and layout display nicely */
        .pelanggan-list {
            max-height: 480px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
  <!-- ── MAIN ── -->
  <main class="main">
    <div class="main-inner" style="display:flex;flex-direction:column;height:100%;">

      <h1 class="page-title">Riwayat Penyewaan</h1>
      <p class="page-subtitle">Pantau seluruh aktivitas sewa per pelanggan dengan detail presisi</p>

      <!-- SEARCH -->
      <form action="{{ route('admin.riwayat') }}" method="GET" style="margin-bottom: 24px;">
        <div class="search-row">
          <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pelanggan, email, atau nomor HP..."/>
          <button class="btn-cari" type="submit">CARI DATA</button>
        </div>
      </form>

      <!-- STAT CARDS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon-wrap blue">👥</div>
          <div>
            <div class="stat-label">Total Pelanggan Aktif</div>
            <div class="stat-value">{{ $stats['total_pelanggan'] }}</div>
          </div>
          <div class="stat-bg-icon">👥</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap green">📦</div>
          <div>
            <div class="stat-label">Total Order Bulan Ini</div>
            <div class="stat-value">{{ $stats['total_order_bulan'] }}</div>
          </div>
          <div class="stat-bg-icon">📦</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon-wrap yellow">🏆</div>
          <div>
            <div class="stat-label">Pelanggan Paling Aktif</div>
            <div class="stat-value highlight" style="font-size: 13px;">
              @if($pengguna->first())
                {{ $pengguna->first()->nama }} ({{ $pengguna->first()->transaksi_count }} order)
              @else
                -
              @endif
            </div>
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
            <span>Total Pesanan</span>
            <span>Terakhir Sewa</span>
            <span>Total Bayar</span>
            <span></span>
          </div>
          <div class="pelanggan-list">
            @forelse($pengguna as $u)
              <div class="pelanggan-item" onclick="selectPelanggan(this, {{ $u->id }})">
                <div class="p-info">
                  @if($u->avatar)
                    <img src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->nama }}" class="p-avatar" style="width:36px; height:36px; border-radius:50%; object-fit:cover; display:flex; align-items:center; justify-content:center; font-weight:700;">
                  @else
                    <div class="p-avatar" style="background:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff;">
                      {{ strtoupper(substr($u->nama, 0, 1)) }}
                    </div>
                  @endif
                  <div>
                    <div class="p-name">{{ $u->nama }}</div>
                    <div class="p-email">{{ $u->email }}</div>
                  </div>
                </div>
                <div><span class="order-badge">{{ $u->transaksi_count }} ORDER</span></div>
                <div class="p-date">{{ $u->transaksi->first()?->created_at?->format('d M Y') ?? '-' }}</div>
                <div class="p-total">Rp {{ number_format($u->transaksi_sum_total_biaya ?? 0, 0, ',', '.') }}</div>
                <div class="p-arrow">›</div>
              </div>
            @empty
              <div style="padding: 40px; text-align: center; color: var(--text-3);">
                Tidak ada pelanggan ditemukan.
              </div>
            @endforelse
          </div>

          <div class="pagination-bar" style="margin-top: 16px; padding: 0 16px;">
            <div class="pagination-container">
              {{ $pengguna->links() }}
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
              <button class="btn-export-foot" onclick="exportPDF()">⬇ Ekspor PDF</button>
              <button class="btn-export-foot" onclick="exportExcel()">📄 Ekspor Excel</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

@endsection

