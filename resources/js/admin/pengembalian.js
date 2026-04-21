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
    document.getElementById('denda-hari').textContent = hariTerlambat + ' HARI';
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
        document.getElementById('kembali-hari').textContent = diff + ' HARI';
        document.getElementById('kembali-total').textContent = 'Rp ' + (diff * 50000).toLocaleString('id-ID');
    } else {
        kalk.style.display = 'none';
    }
}

window.closeModal = function(id) {
    document.getElementById(id).classList.remove('open');
}

window.selectKondisi = function(btn, type) {
    document.querySelectorAll('#modalDenda .kondisi-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

window.selectKondisiK = function(btn, type) {
    document.querySelectorAll('#modalKembali .kondisi-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
}

window.simpanDenda = function() {
    alert('✅ Data pengembalian & denda berhasil disimpan!');
    window.closeModal('modalDenda');
}

window.simpanKembali = function() {
    alert('✅ Pengembalian kostum berhasil dicatat!');
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
        statusBadgeEl.innerHTML = '<span class="badge-detail-tepat">✅ TEPAT WAKTU</span>';
    } else {
        statusBadgeEl.innerHTML = '<span class="badge-detail-terlambat">🔴 TERLAMBAT</span>';
    }

    // Timeline
    document.getElementById('detail-tgl-mulai').textContent = tglMulai;
    document.getElementById('detail-tgl-wajib').textContent = tglWajib;
    document.getElementById('detail-tgl-aktual').textContent = tglAktual;

    // Kondisi
    const kondisiEl = document.getElementById('detail-kondisi-badge');
    const k = kondisi.toLowerCase();
    kondisiEl.className = 'kondisi-display ' + (k === 'baik' ? 'baik' : k === 'lecet' ? 'lecet' : 'rusak');
    kondisiEl.textContent = kondisi.toUpperCase();

    // Keterlambatan
    const terlambatEl = document.getElementById('detail-terlambat');
    if (isTepat) {
        terlambatEl.textContent = '✓ Tepat Waktu';
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
        paymentEl.innerHTML = '<span class="badge-lunas">✅ LUNAS</span>';
    } else {
        paymentEl.innerHTML = '<span class="badge-belum-detail">💲 BELUM DIBAYAR</span>';
    }

    document.getElementById('modalDetail').classList.add('open');
}
