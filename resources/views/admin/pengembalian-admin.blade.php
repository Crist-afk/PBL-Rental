@extends('layouts.admin')

@section('title', 'CosRent — Returns & Penalties')

@push('styles')
    @vite(['resources/css/admin/pengembalian.css', 'resources/js/admin/pengembalian.js'])
    <style>
        /* Modern pagination custom styling to match the design */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }
        .pagination-container nav {
            display: flex;
            gap: 6px;
        }
        .pagination-container nav span, .pagination-container nav a {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-2);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
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
    </style>
@endpush

@section('content')
  <!-- MAIN -->
  <main class="main" style="padding-top: 24px;">
    <div class="main-inner">

      <!-- FLASH MESSAGES -->
      @if(session('success'))
        <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 500; animation: fadeIn 0.4s;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <h1 class="page-title">Record Returns &amp; Penalties</h1>
      <p class="page-subtitle">Monitor return schedules and manage tenant delays</p>

      <!-- STAT CARDS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div>
            <div class="stat-label">Must Return Today</div>
            <div class="stat-value red">{{ $stats['harus_kembali'] }}</div>
          </div>
          <div class="stat-icon red">⚠️</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Returned Today</div>
            <div class="stat-value green">{{ $stats['sudah_kembali'] }}</div>
          </div>
          <div class="stat-icon green">✅</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Very Late Rentals</div>
            <div class="stat-value orange">{{ $stats['terlambat'] }}</div>
          </div>
          <div class="stat-icon orange">🕐</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Total Fines Collected</div>
            <div class="stat-value purple" style="font-size:20px">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</div>
          </div>
          <div class="stat-icon purple">💲</div>
        </div>
      </div>

      <!-- FILTER TABS -->
      <div class="filter-tabs">
        <a href="{{ route('admin.pengembalian', ['filter' => 'semua', 'q' => request('q')]) }}" class="tab {{ $filter === 'semua' ? 'active' : '' }}" style="text-decoration: none;">ALL</a>
        <a href="{{ route('admin.pengembalian', ['filter' => 'belum', 'q' => request('q')]) }}" class="tab {{ $filter === 'belum' ? 'active' : '' }}" style="text-decoration: none;">NOT YET RETURNED</a>
        <a href="{{ route('admin.pengembalian', ['filter' => 'tepat', 'q' => request('q')]) }}" class="tab {{ $filter === 'tepat' ? 'active' : '' }}" style="text-decoration: none;">ON TIME</a>
        <a href="{{ route('admin.pengembalian', ['filter' => 'terlambat', 'q' => request('q')]) }}" class="tab {{ $filter === 'terlambat' ? 'active' : '' }}" style="text-decoration: none;">LATE</a>
        <a href="{{ route('admin.pengembalian', ['filter' => 'denda', 'q' => request('q')]) }}" class="tab {{ $filter === 'denda' ? 'active' : '' }}" style="text-decoration: none;">WITH FINES</a>
      </div>

      <!-- SEARCH ROW -->
      <div class="search-row">
        <form action="{{ route('admin.pengembalian') }}" method="GET" style="display: flex; flex: 1; align-items: center; gap: 12px;">
          <input type="hidden" name="filter" value="{{ $filter }}">
          <div class="search-wrap" style="width: 100%;">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search customer name or order ID..."/>
          </div>
        </form>
      </div>

      <!-- TABLE -->
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ORDER<br>ID</th>
              <th>CUSTOMER</th>
              <th>COSTUME</th>
              <th>RENTAL<br>START DATE</th>
              <th>REQUIRED<br>RETURN DATE</th>
              <th>ACTUAL<br>RETURN DATE</th>
              <th>COSTUME<br>CONDITION</th>
              <th>DELAY</th>
              <th>FINE</th>
              <th>STATUS</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            @forelse($transaksis as $t)
              @php
                $custName = $t->user?->nama ?? 'Customer';
                $kostumNames = [];
                foreach($t->detailTransaksi as $dt) {
                    if($dt->kostum) {
                        $kostumNames[] = $dt->kostum->nama_kostum . ' (' . $dt->ukuran . ')';
                    }
                }
                $kostumDesc = count($kostumNames) > 0 ? implode(', ', $kostumNames) : 'N/A';
                
                $tanggalSelesai = $t->tanggal_selesai;
                $pengembalian = $t->pengembalian;
                $tanggalKembali = $pengembalian?->tanggal_kembali_aktual ?? $t->tanggal_kembali_aktual;
                $kondisiBarang = $pengembalian?->kondisi_barang ?? $t->kondisi_kostum;
                $totalDenda = $pengembalian?->total_denda ?? $t->total_denda;
                $isTerlambat = false;
                $hariTerlambat = 0;
                
                if ($t->status === 'Disewa') {
                    if (\Carbon\Carbon::today()->gt($tanggalSelesai)) {
                        $isTerlambat = true;
                        $hariTerlambat = \Carbon\Carbon::today()->diffInDays($tanggalSelesai);
                    }
                } else if ($t->status === 'Selesai' && $tanggalKembali && $tanggalKembali->gt($tanggalSelesai)) {
                    $isTerlambat = true;
                    $hariTerlambat = $tanggalKembali->diffInDays($tanggalSelesai);
                }
              @endphp
              <tr>
                <td><span class="order-id">#TRX-<br>{{ $t->id }}</span></td>
                <td><strong class="customer-name">{{ $custName }}</strong></td>
                <td><span class="kostum-cell" title="{{ $kostumDesc }}">{{ \Illuminate\Support\Str::limit($kostumDesc, 20) }}</span></td>
                <td><span class="date-normal">{{ $t->tanggal_mulai?->format('d M Y') }}</span></td>
                <td><span class="date-warn">{{ $t->tanggal_selesai?->format('d M Y') }}</span></td>
                <td>
                  @if($t->status === 'Selesai' && $tanggalKembali)
                    <span class="date-normal">{{ $tanggalKembali->format('d M Y') }}</span>
                  @else
                    @if($isTerlambat)
                      <span class="date-muted" style="color:#ef4444;font-weight:700;">LATE!</span>
                    @else
                      <span class="date-muted">Not Returned</span>
                    @endif
                  @endif
                </td>
                <td>
                  @if($t->status === 'Selesai')
                    @if($kondisiBarang === 'Baik')
                      <span class="kondisi-display baik" style="font-size:9px;padding:4px 8px;border-radius:6px;">GOOD</span>
                    @elseif($kondisiBarang === 'Lecet')
                      <span class="kondisi-display lecet" style="font-size:9px;padding:4px 8px;border-radius:6px;">SCUFFED</span>
                    @elseif($kondisiBarang === 'Rusak')
                      <span class="kondisi-display rusak" style="font-size:9px;padding:4px 8px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;border:1px solid rgba(239,68,68,0.2);">DAMAGED</span>
                    @else
                      <span style="color:#4b5a7a">â€“</span>
                    @endif
                  @else
                    <button type="button" class="kondisi-btn-action" style="font-size: 9px; padding: 4px 8px; border-radius: 6px; background: rgba(124, 58, 237, 0.1); color: #7c3aed; border: 1px dashed #7c3aed; cursor: pointer; font-weight: 700; text-transform: uppercase; transition: all 0.2s;" onmouseover="this.style.background='rgba(124, 58, 237, 0.2)'" onmouseout="this.style.background='rgba(124, 58, 237, 0.1)'" onclick="openKembaliFormModal({{ json_encode($t) }}, {{ json_encode($kostumDesc) }})">
                      📝 RECORD RETURN
                    </button>
                  @endif
                </td>
                <td>
                  @if($isTerlambat)
                    <span class="late-days red">{{ $hariTerlambat }} days</span>
                  @else
                    <span style="color:#4b5a7a">–</span>
                  @endif
                </td>
                <td>
                  @if($totalDenda > 0)
                    <div class="fine-amount">
                      <span class="fine-rp">Rp</span>
                      <span class="fine-val">{{ number_format($totalDenda, 0, ',', '.') }}</span>
                    </div>
                  @elseif($t->status === 'Selesai')
                    <span class="fine-zero">Rp 0</span>
                  @else
                    <span style="color:#4b5a7a">–</span>
                  @endif
                </td>
                <td>
                  @if($t->status === 'Disewa')
                    @if($isTerlambat)
                      <span class="badge-status terlambat" style="background:rgba(239,68,68,0.1);border-color:rgba(239,68,68,0.2);color:#ef4444;">
                        <span class="bico">⚠️</span>VERY LATE
                      </span>
                    @else
                      <span class="badge-status belum">
                        <span class="bico">🟡</span>NOT RETURNED
                      </span>
                    @endif
                  @else
                    @if($totalDenda > 0)
                      <span class="badge-status terlambat">
                        <span class="bico">🔴</span>LATE
                      </span>
                    @else
                      <span class="badge-status tepat">
                        <span class="bico">✅</span>ON TIME
                      </span>
                    @endif
                  @endif
                </td>
                <td>
                  @if($t->status === 'Disewa')
                    <button class="btn-action kembali" onclick="openKembaliFormModal({{ json_encode($t) }}, {{ json_encode($kostumDesc) }})">
                      <span class="btn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      </span>
                      <span class="btn-label">RECORD RETURN</span>
                    </button>
                  @else
                    <button class="btn-action detail" onclick="openDetailFormModal({{ json_encode($t) }}, {{ json_encode($kostumDesc) }}, {{ $isTerlambat ? 'true' : 'false' }}, {{ $hariTerlambat }})">👁 VIEW DETAILS</button>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="11" style="text-align: center; padding: 48px; color: var(--text-3); font-weight: 500;">
                  No active/completed rental transactions found.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="pagination-bar" style="margin-top: 16px;">
        <span class="pagination-info">Showing {{ $transaksis->firstItem() ?? 0 }}-{{ $transaksis->lastItem() ?? 0 }} of {{ $transaksis->total() }} orders</span>
        <div class="pagination-container">
          {{ $transaksis->links() }}
        </div>
      </div>

    </div>
  </main>
</div>

<!-- ===== MODAL CATAT KEMBALI ===== -->
<div class="modal-overlay" id="modalKembali">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Catat Pengembalian Kostum</span>
      <button class="modal-close" onclick="closeModal('modalKembali')">✕</button>
    </div>
    <form action="" method="POST">
      @csrf
      <div class="modal-body">
        <div class="field-row">
          <div class="field">
            <label>Order ID</label>
            <div class="field-val highlight" id="kembali-order-id">#TRX-000</div>
          </div>
          <div class="field">
            <label>Tenant</label>
            <div class="field-val" id="kembali-penyewa">Pelanggan</div>
          </div>
        </div>
        <div class="field">
          <label>Costume</label>
          <div class="field-val" id="kembali-kostum">Gaun Cinderella</div>
        </div>
        <div class="field-row" style="margin-top: 12px;">
          <div class="field">
            <label>Required Return Date</label>
            <div class="field-val" id="kembali-wajib" style="color: var(--orange); font-weight: bold;">20/04/2026</div>
          </div>
          <div class="field">
            <label>Actual Return Date</label>
            <input type="date" name="tanggal_kembali_aktual" id="kembali-tgl" value="" onchange="hitungKembaliDenda()" required class="form-input" style="background: var(--bg-body); color: var(--text-1); border: 1px solid var(--border); padding: 8px 12px; border-radius: 8px; font-family: inherit; width: 100%; box-sizing: border-box;"/>
          </div>
        </div>
        <div class="field" style="margin-top: 12px;">
          <label style="font-weight: 600;">Costume Condition <span style="color: var(--red);">*</span></label>
          <div class="kondisi-row" style="margin-top: 6px;">
            <button type="button" class="kondisi-btn baik" onclick="selectKondisi('Baik')">Good</button>
            <button type="button" class="kondisi-btn lecet" onclick="selectKondisi('Lecet')">Scuffed</button>
            <button type="button" class="kondisi-btn rusak" onclick="selectKondisi('Rusak')">Damaged</button>
          </div>
          <input type="hidden" name="kondisi_kostum" id="kembali_kondisi_input" required value="Baik">
          <div style="font-size: 11px; color: var(--text-3); margin-top: 6px;">Select the condition of the costume when received back.</div>
        </div>
        
        <!-- Panel: Kembali Lebih Awal (hijau) -->
        <div id="kembali-early" style="display:none; background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.25); border-radius: 10px; padding: 14px 16px; margin-top: 16px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 22px;">✅</span>
            <div>
              <div style="font-weight: 700; color: #10b981; font-size: 13px;">EARLY RETURN</div>
              <div style="font-size: 12px; color: var(--text-2); margin-top: 2px;">Costume returned <strong id="kembali-early-days">0 days</strong> before the required schedule. <strong style="color:#10b981;">No fine.</strong></div>
            </div>
          </div>
        </div>

        <!-- Panel: Tepat Waktu (biru) -->
        <div id="kembali-ontime" style="display:none; background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); border-radius: 10px; padding: 14px 16px; margin-top: 16px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 22px;">🎯</span>
            <div>
              <div style="font-weight: 700; color: var(--blue); font-size: 13px;">ON TIME</div>
              <div style="font-size: 12px; color: var(--text-2); margin-top: 2px;">Costume returned exactly on schedule. <strong style="color:var(--blue);">No fine.</strong></div>
            </div>
          </div>
        </div>

        <!-- Panel: Terlambat (merah) -->
        <div class="kalkulasi" id="kembali-kalk" style="display:none; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 10px; padding: 14px 16px; margin-top: 16px;">
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
            <span style="font-size:18px;">⚠️</span>
            <span style="font-weight:700; color: var(--red); font-size:13px;">LATE RETURN</span>
          </div>
          <div class="kalk-row" style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 13px;">
            <span style="color:var(--text-2);">Days Late</span>
            <span id="kembali-hari" style="color: var(--red); font-weight: 700;">0 DAYS</span>
          </div>
          <div class="kalk-row" style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; color: var(--text-3);">
            <span>Fine per Day</span>
            <span>Rp 50.000</span>
          </div>
          <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(239,68,68,0.2); padding-top: 10px; font-weight: 700; font-size: 15px;">
            <span>ESTIMATED FINE</span>
            <span id="kembali-total" style="color: var(--red);">Rp 0</span>
          </div>
        </div>
        
        <div class="field" style="margin-top: 16px;">
          <label>Admin Notes</label>
          <textarea class="form-textarea" name="catatan_admin" id="kembali_catatan" placeholder="Optional: Description of costume condition upon return, etc..." style="width: 100%; height: 60px; box-sizing: border-box;"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-batal" onclick="closeModal('modalKembali')">CANCEL</button>
        <button type="submit" class="btn-simpan" style="background: var(--blue); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">✓ CONFIRM COSTUME RETURNED TO STORE</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== MODAL LIHAT DETAIL ===== -->
<div class="modal-overlay" id="modalDetail">
  <div class="modal modal-detail" style="max-width: 600px; width: 90%;">
    <div class="modal-header detail-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="detail-header-left" style="display: flex; align-items: center; gap: 12px;">
        <div class="detail-header-icon" style="font-size: 24px;">📋</div>
        <div>
          <span class="modal-title">Costume Return Details</span>
          <div class="detail-subtitle" style="font-size: 11px; color: var(--text-3);">Complete summary of rental transaction</div>
        </div>
      </div>
      <button class="modal-close" onclick="closeModal('modalDetail')">✕</button>
    </div>
    <div class="modal-body" style="max-height: 480px; overflow-y: auto; padding-right: 6px;">

      <!-- SECTION: Info Order & Penyewa -->
      <div class="detail-section" style="margin-bottom: 20px;">
        <div class="detail-section-title" style="font-size: 12px; font-weight: 700; color: var(--text-2); text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 4px;">📌 Order Information</div>
        <div class="field-row" style="display: flex; gap: 16px; margin-bottom: 10px;">
          <div class="field" style="flex: 1;">
            <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Order ID</label>
            <div class="field-val highlight" id="detail-order-id" style="font-weight: 700; color: var(--blue); font-size: 15px;">#TRX-000</div>
          </div>
          <div class="field" style="flex: 1;">
            <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Transaction Status</label>
            <div id="detail-status-badge"></div>
          </div>
        </div>
        <div class="field-row" style="display: flex; gap: 16px;">
          <div class="field" style="flex: 1;">
            <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Tenant Name</label>
            <div class="field-val" id="detail-penyewa" style="font-size: 13px; font-weight: 600; color: var(--text-1);">Pelanggan</div>
          </div>
          <div class="field" style="flex: 1;">
            <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Rented Costume</label>
            <div class="field-val" id="detail-kostum" style="font-size: 13px; font-weight: 600; color: var(--text-1); white-space: normal; word-break: break-word;">Kostum</div>
          </div>
        </div>
      </div>

      <!-- SECTION: Timeline Sewa -->
      <div class="detail-section" style="margin-bottom: 20px;">
        <div class="detail-section-title" style="font-size: 12px; font-weight: 700; color: var(--text-2); text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 4px;">📅 Rental Timeline</div>
        <div class="timeline-grid" style="display: grid; grid-template-columns: 1fr auto 1fr auto 1fr; align-items: center; gap: 8px;">
          <div class="timeline-item" style="text-align: center;">
            <div class="timeline-label" style="font-size: 10px; color: var(--text-3); text-transform: uppercase;">Start Rent</div>
            <div class="timeline-val" id="detail-tgl-mulai" style="font-size: 12px; font-weight: 600; color: var(--text-1); margin-top: 4px;">15/04/2026</div>
          </div>
          <div class="timeline-connector" style="height: 1px; background: var(--border); width: 20px;"></div>
          <div class="timeline-item" style="text-align: center;">
            <div class="timeline-label" style="font-size: 10px; color: var(--text-3); text-transform: uppercase;">Required Return</div>
            <div class="timeline-val warn" id="detail-tgl-wajib" style="font-size: 12px; font-weight: 600; color: var(--orange); margin-top: 4px;">18/04/2026</div>
          </div>
          <div class="timeline-connector" style="height: 1px; background: var(--border); width: 20px;"></div>
          <div class="timeline-item" style="text-align: center;">
            <div class="timeline-label" style="font-size: 10px; color: var(--text-3); text-transform: uppercase;">Actual Return</div>
            <div class="timeline-val" id="detail-tgl-aktual" style="font-size: 12px; font-weight: 600; color: var(--blue); margin-top: 4px;">18/04/2026</div>
          </div>
        </div>
      </div>

      <!-- SECTION: Kondisi & Denda -->
      <div class="detail-section" style="margin-bottom: 20px;">
        <div class="detail-section-title" style="font-size: 12px; font-weight: 700; color: var(--text-2); text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 4px;">🎭 Condition &amp; Cost</div>
        <div class="field-row" style="display: flex; gap: 16px; margin-bottom: 12px;">
          <div class="field" style="flex: 1;">
            <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Condition Upon Return</label>
            <div id="detail-kondisi-badge" style="display: inline-block; margin-top: 4px;">BAIK</div>
          </div>
          <div class="field" style="flex: 1;">
            <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Delay</label>
            <div class="field-val" id="detail-terlambat" style="font-size: 13px; font-weight: 700; color: var(--text-1); margin-top: 4px;">Tepat Waktu</div>
          </div>
        </div>
        <div class="detail-biaya-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 10px;">
          <div class="biaya-card" style="background: var(--bg-body); padding: 10px; border-radius: 8px; border: 1px solid var(--border); text-align: center;">
            <div class="biaya-label" style="font-size: 10px; color: var(--text-3); text-transform: uppercase;">Rental Cost</div>
            <div class="biaya-val" id="detail-biaya-sewa" style="font-size: 14px; font-weight: 700; color: var(--text-1); margin-top: 4px; font-family: 'JetBrains Mono', monospace;">Rp 0</div>
          </div>
          <div class="biaya-card denda" style="background: var(--bg-body); padding: 10px; border-radius: 8px; border: 1px solid var(--border); text-align: center;">
            <div class="biaya-label" style="font-size: 10px; color: var(--text-3); text-transform: uppercase;">Total Fine</div>
            <div class="biaya-val denda" id="detail-denda" style="font-size: 14px; font-weight: 700; color: var(--red); margin-top: 4px; font-family: 'JetBrains Mono', monospace;">Rp 0</div>
          </div>
          <div class="biaya-card total" style="background: rgba(59,130,246,0.06); padding: 10px; border-radius: 8px; border: 1px solid rgba(59,130,246,0.15); text-align: center;">
            <div class="biaya-label" style="font-size: 10px; color: var(--text-3); text-transform: uppercase;">Total Cost</div>
            <div class="biaya-val total" id="detail-total" style="font-size: 14px; font-weight: 700; color: var(--blue); margin-top: 4px; font-family: 'JetBrains Mono', monospace;">Rp 0</div>
          </div>
        </div>
      </div>

      <!-- SECTION: Status Pembayaran -->
      <div class="detail-section">
        <div class="detail-section-title" style="font-size: 12px; font-weight: 700; color: var(--text-2); text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 4px;">💳 Additional Information</div>
        <div class="field">
          <label style="font-size: 11px; color: var(--text-3); text-transform: uppercase;">Admin Notes</label>
          <div class="field-val" id="detail-catatan-admin" style="font-size: 13px; color: var(--text-2); font-style: italic; background: var(--bg-body); padding: 10px; border-radius: 8px; border: 1px solid var(--border); margin-top: 4px; min-height: 40px; white-space: pre-line;">
            No notes.
          </div>
        </div>
      </div>

    </div>
    <div class="modal-footer" style="justify-content: flex-end;">
      <button class="btn btn-ghost" onclick="closeModal('modalDetail')">CLOSE</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let currentTransaksi = null;

  window.selectKondisi = function(val) {
      document.getElementById('kembali_kondisi_input').value = val;
      const buttons = document.querySelectorAll('.kondisi-btn');
      buttons.forEach(btn => {
          btn.classList.remove('selected');
          if (btn.classList.contains(val.toLowerCase())) {
              btn.classList.add('selected');
          }
      });
  }

  window.openKembaliFormModal = function(transaksi, kostumDesc) {
      currentTransaksi = transaksi;
      const modal = document.getElementById('modalKembali');
      const form = modal.querySelector('form');
      form.action = `/admin/pengembalian/${transaksi.id}/kembali`;

      document.getElementById('kembali-order-id').textContent = '#TRX-' + transaksi.id;
      document.getElementById('kembali-penyewa').textContent = transaksi.user ? transaksi.user.nama : 'Pelanggan';
      document.getElementById('kembali-kostum').textContent = kostumDesc;

      const tSelesai = new Date(transaksi.tanggal_selesai);
      document.getElementById('kembali-wajib').textContent = tSelesai.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

      // Set tanggal kembali default = hari ini
      const todayStr = new Date().toISOString().split('T')[0];
      document.getElementById('kembali-tgl').value = todayStr;

      // Reset kondisi ke 'Baik'
      selectKondisi('Baik');
      document.getElementById('kembali_catatan').value = '';

      // Sembunyikan semua panel info
      document.getElementById('kembali-early').style.display  = 'none';
      document.getElementById('kembali-ontime').style.display = 'none';
      document.getElementById('kembali-kalk').style.display   = 'none';

      hitungKembaliDenda();
      modal.classList.add('open');

      // Fokus ke tanggal input
      setTimeout(() => {
          const tglInput = document.getElementById('kembali-tgl');
          if (tglInput) tglInput.focus();
      }, 200);
  }

  window.hitungKembaliDenda = function() {
      if (!currentTransaksi) return;

      const tSelesai = new Date(currentTransaksi.tanggal_selesai);
      tSelesai.setHours(0,0,0,0);

      const tKembaliVal = document.getElementById('kembali-tgl').value;
      if (!tKembaliVal) return;

      const tKembali = new Date(tKembaliVal);
      tKembali.setHours(0,0,0,0);

      const panelEarly  = document.getElementById('kembali-early');
      const panelOntime = document.getElementById('kembali-ontime');
      const panelLate   = document.getElementById('kembali-kalk');

      const diffMs   = tKembali - tSelesai;
      const diffDays = Math.round(diffMs / (1000 * 60 * 60 * 24));

      // Sembunyikan semua panel dulu
      panelEarly.style.display  = 'none';
      panelOntime.style.display = 'none';
      panelLate.style.display   = 'none';

      if (diffDays < 0) {
          // Kembali lebih awal
          document.getElementById('kembali-early-days').textContent = Math.abs(diffDays) + ' hari';
          panelEarly.style.display = 'block';
      } else if (diffDays === 0) {
          // Tepat waktu
          panelOntime.style.display = 'block';
      } else {
          // Terlambat
          document.getElementById('kembali-hari').textContent = diffDays + ' HARI';
          const dendaVal = diffDays * 50000;
          document.getElementById('kembali-total').textContent =
              new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(dendaVal);
          panelLate.style.display = 'block';
      }
  }

  window.openDetailFormModal = function(transaksi, kostumDesc, isTerlambat, hariTerlambat) {
      document.getElementById('detail-order-id').textContent = '#TRX-' + transaksi.id;
      document.getElementById('detail-penyewa').textContent = transaksi.user ? transaksi.user.nama : 'Pelanggan';
      document.getElementById('detail-kostum').textContent = kostumDesc;
      
      const options = { day: 'numeric', month: 'short', year: 'numeric' };
      
      const tMulai = new Date(transaksi.tanggal_mulai);
      document.getElementById('detail-tgl-mulai').textContent = tMulai.toLocaleDateString('id-ID', options);
      
      const tWajib = new Date(transaksi.tanggal_selesai);
      document.getElementById('detail-tgl-wajib').textContent = tWajib.toLocaleDateString('id-ID', options);
      
      const pengembalian = transaksi.pengembalian || {};
      const tanggalAktual = pengembalian.tanggal_kembali_aktual || transaksi.tanggal_kembali_aktual;
      const kondisi = pengembalian.kondisi_barang || transaksi.kondisi_kostum;
      const totalDenda = Number((pengembalian.total_denda != null ? pengembalian.total_denda : transaksi.total_denda) || 0);
      const catatanQc = pengembalian.catatan_qc || transaksi.catatan_admin;
      const tAktual = tanggalAktual ? new Date(tanggalAktual) : null;
      document.getElementById('detail-tgl-aktual').textContent = tAktual ? tAktual.toLocaleDateString('id-ID', options) : 'Belum Kembali';
      
      // Status & Kondisi badges
      const statusBadge = document.getElementById('detail-status-badge');
      if (transaksi.status === 'Selesai') {
          statusBadge.innerHTML = '<span class="badge-status tepat"><span class="bico">✅</span>SELESAI</span>';
      } else {
          statusBadge.innerHTML = '<span class="badge-status belum"><span class="bico">🟡</span>BELUM KEMBALI</span>';
      }
      
      const kondisiBadge = document.getElementById('detail-kondisi-badge');
      kondisiBadge.className = 'kondisi-display';
      if (kondisi) {
          const kLower = kondisi.toLowerCase();
          kondisiBadge.classList.add(kLower);
          kondisiBadge.textContent = kondisi.toUpperCase();
          kondisiBadge.style.display = 'inline-block';
      } else {
          kondisiBadge.style.display = 'none';
      }
      
      // Terlambat text
      const terlambatVal = document.getElementById('detail-terlambat');
      if (isTerlambat || (totalDenda > 0)) {
          terlambatVal.textContent = `Terlambat ${hariTerlambat || Math.ceil(totalDenda / 50000)} Hari`;
          terlambatVal.style.color = 'var(--red)';
      } else {
          terlambatVal.textContent = 'Tepat Waktu';
          terlambatVal.style.color = 'var(--green)';
      }
      
      // Biaya
      const fmt = (v) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(v);
      document.getElementById('detail-biaya-sewa').textContent = fmt(transaksi.total_biaya);
      document.getElementById('detail-denda').textContent = fmt(totalDenda);
      document.getElementById('detail-total').textContent = fmt(Number(transaksi.total_biaya) + totalDenda);
      
      // Notes
      document.getElementById('detail-catatan-admin').textContent = catatanQc || 'Tidak ada catatan admin.';
      
      const modal = document.getElementById('modalDetail');
      modal.classList.add('open');
  }

  window.closeModal = function(id) {
      document.getElementById(id).classList.remove('open');
  }
</script>
@endpush
