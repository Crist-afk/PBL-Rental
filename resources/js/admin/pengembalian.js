// ── TAB ──
window.setTab = function(el) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// ── MODAL DENDA ──
window.openModalDenda = function(orderId, penyewa, kostum, tglWajib, hariTerlambat, dendaPerHari) {
    document.getElementById('denda-order-id').textContent = '#' + orderId;
    document.getElementById('denda-penyewa').textContent = penyewa;
    document.getElementById('denda-kostum').textContent = kostum;
    document.getElementById('denda-hari').textContent = hariTerlambat + ' DAYS';
    document.getElementById('denda-perhari').textContent = 'Rp ' + dendaPerHari.toLocaleString('id-ID');
    document.getElementById('denda-total').textContent = 'Rp ' + (hariTerlambat * dendaPerHari).toLocaleString('id-ID');

    // Reset kondisi
    document.querySelectorAll('#modalDenda .kondisi-btn').forEach(b => b.classList.remove('selected'));
    document.querySelector('#modalDenda .kondisi-btn.baik').classList.add('selected');

    document.getElementById('modalDenda').classList.add('open');
}

// ── MODAL KEMBALI ──
let kembaliWajibDate = null;

window.openModalKembali = function(orderId, penyewa, kostum, tglWajib) {
    document.getElementById('kembali-order-id').textContent = '#' + orderId;
    document.getElementById('kembali-penyewa').textContent = penyewa;
    document.getElementById('kembali-kostum').textContent = kostum;
    document.getElementById('kembali-wajib').textContent = tglWajib;

    const parts = tglWajib.split('/');
    kembaliWajibDate = new Date(parts[2], parts[1] - 1, parts[0]);

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    document.getElementById('kembali-tgl').value = `${yyyy}-${mm}-${dd}`;
    document.getElementById('kembali-kalk').style.display = 'none';

    document.querySelectorAll('#modalKembali .kondisi-btn').forEach(b => b.classList.remove('selected'));
    document.querySelector('#modalKembali .kondisi-btn.baik').classList.add('selected');

    hitungKembaliDenda();
    document.getElementById('modalKembali').classList.add('open');
}

window.hitungKembaliDenda = function() {
    const tglInput = document.getElementById('kembali-tgl').value;
    if (!tglInput || !kembaliWajibDate) return;
    const aktual = new Date(tglInput);
    const diff = Math.floor((aktual - kembaliWajibDate) / (1000 * 60 * 60 * 24));
    const kalk = document.getElementById('kembali-kalk');
    if (diff > 0) {
        kalk.style.display = 'block';
        document.getElementById('kembali-hari').textContent = diff + ' DAYS';
        document.getElementById('kembali-total').textContent = 'Rp ' + (diff * 50000).toLocaleString('id-ID');
    } else {
        kalk.style.display = 'none';
    }
}

window.closeModal = function(id) {
    document.getElementById(id).classList.remove('open');
}

window.selectKondisi = function(val) {
    const modalDenda = document.getElementById('modalDenda');
    if (modalDenda) {
        modalDenda.querySelectorAll('.kondisi-btn').forEach(b => b.classList.remove('selected'));
        const target = modalDenda.querySelector('.kondisi-btn.' + (typeof val === 'string' ? val.toLowerCase() : ''));
        if (target) target.classList.add('selected');
    }
    // Also handle the kembali modal kondisi by value
    const hiddenInput = document.getElementById('kembali_kondisi_input');
    if (hiddenInput && typeof val === 'string') {
        hiddenInput.value = val;
        document.querySelectorAll('.kondisi-btn').forEach(btn => {
            btn.classList.remove('selected');
            if (btn.classList.contains(val.toLowerCase())) {
                btn.classList.add('selected');
            }
        });
    }
}

window.selectKondisiK = function(val) {
    const modalKembali = document.getElementById('modalKembali');
    if (modalKembali) {
        modalKembali.querySelectorAll('.kondisi-btn').forEach(b => b.classList.remove('selected'));
        const target = modalKembali.querySelector('.kondisi-btn.' + (typeof val === 'string' ? val.toLowerCase() : ''));
        if (target) target.classList.add('selected');
    }
}

window.simpanDenda = function() {
    alert('✅ Return & penalty data saved successfully!');
    window.closeModal('modalDenda');
}

window.simpanKembali = function() {
    alert('✅ Costume return recorded successfully!');
    window.closeModal('modalKembali');
}

// Close overlay on backdrop click
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) overlay.classList.remove('open');
        });
    });
});

// ── MODAL DETAIL ──
window.openModalDetail = function(orderId, penyewa, kostum, tglMulai, tglWajib, tglAktual, status, kondisi, biayaSewa, denda, statusBayar) {
    // Info Order
    document.getElementById('detail-order-id').textContent = '#' + orderId;
    document.getElementById('detail-penyewa').textContent = penyewa;
    document.getElementById('detail-kostum').textContent = kostum;

    // Status Badge
    const isTepat = status.toLowerCase().includes('tepat');
    const statusBadgeEl = document.getElementById('detail-status-badge');
    if (isTepat) {
        statusBadgeEl.innerHTML = '<span class="badge-detail-tepat">✅ ON TIME</span>';
    } else {
        statusBadgeEl.innerHTML = '<span class="badge-detail-terlambat">🔴 LATE</span>';
    }

    // Timeline
    document.getElementById('detail-tgl-mulai').textContent = tglMulai;
    document.getElementById('detail-tgl-wajib').textContent = tglWajib;
    document.getElementById('detail-tgl-aktual').textContent = tglAktual;

    // Kondisi
    const kondisiEl = document.getElementById('detail-kondisi-badge');
    const k = kondisi.toLowerCase();
    kondisiEl.className = 'kondisi-display ' + (k === 'baik' ? 'baik' : k === 'lecet' ? 'lecet' : 'rusak');
    const kondisiMap = {
        'baik': 'GOOD',
        'lecet': 'SCRATCHED',
        'rusak': 'DAMAGED'
    };
    kondisiEl.textContent = kondisiMap[k] || kondisi.toUpperCase();

    // Keterlambatan
    const terlambatEl = document.getElementById('detail-terlambat');
    if (isTepat) {
        terlambatEl.textContent = '✓ On Time';
        terlambatEl.style.color = 'var(--green)';
    } else {
        terlambatEl.textContent = status;
        terlambatEl.style.color = 'var(--red)';
    }

    // Biaya
    document.getElementById('detail-biaya-sewa').textContent = biayaSewa;
    document.getElementById('detail-denda').textContent = denda;

    // Total Tagihan: parse and sum if possible
    const cleanNum = s => parseInt(s.replace(/[^\d]/g, '')) || 0;
    const total = cleanNum(biayaSewa) + cleanNum(denda);
    document.getElementById('detail-total').textContent = 'Rp ' + total.toLocaleString('id-ID');

    // Payment Badge
    const paymentEl = document.getElementById('detail-payment-badge');
    if (statusBayar.toLowerCase() === 'lunas') {
        paymentEl.innerHTML = '<span class="badge-lunas">✅ PAID</span>';
    } else {
        paymentEl.innerHTML = '<span class="badge-belum-detail">💲 UNPAID</span>';
    }

    document.getElementById('modalDetail').classList.add('open');
}
  function setStatusDenda(status) {
    const unpaid = document.getElementById('opt-unpaid');
    const paid = document.getElementById('opt-paid');
    
    if (status === 'paid') {
      paid.classList.add('active');
      unpaid.classList.remove('active');
    } else {
      unpaid.classList.add('active');
      paid.classList.remove('active');
    }
  }
