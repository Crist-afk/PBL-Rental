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
                      $icon = '🔴';
                      $bg = 'linear-gradient(135deg, #ef4444, #f87171)';
                      $title = 'Belum Upload Bukti';
                      $desc = 'Pesanan #' . $trx->id . ' belum upload bukti';
                      $targetUrl = route('admin.pembayaran', ['status' => 'belum_upload']);
                  } elseif ($trx->status === 'Menunggu Verifikasi') {
                      $icon = '⏳';
                      $bg = 'linear-gradient(135deg, #f59e0b, #fbbf24)';
                      $title = 'Menunggu Verifikasi';
                      $desc = 'Bukti pembayaran #' . $trx->id . ' perlu diverifikasi';
                      $targetUrl = route('admin.pembayaran', ['status' => 'menunggu_verifikasi']);
                  } elseif ($trx->status === 'Sudah Dibayar') {
                      $icon = '✅';
                      $bg = 'linear-gradient(135deg, #10b981, #34d399)';
                      $title = 'Sudah Dibayar';
                      $desc = 'Pesanan #' . $trx->id . ' siap diambil pelanggan';
                      $targetUrl = route('admin.pembayaran', ['status' => 'sudah_dibayar']);
                  } elseif ($trx->status === 'Disewa') {
                      $icon = '🎭';
                      $bg = 'linear-gradient(135deg, #3b82f6, #60a5fa)';
                      $title = 'Kostum Diambil';
                      $desc = 'Pesanan #' . $trx->id . ' sedang disewa';
                      $targetUrl = route('admin.pengembalian');
                  } elseif ($trx->status === 'Selesai') {
                      $icon = '↩️';
                      $bg = 'linear-gradient(135deg, #f97316, #fb923c)';
                      $title = 'Kostum Dikembalikan';
                      $desc = 'Pesanan #' . $trx->id . ' selesai';
                      $targetUrl = route('admin.pengembalian');
                      if ($totalDenda > 0) {
                          $icon = '⚠️';
                          $bg = 'linear-gradient(135deg, #ef4444, #f87171)';
                          $title = 'Terlambat & Didenda';
                          $desc = 'Pesanan #' . $trx->id . ' denda Rp' . number_format($totalDenda, 0, ',', '.');
                      }
                  } elseif ($trx->status === 'Batal') {
                      $icon = '❌';
                      $bg = 'linear-gradient(135deg, #6b7280, #9ca3af)';
                      $title = 'Dibatalkan';
                      $desc = 'Pesanan #' . $trx->id . ' dibatalkan';
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

    {{-- STAT CARDS --}}
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
      {{-- Pendapatan --}}
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon green">💰</div>
        </div>
        <div class="stat-value">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
      </div>
      {{-- Sedang Disewa --}}
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon blue">🎭</div>
        </div>
        <div class="stat-value">{{ $stats['sewa_aktif'] }}</div>
        <div class="stat-label">Sedang Disewa</div>
      </div>
      {{-- Sudah Dibayar (belum ambil) --}}
      <a href="{{ route('admin.pembayaran', ['status' => 'sudah_dibayar']) }}" style="text-decoration:none;">
      <div class="stat-card" style="border-left: 3px solid #10b981; cursor:pointer;">
        <div class="stat-top">
          <div class="stat-icon" style="background:rgba(16,185,129,0.15);">✅</div>
        </div>
        <div class="stat-value" style="color:#10b981;">{{ $stats['sudah_dibayar'] }}</div>
        <div class="stat-label">Sudah Dibayar (Belum Ambil)</div>
      </div>
      </a>
      {{-- Menunggu Verifikasi --}}
      <a href="{{ route('admin.pembayaran', ['status' => 'menunggu_verifikasi']) }}" style="text-decoration:none;">
      <div class="stat-card" style="border-left: 3px solid #f59e0b; cursor:pointer;">
        <div class="stat-top">
          <div class="stat-icon" style="background:rgba(245,158,11,0.15);">⏳</div>
          @if($stats['menunggu_verifikasi'] > 0)
            <span style="font-size:10px;font-weight:800;background:#f59e0b;color:#fff;border-radius:999px;padding:2px 8px;">PERLU AKSI</span>
          @endif
        </div>
        <div class="stat-value" style="color:#f59e0b;">{{ $stats['menunggu_verifikasi'] }}</div>
        <div class="stat-label">Menunggu Verifikasi</div>
      </div>
      </a>
      {{-- Total Kostum --}}
      <div class="stat-card">
        <div class="stat-top">
          <div class="stat-icon orange">📦</div>
        </div>
        <div class="stat-value">{{ $stats['total_kostum'] }}</div>
        <div class="stat-label">Total Kostum</div>
      </div>
      {{-- Belum Upload Bukti --}}
      <a href="{{ route('admin.pembayaran', ['status' => 'belum_upload']) }}" style="text-decoration:none;">
      <div class="stat-card" style="border-left: 3px solid #ef4444; cursor:pointer;">
        <div class="stat-top">
          <div class="stat-icon" style="background:rgba(239,68,68,0.12);">🔴</div>
        </div>
        <div class="stat-value" style="color:#ef4444;">{{ $stats['menunggu_bayar'] }}</div>
        <div class="stat-label">Belum Upload Bukti</div>
      </div>
      </a>
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
            $title = 'Aktivitas Transaksi';
            $desc = 'Pesanan #' . $trx->id . ' oleh ' . ($trx->user?->nama ?? 'Pelanggan');
            $totalDenda = $trx->pengembalian?->total_denda ?? 0;

            if ($trx->status === 'Menunggu Pembayaran') {
                $icon = '🔴'; $bg = 'rgba(239,68,68,0.12)';
                $title = 'Belum Upload Bukti';
                $desc = 'Pesanan #TRX-' . $trx->id . ' belum upload bukti transfer';
            } elseif ($trx->status === 'Menunggu Verifikasi') {
                $icon = '⏳'; $bg = 'rgba(245,158,11,0.12)';
                $title = 'Menunggu Verifikasi';
                $desc = 'Bukti pembayaran #TRX-' . $trx->id . ' perlu diverifikasi admin';
            } elseif ($trx->status === 'Sudah Dibayar') {
                $icon = '✅'; $bg = 'rgba(16,185,129,0.12)';
                $title = 'Sudah Dibayar';
                $desc = 'Pesanan #TRX-' . $trx->id . ' siap diambil pelanggan';
            } elseif ($trx->status === 'Disewa') {
                $icon = '🎭'; $bg = 'rgba(59,130,246,0.12)';
                $title = 'Kostum Sedang Disewa';
                $desc = 'Pesanan #TRX-' . $trx->id . ' sudah diambil pelanggan';
            } elseif ($trx->status === 'Selesai') {
                $icon = '↩️'; $bg = 'rgba(251,146,60,0.12)';
                $title = 'Kostum Dikembalikan';
                $desc = 'Pesanan #TRX-' . $trx->id . ' selesai';
                if ($totalDenda > 0) {
                    $icon = '⚠️'; $bg = 'rgba(248,113,113,0.12)';
                    $title = 'Terlambat & Didenda';
                    $desc = 'Pesanan #TRX-' . $trx->id . ' denda Rp ' . number_format($totalDenda, 0, ',', '.');
                }
            } elseif ($trx->status === 'Batal') {
                $icon = '❌'; $bg = 'rgba(107,114,128,0.12)';
                $title = 'Pesanan Dibatalkan';
                $desc = 'Pesanan #TRX-' . $trx->id . ' dibatalkan';
            }
          @endphp
          
          <a href="{{ $trx->status === 'Menunggu Pembayaran' ? route('admin.pembayaran', ['status' => 'belum_upload']) : ($trx->status === 'Menunggu Verifikasi' ? route('admin.pembayaran', ['status' => 'menunggu_verifikasi']) : ($trx->status === 'Sudah Dibayar' ? route('admin.pembayaran', ['status' => 'sudah_dibayar']) : ($trx->status === 'Disewa' || $trx->status === 'Selesai' ? route('admin.pengembalian') : '#'))) }}" class="activity-item" style="text-decoration: none;">
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

        <!-- LOW STOCK ALERT -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">⚠️ Low Stock Alert</span>
            <a class="card-link" href="{{ route('admin.kostum', ['low_stock' => 1]) }}">Manage All →</a>
          </div>
          <div class="low-stock-list" style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
            @forelse($stok_hampir_habis as $kostum)
              <a href="{{ route('admin.kostum', ['q' => $kostum->nama_kostum]) }}" class="low-stock-item" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: var(--bg-hover); border-radius: var(--radius-sm); border-left: 3px solid {{ $kostum->stok === 0 ? '#ef4444' : '#f59e0b' }}; text-decoration: none; transition: transform var(--transition), background var(--transition);" onmouseover="this.style.background='var(--brand-surface-strong)'; this.style.transform='translateX(4px)'" onmouseout="this.style.background='var(--bg-hover)'; this.style.transform='none'">
                <div class="low-stock-info" style="min-width: 0; flex: 1; padding-right: 8px;">
                  <div class="low-stock-name" style="font-size: 13px; font-weight: 600; color: var(--text-1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $kostum->nama_kostum }}</div>
                  <div class="low-stock-cat" style="font-size: 11px; color: var(--text-3); margin-top: 2px;">{{ $kostum->kategori?->nama_kategori ?? 'Uncategorized' }}</div>
                </div>
                <div class="low-stock-badge">
                  @if($kostum->stok === 0)
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; background: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 3px 8px; border-radius: 6px; white-space: nowrap;">Out of Stock</span>
                  @else
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 3px 8px; border-radius: 6px; white-space: nowrap;">1 Unit Left</span>
                  @endif
                </div>
              </a>
            @empty
              <div class="low-stock-empty" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 20px 10px; text-align: center;">
                <span style="font-size: 24px;">🟢</span>
                <div style="font-size: 13px; font-weight: 600; color: var(--text-2);">All costumes are in good stock.</div>
                <div style="font-size: 11px; color: var(--text-3);">Inventory level looks healthy!</div>
              </div>
            @endforelse
          </div>
        </div>

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

        {{-- TOP 5 KOSTUM TERLARIS --}}
        <div class="card">
          <div class="card-header">
            <span class="card-title">🏆 Top 5 Kostum Terlaris</span>
            <a class="card-link" href="{{ route('admin.kostum') }}">Lihat Semua →</a>
          </div>
          <div style="display:flex;flex-direction:column;gap:10px;margin-top:10px;">
            @forelse($top_kostum as $idx => $item)
              <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;background:var(--bg-hover);border-radius:var(--radius-sm);">
                <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;
                  background:{{ ['linear-gradient(135deg,#f59e0b,#fbbf24)','linear-gradient(135deg,#94a3b8,#cbd5e1)','linear-gradient(135deg,#b45309,#d97706)','rgba(59,130,246,0.2)','rgba(107,114,128,0.15)'][$idx] ?? 'rgba(107,114,128,0.15)' }};
                  color:{{ $idx < 3 ? '#fff' : 'var(--text-2)' }};">
                  {{ $idx === 0 ? '🥇' : ($idx === 1 ? '🥈' : ($idx === 2 ? '🥉' : ($idx + 1))) }}
                </div>
                <div style="flex:1;min-width:0;">
                  <div style="font-size:13px;font-weight:600;color:var(--text-1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->kostum?->nama_kostum ?? 'N/A' }}</div>
                  <div style="font-size:11px;color:var(--text-3);margin-top:1px;">{{ $item->kostum?->kategori?->nama_kategori ?? '-' }}</div>
                </div>
                <div style="font-size:11px;font-weight:800;background:rgba(59,130,246,0.12);color:#3b82f6;border-radius:999px;padding:3px 10px;white-space:nowrap;">{{ $item->total_sewa }}x disewa</div>
              </div>
            @empty
              <div style="padding:20px;text-align:center;color:var(--text-3);font-size:13px;">Belum ada data sewa.</div>
            @endforelse
          </div>
        </div>

        <!-- POPULAR COSTUMES CHART -->
        <div class="card">
          <div class="card-header">
            <span class="card-title">Kostum Dipesan per Bulan</span>
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
