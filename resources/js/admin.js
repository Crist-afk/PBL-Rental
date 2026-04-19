// ── ANIMATE BARS ON DASHBOARD LOAD ──
window.addEventListener('load', () => {
    const bars = [
        { el: document.getElementById('bar1'), w: 32 },
        { el: document.getElementById('bar2'), w: 12 },
        { el: document.getElementById('bar3'), w: 87 },
    ];
    bars.forEach(({ el, w }, i) => {
        if(el) {
            el.style.width = '0';
            setTimeout(() => { el.style.width = w + '%'; }, 400 + i * 150);
        }
    });
});

// ── DROPDOWN logic ──
window.toggleDrop = function(id) {
    const wrap = document.getElementById(id);
    if (!wrap) return;
    const btn = wrap.querySelector('.dropdown-btn');
    const menu = wrap.querySelector('.dropdown-menu');
    const isOpen = menu.classList.contains('show');
    window.closeAllDrops();
    if (!isOpen) {
        menu.classList.add('show');
        btn.classList.add('open');
    }
}

window.selectDrop = function(id, label, el) {
    const wrap = document.getElementById(id);
    if (!wrap) return;
    const labelEl = id === 'statusDrop' ? document.getElementById('statusLabel') : document.getElementById('sortLabel');
    if (labelEl) labelEl.textContent = label;
    wrap.querySelectorAll('.drop-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    window.closeAllDrops();
}

window.closeAllDrops = function() {
    document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
    document.querySelectorAll('.dropdown-btn').forEach(b => b.classList.remove('open'));
}

document.addEventListener('click', e => {
    if (!e.target.closest('.dropdown-wrap')) {
        window.closeAllDrops();
    }
});

// ── TAB logic ──
window.selectTab = function(el) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// ── VIEW TOGGLE ──
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // ── MODAL ──
    const overlay = document.getElementById('modalOverlay');
    if (overlay) {
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        if (openBtn) openBtn.addEventListener('click', () => overlay.classList.add('show'));
        if (closeBtn) closeBtn.addEventListener('click', () => overlay.classList.remove('show'));
        if (cancelBtn) cancelBtn.addEventListener('click', () => overlay.classList.remove('show'));

        overlay.addEventListener('click', e => { 
            if (e.target === overlay) overlay.classList.remove('show'); 
        });
    }
});
