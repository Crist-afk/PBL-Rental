function rupiah(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

let selectedItem = null;

window.selectPelanggan = function(el, userId) {
  if (selectedItem) selectedItem.classList.remove('selected');
  el.classList.add('selected');
  selectedItem = el;

  document.getElementById('emptyState').style.display = 'none';
  const det = document.getElementById('customerDetail');
  det.style.display = 'flex';

  const avatar = document.getElementById('custAvatar');
  avatar.textContent = '...';
  avatar.style.background = '#3b82f6';
  document.getElementById('custName').textContent = 'Memuat...';
  document.getElementById('custEmail').textContent = '';
  document.getElementById('custPhone').textContent = '';
  document.getElementById('custJoin').textContent = '';

  const list = document.getElementById('timelineList');
  list.innerHTML = '<div style="padding:20px; text-align:center; color:var(--text-3);">Memuat data timeline...</div>';

  fetch(`/admin/riwayat/user/${userId}`)
    .then(response => {
      if (!response.ok) throw new Error('Gagal memuat detail pelanggan');
      return response.json();
    })
    .then(data => {
      const u = data.user;
      const orders = data.transaksis;

      avatar.textContent = u.nama.charAt(0).toUpperCase();
      avatar.style.background = '#2563eb';
      document.getElementById('custName').textContent = u.nama;
      document.getElementById('custEmail').textContent = u.email;
      document.getElementById('custPhone').textContent = u.no_hp ?? '-';
      document.getElementById('custJoin').textContent = u.join;

      list.innerHTML = '';
      if (orders.length === 0) {
        list.innerHTML = '<div style="padding:20px; text-align:center; color:var(--text-3);">Belum ada riwayat sewa.</div>';
        return;
      }

      orders.forEach(t => {
        const dotClass   = t.status === 'Selesai' ? 'green' : (t.status === 'Batal' ? 'red' : 'blue');
        const badgeClass = t.status === 'Selesai' ? 'selesai' : (t.status === 'Batal' ? 'batal' : 'berjalan');
        const badgeLabel = t.status.toUpperCase();
        
        let infoText = 'TEPAT WAKTU';
        let infoClass = '';
        if (t.status === 'Disewa') {
            infoText = 'SEDANG BERJALAN';
            infoClass = 'blue';
        } else if (t.status === 'Batal') {
            infoText = 'BATAL';
            infoClass = 'red';
        } else if (t.total_denda > 0) {
            infoText = 'TERLAMBAT';
            infoClass = 'red';
        }

        const dendaHtml = t.total_denda > 0 ? `<span class="tl-denda">⚠ DENDA ${rupiah(t.total_denda)}</span>` : '';

        list.innerHTML += `
          <div class="tl-item">
            <div class="tl-dot ${dotClass}"></div>
            <div class="tl-card">
              <div class="tl-card-head">
                <div style="display:flex;align-items:center;gap:8px">
                  <span class="tl-order-id">#TRX-${t.id}</span>
                  <span class="tl-kostum">${t.kostum}</span>
                </div>
                <span class="tl-badge ${badgeClass}">${badgeLabel}</span>
              </div>
              <div class="tl-date">📅 ${t.tanggal_mulai ?? '-'} s/d ${t.tanggal_selesai ?? '-'} (${t.durasi})</div>
              <div class="tl-bottom">
                <span class="tl-status-text ${infoClass}">${infoText}${dendaHtml ? ' &nbsp; ' + dendaHtml : ''}</span>
                <span class="tl-price">${rupiah(t.total_biaya)}</span>
              </div>
            </div>
          </div>`;
      });

      document.getElementById('timelineScroll').scrollTop = 0;
    })
    .catch(err => {
      console.error(err);
      document.getElementById('custName').textContent = 'Kesalahan';
      list.innerHTML = '<div style="padding:20px; text-align:center; color:var(--red);">Gagal mengambil riwayat dari server.</div>';
    });
};

window.exportPDF = function() {
  alert('📄 Fitur Ekspor PDF akan segera hadir!');
};

window.exportExcel = function() {
  alert('📊 Fitur Ekspor Excel akan segera hadir!');
};
