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
    document.getElementById('modalTitle').textContent    = 'Loading Data...';
    document.getElementById('modalSubtitle').textContent = 'Please wait';

    document.getElementById('mstatTotal').textContent   = '...';
    document.getElementById('mstatSelesai').textContent = '...';
    document.getElementById('mstatBerjalan').textContent = '...';
    document.getElementById('mstatTotal2').textContent  = '...';
    
    const tbody = document.getElementById('riwayatTableBody');
    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px;">Loading order history...</td></tr>';

    // Show modal first so user knows it's fetching
    modalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';

    fetch(`/admin/riwayat/user/${userId}`)
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch data');
            return response.json();
        })
        .then(data => {
            const u = data.user;
            const orders = data.transaksis;

            // Set header
            document.getElementById('modalAvatar').textContent   = u.nama.charAt(0).toUpperCase();
            document.getElementById('modalTitle').textContent    = 'Order Catalog — ' + u.nama;
            document.getElementById('modalSubtitle').textContent = u.email + (u.no_hp ? ' | ' + u.no_hp : '');

            // Compute stats
            document.getElementById('mstatTotal').textContent   = u.total_transaksi + ' Orders';
            document.getElementById('mstatSelesai').textContent = u.total_selesai;
            document.getElementById('mstatBerjalan').textContent = u.total_disewa;
            document.getElementById('mstatTotal2').textContent  = rupiah(u.total_bayar || 0);

            // Render table rows
            tbody.innerHTML = '';
            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px; color:var(--text-3);">No order history yet.</td></tr>';
                return;
            }

            orders.forEach(order => {
                const total = order.total_biaya;
                const statusClass = order.status === 'Selesai' ? 'selesai'
                                  : (order.status === 'Disewa' ? 'berjalan' : 'batal');
                const statusMap = {
                    'Selesai': 'Completed',
                    'Disewa': 'Rented',
                    'Batal': 'Cancelled'
                };
                const statusLabel = statusMap[order.status] || order.status;
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
            document.getElementById('modalTitle').textContent = 'Error';
            document.getElementById('modalSubtitle').textContent = 'Failed to load user data.';
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:20px; color:var(--red);">Failed to load data from server. Please try again.</td></tr>';
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
// ── TOGGLE ACTIVE MODAL LOGIC ──
const toggleActiveModalOverlay = document.getElementById('toggleActiveModalOverlay');
let currentToggleActiveUserId = null;

function openToggleActiveModal(userId, name, isActive) {
    currentToggleActiveUserId = userId;
    const title = isActive ? 'Nonaktifkan Akun Pengguna?' : 'Aktifkan Akun Pengguna?';
    const text = isActive
        ? `Apakah Anda yakin ingin menonaktifkan akun <strong style="color:var(--text-1);">${name}</strong>? Pengguna tidak akan bisa login ke dalam situs.`
        : `Apakah Anda yakin ingin mengaktifkan kembali akun <strong style="color:var(--text-1);">${name}</strong>? Pengguna akan bisa login kembali ke dalam situs.`;
    const btnText = isActive ? 'Ya, Nonaktifkan Akun' : 'Ya, Aktifkan Akun';
    const btnBg = isActive ? 'var(--red)' : 'var(--green)';
    const iconBg = isActive ? 'rgba(239, 68, 68, 0.1)' : 'rgba(16, 185, 129, 0.1)';
    const iconColor = isActive ? 'var(--red)' : 'var(--green)';

    document.getElementById('toggleActiveModalTitle').textContent = title;
    document.getElementById('toggleActiveModalText').innerHTML = text;
    
    const confirmBtn = document.getElementById('btnConfirmToggleActive');
    confirmBtn.textContent = btnText;
    confirmBtn.style.background = btnBg;
    confirmBtn.style.boxShadow = `0 4px 12px ${isActive ? 'rgba(239, 68, 68, 0.3)' : 'rgba(16, 185, 129, 0.3)'}`;

    const iconDiv = document.getElementById('toggleActiveModalIcon');
    iconDiv.style.background = iconBg;
    iconDiv.style.color = iconColor;
    // Update SVG in icon
    iconDiv.innerHTML = isActive 
        ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px; height:32px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px; height:32px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;

    toggleActiveModalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeToggleActiveModal() {
    toggleActiveModalOverlay.classList.remove('show');
    document.body.style.overflow = '';
}

function confirmToggleActive() {
    if (currentToggleActiveUserId) {
        const form = document.getElementById('toggleActiveUserForm');
        form.action = `/admin/pengguna/${currentToggleActiveUserId}/toggle-active`;
        form.submit();
    }
}

if (toggleActiveModalOverlay) {
    toggleActiveModalOverlay.addEventListener('click', (e) => {
        if (e.target === toggleActiveModalOverlay) closeToggleActiveModal();
    });
}

// ── EXPOSE KE GLOBAL ──
window.openModal  = openModal;
window.closeModal = closeModal;
window.toggleDrop = toggleDrop;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.confirmDelete = confirmDelete;
window.openToggleActiveModal = openToggleActiveModal;
window.closeToggleActiveModal = closeToggleActiveModal;
window.confirmToggleActive = confirmToggleActive;
