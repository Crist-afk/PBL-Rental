@extends('layouts.admin')

@section('title', 'CosRent — Payment Validation')

@push('styles')
    @vite(['resources/css/admin/pembayaran.css', 'resources/js/admin/pembayaran.js'])
@endpush

@section('content')
  <main class="main" style="padding-top: 24px;">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
      <div style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);color:#10b981;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-weight:500;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
      </div>
    @endif
    @if(session('error'))
      <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#ef4444;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-weight:500;">
        <span style="font-size:18px;">⚠️</span>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    @if ($errors->any())
      <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#ef4444;padding:12px 16px;border-radius:8px;margin-bottom:20px;display:flex;flex-direction:column;gap:5px;font-weight:500;">
        <div style="display:flex;align-items:center;gap:10px;"><span style="font-size:18px;">⚠️</span> <strong>Errors occurred:</strong></div>
        <ul style="padding-left: 20px;">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
      </div>
    @endif

    <h1 class="page-title">Payment Validation</h1>
    <p class="page-sub">Verify bank transfer receipts and confirm customer costume pickups</p>

    {{-- STAT CARDS --}}
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">🔴</span><span class="stat-lbl">No Proof Uploaded</span></div>
        <div class="stat-val red">{{ $stats['belum_upload'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">⏳</span><span class="stat-lbl">Awaiting Verification</span></div>
        <div class="stat-val amber">{{ $stats['menunggu_verifikasi'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">✅</span><span class="stat-lbl">Paid (Not Picked Up)</span></div>
        <div class="stat-val green2">{{ $stats['sudah_dibayar'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">🎭</span><span class="stat-lbl">Rental Active</span></div>
        <div class="stat-val" style="color:var(--blue);">{{ $stats['disewa'] }}</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon-label"><span class="stat-icon">🚫</span><span class="stat-lbl">Proof Rejected</span></div>
        <div class="stat-val" style="color:#f43f5e;">{{ $stats['ditolak'] }}</div>
      </div>
    </div>

    {{-- TABS --}}
    <div class="tabs">
      <a href="{{ route('admin.pembayaran', ['status'=>'semua','q'=>request('q')]) }}" class="tab {{ $filter==='semua'?'active':'' }}" style="text-decoration:none;">All</a>
      <a href="{{ route('admin.pembayaran', ['status'=>'belum_upload','q'=>request('q')]) }}" class="tab {{ $filter==='belum_upload'?'active':'' }}" style="text-decoration:none;">
        🔴 No Proof
        @if($stats['belum_upload']>0)<span class="tab-badge">{{ $stats['belum_upload'] }}</span>@endif
      </a>
      <a href="{{ route('admin.pembayaran', ['status'=>'menunggu_verifikasi','q'=>request('q')]) }}" class="tab {{ $filter==='menunggu_verifikasi'?'active':'' }}" style="text-decoration:none;">
        ⏳ Awaiting Verification
        @if($stats['menunggu_verifikasi']>0)<span class="tab-badge">{{ $stats['menunggu_verifikasi'] }}</span>@endif
      </a>
      <a href="{{ route('admin.pembayaran', ['status'=>'sudah_dibayar','q'=>request('q')]) }}" class="tab {{ $filter==='sudah_dibayar'?'active':'' }}" style="text-decoration:none;">
        ✅ Payment Confirmed
        @if($stats['sudah_dibayar']>0)<span class="tab-badge">{{ $stats['sudah_dibayar'] }}</span>@endif
      </a>
      <a href="{{ route('admin.pembayaran', ['status'=>'disewa','q'=>request('q')]) }}" class="tab {{ $filter==='disewa'?'active':'' }}" style="text-decoration:none;">
        🎭 Rental Active
        @if($stats['disewa']>0)<span class="tab-badge">{{ $stats['disewa'] }}</span>@endif
      </a>
      <a href="{{ route('admin.pembayaran', ['status'=>'ditolak','q'=>request('q')]) }}" class="tab {{ $filter==='ditolak'?'active':'' }}" style="text-decoration:none;">
        🚫 Proof Rejected
        @if($stats['ditolak']>0)<span class="tab-badge">{{ $stats['ditolak'] }}</span>@endif
      </a>
    </div>

    {{-- TOOLBAR --}}
    <div class="toolbar">
      <form action="{{ route('admin.pembayaran') }}" method="GET" style="display:flex;flex:1;align-items:center;gap:12px;">
        <input type="hidden" name="status" value="{{ $filter }}">
        <div class="search-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input class="search-input" type="text" name="q" value="{{ request('q') }}" placeholder="Search customer name or order ID..."/>
        </div>
      </form>
    </div>

    {{-- TABLE --}}
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:80px;">ORDER<br>ID</th>
            <th style="width:180px;">CUSTOMER</th>
            <th style="width:200px;">RENTED<br>COSTUME</th>
            <th style="width:100px;">RENTAL<br>DATE</th>
            <th style="width:90px;">DURATION</th>
            <th style="width:120px;">TOTAL<br>BILL</th>
            <th style="width:110px;text-align:center;">TRANSFER<br>RECEIPT</th>
            <th style="width:150px;">STATUS</th>
            <th style="width:140px;">ACTION</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transaksis as $t)
            @php
              $custName    = $t->user?->nama ?? 'Customer';
              $firstLetter = strtoupper(substr($custName, 0, 1));
              $kostumNames = [];
              foreach($t->detailTransaksi as $dt) {
                  if($dt->kostum) $kostumNames[] = $dt->kostum->nama_kostum . ' (' . $dt->ukuran . ')';
              }
              $kostumDesc = count($kostumNames) > 0 ? implode(', ', $kostumNames) : 'N/A';
              $durasi     = $t->tanggal_mulai && $t->tanggal_selesai
                  ? $t->tanggal_mulai->diffInDays($t->tanggal_selesai) . ' days'
                  : 'N/A';
              $colors  = ['#2563eb','#7c3aed','#0f766e','#b45309','#dc2626','#0891b2','#db2777'];
              $avColor = $colors[$t->user_id % count($colors)];
            @endphp
            <tr>
              {{-- ORDER ID --}}
              <td>
                <span class="order-id-stacked">#TRX-{{ $t->id }}</span>
              </td>

              {{-- CUSTOMER --}}
              <td>
                <div class="cust-wrap">
                  <div class="cust-av" style="background:{{ $avColor }}">
                    @if($t->user?->avatar)
                      <img src="{{ asset('storage/'.$t->user->avatar) }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                    @else
                      {{ $firstLetter }}
                    @endif
                  </div>
                  <div>
                    <span class="cust-name">{{ $custName }}</span><br>
                    <span style="font-size:11px;color:var(--text-3);">{{ $t->user?->no_hp ?? '-' }}</span>
                  </div>
                </div>
              </td>

              {{-- COSTUME --}}
              <td>
                <span class="kostum-name" title="{{ $kostumDesc }}">{{ \Illuminate\Support\Str::limit($kostumDesc, 35) }}</span>
              </td>

              {{-- RENTAL DATE --}}
              <td>
                <span class="date-stacked">
                  <span class="date-day">{{ $t->tanggal_mulai?->format('d M') }}</span><br>
                  <span class="date-year">{{ $t->tanggal_mulai?->format('Y') }}</span>
                </span>
              </td>

              {{-- DURATION --}}
              <td>
                <span class="durasi-text">{{ $durasi }}</span>
              </td>

              {{-- TOTAL BILL --}}
              <td>
                <div class="payment-wrap">
                  <span class="payment-rp">Rp</span>
                  <span class="payment-val">{{ number_format($t->total_biaya, 0, ',', '.') }}</span>
                </div>
              </td>

              {{-- TRANSFER RECEIPT --}}
              <td style="text-align:center;">
                @if($t->bukti_pembayaran)
                  <button class="btn-bukti" onclick="openValidationModal({{ json_encode($t) }}, {{ json_encode($kostumDesc) }}, {{ json_encode($durasi) }})">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    View Proof
                  </button>
                @else
                  <span style="color:var(--red);font-size:11px;font-weight:700;white-space:nowrap;">⚠ Not Uploaded</span>
                @endif
              </td>

              {{-- STATUS --}}
              <td style="white-space:nowrap;">
                @if($t->status === 'Menunggu Pembayaran')
                  <span class="status-badge" style="background:rgba(239,68,68,0.1);color:#ef4444;border:1.5px solid rgba(239,68,68,0.25);border-radius:99px;padding:5px 12px;font-size:10px;font-weight:800;letter-spacing:0.5px;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                    <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> NOT UPLOADED
                  </span>
                @elseif($t->status === 'Menunggu Verifikasi')
                  <span class="status-badge waiting" style="display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                    <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> AWAITING VERIFICATION
                  </span>
                @elseif($t->status === 'Sudah Dibayar')
                  <div>
                    <span class="status-badge confirmed" style="display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                      <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> PAYMENT CONFIRMED
                    </span>
                    <div style="margin-top:5px;">
                      <span style="display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:#f59e0b;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);border-radius:99px;padding:3px 9px;white-space:nowrap;">🟡 Not Picked Up</span>
                    </div>
                  </div>
                @elseif($t->status === 'Disewa')
                  <div>
                    <span class="status-badge" style="background:rgba(59,130,246,0.12);color:#60a5fa;border:1.5px solid rgba(59,130,246,0.25);border-radius:99px;padding:5px 12px;font-size:10px;font-weight:800;letter-spacing:0.5px;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                      <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> RENTAL ACTIVE
                    </span>
                    <div style="margin-top:5px;">
                      <span style="display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:#10b981;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);border-radius:99px;padding:3px 9px;white-space:nowrap;">🟢 Picked Up</span>
                    </div>
                  </div>
                @elseif($t->status === 'Ditolak')
                  <span class="status-badge rejected" style="display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                    <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> PROOF REJECTED
                  </span>
                @elseif($t->status === 'Selesai')
                  <span class="status-badge" style="background:rgba(107,114,128,0.1);color:#9ca3af;border:1.5px solid rgba(107,114,128,0.2);border-radius:99px;padding:5px 12px;font-size:10px;font-weight:800;letter-spacing:0.5px;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                    <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> COMPLETED
                  </span>
                @else
                  <span class="status-badge rejected" style="display:inline-flex;align-items:center;gap:5px;white-space:nowrap;">
                    <span class="status-dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;flex-shrink:0;"></span> CANCELLED
                  </span>
                @endif
              </td>

              {{-- ACTION --}}
              <td>
                <div style="display:flex;flex-direction:column;gap:6px;align-items:flex-start;">
                  {{-- Menunggu Verifikasi: tampilkan Verify --}}
                  @if($t->status === 'Menunggu Verifikasi')
                    <button class="btn-approve" onclick="openValidationModal({{ json_encode($t) }}, {{ json_encode($kostumDesc) }}, {{ json_encode($durasi) }})">
                      🟢 Verify
                    </button>
                  {{-- Sudah Dibayar: tampilkan Konfirmasi Pengambilan --}}
                  @elseif($t->status === 'Sudah Dibayar')
                    @php $tglMulaiStr = $t->tanggal_mulai?->format('d M Y') ?? '-'; @endphp
                    <button class="btn-konfirmasi-ambil" onclick="openKonfirmasiAmbilModal({{ $t->id }}, {{ json_encode($custName) }}, {{ json_encode($kostumDesc) }}, {{ json_encode($tglMulaiStr) }})">
                      🎭 Confirm Pickup
                    </button>
                  {{-- Status lain: View Detail saja --}}
                  @else
                    <button class="btn-det" onclick="openValidationModal({{ json_encode($t) }}, {{ json_encode($kostumDesc) }}, {{ json_encode($durasi) }})">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                      DETAIL
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" style="text-align:center;padding:48px;color:var(--text-3);font-weight:500;">
                No payment orders in this category.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- PAGINATION --}}
    <div class="pagination-bar" style="margin-top:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
      <span style="font-size:13px;color:var(--text-3);font-weight:500;">
        Showing {{ $transaksis->firstItem() ?? 0 }}–{{ $transaksis->lastItem() ?? 0 }} of {{ $transaksis->total() }} orders
      </span>
      <div>{{ $transaksis->links() }}</div>
    </div>

  </main>

@push('modals')
{{-- ── MODAL DETAIL & VALIDASI ── --}}
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
      {{-- LEFT --}}
      <div style="display:flex;flex-direction:column;gap:0;">
        <div class="modal-section-title" style="margin-top:0;">ORDER SUMMARY</div>
        <div class="order-item-card" style="display:flex;align-items:flex-start;gap:14px;">
          <div id="mItemIcon" style="font-size:24px;display:flex;align-items:center;justify-content:center;width:48px;height:48px;background:rgba(59,130,246,0.12);border-radius:10px;flex-shrink:0;">🎭</div>
          <div style="flex:1;min-width:0;">
            <div id="mKostum" style="font-weight:700;font-size:14px;color:#1f2937;word-break:break-word;">Cosplay Costume</div>
            <div id="mDate" style="font-size:12px;color:#6b7280;margin-top:4px;font-family:'JetBrains Mono',monospace;">-</div>
          </div>
        </div>
        <div style="margin-top:14px;padding:14px 16px;background:var(--bg-body);border-radius:10px;border:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
          <span style="font-size:13px;font-weight:600;color:var(--text-2);">Total Bill</span>
          <span id="mTotal" style="font-size:18px;font-weight:800;color:var(--text-1);font-family:'JetBrains Mono',monospace;">Rp 0</span>
        </div>

        {{-- Form catatan admin (hanya saat pending verifikasi) --}}
        <div id="validationFormContainer" style="margin-top:20px;">
          <form action="" method="POST" id="confirmPaymentForm">
            @csrf
            <div class="modal-section-title" style="margin-top:0;">ADMIN NOTES</div>
            <textarea class="form-textarea" name="catatan_admin" id="mCatatanAdmin"
              placeholder="Add a note if needed (e.g., Transfer amount matches)..."
              style="width:100%;min-height:80px;resize:vertical;"></textarea>
          </form>
        </div>

        {{-- Catatan read-only (sudah diproses) --}}
        <div id="readOnlyNotesContainer" style="margin-top:20px;display:none;">
          <div class="modal-section-title" style="margin-top:0;">ADMIN NOTES (SAVED)</div>
          <div id="mSavedCatatanAdmin" style="font-size:13px;color:var(--text-2);background:var(--bg-body);padding:12px 14px;border-radius:10px;border:1px solid var(--border);min-height:50px;">-</div>
        </div>
      </div>

      {{-- RIGHT — Bukti Transfer --}}
      <div style="display:flex;flex-direction:column;gap:14px;">
        <div class="modal-section-title" style="margin-top:0;">CUSTOMER TRANSFER PROOF</div>
        <div style="background:var(--bg-body);border-radius:12px;border:1px dashed var(--border);min-height:260px;display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative;">
          <img src="" id="mBuktiImg" style="max-width:100%;max-height:320px;object-fit:contain;display:none;">
          <div id="mNoBuktiText" style="text-align:center;color:var(--text-3);font-size:13px;padding:24px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:44px;height:44px;margin-bottom:8px;opacity:0.4;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg><br>
            Transfer proof is not available
          </div>
        </div>
        <a href="" id="mFullResLink" target="_blank" class="btn-resolusi" style="display:none;text-decoration:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          View Full Resolution
        </a>
      </div>
    </div>

    {{-- FOOTER --}}
    <div class="modal-footer" id="validationModalFooter">
      <button type="button" class="btn btn-ghost" onclick="closeValidationModal()">Close</button>
      {{-- Reject --}}
      <button type="button" id="mBtnReject" class="btn" style="display:none;background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#f87171;font-weight:700;padding:10px 22px;border-radius:10px;cursor:pointer;"
        onclick="submitRejectWithReason()">
        🔴 Reject Proof
      </button>
      {{-- Approve --}}
      <button type="button" id="mBtnApprove" class="btn btn-primary" style="display:none;background:linear-gradient(135deg,#10b981,#059669);border-color:#059669;padding:10px 22px;font-weight:700;border-radius:10px;"
        onclick="document.getElementById('confirmPaymentForm').action = window._approveUrl; document.getElementById('confirmPaymentForm').submit();">
        🟢 Verify &amp; Approve
      </button>
    </div>
  </div>
</div>

{{-- ── MODAL KONFIRMASI PENGAMBILAN ── --}}
<div class="modal-overlay" id="konfirmasiAmbilOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
  <div class="modal" style="max-width:460px;width:90%;background:var(--bg-card);border-radius:16px;padding:0;overflow-y:auto;max-height:90vh;">
    <div class="modal-header" style="padding:16px 20px 12px;border-bottom:1px solid var(--border);">
      <div>
        <div style="font-size:13px;font-weight:800;color:var(--blue);letter-spacing:0.05em;">CONFIRM PICKUP</div>
        <div style="font-size:12px;color:var(--text-3);margin-top:3px;">Has the customer picked up the costume?</div>
      </div>
      <button onclick="closeKonfirmasiAmbil()" style="background:none;border:none;cursor:pointer;color:var(--text-3);">✕</button>
    </div>
    <div style="padding:16px 20px 20px;">
      <div style="background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.2);border-radius:10px;padding:10px 12px;margin-bottom:12px;">
        <div style="font-size:11px;color:var(--text-3);margin-bottom:2px;font-weight:600;">CUSTOMER</div>
        <div id="ambil-cust" style="font-weight:700;font-size:13px;color:var(--text-1);">-</div>
        <div style="font-size:11px;color:var(--text-3);margin-top:6px;margin-bottom:2px;font-weight:600;">COSTUME</div>
        <div id="ambil-kostum" style="font-weight:600;font-size:12px;color:var(--text-2);">-</div>
        <div style="font-size:11px;color:var(--text-3);margin-top:6px;margin-bottom:2px;font-weight:600;">RENTAL START DATE</div>
        <div id="ambil-tgl" style="font-weight:700;font-size:12px;color:var(--blue);">-</div>
      </div>
      <div style="background:rgba(16,185,129,0.06);border:1px solid rgba(16,185,129,0.2);border-radius:10px;padding:10px 12px;margin-bottom:12px;font-size:12px;color:var(--text-2);line-height:1.4;">
        ✅ Once confirmed, status will change to <strong style="color:#10b981;">Rental Active</strong>.<br>
        The costume is registered as picked up from the store.
      </div>
      <form id="konfirmasiAmbilForm" action="" method="POST">
        @csrf
        <div style="margin-bottom:12px;">
          <label style="font-size:11px;color:var(--text-3);font-weight:600;text-transform:uppercase;">Admin Notes (optional)</label>
          <textarea name="catatan_admin" style="width:100%;margin-top:4px;padding:8px 10px;border-radius:8px;border:1px solid var(--border);background:var(--bg-body);color:var(--text-1);font-family:inherit;font-size:13px;resize:none;height:50px;box-sizing:border-box;" placeholder="e.g., Costume picked up directly by the customer..."></textarea>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px;">
          <button type="button" onclick="closeKonfirmasiAmbil()" style="flex:1;padding:10px;border-radius:8px;background:var(--bg-body);border:1px solid var(--border);color:var(--text-2);font-weight:600;cursor:pointer;font-size:12px;">Cancel</button>
          <button type="submit" class="btn-konfirmasi-ambil" style="flex:2;padding:10px;font-size:12px;">🎭 Yes, Costume Has Been Picked Up</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── MODAL TOLAK BUKTI ── --}}
<div class="modal-overlay" id="tolakBuktiOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
  <div class="modal" style="max-width:440px;width:90%;background:var(--bg-card);border-radius:16px;padding:0;overflow-y:auto;max-height:90vh;">
    <div class="modal-header" style="padding:16px 20px 12px;border-bottom:1px solid var(--border);">
      <div>
        <div style="font-size:13px;font-weight:800;color:#ef4444;letter-spacing:0.05em;">REJECT PAYMENT PROOF</div>
        <div style="font-size:12px;color:var(--text-3);margin-top:3px;">The customer will be asked to re-upload the correct proof</div>
      </div>
      <button onclick="cancelReject()" style="background:none;border:none;cursor:pointer;color:var(--text-3);">✕</button>
    </div>
    <div style="padding:16px 20px 20px;">
      <div style="background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:10px 12px;margin-bottom:12px;font-size:12px;color:var(--text-2);line-height:1.4;">
        ⚠️ The uploaded payment proof is invalid or incorrect.<br>
        Status will return to <strong style="color:#f59e0b;">Awaiting Payment</strong> and the customer can re-upload.
      </div>
      <form id="tolakBuktiForm" action="" method="POST">
        @csrf
        <div style="margin-bottom:12px;">
          <label style="font-size:11px;color:var(--text-3);font-weight:600;text-transform:uppercase;">Rejection Reason <span style="color:#ef4444;">*</span></label>
          <textarea name="catatan_admin" required style="width:100%;margin-top:4px;padding:8px 10px;border-radius:8px;border:1px solid rgba(239,68,68,0.3);background:var(--bg-body);color:var(--text-1);font-family:inherit;font-size:13px;resize:none;height:60px;box-sizing:border-box;" placeholder="e.g., Proof unclear, incorrect amount, invalid image..."></textarea>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px;">
          <button type="button" onclick="cancelReject()" style="flex:1;padding:10px;border-radius:8px;background:var(--bg-body);border:1px solid var(--border);color:var(--text-2);font-weight:600;cursor:pointer;font-size:12px;">Cancel</button>
          <button type="submit" class="btn-tolak-bukti" style="flex:2;padding:10px;font-size:12px;">🔴 Reject &amp; Request Re-upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush
@endsection

@push('scripts')
<script>
  // Konfigurasi URL dasar untuk digunakan oleh pembayaran.js
  window._adminPembayaranBase = '{{ url('/admin/pembayaran') }}';

  // Pasang event listener setelah DOM siap
  document.addEventListener('DOMContentLoaded', function() {
    var validationOverlay = document.getElementById('validationModalOverlay');
    if (validationOverlay) {
      validationOverlay.addEventListener('click', function(e) {
        if (e.target === validationOverlay) window.closeValidationModal && window.closeValidationModal();
      });
    }
    var konfirmasiOverlay = document.getElementById('konfirmasiAmbilOverlay');
    if (konfirmasiOverlay) {
      konfirmasiOverlay.addEventListener('click', function(e) {
        if (e.target === konfirmasiOverlay) window.closeKonfirmasiAmbil && window.closeKonfirmasiAmbil();
      });
    }
    var tolakOverlay = document.getElementById('tolakBuktiOverlay');
    if (tolakOverlay) {
      tolakOverlay.addEventListener('click', function(e) {
        if (e.target === tolakOverlay) {
          if (window.cancelReject) {
            window.cancelReject();
          } else {
            tolakOverlay.style.display = 'none';
          }
        }
      });
    }
  });
</script>
@endpush
