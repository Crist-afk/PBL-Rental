// ── FORMAT RUPIAH ──
function rupiah(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

// ── MODAL LOGIC ──
const modalOverlay   = document.getElementById('modalOverlay');
const closeModalBtn  = document.getElementById('closeModalBtn');

function openModal(userId) {
    // Show a loading state inside the modal first
    document.getElementById('modalAvatar').textContent   = '...';
    document.getElementById('modalTitle').textContent    = 'Memuat Data...';
    document.getElementById('modalSubtitle').textContent = 'Silakan tunggu';

    document.getElementById('mstatTotal').textContent   = '...';
    document.getElementById('mstatSelesai').textContent = '...';
    document.getElementById('mstatBerjalan').textContent = '...';
    document.getElementById('mstatTotal2').textContent  = '...';
    
    const tbody = document.getElementById('riwayatTableBody');
    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px;">Memuat data riwayat pesanan...</td></tr>';

    // Show modal first so user knows it's fetching
    modalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';

    fetch(`/admin/riwayat/user/${userId}`)
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data');
            return response.json();
        })
        .then(data => {
            const u = data.user;
            const orders = data.transaksis;

            // Set header
            document.getElementById('modalAvatar').textContent   = u.nama.charAt(0).toUpperCase();
            document.getElementById('modalTitle').textContent    = 'Katalog Pesanan — ' + u.nama;
            document.getElementById('modalSubtitle').textContent = u.email + (u.no_hp ? ' | ' + u.no_hp : '');

            // Compute stats
            document.getElementById('mstatTotal').textContent   = u.total_transaksi + ' Order';
            document.getElementById('mstatSelesai').textContent = u.total_selesai;
            document.getElementById('mstatBerjalan').textContent = u.total_disewa;
            document.getElementById('mstatTotal2').textContent  = rupiah(u.total_bayar || 0);

            // Render table rows
            tbody.innerHTML = '';
            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px; color:var(--text-3);">Belum ada riwayat pesanan.</td></tr>';
                return;
            }

            orders.forEach(order => {
                const total = order.total_biaya;
                const statusClass = order.status === 'Selesai' ? 'selesai'
                                  : (order.status === 'Disewa' ? 'berjalan' : 'batal');
                const statusLabel = order.status;
                const dendaHtml = order.total_denda > 0
                    ? `<span class="denda-val">+${rupiah(order.total_denda)}</span>`
                    : `<span class="denda-none">—</span>`;

                tbody.innerHTML += `
                    <tr>
                        <td><span class="order-id">#TRX-${order.id}</span></td>
                        <td>
                            <div class="kostum-cell">
                                <span class="kostum-emoji">📦</span>
                                <span class="kostum-name">${order.kostum}</span>
                            </div>
                        </td>
                        <td>${order.tanggal_mulai ?? '-'}</td>
                        <td>${order.tanggal_selesai ?? '-'}</td>
                        <td>${order.durasi}</td>
                        <td class="mono">${rupiah(total)}</td>
                        <td>${dendaHtml}</td>
                        <td><span class="rs-badge ${statusClass}">${statusLabel}</span></td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error(err);
            document.getElementById('modalTitle').textContent = 'Kesalahan';
            document.getElementById('modalSubtitle').textContent = 'Gagal memuat data pengguna.';
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px; color:var(--red);">Gagal memuat data dari server. Silakan coba lagi.</td></tr>';
        });
}

function closeModal() {
    modalOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

closeModalBtn.addEventListener('click', closeModal);
modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });

// ── DELETE MODAL LOGIC ──
const deleteModalOverlay = document.getElementById('deleteModalOverlay');
let currentDeleteUserId = null;

function openDeleteModal(userId, name) {
    currentDeleteUserId = userId;
    document.getElementById('deleteUserName').textContent = name;
    deleteModalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    deleteModalOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

function confirmDelete() {
    if (currentDeleteUserId) {
        const form = document.getElementById('deleteUserForm');
        form.action = `/admin/pengguna/${currentDeleteUserId}`;
        form.submit();
    }
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

document.addEventListener('click', (e) => {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
        document.querySelectorAll('.dropdown-btn').forEach(b => b.classList.remove('open'));
    }
});

// ── EXPOSE KE GLOBAL ──
window.openModal  = openModal;
window.closeModal = closeModal;
window.toggleDrop = toggleDrop;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.confirmDelete = confirmDelete;
