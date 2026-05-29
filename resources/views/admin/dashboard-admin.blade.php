@extends('layouts.admin')

@section('title', 'CosRent — Dashboard Admin')

@push('styles')
    @vite(['resources/css/admin/dashboard.css', 'resources/js/admin/dashboard.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
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
            @if($pesanan_masuk->count() > 0)
              <span class="notif-badge" id="notifBadge">{{ $pesanan_masuk->count() }}</span>
            @endif
          </button>

          <!-- NOTIFICATION DROPDOWN -->
          <div class="notif-dropdown" id="notifDropdown">
            <!-- Header -->
            <div class="notif-header">
              <div class="notif-header-left">
                <span class="notif-header-title">Pesanan Masuk</span>
                <span class="notif-header-count">{{ $pesanan_masuk->count() }} menunggu konfirmasi</span>
              </div>
              <a href="{{ route('admin.pembayaran') }}" class="notif-see-all">Lihat Semua →</a>
            </div>

            <!-- Order List -->
            <div class="notif-list">
              @forelse($pesanan_masuk as $order)
                <a href="{{ route('admin.pembayaran') }}" class="notif-item unread">
                  <div class="notif-avatar" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700;">
                    {{ strtoupper(substr($order->user?->nama ?? 'P', 0, 1)) }}
                  </div>
                  <div class="notif-info">
                    <div class="notif-item-top">
                      <span class="notif-user">{{ $order->user?->nama ?? 'Pelanggan' }}</span>
                      <span class="notif-time">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="notif-kostum">📦 {{ $order->detailTransaksi->first()?->kostum?->nama_kostum ?? 'Kostum' }}</div>
                    <div class="notif-item-bot">
                      <span class="notif-id">#TRX-{{ $order->id }}</span>
                      <span class="notif-rp">Rp {{ number_format($order->total_biaya, 0, ',', '.') }}</span>
                    </div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </a>
              @empty
                <div style="padding: 20px; text-align: center; color: var(--text-3); font-size: 13px;">
                  Tidak ada pesanan menunggu pembayaran.
                </div>
              @endforelse
            </div><!-- /notif-list -->

            <!-- Footer -->
            <div class="notif-footer">
              <a href="{{ route('admin.pembayaran') }}" class="notif-footer-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Validasi Pembayaran
              </a>
            </div>
          </div><!-- /notif-dropdown -->
        </div><!-- /notif-wrap -->

        <a href="{{ route('admin.profile') }}" title="Lihat Profil">
          <div class="user-avatar">
            @if(Auth::user()->avatar)
              <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
            @else
              {{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}
            @endif
          </div>
        </a>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon green">💰</div>
        </div>
        <div class="stat-value">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon blue">👕</div>
        </div>
        <div class="stat-value">{{ $stats['sewa_aktif'] }}</div>
        <div class="stat-label">Kostum Aktif Disewa</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon purple">🛍️</div>
        </div>
        <div class="stat-value">{{ $stats['menunggu_bayar'] }}</div>
        <div class="stat-label">Menunggu Pembayaran</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon orange">📦</div>
        </div>
        <div class="stat-value">{{ $stats['total_kostum'] }}</div>
        <div class="stat-label">Total Kostum</div>
      </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">

      <!-- ACTIVITY -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Aktivitas Terbaru</span>
          <a class="card-link" href="{{ route('admin.pembayaran') }}">Lihat Semua →</a>
        </div>

        @forelse($transaksi_terbaru as $trx)
          @php
            $icon = '📦';
            $bg = 'rgba(59,130,246,0.12)';
            $title = 'Aktivitas Transaksi';
            $desc = 'Order #' . $trx->id . ' oleh ' . ($trx->user?->nama ?? 'Pelanggan');
            $totalDenda = $trx->pengembalian?->total_denda ?? $trx->total_denda;
            
            if ($trx->status === 'Menunggu Pembayaran') {
                $icon = '💵';
                $bg = 'rgba(167,139,250,0.12)';
                $title = 'Pembayaran baru diunggah';
                $desc = 'Menunggu konfirmasi pembayaran #TRX-' . $trx->id;
            } elseif ($trx->status === 'Disewa') {
                $icon = '👕';
                $bg = 'rgba(34,211,165,0.12)';
                $title = 'Penyewaan disetujui';
                $desc = 'Order #TRX-' . $trx->id . ' sedang aktif disewa';
            } elseif ($trx->status === 'Selesai') {
                $icon = '↩️';
                $bg = 'rgba(251,146,60,0.12)';
                $title = 'Kostum dikembalikan';
                $desc = 'Penyewaan #TRX-' . $trx->id . ' telah selesai';
                if ($totalDenda > 0) {
                    $icon = '⚠️';
                    $bg = 'rgba(248,113,113,0.12)';
                    $title = 'Pengembalian terlambat';
                    $desc = 'Penyewaan #TRX-' . $trx->id . ' dikenakan denda Rp ' . number_format($totalDenda, 0, ',', '.');
                }
            } elseif ($trx->status === 'Batal') {
                $icon = '❌';
                $bg = 'rgba(248,113,113,0.12)';
                $title = 'Pesanan dibatalkan';
                $desc = 'Order #TRX-' . $trx->id . ' telah dibatalkan';
            }
          @endphp
          
          <a href="{{ $trx->status === 'Menunggu Pembayaran' ? route('admin.pembayaran') : ($trx->status === 'Disewa' || $trx->status === 'Selesai' ? route('admin.pengembalian') : '#') }}" class="activity-item" style="text-decoration: none;">
            <div class="activity-icon" style="background: {{ $bg }}">{{ $icon }}</div>
            <div class="activity-info">
              <div class="activity-title">{{ $title }}</div>
              <div class="activity-sub">{{ $desc }}</div>
            </div>
            <div class="activity-time">{{ $trx->created_at->diffForHumans() }}</div>
          </a>
        @empty
          <div style="padding: 40px; text-align: center; color: var(--text-3); font-size: 13px;">
            Belum ada aktivitas transaksi terbaru.
          </div>
        @endforelse
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
@endsection
