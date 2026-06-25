// ── TAB ──
window.selectTab = function(el) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// ── CALENDAR ──
let calYear = new Date().getFullYear();
let calMonth = new Date().getMonth();
let selFrom = null, selTo = null, pickingFrom = true;
const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

window.openCalendar = function(e) {
    e.stopPropagation();
    const btn = document.getElementById('dateRangeBtn');
    const popup = document.getElementById('calPopup');
    if (!btn || !popup) return;
    const rect = btn.getBoundingClientRect();
    popup.style.top = (rect.bottom + window.scrollY + 6) + 'px';
    popup.style.left = rect.left + 'px';
    const overlay = document.getElementById('calOverlay');
    if (overlay) overlay.classList.add('show');
    renderCal();
}

window.closeCalendar = function(e) {
    if (!e || e.target === document.getElementById('calOverlay')) {
        const overlay = document.getElementById('calOverlay');
        if (overlay) overlay.classList.remove('show');
    }
}

window.changeMonth = function(d) {
    calMonth += d;
    if (calMonth > 11) { calMonth = 0; calYear++ }
    if (calMonth < 0) { calMonth = 11; calYear-- }
    renderCal();
}

function renderCal() {
    const titleEl = document.getElementById('calTitle');
    const grid = document.getElementById('calGrid');
    if (!titleEl || !grid) return;

    titleEl.textContent = MONTHS[calMonth] + ' ' + calYear;
    grid.innerHTML = '';
    DAYS.forEach(d => { const el = document.createElement('div'); el.className = 'cal-dow'; el.textContent = d; grid.appendChild(el); });
    const first = new Date(calYear, calMonth, 1).getDay();
    const days = new Date(calYear, calMonth + 1, 0).getDate();
    const today = new Date();
    for (let i = 0; i < first; i++) { const el = document.createElement('div'); el.className = 'cal-day empty'; grid.appendChild(el); }
    for (let d = 1; d <= days; d++) {
        const el = document.createElement('div');
        el.className = 'cal-day';
        const thisDate = new Date(calYear, calMonth, d);
        if (today.getFullYear() === calYear && today.getMonth() === calMonth && today.getDate() === d) el.classList.add('today');
        if (selFrom && sameDay(thisDate, selFrom)) el.classList.add('selected');
        if (selTo && sameDay(thisDate, selTo)) el.classList.add('selected');
        if (selFrom && selTo && thisDate > selFrom && thisDate < selTo) el.classList.add('in-range');
        el.textContent = d;
        el.addEventListener('click', () => pickDay(new Date(calYear, calMonth, d)));
        grid.appendChild(el);
    }
    const hint = document.getElementById('calHint');
    if (hint) {
        if (!selFrom) hint.textContent = 'Select start date';
        else if (!selTo) hint.textContent = 'Select end date';
        else hint.textContent = fmt(selFrom) + ' — ' + fmt(selTo);
    }
}

function sameDay(a, b) { return a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate(); }

function pickDay(d) {
    if (pickingFrom || !selFrom || (selTo && d <= selFrom)) { selFrom = d; selTo = null; pickingFrom = false; }
    else { if (d < selFrom) { selTo = selFrom; selFrom = d; } else selTo = d; pickingFrom = true; }
    renderCal();
}

function fmt(d) { return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth() + 1).toString().padStart(2, '0') + '/' + d.getFullYear(); }

window.resetCalendar = function() {
    selFrom = null; selTo = null; pickingFrom = true;
    const from = document.getElementById('dateFrom');
    const to = document.getElementById('dateTo');
    if (from) from.textContent = 'dd/mm/yyyy';
    if (to) to.textContent = 'dd/mm/yyyy';
    renderCal();
}

window.applyCalendar = function() {
    if (selFrom) { const f = document.getElementById('dateFrom'); if (f) { f.textContent = fmt(selFrom); f.classList.add('filled'); } }
    if (selTo) { const t = document.getElementById('dateTo'); if (t) { t.textContent = fmt(selTo); t.classList.add('filled'); } }
    window.closeCalendar({ target: document.getElementById('calOverlay') });
}

// ── HELPER: dapatkan base URL admin pembayaran ──
// Prioritaskan nilai dari blade (window._adminPembayaranBase), fallback ke pathname
function getAdminPembayaranBase() {
    if (window._adminPembayaranBase) {
        return window._adminPembayaranBase;
    }
    // Fallback: ambil path tanpa query string, strip trailing slash
    return window.location.origin + window.location.pathname.replace(/\/$/, '');
}

// ── VALIDATION MODAL (Verifikasi + Detail) ──
window.openValidationModal = function(transaksi, kostumDesc, durasi) {
    const modal = document.getElementById('validationModalOverlay');
    if (!modal) return;

    document.getElementById('mOrderId').textContent = '#TRX-' + transaksi.id;
    document.getElementById('mCustName').textContent = transaksi.user ? transaksi.user.nama : 'Customer';
    document.getElementById('mKostum').textContent = kostumDesc;

    const tMulai  = new Date(transaksi.tanggal_mulai);
    const tSelesai = new Date(transaksi.tanggal_selesai);
    const opts = { day: 'numeric', month: 'short', year: 'numeric' };
    document.getElementById('mDate').textContent =
        tMulai.toLocaleDateString('en-US', opts) + ' - ' + tSelesai.toLocaleDateString('en-US', opts) + ' (' + durasi + ')';

    const totalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(transaksi.total_biaya);
    document.getElementById('mTotal').textContent = totalFormatted;

    // Bukti Transfer
    const buktiImg   = document.getElementById('mBuktiImg');
    const noBuktiTxt = document.getElementById('mNoBuktiText');
    const fullRes    = document.getElementById('mFullResLink');
    if (transaksi.bukti_pembayaran) {
        const imgUrl = transaksi.bukti_pembayaran.startsWith('http')
            ? transaksi.bukti_pembayaran
            : '/storage/' + transaksi.bukti_pembayaran;
        buktiImg.src = imgUrl;
        buktiImg.style.display = 'block';
        noBuktiTxt.style.display = 'none';
        fullRes.href = imgUrl;
        fullRes.style.display = 'flex';
    } else {
        buktiImg.style.display = 'none';
        noBuktiTxt.style.display = 'block';
        fullRes.style.display = 'none';
    }

    const btnApprove        = document.getElementById('mBtnApprove');
    const btnReject         = document.getElementById('mBtnReject');
    const formContainer     = document.getElementById('validationFormContainer');
    const readOnlyContainer = document.getElementById('readOnlyNotesContainer');

    const base = getAdminPembayaranBase();

    if (transaksi.status === 'Menunggu Verifikasi') {
        // Tampilkan form approve/reject
        formContainer.style.display    = 'block';
        readOnlyContainer.style.display = 'none';
        document.getElementById('mCatatanAdmin').value = '';

        // Bangun URL dengan base yang sudah terbukti benar
        window._approveUrl = base + '/' + transaksi.id + '/setujui';
        window._rejectUrl  = base + '/' + transaksi.id + '/tolak';

        window._currentTrxId      = transaksi.id;
        window._currentTransaksi  = transaksi;
        window._currentKostumDesc = kostumDesc;
        window._currentDurasi     = durasi;

        if (btnApprove) btnApprove.style.display = 'inline-flex';
        if (btnReject)  btnReject.style.display  = 'inline-flex';
    } else {
        // Read-only — tampilkan catatan admin yang tersimpan
        formContainer.style.display    = 'none';
        readOnlyContainer.style.display = 'block';
        document.getElementById('mSavedCatatanAdmin').textContent =
            transaksi.catatan_admin || 'No admin notes.';
        if (btnApprove) btnApprove.style.display = 'none';
        if (btnReject)  btnReject.style.display  = 'none';
    }

    modal.classList.add('show');
}

window.closeValidationModal = function() {
    const modal = document.getElementById('validationModalOverlay');
    if (modal) modal.classList.remove('show');
}

// ── REJECT: buka modal alasan penolakan ──
window.submitRejectWithReason = function() {
    // Pastikan _rejectUrl sudah di-set
    if (!window._rejectUrl) {
        alert('Rejection URL not found. Please try opening the modal again.');
        return;
    }

    // Ambil catatan yang mungkin sudah diisi di modal validasi
    const mCatatanAdmin = document.getElementById('mCatatanAdmin');
    const noteVal = mCatatanAdmin ? mCatatanAdmin.value : '';

    // Set action form SEBELUM menampilkan modal
    const form = document.getElementById('tolakBuktiForm');
    if (form) {
        form.action = window._rejectUrl;
        const textarea = form.querySelector('textarea[name="catatan_admin"]');
        if (textarea) textarea.value = noteVal; // Copy note from previous modal
    }

    // Tutup modal validasi dahulu
    window.closeValidationModal();

    // Tampilkan modal tolak
    const rejectOverlay = document.getElementById('tolakBuktiOverlay');
    if (rejectOverlay) {
        rejectOverlay.style.display = 'flex';
        // Force reflow
        rejectOverlay.offsetHeight;
        rejectOverlay.classList.add('show');
    }
}

// ── CANCEL REJECT: kembali ke modal validasi ──
window.cancelReject = function() {
    const rejectOverlay = document.getElementById('tolakBuktiOverlay');
    if (rejectOverlay) {
        rejectOverlay.classList.remove('show');
        setTimeout(() => {
            rejectOverlay.style.display = 'none';
        }, 150);
    }
    if (window._currentTransaksi) {
        openValidationModal(window._currentTransaksi, window._currentKostumDesc, window._currentDurasi);
    }
}

// ── APPROVE: submit form konfirmasi pembayaran ──
window.submitApproveForm = function() {
    if (!window._approveUrl) {
        alert('Approval URL not found. Please try opening the modal again.');
        return;
    }
    const form = document.getElementById('confirmPaymentForm');
    if (form) {
        form.action = window._approveUrl;
        form.submit();
    }
}

// ── KONFIRMASI PENGAMBILAN MODAL ──
window.openKonfirmasiAmbilModal = function(trxId, custName, kostumDesc, tglMulai) {
    var custEl    = document.getElementById('ambil-cust');
    var kostumEl  = document.getElementById('ambil-kostum');
    var tglEl     = document.getElementById('ambil-tgl');
    var formEl    = document.getElementById('konfirmasiAmbilForm');
    var overlay   = document.getElementById('konfirmasiAmbilOverlay');

    if (custEl)   custEl.textContent   = custName;
    if (kostumEl) kostumEl.textContent = kostumDesc;
    if (tglEl)    tglEl.textContent    = tglMulai;
    if (formEl)   formEl.action        = getAdminPembayaranBase() + '/' + trxId + '/konfirmasi-ambil';
    if (overlay) {
        overlay.style.display = 'flex';
        // Force reflow
        overlay.offsetHeight;
        overlay.classList.add('show');
    }
}

window.closeKonfirmasiAmbil = function() {
    var overlay = document.getElementById('konfirmasiAmbilOverlay');
    if (overlay) {
        overlay.classList.remove('show');
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 150);
    }
}


// ── OVERLAY CLICK-TO-CLOSE (dipasang di blade via DOMContentLoaded) ──
// Listener ini sudah dipasang dari blade @push('scripts') agar tidak terjadi double-attach
