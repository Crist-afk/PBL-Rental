// ── DATA PENGGUNA & RIWAYAT PESANAN ──
const userData = {
    usr1: {
        name: 'Ridho',
        email: 'ridho@example.com',
        avatar: 'R',
        orders: [
            { id: '#ORD-1041', kostum: '🦸', namaKostum: 'Kostum Batman',      tglSewa: '10 Apr 2026', tglKembali: '12 Apr 2026', durasi: 2, harga: 150000, denda: 0,     status: 'selesai' },
            { id: '#ORD-1035', kostum: '🥷', namaKostum: 'Kostum Naruto',      tglSewa: '15 Mar 2026', tglKembali: '17 Mar 2026', durasi: 2, harga: 120000, denda: 0,     status: 'selesai' },
            { id: '#ORD-1028', kostum: '🧛', namaKostum: 'Kostum Drakula',     tglSewa: '01 Mar 2026', tglKembali: '03 Mar 2026', durasi: 2, harga: 130000, denda: 0,     status: 'selesai' },
            { id: '#ORD-1055', kostum: '👗', namaKostum: 'Gaun Cinderella',    tglSewa: '21 Apr 2026', tglKembali: '23 Apr 2026', durasi: 2, harga: 200000, denda: 0,     status: 'berjalan' },
            { id: '#ORD-1020', kostum: '🧝', namaKostum: 'Kostum Elf',         tglSewa: '10 Feb 2026', tglKembali: '14 Feb 2026', durasi: 4, harga: 160000, denda: 100000, status: 'terlambat' },
        ]
    },
    usr2: {
        name: 'Asep Sudrajat',
        email: 'asep.sudrajat@email.com',
        avatar: 'A',
        orders: [
            { id: '#ORD-1042', kostum: '⚔️', namaKostum: 'Kostum Samurai',    tglSewa: '12 Apr 2026', tglKembali: '14 Apr 2026', durasi: 2, harga: 175000, denda: 0,     status: 'selesai' },
            { id: '#ORD-1036', kostum: '🦸', namaKostum: 'Kostum Spiderman',   tglSewa: '20 Mar 2026', tglKembali: '22 Mar 2026', durasi: 2, harga: 150000, denda: 0,     status: 'selesai' },
            { id: '#ORD-1058', kostum: '🥷', namaKostum: 'Kostum Ninja',       tglSewa: '22 Apr 2026', tglKembali: '24 Apr 2026', durasi: 2, harga: 140000, denda: 0,     status: 'berjalan' },
        ]
    },
    usr3: {
        name: 'Siti Aminah',
        email: 'siti.aminah@mail.com',
        avatar: 'S',
        orders: [
            { id: '#ORD-1015', kostum: '👘', namaKostum: 'Kimono Merah',       tglSewa: '05 Jan 2026', tglKembali: '10 Jan 2026', durasi: 5, harga: 180000, denda: 200000, status: 'terlambat' },
            { id: '#ORD-1008', kostum: '👗', namaKostum: 'Gaun Aurora',         tglSewa: '15 Dec 2025', tglKembali: '17 Dec 2025', durasi: 2, harga: 195000, denda: 0,     status: 'selesai' },
        ]
    },
    usr4: {
        name: 'Budi Santoso',
        email: 'budisantoso@gmail.com',
        avatar: 'B',
        orders: [
            { id: '#ORD-1060', kostum: '🧛', namaKostum: 'Kostum Drakula',     tglSewa: '19 Apr 2026', tglKembali: '21 Apr 2026', durasi: 2, harga: 130000, denda: 0,     status: 'berjalan' },
            { id: '#ORD-1052', kostum: '🥷', namaKostum: 'Kostum Naruto',      tglSewa: '05 Apr 2026', tglKembali: '07 Apr 2026', durasi: 2, harga: 120000, denda: 0,     status: 'selesai' },
        ]
    }
};

// ── FORMAT RUPIAH ──
function rupiah(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
}

// ── MODAL LOGIC ──
const modalOverlay   = document.getElementById('modalOverlay');
const closeModalBtn  = document.getElementById('closeModalBtn');

function openModal(userId) {
    const u = userData[userId];
    if (!u) return;

    // Set header
    document.getElementById('modalAvatar').textContent   = u.avatar;
    document.getElementById('modalTitle').textContent    = 'Katalog Pesanan — ' + u.name;
    document.getElementById('modalSubtitle').textContent = u.email;

    // Compute stats
    const total    = u.orders.length;
    const selesai  = u.orders.filter(o => o.status === 'selesai').length;
    const berjalan = u.orders.filter(o => o.status === 'berjalan' || o.status === 'terlambat').length;
    const totalBayar = u.orders.reduce((acc, o) => acc + (o.durasi * o.harga) + o.denda, 0);

    document.getElementById('mstatTotal').textContent   = total + ' Order';
    document.getElementById('mstatSelesai').textContent = selesai;
    document.getElementById('mstatBerjalan').textContent = berjalan;
    document.getElementById('mstatTotal2').textContent  = rupiah(totalBayar);

    // Render table rows
    const tbody = document.getElementById('riwayatTableBody');
    tbody.innerHTML = '';
    u.orders.forEach(order => {
        const total = order.durasi * order.harga;
        const statusLabel = order.status === 'selesai' ? 'Selesai'
                          : order.status === 'berjalan' ? 'Berjalan'
                          : 'Terlambat';
        const dendaHtml = order.denda > 0
            ? `<span class="denda-val">+${rupiah(order.denda)}</span>`
            : `<span class="denda-none">—</span>`;

        tbody.innerHTML += `
            <tr>
                <td><span class="order-id">${order.id}</span></td>
                <td>
                    <div class="kostum-cell">
                        <span class="kostum-emoji">${order.kostum}</span>
                        <span class="kostum-name">${order.namaKostum}</span>
                    </div>
                </td>
                <td>${order.tglSewa}</td>
                <td>${order.tglKembali}</td>
                <td>${order.durasi} Hari</td>
                <td class="mono">${rupiah(order.harga)}</td>
                <td class="mono">${rupiah(total)}</td>
                <td>${dendaHtml}</td>
                <td><span class="rs-badge ${order.status}">${statusLabel}</span></td>
            </tr>
        `;
    });

    // Show modal
    modalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modalOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

closeModalBtn.addEventListener('click', closeModal);
modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });

// ── DELETE MODAL LOGIC ──
const deleteModalOverlay = document.getElementById('deleteModalOverlay');

function openDeleteModal(userId) {
    const u = userData[userId];
    if (!u) return;
    
    document.getElementById('deleteUserName').textContent = u.name;
    deleteModalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    deleteModalOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

function confirmDelete() {
    // In a real app, this would send an AJAX request to delete the user.
    // For now, just show an alert and close the modal.
    alert('Akun pengguna berhasil dihapus (Simulasi).');
    closeDeleteModal();
}

deleteModalOverlay.addEventListener('click', (e) => { 
    if (e.target === deleteModalOverlay) closeDeleteModal(); 
});

// ── DROPDOWN LOGIC ──
function toggleDrop(id) {
    const wrap = document.getElementById(id);
    const btn  = wrap.querySelector('.dropdown-btn');
    const menu = wrap.querySelector('.dropdown-menu');
    document.querySelectorAll('.dropdown-wrap').forEach(el => {
        if (el.id !== id) {
            el.querySelector('.dropdown-menu').classList.remove('show');
            el.querySelector('.dropdown-btn').classList.remove('open');
        }
    });
    menu.classList.toggle('show');
    btn.classList.toggle('open');
}

function selectDrop(wrapId, val, itemEl) {
    document.getElementById('sortLabel').textContent = val;
    const wrap = document.getElementById(wrapId);
    wrap.querySelectorAll('.drop-item').forEach(el => el.classList.remove('selected'));
    itemEl.classList.add('selected');
    wrap.querySelector('.dropdown-menu').classList.remove('show');
    wrap.querySelector('.dropdown-btn').classList.remove('open');
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
        document.querySelectorAll('.dropdown-btn').forEach(b => b.classList.remove('open'));
    }
});

// ── EXPOSE KE GLOBAL (dibutuhkan saat Vite load sebagai ES Module) ──
window.openModal  = openModal;
window.closeModal = closeModal;
window.toggleDrop = toggleDrop;
window.selectDrop = selectDrop;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.confirmDelete = confirmDelete;
