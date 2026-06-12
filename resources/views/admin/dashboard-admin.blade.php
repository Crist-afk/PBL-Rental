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
        <p class="page-sub">Welcome back, Admin 👋</p>
      </div>
      <div class="header-actions">
        <!-- NOTIFICATION BELL -->
        <div class="notif-wrap" id="notifWrap">
          <button class="icon-btn notif-btn" id="notifBtn" title="Order Notifications">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="notif-badge" id="notifBadge" style="display: none;">0</span>
          </button>

          <!-- NOTIFICATION DROPDOWN -->
          <div class="notif-dropdown" id="notifDropdown">
            <!-- Header -->
            <div class="notif-header">
              <div class="notif-header-left">
                <span class="notif-header-title">Activity Notifications</span>
                <span class="notif-header-count" id="notifHeaderCount">0 unread</span>
              </div>
              <a href="#" class="notif-see-all" id="notifMarkAllRead">Mark All Read</a>
            </div>

            <!-- Activity List -->
            <div class="notif-list">
              @forelse($transaksi_terbaru as $trx)
                @php
                  $icon = '📦';
                  $bg = 'linear-gradient(135deg, #3b82f6, #60a5fa)';
                  $title = 'Transaction Activity';
                  $desc = 'Order #' . $trx->id . ' by ' . ($trx->user?->nama ?? 'Customer');
                  $totalDenda = $trx->pengembalian?->total_denda ?? 0;
                  $targetUrl = '#';

                  if ($trx->status === 'Menunggu Pembayaran') {
                      $icon = '💵';
                      $bg = 'linear-gradient(135deg, #a78bfa, #c084fc)';
                      $title = 'New Payment';
                      $desc = 'Awaiting confirmation #' . $trx->id;
                      $targetUrl = route('admin.pembayaran');
                  } elseif ($trx->status === 'Disewa') {
                      $icon = '👕';
                      $bg = 'linear-gradient(135deg, #10b981, #34d399)';
                      $title = 'Rental Approved';
                      $desc = 'Order #' . $trx->id . ' actively rented';
                      $targetUrl = route('admin.pengembalian');
                  } elseif ($trx->status === 'Selesai') {
                      $icon = '↩️';
                      $bg = 'linear-gradient(135deg, #f97316, #fb923c)';
                      $title = 'Costume Returned';
                      $desc = 'Order #' . $trx->id . ' completed';
                      $targetUrl = route('admin.pengembalian');
                      if ($totalDenda > 0) {
                          $icon = '⚠️';
                          $bg = 'linear-gradient(135deg, #ef4444, #f87171)';
                          $title = 'Late & Fined';
                          $desc = 'Order #' . $trx->id . ' fine Rp' . number_format($totalDenda, 0, ',', '.');
                      }
                  } elseif ($trx->status === 'Batal') {
                      $icon = '❌';
                      $bg = 'linear-gradient(135deg, #6b7280, #9ca3af)';
                      $title = 'Rental Cancelled';
                      $desc = 'Order #' . $trx->id . ' cancelled';
                      $targetUrl = route('admin.riwayat');
                  }
                  
                  $notifId = "activity_{$trx->id}_{$trx->status}";
                @endphp
                <a href="{{ $targetUrl }}" class="notif-item unread" data-notif-id="{{ $notifId }}">
                  <div class="notif-avatar" style="background: {{ $bg }}; display:flex; align-items:center; justify-content:center; color:#fff; font-size: 16px;">
                    {{ $icon }}
                  </div>
                  <div class="notif-info">
                    <div class="notif-item-top">
                      <span class="notif-user" style="font-weight: 700; color: var(--text-1);">{{ $title }}</span>
                      <span class="notif-time">{{ $trx->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="notif-kostum" style="font-size: 11px; color: var(--text-2); margin-top: 2px;">{{ $desc }}</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </a>
              @empty
                <div style="padding: 20px; text-align: center; color: var(--text-3); font-size: 13px;">
                  No new activity.
                </div>
              @endforelse
            </div><!-- /notif-list -->

            <!-- Footer -->
            <div class="notif-footer">
              <a href="{{ route('admin.pembayaran') }}" class="notif-footer-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Payment Validation
              </a>
            </div>
          </div><!-- /notif-dropdown -->
        </div><!-- /notif-wrap -->

        <a href="{{ route('admin.profile') }}" title="View Profile">
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
        <div class="stat-label">Total Revenue</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon blue">👕</div>
        </div>
        <div class="stat-value">{{ $stats['sewa_aktif'] }}</div>
        <div class="stat-label">Actively Rented Costumes</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon purple">🛍️</div>
        </div>
        <div class="stat-value">{{ $stats['menunggu_bayar'] }}</div>
        <div class="stat-label">Awaiting Payment</div>
      </div>
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon orange">📦</div>
        </div>
        <div class="stat-value">{{ $stats['total_kostum'] }}</div>
        <div class="stat-label">Total Costumes</div>
      </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">

      <!-- ACTIVITY -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Recent Activity</span>
          <a class="card-link" href="{{ route('admin.pembayaran') }}">View All →</a>
        </div>

        @forelse($transaksi_terbaru as $trx)
          @php
            $icon = '📦';
            $bg = 'rgba(59,130,246,0.12)';
            $title = 'Transaction Activity';
            $desc = 'Order #' . $trx->id . ' by ' . ($trx->user?->nama ?? 'Customer');
            $totalDenda = $trx->pengembalian?->total_denda ?? 0;
            
            if ($trx->status === 'Menunggu Pembayaran') {
                $icon = '💵';
                $bg = 'rgba(167,139,250,0.12)';
                $title = 'New payment uploaded';
                $desc = 'Awaiting payment confirmation #TRX-' . $trx->id;
            } elseif ($trx->status === 'Disewa') {
                $icon = '👕';
                $bg = 'rgba(34,211,165,0.12)';
                $title = 'Rental approved';
                $desc = 'Order #TRX-' . $trx->id . ' is actively rented';
            } elseif ($trx->status === 'Selesai') {
                $icon = '↩️';
                $bg = 'rgba(251,146,60,0.12)';
                $title = 'Costume returned';
                $desc = 'Rental #TRX-' . $trx->id . ' has been completed';
                if ($totalDenda > 0) {
                    $icon = '⚠️';
                    $bg = 'rgba(248,113,113,0.12)';
                    $title = 'Late return';
                    $desc = 'Rental #TRX-' . $trx->id . ' incurred a fine of Rp ' . number_format($totalDenda, 0, ',', '.');
                }
            } elseif ($trx->status === 'Batal') {
                $icon = '❌';
                $bg = 'rgba(248,113,113,0.12)';
                $title = 'Order cancelled';
                $desc = 'Order #TRX-' . $trx->id . ' has been cancelled';
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
            No recent transaction activity.
          </div>
        @endforelse
      </div>

      <!-- RIGHT PANEL -->
      <div class="right-panel">

        <!-- QUICK STATS -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">Quick Statistics</span>
          </div>

          <div class="stat-bar-item">
            <div class="stat-bar-header">
              <span>On-time Customer Returns</span>
              <strong>{{ $persen_tepat_waktu }}%</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill blue" data-width="{{ $persen_tepat_waktu }}" style="width: 0%" id="bar1"></div>
            </div>
          </div>

          <div class="stat-bar-item">
            <div class="stat-bar-header">
              <span>Late Return Rate</span>
              <strong>{{ $tingkat_keterlambatan }}%</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill orange" data-width="{{ $tingkat_keterlambatan }}" style="width: 0%" id="bar2"></div>
            </div>
          </div>

          <div class="stat-bar-item">
            <div class="stat-bar-header">
              <span>Registered Accounts</span>
              <strong>{{ $total_akun }}</strong>
            </div>
            <div class="bar-track">
              <div class="bar-fill green" data-width="100" style="width: 0%" id="bar3"></div>
            </div>
          </div>
        </div>

        <!-- POPULAR COSTUMES CHART -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">Costumes Ordered per Month</span>
          </div>

          <div class="chart-container" style="position: relative; height: 250px; width: 100%;">
            <canvas id="popularCostumesChart" data-labels="{{ json_encode($bulanLabels) }}" data-values="{{ json_encode($kostumPerBulan) }}"></canvas>
          </div>
        </div>

      </div>
    </div>
    </div>
  </main>
@endsection
