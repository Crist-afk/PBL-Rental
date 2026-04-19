// ── TAB ──
window.selectTab = function(el) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// ── CALENDAR ──
let calYear = new Date().getFullYear();
let calMonth = new Date().getMonth();
let selFrom = null, selTo = null, pickingFrom = true;
const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
const DAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

window.openCalendar = function(e) {
    e.stopPropagation();
    const btn = document.getElementById('dateRangeBtn');
    const popup = document.getElementById('calPopup');
    const rect = btn.getBoundingClientRect();
    popup.style.top = (rect.bottom + window.scrollY + 6) + 'px';
    popup.style.left = rect.left + 'px';
    document.getElementById('calOverlay').classList.add('show');
    renderCal();
}

window.closeCalendar = function(e) {
    if (!e || e.target === document.getElementById('calOverlay'))
        document.getElementById('calOverlay').classList.remove('show');
}

window.changeMonth = function(d) {
    calMonth += d;
    if (calMonth > 11) { calMonth = 0; calYear++ }
    if (calMonth < 0) { calMonth = 11; calYear-- }
    renderCal();
}

function renderCal() {
    document.getElementById('calTitle').textContent = MONTHS[calMonth] + ' ' + calYear;
    const grid = document.getElementById('calGrid');
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
    if (!selFrom) hint.textContent = 'Pilih tanggal mulai';
    else if (!selTo) hint.textContent = 'Pilih tanggal akhir';
    else hint.textContent = fmt(selFrom) + ' — ' + fmt(selTo);
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
    document.getElementById('dateFrom').textContent = 'dd/mm/yyyy';
    document.getElementById('dateTo').textContent = 'dd/mm/yyyy';
    renderCal();
}

window.applyCalendar = function() {
    if (selFrom) { const f = document.getElementById('dateFrom'); f.textContent = fmt(selFrom); f.classList.add('filled'); }
    if (selTo) { const t = document.getElementById('dateTo'); t.textContent = fmt(selTo); t.classList.add('filled'); }
    window.closeCalendar({ target: document.getElementById('calOverlay') });
}

// ── MODAL ──
window.openModal = function(id, cust, kostum, total, bank, pengirim, status) {
    document.getElementById('mOrderId').textContent = '#' + id;
    document.getElementById('mCustName').textContent = cust;
    document.getElementById('mKostum').textContent = kostum;
    document.getElementById('mTotal').textContent = 'Rp ' + total;
    document.getElementById('mBank').textContent = bank;
    document.getElementById('mPengirim').textContent = pengirim;
    document.getElementById('mNominal').textContent = 'Rp ' + total;
    const icons = { 'Batman + Joker (2 kostum)': '🦸', 'Gaun Cinderella': '👗', 'Kostum Naruto': '🥷', 'Baju Kimono': '👘', 'default': '🎭' };
    document.getElementById('mItemIcon').textContent = icons[kostum] || icons['default'];
    const footer = document.getElementById('mFooter');
    if (status === 'menunggu') {
        footer.innerHTML = `
      <button class="btn-tolak-modal" onclick="closeModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:15px;height:15px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        TOLAK PEMBAYARAN
      </button>
      <button class="btn-konfirmasi" onclick="closeModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:15px;height:15px"><polyline points="20 6 9 17 4 12"/></svg>
        KONFIRMASI PEMBAYARAN
      </button>`;
    } else {
        footer.innerHTML = `
      <button class="btn-detail" style="grid-column:1/-1;padding:14px;font-size:13px;justify-content:center" onclick="closeModal()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        Tutup
      </button>`;
    }
    document.getElementById('modalOverlay').classList.add('show');
}

window.closeModal = function() { document.getElementById('modalOverlay').classList.remove('show'); }

document.addEventListener('DOMContentLoaded', () => {
    const modalOverlay = document.getElementById('modalOverlay');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', e => {
            if (e.target === modalOverlay) window.closeModal();
        });
    }
});
