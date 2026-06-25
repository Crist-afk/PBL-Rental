let currentTransaksi = null;
let currentDendaKeterlambatan = 0; // simpan nilai keterlambatan untuk total

const fmt = (v) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(v);

// Pilih kondisi kostum + set preset denda kerusakan
window.selectKondisi = function(val, presetDenda) {
    const hiddenInput = document.getElementById('kembali_kondisi_input');
    if (hiddenInput) hiddenInput.value = val;

    // Update active button
    document.querySelectorAll('#modalKembali .kondisi-btn').forEach(btn => {
        btn.classList.remove('selected');
        if ((btn.dataset.kondisi || '').toLowerCase() === val.toLowerCase()) {
            btn.classList.add('selected');
        }
    });

    // Set preset denda kerusakan
    if (presetDenda !== undefined) {
        window.setDendaKerusakan(presetDenda);
    }
}

// Set nilai denda kerusakan dan update total
window.setDendaKerusakan = function(val) {
    const input = document.getElementById('kembali_denda_kerusakan');
    if (input) {
        input.value = val;
        window.hitungTotalDenda();
    }
}

// Hitung dan tampilkan grand total denda (keterlambatan + kerusakan)
window.hitungTotalDenda = function() {
    const kerusakanInput = document.getElementById('kembali_denda_kerusakan');
    const kerusakan = parseInt(kerusakanInput ? kerusakanInput.value : 0, 10) || 0;
    const total = currentDendaKeterlambatan + kerusakan;
    const el = document.getElementById('kembali-grand-total');
    if (el) el.textContent = fmt(total);
}

window.openKembaliFormModal = function(transaksi, kostumDesc) {
    currentTransaksi = transaksi;
    currentDendaKeterlambatan = 0;
    const modal = document.getElementById('modalKembali');
    const form = modal.querySelector('form');
    
    // Gunakan window._adminPengembalianBase yang dinonaktifkan / diset dari blade
    const baseUrl = window._adminPengembalianBase || '/admin/pengembalian';
    form.action = `${baseUrl}/${transaksi.id}/kembali`;

    document.getElementById('kembali-order-id').textContent = '#TRX-' + transaksi.id;
    document.getElementById('kembali-penyewa').textContent = transaksi.user ? transaksi.user.nama : 'Customer';
    document.getElementById('kembali-kostum').textContent = kostumDesc;

    const tSelesai = new Date(transaksi.tanggal_selesai);
    document.getElementById('kembali-wajib').textContent = tSelesai.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });

    // Set tanggal kembali default = hari ini
    const todayStr = new Date().toISOString().split('T')[0];
    document.getElementById('kembali-tgl').value = todayStr;

    // Reset kondisi ke 'GOOD' dan denda kerusakan ke 0
    window.selectKondisi('GOOD', 0);
    const catatanInput = document.getElementById('kembali_catatan');
    if (catatanInput) catatanInput.value = '';
    const kerusakanInput = document.getElementById('kembali_denda_kerusakan');
    if (kerusakanInput) kerusakanInput.value = 0;

    // Sembunyikan semua panel info
    document.getElementById('kembali-early').style.display  = 'none';
    document.getElementById('kembali-ontime').style.display = 'none';
    document.getElementById('kembali-kalk').style.display   = 'none';

    window.hitungKembaliDenda();
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
        // Kembali lebih awal — tidak ada denda keterlambatan
        currentDendaKeterlambatan = 0;
        document.getElementById('kembali-early-days').textContent = Math.abs(diffDays) + ' day(s)';
        panelEarly.style.display = 'block';
    } else if (diffDays === 0) {
        // Tepat waktu
        currentDendaKeterlambatan = 0;
        panelOntime.style.display = 'block';
    } else {
        // Terlambat — hitung denda otomatis
        currentDendaKeterlambatan = diffDays * 50000;
        document.getElementById('kembali-hari').textContent = diffDays + ' DAY(S)';
        document.getElementById('kembali-denda-terlambat').textContent = fmt(currentDendaKeterlambatan);
        panelLate.style.display = 'block';
    }

    // Update grand total setelah menghitung keterlambatan
    window.hitungTotalDenda();
}

window.openDetailFormModal = function(transaksi, kostumDesc, isTerlambat, hariTerlambat) {
    document.getElementById('detail-order-id').textContent = '#TRX-' + transaksi.id;
    document.getElementById('detail-penyewa').textContent = transaksi.user ? transaksi.user.nama : 'Customer';
    document.getElementById('detail-kostum').textContent = kostumDesc;

    const options = { day: 'numeric', month: 'short', year: 'numeric' };

    const tMulai = new Date(transaksi.tanggal_mulai);
    document.getElementById('detail-tgl-mulai').textContent = tMulai.toLocaleDateString('en-US', options);

    const tWajib = new Date(transaksi.tanggal_selesai);
    document.getElementById('detail-tgl-wajib').textContent = tWajib.toLocaleDateString('en-US', options);

    const pengembalian = transaksi.pengembalian || {};
    const tanggalAktual = pengembalian.tanggal_kembali_aktual;
    const kondisi = pengembalian.kondisi_barang;
    const dendaKeterlambatan = Number(pengembalian.denda_keterlambatan || 0);
    const dendaKerusakan     = Number(pengembalian.denda_kerusakan || 0);
    const totalDenda         = Number(pengembalian.total_denda || 0);
    const catatanQc = pengembalian.catatan_qc || transaksi.catatan_admin;

    const tAktual = tanggalAktual ? new Date(tanggalAktual) : null;
    document.getElementById('detail-tgl-aktual').textContent = tAktual ? tAktual.toLocaleDateString('en-US', options) : 'Not Returned';

    // Status badge
    const statusBadge = document.getElementById('detail-status-badge');
    if (transaksi.status === 'Selesai') {
        statusBadge.innerHTML = '<span class="badge-status tepat"><span class="bico">✅</span>COMPLETED</span>';
    } else {
        statusBadge.innerHTML = '<span class="badge-status belum"><span class="bico">🟡</span>NOT RETURNED</span>';
    }

    // Kondisi badge
    const kondisiBadge = document.getElementById('detail-kondisi-badge');
    kondisiBadge.className = 'kondisi-display';
    if (kondisi) {
        let displayKondisi = kondisi;
        let kLower = kondisi.toLowerCase().replace(' ', '-');
        if (kLower === 'lecet' || kLower === 'rusak-ringan' || kLower === 'minor-damage') {
            displayKondisi = 'Minor Damage';
            kLower = 'rusak-ringan';
        } else if (kLower === 'rusak' || kLower === 'rusak-berat' || kLower === 'severe-damage') {
            displayKondisi = 'Severe Damage';
            kLower = 'rusak-berat';
        } else if (kLower === 'baik' || kLower === 'good') {
            displayKondisi = 'Good';
            kLower = 'baik';
        } else if (kLower === 'aksesoris-hilang' || kLower === 'missing-accessories') {
            displayKondisi = 'Missing Accessories';
            kLower = 'aksesoris-hilang';
        }
        kondisiBadge.classList.add(kLower);
        kondisiBadge.textContent = displayKondisi.toUpperCase();
        kondisiBadge.style.display = 'inline-block';
    } else {
        kondisiBadge.style.display = 'none';
    }

    // Terlambat text
    const terlambatVal = document.getElementById('detail-terlambat');
    if (isTerlambat || dendaKeterlambatan > 0) {
        const hari = hariTerlambat || Math.ceil(dendaKeterlambatan / 50000);
        terlambatVal.textContent = `${hari} day(s) late`;
        terlambatVal.style.color = 'var(--red)';
    } else {
        terlambatVal.textContent = 'On Time';
        terlambatVal.style.color = 'var(--green)';
    }

    // Biaya breakdown
    document.getElementById('detail-biaya-sewa').textContent      = fmt(transaksi.total_biaya);
    document.getElementById('detail-denda-terlambat').textContent  = fmt(dendaKeterlambatan);
    document.getElementById('detail-denda-kerusakan').textContent  = fmt(dendaKerusakan);
    document.getElementById('detail-denda').textContent            = fmt(totalDenda);
    document.getElementById('detail-total').textContent            = fmt(Number(transaksi.total_biaya) + totalDenda);

    // Notes
    document.getElementById('detail-catatan-admin').textContent = catatanQc || 'No admin notes.';

    const modal = document.getElementById('modalDetail');
    modal.classList.add('open');
}

window.closeModal = function(id) {
    document.getElementById(id).classList.remove('open');
}

// Close overlay on backdrop click
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('open');
            }
        });
    });
});
