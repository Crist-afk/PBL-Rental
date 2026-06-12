@extends('layouts.admin')

@section('title', 'CosRent — Payment Validation')

@push('styles')
    @vite(['resources/css/admin/pembayaran.css', 'resources/js/admin/pembayaran.js'])
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
  <!-- ── MAIN ── -->
  <main class="main" style="padding-top: 24px;">

    <!-- FLASH MESSAGES -->
    @if(session('success'))
      <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 500; animation: fadeIn 0.4s;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 500; animation: fadeIn 0.4s;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    <h1 class="page-title">Payment Validation</h1>
    <p class="page-sub">Confirm transfer receipts from new customers</p>

    <!-- STAT CARDS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">⏳</span><span class="stat-lbl">Waiting for Validation</span></div>
        <div class="stat-val amber">{{ $stats['menunggu'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">✅</span><span class="stat-lbl">Rented (Active)</span></div>
        <div class="stat-val green2">{{ $stats['dikonfirmasi'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">🚫</span><span class="stat-lbl">Cancelled / Rejected</span></div>
        <div class="stat-val red">{{ $stats['ditolak'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">💵</span><span class="stat-lbl">Estimated Revenue Today</span></div>
        <div class="stat-subval">Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}</div>
      </div>
    </div>

    <!-- TABS -->
    <div class="tabs">
      <a href="{{ route('admin.pembayaran', ['status' => 'semua', 'q' => request('q')]) }}" class="tab {{ $filter === 'semua' ? 'active' : '' }}" style="text-decoration: none;">All</a>
      <a href="{{ route('admin.pembayaran', ['status' => 'menunggu', 'q' => request('q')]) }}" class="tab {{ $filter === 'menunggu' ? 'active' : '' }}" style="text-decoration: none; display: flex; align-items: center; gap: 6px;">
        Waiting for Confirmation 
        @if($stats['menunggu'] > 0)
          <span class="tab-badge" style="background: var(--orange); color: white;">{{ $stats['menunggu'] }}</span>
        @endif
      </a>
      <a href="{{ route('admin.pembayaran', ['status' => 'dikonfirmasi', 'q' => request('q')]) }}" class="tab {{ $filter === 'dikonfirmasi' ? 'active' : '' }}" style="text-decoration: none;">Confirmed (Rented)</a>
      <a href="{{ route('admin.pembayaran', ['status' => 'ditolak', 'q' => request('q')]) }}" class="tab {{ $filter === 'ditolak' ? 'active' : '' }}" style="text-decoration: none;">Rejected (Cancelled)</a>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
      <form action="{{ route('admin.pembayaran') }}" method="GET" style="display: flex; flex: 1; align-items: center; gap: 12px;">
        <input type="hidden" name="status" value="{{ $filter }}">
        <div class="search-wrap" style="width: 100%;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input class="search-input" type="text" name="q" value="{{ request('q') }}" placeholder="Search customer name or order ID..."/>
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
            <th>RENTED<br>COSTUME</th>
            <th>RENTAL<br>DATE</th>
            <th>DURATION</th>
            <th>TOTAL<br>PAYMENT</th>
            <th>TRANSFER<br>RECEIPT</th>
            <th>STATUS</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transaksis as $t)
            @php
              $custName = $t->user?->nama ?? 'Customer';
              $firstLetter = strtoupper(substr($custName, 0, 1));
              
              // Get costum description
              $kostumNames = [];
              foreach($t->detailTransaksi as $dt) {
                  if($dt->kostum) {
                      $kostumNames[] = $dt->kostum->nama_kostum . ' (' . $dt->ukuran . ')';
                  }
              }
              $kostumDesc = count($kostumNames) > 0 ? implode(', ', $kostumNames) : 'N/A';
              
              $durasi = $t->tanggal_mulai && $t->tanggal_selesai 
                  ? $t->tanggal_mulai->diffInDays($t->tanggal_selesai) . ' days'
                  : 'N/A';
              
              // Colors for avatar
              $colors = ['#2563eb', '#7c3aed', '#0f766e', '#b45309', '#dc2626', '#0891b2', '#db2777'];
              $avColor = $colors[$t->user_id % count($colors)];
            @endphp
            <tr>
              <td><span class="order-id-stacked">#TRX-<br>{{ $t->id }}</span></td>
              <td>
                <div class="cust-wrap">
                  <div class="cust-av" style="background:{{ $avColor }}">
                    @if($t->user?->avatar)
                      <img src="{{ asset('storage/' . $t->user->avatar) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    @else
                      {{ $firstLetter }}
                    @endif
                  </div>
                  <div>
                    <span class="cust-name" style="font-weight: 600;">{{ $custName }}</span><br>
                    <span style="font-size: 11px; color: var(--text-3);">{{ $t->user?->no_hp ?? '-' }}</span>
                  </div>
                </div>
              </td>
              <td><span class="kostum-name" title="{{ $kostumDesc }}">{{ \Illuminate\Support\Str::limit($kostumDesc, 30) }}</span></td>
              <td>
                <span class="date-stacked">
                  <span class="date-day">{{ $t->tanggal_mulai?->format('d M') }}</span><br>
                  <span class="date-year">{{ $t->tanggal_mulai?->format('Y') }}</span>
                </span>
              </td>
              <td><span class="durasi-text">{{ $durasi }}</span></td>
              <td>
                <div class="payment-wrap">
                  <span class="payment-rp">Rp</span>
                  <span class="payment-val">{{ number_format($t->total_biaya, 0, ',', '.') }}</span>
                </div>
              </td>
              <td>
                @if($t->bukti_pembayaran)
                  <button class="btn-bukti" onclick="openValidationModal({{ json_encode($t) }}, '{{ $kostumDesc }}', '{{ $durasi }}')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    View Receipt
                  </button>
                @else
                  <span style="color: var(--text-3); font-size: 12px; font-style: italic;">Not Uploaded</span>
                @endif
              </td>
              <td>
                @if($t->status === 'Menunggu Pembayaran')
                  <span class="status-badge waiting">
                    <span class="status-dot"></span> WAITING
                  </span>
                @elseif($t->status === 'Disewa')
                  <span class="status-badge confirmed">
                    <span class="status-dot"></span> RENTED
                  </span>
                @elseif($t->status === 'Selesai')
                  <span class="status-badge confirmed" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                    <span class="status-dot" style="background: #10b981;"></span> COMPLETED
                  </span>
                @else
                  <span class="status-badge rejected">
                    <span class="status-dot"></span> CANCELLED
                  </span>
                @endif
              </td>
              <td>
                <div class="act-btns">
                  @if($t->status === 'Menunggu Pembayaran')
                    <button class="btn-approve" onclick="openValidationModal({{ json_encode($t) }}, '{{ $kostumDesc }}', '{{ $durasi }}')">🟢 Validate</button>
                  @else
                    <button class="btn-det" onclick="openValidationModal({{ json_encode($t) }}, '{{ $kostumDesc }}', '{{ $durasi }}')">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                      DETAILS
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" style="text-align: center; padding: 48px; color: var(--text-3); font-weight: 500;">
                No payment orders found in this category.
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

  </main>

@push('modals')
<!-- ── DETAIL & VALIDATION MODAL ── -->
<div class="modal-overlay" id="validationModalOverlay">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-order-id" id="mOrderId">#TRX-000</div>
        <div class="modal-sub">Payment validation for: <span id="mCustName">Customer</span></div>
      </div>
      <div class="modal-close" onclick="closeValidationModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:20px;height:20px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </div>
    </div>

    <div class="modal-body">
      <!-- LEFT COLUMN -->
      <div style="display: flex; flex-direction: column; gap: 0;">

        <div class="modal-section-title" style="margin-top:0;">ORDER SUMMARY</div>
        <div class="order-item-card" style="display: flex; align-items: flex-start; gap: 14px;">
          <div id="mItemIcon" style="font-size:24px; display:flex; align-items:center; justify-content:center; width:48px; height:48px; background:rgba(59,130,246,0.12); border-radius:10px; flex-shrink:0;">🎭</div>
          <div style="flex:1; min-width:0;">
            <div id="mKostum" style="font-weight:700; font-size:14px; color:#1f2937; word-break:break-word;">Cosplay Costume</div>
            <div id="mDate" style="font-size:12px; color:#6b7280; margin-top:4px; font-family:'JetBrains Mono',monospace;">20 Apr 2026 (3 days)</div>
          </div>
        </div>

        <div style="margin-top:14px; padding:14px 16px; background:var(--bg-body); border-radius:10px; border:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
          <span style="font-size:13px; font-weight:600; color:var(--text-2);">Total Bill</span>
          <span id="mTotal" style="font-size:18px; font-weight:800; color:var(--text-1); font-family:'JetBrains Mono',monospace;">Rp 0</span>
        </div>

        <div class="modal-section-title" style="margin-top:24px;">TRANSFER DETAILS</div>
        <div style="background:#fff; border-radius:10px; padding:14px 16px; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
          <div style="font-size:10px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#9ca3af; margin-bottom:6px;">PAYMENT METHOD &amp; AMOUNT</div>
          <div style="font-size:14px; font-weight:600; color:#1f2937;">Bank Transfer / Receipt Attached</div>
        </div>

        <!-- ADMIN NOTES (editable — only shown when pending) -->
        <div id="validationFormContainer" style="margin-top:20px;">
          <form action="" method="POST" id="confirmPaymentForm">
            @csrf
            <div class="modal-section-title" style="margin-top:0;">ADMIN NOTES</div>
            <textarea class="form-textarea" name="catatan_admin" id="mCatatanAdmin"
              placeholder="Add notes if necessary (e.g., Transfer amount matches)..."
              style="width:100%; min-height:80px; resize:vertical;"></textarea>
          </form>
        </div>

        <!-- READ-ONLY NOTES (shown when already processed) -->
        <div id="readOnlyNotesContainer" style="margin-top:20px; display:none;">
          <div class="modal-section-title" style="margin-top:0;">ADMIN NOTES (SAVED)</div>
          <div id="mSavedCatatanAdmin" style="font-size:13px; color:var(--text-2); background:var(--bg-body); padding:12px 14px; border-radius:10px; border:1px solid var(--border); min-height:50px;">-</div>
        </div>
      </div>

      <!-- RIGHT COLUMN -->
      <div style="display:flex; flex-direction:column; gap:14px;">
        <div class="modal-section-title" style="margin-top:0;">CUSTOMER TRANSFER RECEIPT</div>
        <div style="background:var(--bg-body); border-radius:12px; border:1px dashed var(--border); min-height:260px; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative;">
          <img src="" id="mBuktiImg" style="max-width:100%; max-height:320px; object-fit:contain; display:none;">
          <div id="mNoBuktiText" style="text-align:center; color:var(--text-3); font-size:13px; padding:24px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:44px; height:44px; margin-bottom:8px; opacity:0.4;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg><br>
            Transfer receipt unavailable
          </div>
        </div>
        <a href="" id="mFullResLink" target="_blank" class="btn-resolusi" style="display:none; text-decoration:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          View Full Resolution
        </a>
      </div>
    </div>

    <!-- FOOTER: shows Approve+Reject when pending, Close-only otherwise -->
    <div class="modal-footer" id="validationModalFooter">
      <button type="button" class="btn btn-ghost" onclick="closeValidationModal()">Close</button>
      <button type="button" id="mBtnReject" class="btn" style="display:none; background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.3); color:#f87171; font-weight:700; padding:10px 22px; border-radius:10px; cursor:pointer;"
        onclick="document.getElementById('mCatatanAdmin').form && (document.getElementById('confirmPaymentForm').action = window._rejectUrl); document.getElementById('confirmPaymentForm').submit();">
        🔴 Reject / Cancel
      </button>
      <button type="button" id="mBtnApprove" class="btn btn-primary" style="display:none; background:linear-gradient(135deg,#10b981,#059669); border-color:#059669; padding:10px 22px; font-weight:700; border-radius:10px;"
        onclick="document.getElementById('confirmPaymentForm').action = window._approveUrl; document.getElementById('confirmPaymentForm').submit();">
        🟢 Approve &amp; Rent
      </button>
    </div>
  </div>
</div>
@endpush
@endsection

@push('scripts')
<script>
  window.openValidationModal = function(transaksi, kostumDesc, durasi) {
      const modal = document.getElementById('validationModalOverlay');
      
      document.getElementById('mOrderId').textContent = '#TRX-' + transaksi.id;
      document.getElementById('mCustName').textContent = transaksi.user ? transaksi.user.nama : 'Customer';
      document.getElementById('mKostum').textContent = kostumDesc;
      
      // Date formatting
      const tMulai = new Date(transaksi.tanggal_mulai);
      const tSelesai = new Date(transaksi.tanggal_selesai);
      const options = { day: 'numeric', month: 'short', year: 'numeric' };
      const formattedDateRange = tMulai.toLocaleDateString('en-US', options) + ' - ' + tSelesai.toLocaleDateString('en-US', options) + ' (' + durasi + ')';
      document.getElementById('mDate').textContent = formattedDateRange;
      
      // Total formatting
      const totalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(transaksi.total_biaya);
      document.getElementById('mTotal').textContent = totalFormatted;
      
      // Bukti Transfer
      const buktiImg = document.getElementById('mBuktiImg');
      const noBuktiText = document.getElementById('mNoBuktiText');
      const fullResLink = document.getElementById('mFullResLink');
      
      if (transaksi.bukti_pembayaran) {
          let imgUrl = '';
          if (transaksi.bukti_pembayaran.startsWith('http://') || transaksi.bukti_pembayaran.startsWith('https://')) {
              imgUrl = transaksi.bukti_pembayaran;
          } else {
              imgUrl = '/storage/' + transaksi.bukti_pembayaran;
          }
          
          buktiImg.src = imgUrl;
          buktiImg.style.display = 'block';
          noBuktiText.style.display = 'none';
          
          fullResLink.href = imgUrl;
          fullResLink.style.display = 'flex';
      } else {
          buktiImg.style.display = 'none';
          noBuktiText.style.display = 'block';
          fullResLink.style.display = 'none';
      }
      
      // Buttons in footer
      const btnApprove = document.getElementById('mBtnApprove');
      const btnReject  = document.getElementById('mBtnReject');
      const formContainer      = document.getElementById('validationFormContainer');
      const readOnlyContainer  = document.getElementById('readOnlyNotesContainer');
      
      if (transaksi.status === 'Menunggu Pembayaran') {
          formContainer.style.display    = 'block';
          readOnlyContainer.style.display = 'none';
          document.getElementById('mCatatanAdmin').value = transaksi.catatan_admin || '';
          // Store URLs globally so footer buttons can access them
          window._approveUrl = `/admin/pembayaran/${transaksi.id}/setujui`;
          window._rejectUrl  = `/admin/pembayaran/${transaksi.id}/tolak`;
          btnApprove.style.display = 'inline-flex';
          btnReject.style.display  = 'inline-flex';
      } else {
          formContainer.style.display    = 'none';
          readOnlyContainer.style.display = 'block';
          document.getElementById('mSavedCatatanAdmin').textContent = transaksi.catatan_admin || 'No admin notes.';
          btnApprove.style.display = 'none';
          btnReject.style.display  = 'none';
      }
      
      modal.classList.add('show');
  }
  
  window.closeValidationModal = function() {
      document.getElementById('validationModalOverlay').classList.remove('show');
  }
  
  // Close overlay on click outside
  document.getElementById('validationModalOverlay').addEventListener('click', function(e) {
      if (e.target === this) closeValidationModal();
  });
</script>
@endpush
