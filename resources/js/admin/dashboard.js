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
