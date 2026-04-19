const pelangganData = [
  {
    name: 'Asep Sulaiman', initial: 'AS', color: '#2563eb',
    email: 'asep@email.com', phone: '0812-XXXX-XXXX', join: 'Januari 2025',
    timeline: [
      { id: 'ORD-001', kostum: 'Batman', date: '1-3 Apr 2026', status: 'selesai', price: 'Rp 450.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-003', kostum: 'Drakula', date: '5-7 Apr 2026', status: 'terlambat', price: 'Rp 390.000', info: 'TERLAMBAT 2 HARI', denda: 'DENDA RP 100.000' },
      { id: 'ORD-007', kostum: 'Naruto', date: '10-11 Apr 2026', status: 'selesai', price: 'Rp 120.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-012', kostum: 'Kimono', date: '15-20 Apr 2026', status: 'berjalan', price: 'Rp 900.000', info: 'SEDANG BERJALAN', denda: null },
      { id: 'ORD-015', kostum: 'Gaun Cinderella', date: '8-9 Apr 2026', status: 'terlambat', price: 'Rp 400.000', info: 'TERLAMBAT 1 HARI', denda: 'DENDA RP 50.000' },
      { id: 'ORD-019', kostum: 'Elf', date: '12-14 Apr 2026', status: 'selesai', price: 'Rp 320.000', info: 'TEPAT WAKTU', denda: null },
    ]
  },
  {
    name: 'Budi Santoso', initial: 'BS', color: '#1d4ed8',
    email: 'budi@email.com', phone: '0813-XXXX-XXXX', join: 'Maret 2025',
    timeline: [
      { id: 'ORD-002', kostum: 'Gaun Cinderella', date: '3-5 Apr 2026', status: 'selesai', price: 'Rp 350.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-008', kostum: 'Spiderman', date: '7-9 Apr 2026', status: 'terlambat', price: 'Rp 300.000', info: 'TERLAMBAT 1 HARI', denda: 'DENDA RP 50.000' },
      { id: 'ORD-011', kostum: 'Gaun Cinderella', date: '16-18 Apr 2026', status: 'terlambat', price: 'Rp 400.000', info: 'TERLAMBAT 2 HARI', denda: 'DENDA RP 100.000' },
      { id: 'ORD-016', kostum: 'Batman', date: '10-12 Apr 2026', status: 'selesai', price: 'Rp 450.000', info: 'TEPAT WAKTU', denda: null },
    ]
  },
  {
    name: 'Citra Dewi', initial: 'CD', color: '#0f766e',
    email: 'citra@email.com', phone: '0814-XXXX-XXXX', join: 'Juni 2025',
    timeline: [
      { id: 'ORD-004', kostum: 'Naruto', date: '2-4 Apr 2026', status: 'selesai', price: 'Rp 150.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-010', kostum: 'Kimono', date: '12-17 Apr 2026', status: 'berjalan', price: 'Rp 600.000', info: 'SEDANG BERJALAN', denda: null },
      { id: 'ORD-012', kostum: 'Drakula', date: '17-20 Apr 2026', status: 'selesai', price: 'Rp 0', info: 'BELUM KEMBALI', denda: null },
    ]
  },
  {
    name: 'Deni Pratama', initial: 'DP', color: '#7c3aed',
    email: 'deni@email.com', phone: '0815-XXXX-XXXX', join: 'September 2025',
    timeline: [
      { id: 'ORD-005', kostum: 'Kimono', date: '14-17 Apr 2026', status: 'selesai', price: 'Rp 180.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-013', kostum: 'Elf', date: '10-14 Apr 2026', status: 'selesai', price: 'Rp 260.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-017', kostum: 'Batman', date: '5-7 Apr 2026', status: 'terlambat', price: 'Rp 100.000', info: 'TERLAMBAT 1 HARI', denda: 'DENDA RP 50.000' },
    ]
  },
  {
    name: 'Eka Putri', initial: 'EP', color: '#b45309',
    email: 'eka@email.com', phone: '0816-XXXX-XXXX', join: 'Februari 2025',
    timeline: [
      { id: 'ORD-006', kostum: 'Drakula', date: '15-17 Apr 2026', status: 'terlambat', price: 'Rp 390.000', info: 'TERLAMBAT 3 HARI', denda: 'DENDA RP 150.000' },
      { id: 'ORD-009', kostum: 'Gaun Cinderella', date: '8-10 Apr 2026', status: 'selesai', price: 'Rp 350.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-014', kostum: 'Naruto', date: '1-4 Apr 2026', status: 'selesai', price: 'Rp 180.000', info: 'TEPAT WAKTU', denda: null },
      { id: 'ORD-018', kostum: 'Elf', date: '12-14 Apr 2026', status: 'berjalan', price: 'Rp 200.000', info: 'SEDANG BERJALAN', denda: null },
    ]
  }
];

let selectedItem = null;

window.selectPelanggan = function(el, idx) {
  if (selectedItem) selectedItem.classList.remove('selected');
  el.classList.add('selected');
  selectedItem = el;

  const p = pelangganData[idx];
  document.getElementById('emptyState').style.display = 'none';
  const det = document.getElementById('customerDetail');
  det.style.display = 'flex';

  const avatar = document.getElementById('custAvatar');
  avatar.textContent = p.initial;
  avatar.style.background = p.color;
  document.getElementById('custName').textContent = p.name;
  document.getElementById('custEmail').textContent = p.email;
  document.getElementById('custPhone').textContent = p.phone;
  document.getElementById('custJoin').textContent = p.join;

  const list = document.getElementById('timelineList');
  list.innerHTML = '';

  p.timeline.forEach(t => {
    const dotClass   = t.status === 'selesai' ? 'green' : t.status === 'terlambat' ? 'red' : 'blue';
    const badgeClass = t.status === 'selesai' ? 'selesai' : t.status === 'terlambat' ? 'terlambat' : 'berjalan';
    const badgeLabel = t.status === 'selesai' ? 'SELESAI' : t.status === 'terlambat' ? 'TERLAMBAT' : 'BERJALAN';
    const infoClass  = t.status === 'terlambat' ? 'red' : t.status === 'berjalan' ? 'blue' : '';
    const dendaHtml  = t.denda ? `<span class="tl-denda">⚠ ${t.denda}</span>` : '';

    list.innerHTML += `
      <div class="tl-item">
        <div class="tl-dot ${dotClass}"></div>
        <div class="tl-card">
          <div class="tl-card-head">
            <div style="display:flex;align-items:center;gap:8px">
              <span class="tl-order-id">#${t.id}</span>
              <span class="tl-kostum">${t.kostum}</span>
            </div>
            <span class="tl-badge ${badgeClass}">${badgeLabel}</span>
          </div>
          <div class="tl-date">📅 ${t.date}</div>
          <div class="tl-bottom">
            <span class="tl-status-text ${infoClass}">${t.info}${dendaHtml ? ' &nbsp; ' + dendaHtml : ''}</span>
            <span class="tl-price">${t.price}</span>
          </div>
        </div>
      </div>`;
  });

  document.getElementById('timelineScroll').scrollTop = 0;
};

window.exportPDF = function() {
  alert('📄 Mengekspor data ke PDF...');
};

window.exportExcel = function() {
  alert('📊 Mengekspor data ke Excel...');
};
