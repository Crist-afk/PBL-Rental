@extends('layouts.admin')

@section('title', 'CosRent — Returns & Penalties')

@push('styles')
    @vite(['resources/css/admin/pengembalian.css', 'resources/js/admin/pengembalian.js'])
@endpush

@section('content')
  <!-- MAIN -->
  <main class="main">
    <div class="main-inner">

      <h1 class="page-title">Record Returns &amp; Penalties</h1>
      <p class="page-subtitle">Monitor return schedules and manage late rentals</p>

      <!-- STAT CARDS -->
      <div class="stats-grid">
        <div class="stat-card">
          <div>
            <div class="stat-label">Due Today</div>
            <div class="stat-value red">7</div>
          </div>
          <div class="stat-icon red">⚠️</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Returned</div>
            <div class="stat-value green">23</div>
          </div>
          <div class="stat-icon green">✅</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Late</div>
            <div class="stat-value orange">4</div>
          </div>
          <div class="stat-icon orange">🕐</div>
        </div>
        <div class="stat-card">
          <div>
            <div class="stat-label">Total Penalties This Month</div>
            <div class="stat-value purple" style="font-size:24px">Rp 850.000</div>
          </div>
          <div class="stat-icon purple">💲</div>
        </div>
      </div>

      <!-- FILTER TABS -->
      <div class="filter-tabs">
        <button class="tab active" onclick="setTab(this)">ALL</button>
        <button class="tab" onclick="setTab(this)">NOT RETURNED</button>
        <button class="tab" onclick="setTab(this)">ON TIME</button>
        <button class="tab" onclick="setTab(this)">LATE</button>
        <button class="tab" onclick="setTab(this)">UNPAID PENALTY</button>
      </div>

      <!-- SEARCH ROW -->
      <div class="search-row">
        <div class="search-wrap">
          <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Search customer name or order ID..."/>
        </div>
        <select class="select-period">
          <option value="hari">Today</option>
          <option value="minggu">This Week</option>
          <option value="bulan">This Month</option>
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
              <th>ORDER<br>ID</th>
              <th>CUSTOMER</th>
              <th>COSTUME</th>
              <th>RENTAL<br>START DATE</th>
              <th>REQUIRED<br>RETURN DATE</th>
              <th>ACTUAL<br>RETURN DATE</th>
              <th>COSTUME<br>CONDITION</th>
              <th>LATENESS</th>
              <th>PENALTY</th>
              <th>STATUS</th>
              <th>ACTIONS</th>
            </tr>
          </thead>
          <tbody>
            <!-- Row 1: On Time -->
            <tr>
              <td><span class="order-id">#ORD-<br>010</span></td>
              <td><strong class="customer-name">Asep<br>Sulaiman</strong></td>
              <td><span class="kostum-cell">Batman</span></td>
              <td><span class="date-normal">15 Apr</span></td>
              <td><span class="date-warn">18 Apr</span></td>
              <td><span class="date-normal">18 Apr</span></td>
              <td><span class="kondisi-display baik" style="font-size:9px;padding:4px 8px;border-radius:6px;">GOOD</span></td>
              <td style="color:#4b5a7a">–</td>
              <td><span class="fine-zero">Rp 0</span></td>
              <td>
                <span class="badge-status tepat">
                  <span class="bico">✅</span>ON<br>TIME
                </span>
              </td>
              <td><button class="btn-action detail" onclick="openModalDetail('ORD-010','Asep Sulaiman','Batman','15/04/2026','18/04/2026','18/04/2026','Tepat Waktu','Baik','Rp 500.000','Rp 0','Lunas')">👁 VIEW DETAILS</button></td>
            </tr>

            <!-- Row 2: Late -->
            <tr>
              <td><span class="order-id">#ORD-<br>011</span></td>
              <td><strong class="customer-name">Budi<br>Santoso</strong></td>
              <td><span class="kostum-cell">Cinderella<br>Dress</span></td>
              <td><span class="date-normal">16 Apr</span></td>
              <td><span class="date-warn">18 Apr</span></td>
              <td><span class="date-normal">20 Apr</span></td>
              <td><span class="kondisi-display lecet" style="font-size:9px;padding:4px 8px;border-radius:6px;">SCRATCHED</span></td>
              <td><span class="late-days red">2 days</span></td>
              <td>
                <div class="fine-amount">
                  <span class="fine-rp">Rp</span>
                  <span class="fine-val">400.000</span>
                </div>
              </td>
              <td>
                <span class="badge-status terlambat">
                  <span class="bico">🔴</span>LATE
                </span>
              </td>
              <td>
                <button class="btn-action denda" onclick="openModalDenda('ORD-011','Budi Santoso','Gaun Cinderella','18/04/2026',2,50000)">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">RECORD<br>PENALTY</span>
                </button>
              </td>
            </tr>

            <!-- Row 3: Not Returned -->
            <tr>
              <td><span class="order-id">#ORD-<br>012</span></td>
              <td><strong class="customer-name">Citra Dewi</strong></td>
              <td><span class="kostum-cell">Naruto</span></td>
              <td><span class="date-normal">17 Apr</span></td>
              <td><span class="date-warn">20 Apr</span></td>
              <td><span class="date-muted">Not<br>Returned</span></td>
              <td style="color:#4b5a7a">–</td>
              <td style="color:#4b5a7a">–</td>
              <td style="color:#4b5a7a">–</td>
              <td>
                <span class="badge-status belum">
                  <span class="bico">🟡</span>NOT<br>RETURNED
                </span>
              </td>
              <td>
                <button class="btn-action kembali" onclick="openModalKembali('ORD-012','Citra Dewi','Naruto','20/04/2026')">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">RECORD<br>RETURN</span>
                </button>
              </td>
            </tr>

            <!-- Row 4: On Time -->
            <tr>
              <td><span class="order-id">#ORD-<br>013</span></td>
              <td><strong class="customer-name">Deni<br>Pratama</strong></td>
              <td><span class="kostum-cell">Kimono</span></td>
              <td><span class="date-normal">14 Apr</span></td>
              <td><span class="date-warn">17 Apr</span></td>
              <td><span class="date-normal">17 Apr</span></td>
              <td><span class="kondisi-display baik" style="font-size:9px;padding:4px 8px;border-radius:6px;">GOOD</span></td>
              <td style="color:#4b5a7a">–</td>
              <td><span class="fine-zero">Rp 0</span></td>
              <td>
                <span class="badge-status tepat">
                  <span class="bico">✅</span>ON<br>TIME
                </span>
              </td>
              <td><button class="btn-action detail" onclick="openModalDetail('ORD-013','Deni Pratama','Kimono','14/04/2026','17/04/2026','17/04/2026','Tepat Waktu','Baik','Rp 350.000','Rp 0','Lunas')">👁 VIEW DETAILS</button></td>
            </tr>

            <!-- Row 5: Late -->
            <tr>
              <td><span class="order-id">#ORD-<br>014</span></td>
              <td><strong class="customer-name">Eka Putri</strong></td>
              <td><span class="kostum-cell">Dracula</span></td>
              <td><span class="date-normal">15 Apr</span></td>
              <td><span class="date-warn">17 Apr</span></td>
              <td><span class="date-muted">Not<br>Returned</span></td>
              <td style="color:#4b5a7a">–</td>
              <td><span class="late-days red">3 days</span></td>
              <td>
                <div class="fine-amount">
                  <span class="fine-rp">Rp</span>
                  <span class="fine-val">390.000</span>
                </div>
              </td>
              <td>
                <span class="badge-status terlambat">
                  <span class="bico">🔴</span>LATE
                </span>
              </td>
              <td>
                <button class="btn-action denda" onclick="openModalDenda('ORD-014','Eka Putri','Drakula','17/04/2026',3,130000)">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">RECORD<br>PENALTY</span>
                </button>
              </td>
            </tr>

            <!-- Row 6: Not Returned -->
            <tr>
              <td><span class="order-id">#ORD-<br>015</span></td>
              <td><strong class="customer-name">Fajar<br>Nugroho</strong></td>
              <td><span class="kostum-cell">Spiderman</span></td>
              <td><span class="date-normal">13 Apr</span></td>
              <td><span class="date-warn">16 Apr</span></td>
              <td><span class="date-muted">Not<br>Returned</span></td>
              <td style="color:#4b5a7a">–</td>
              <td style="color:#4b5a7a">–</td>
              <td style="color:#4b5a7a">–</td>
              <td>
                <span class="badge-status belum">
                  <span class="bico">🟡</span>NOT<br>RETURNED
                </span>
              </td>
              <td>
                <button class="btn-action kembali" onclick="openModalKembali('ORD-015','Fajar Nugroho','Spiderman','16/04/2026')">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">RECORD<br>RETURN</span>
                </button>
              </td>
            </tr>

            <!-- Row 7: Late & Unpaid Penalty -->
            <tr>
              <td><span class="order-id">#ORD-<br>016</span></td>
              <td><strong class="customer-name">Guntur<br>Pratama</strong></td>
              <td><span class="kostum-cell">Gojo Satoru</span></td>
              <td><span class="date-normal">10 Apr</span></td>
              <td><span class="date-warn">13 Apr</span></td>
              <td><span class="date-normal">16 Apr</span></td>
              <td><span class="kondisi-display rusak" style="font-size:9px;padding:4px 8px;border-radius:6px;background:rgba(239,68,68,0.1);color:#ef4444;border:1px solid rgba(239,68,68,0.2);">DAMAGED</span></td>
              <td><span class="late-days red">3 days</span></td>
              <td>
                <div class="fine-amount">
                  <span class="fine-rp">Rp</span>
                  <span class="fine-val">450.000</span>
                </div>
                <div style="font-size:8px;color:#ef4444;font-weight:700;margin-top:2px;">UNPAID</div>
              </td>
              <td>
                <span class="badge-status terlambat">
                  <span class="bico">🔴</span>LATE
                </span>
              </td>
              <td>
                <button class="btn-action denda" onclick="openModalDenda('ORD-016','Guntur Pratama','Gojo Satoru','13/04/2026',3,150000)">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">PAY<br>PENALTY</span>
                </button>
              </td>
            </tr>

            <!-- Row 8: Not Returned & Very Late -->
            <tr>
              <td><span class="order-id">#ORD-<br>017</span></td>
              <td><strong class="customer-name">Hana Amalia</strong></td>
              <td><span class="kostum-cell">Kafka</span></td>
              <td><span class="date-normal">08 Apr</span></td>
              <td><span class="date-warn">11 Apr</span></td>
              <td><span class="date-muted" style="color:#ef4444;font-weight:700;">LATE!</span></td>
              <td style="color:#4b5a7a">–</td>
              <td><span class="late-days red">12 days</span></td>
              <td>
                <div class="fine-amount">
                  <span class="fine-rp">Rp</span>
                  <span class="fine-val">600.000+</span>
                </div>
              </td>
              <td>
                <span class="badge-status belum" style="background:rgba(239,68,68,0.1);border-color:rgba(239,68,68,0.2);color:#ef4444;">
                  <span class="bico">⚠️</span>VERY<br>LATE
                </span>
              </td>
              <td>
                <button class="btn-action kembali" style="background:linear-gradient(135deg,#ef4444,#dc2626);" onclick="openModalKembali('ORD-017','Hana Amalia','Kafka','11/04/2026')">
                  <span class="btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <span class="btn-label">FOLLOW<br>UP</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>


    </div>
  </main>
</div>

<!-- ===== RECORD PENALTY MODAL ===== -->
<div class="modal-overlay" id="modalDenda">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Record Return &amp; Penalty</span>
      <button class="modal-close" onclick="closeModal('modalDenda')">✕</button>
    </div>
    <div class="modal-body">
      <div class="field-row">
        <div class="field">
          <label>Order ID</label>
          <div class="field-val highlight" id="denda-order-id">#ORD-011</div>
        </div>
        <div class="field">
          <label>Renter</label>
          <div class="field-val" id="denda-penyewa">Budi Santoso</div>
        </div>
      </div>
      <div class="field">
        <label>Costume</label>
        <div class="field-val" id="denda-kostum">Cinderella Dress</div>
      </div>
      <div class="field">
        <label>Actual Return Date</label>
        <input type="date" id="denda-tgl" value="2026-04-20"/>
      </div>
      <div class="field">
        <label>Costume Condition</label>
        <div class="kondisi-row">
          <button class="kondisi-btn baik selected" onclick="selectKondisi(this,'baik')">GOOD</button>
          <button class="kondisi-btn lecet" onclick="selectKondisi(this,'lecet')">SCRATCHED</button>
          <button class="kondisi-btn rusak" onclick="selectKondisi(this,'rusak')">DAMAGED</button>
        </div>
      </div>
      <div class="kalkulasi">
        <div class="kalk-row">
          <span>Days Late</span>
          <span class="red" id="denda-hari">3 DAYS</span>
        </div>
        <div class="kalk-row">
          <span>Penalty per Day</span>
          <span id="denda-perhari">Rp 50.000</span>
        </div>
        <div class="kalk-total">
          <span>TOTAL PENALTY</span>
          <span id="denda-total">Rp 150.000</span>
        </div>
      </div>
      <div class="status-payment-row">
        <span class="status-payment-label">Penalty Payment Status</span>
        <div class="status-options">
          <div class="status-opt unpaid active" id="opt-unpaid" onclick="setStatusDenda('unpaid')">💲 UNPAID</div>
          <div class="status-opt paid" id="opt-paid" onclick="setStatusDenda('paid')">✅ PAID</div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-batal" onclick="closeModal('modalDenda')">CANCEL</button>
      <button class="btn-simpan" onclick="simpanDenda()">SAVE RETURN</button>
    </div>
  </div>
</div>

<!-- ===== RECORD RETURN MODAL ===== -->
<div class="modal-overlay" id="modalKembali">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Record Costume Return</span>
      <button class="modal-close" onclick="closeModal('modalKembali')">✕</button>
    </div>
    <div class="modal-body">
      <div class="field-row">
        <div class="field">
          <label>Order ID</label>
          <div class="field-val highlight" id="kembali-order-id">#ORD-012</div>
        </div>
        <div class="field">
          <label>Renter</label>
          <div class="field-val" id="kembali-penyewa">Citra Dewi</div>
        </div>
      </div>
      <div class="field">
        <label>Costume</label>
        <div class="field-val" id="kembali-kostum">Naruto</div>
      </div>
      <div class="field">
        <label>Required Return Date</label>
        <div class="field-val" id="kembali-wajib">20/04/2026</div>
      </div>
      <div class="field">
        <label>Actual Return Date</label>
        <input type="date" id="kembali-tgl" value="2026-04-19" onchange="hitungKembaliDenda()"/>
      </div>
      <div class="field">
        <label>Costume Condition</label>
        <div class="kondisi-row">
          <button class="kondisi-btn baik selected" onclick="selectKondisiK(this,'baik')">GOOD</button>
          <button class="kondisi-btn lecet" onclick="selectKondisiK(this,'lecet')">SCRATCHED</button>
          <button class="kondisi-btn rusak" onclick="selectKondisiK(this,'rusak')">DAMAGED</button>
        </div>
      </div>
      <div class="kalkulasi" id="kembali-kalk" style="display:none">
        <div class="kalk-row">
          <span>Days Late</span>
          <span class="red" id="kembali-hari">0 DAYS</span>
        </div>
        <div class="kalk-row">
          <span>Penalty per Day</span>
          <span>Rp 50.000</span>
        </div>
        <div class="kalk-total">
          <span>TOTAL PENALTY</span>
          <span id="kembali-total">Rp 0</span>
        </div>
      </div>
      <div class="field">
        <label>Notes</label>
        <input type="text" placeholder="Optional: condition, additional details..."/>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-batal" onclick="closeModal('modalKembali')">CANCEL</button>
      <button class="btn-simpan" onclick="simpanKembali()">SAVE RETURN</button>
    </div>
  </div>
</div>

<!-- ===== VIEW DETAILS MODAL ===== -->
<div class="modal-overlay" id="modalDetail">
  <div class="modal modal-detail">
    <div class="modal-header detail-header">
      <div class="detail-header-left">
        <div class="detail-header-icon">📋</div>
        <div>
          <span class="modal-title">Costume Return Details</span>
          <div class="detail-subtitle">Complete rental transaction summary</div>
        </div>
      </div>
      <button class="modal-close" onclick="closeModal('modalDetail')">✕</button>
    </div>
    <div class="modal-body">

      <!-- SECTION: Order & Renter Info -->
      <div class="detail-section">
        <div class="detail-section-title">📌 Order Information</div>
        <div class="field-row">
          <div class="field">
            <label>Order ID</label>
            <div class="field-val highlight" id="detail-order-id">#ORD-010</div>
          </div>
          <div class="field">
            <label>Return Status</label>
            <div id="detail-status-badge"></div>
          </div>
        </div>
        <div class="field-row">
          <div class="field">
            <label>Renter Name</label>
            <div class="field-val" id="detail-penyewa">Asep Sulaiman</div>
          </div>
          <div class="field">
            <label>Rented Costume</label>
            <div class="field-val" id="detail-kostum">Batman</div>
          </div>
        </div>
      </div>

      <!-- SECTION: Rental Timeline -->
      <div class="detail-section">
        <div class="detail-section-title">📅 Rental Timeline</div>
        <div class="timeline-grid">
          <div class="timeline-item">
            <div class="timeline-dot green"></div>
            <div class="timeline-info">
              <div class="timeline-label">Rental Start Date</div>
              <div class="timeline-val" id="detail-tgl-mulai">15/04/2026</div>
            </div>
          </div>
          <div class="timeline-connector"></div>
          <div class="timeline-item">
            <div class="timeline-dot orange"></div>
            <div class="timeline-info">
              <div class="timeline-label">Required Return Date</div>
              <div class="timeline-val warn" id="detail-tgl-wajib">18/04/2026</div>
            </div>
          </div>
          <div class="timeline-connector"></div>
          <div class="timeline-item">
            <div class="timeline-dot blue"></div>
            <div class="timeline-info">
              <div class="timeline-label">Actual Return Date</div>
              <div class="timeline-val" id="detail-tgl-aktual">18/04/2026</div>
            </div>
          </div>
        </div>
      </div>

      <!-- SECTION: Condition & Costs -->
      <div class="detail-section">
        <div class="detail-section-title">🎭 Condition &amp; Costs</div>
        <div class="field-row">
          <div class="field">
            <label>Returned Costume Condition</label>
            <div id="detail-kondisi-badge" class="kondisi-display">GOOD</div>
          </div>
          <div class="field">
            <label>Lateness</label>
            <div class="field-val" id="detail-terlambat" style="color:var(--green);font-weight:700">On Time</div>
          </div>
        </div>
        <div class="detail-biaya-grid">
          <div class="biaya-card">
            <div class="biaya-label">Rental Fee</div>
            <div class="biaya-val" id="detail-biaya-sewa">Rp 500.000</div>
          </div>
          <div class="biaya-card denda">
            <div class="biaya-label">Total Penalty</div>
            <div class="biaya-val denda" id="detail-denda">Rp 0</div>
          </div>
          <div class="biaya-card total">
            <div class="biaya-label">Total Bill</div>
            <div class="biaya-val total" id="detail-total">Rp 500.000</div>
          </div>
        </div>
      </div>

      <!-- SECTION: Payment Status -->
      <div class="detail-section">
        <div class="detail-section-title">💳 Payment Status</div>
        <div class="status-payment-row">
          <span class="status-payment-label">Rental Payment Status</span>
          <div id="detail-payment-badge"></div>
        </div>
        <div class="field" style="margin-top:10px">
          <label>Admin Notes</label>
          <div class="field-val" style="color:var(--text-2);font-style:italic">Costume returned in good condition and on time. No damage found.</div>
        </div>
      </div>

    </div>
    <div class="modal-footer">
      <button class="btn-batal" onclick="closeModal('modalDetail')">CLOSE</button>
      <button class="btn-simpan" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 14px rgba(16,185,129,0.3)" onclick="window.print ? alert('🖨️ Print feature will be available soon!') : null()">🖨️ PRINT RECEIPT</button>
    </div>
  </div>
</div>
@endsection
