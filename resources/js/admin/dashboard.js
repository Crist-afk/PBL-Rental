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

    // ── POPULAR COSTUMES LINE CHART ──
    const ctx = document.getElementById('popularCostumesChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Penyewaan',
                    data: [65, 85, 73, 110, 95, 130],
                    borderColor: '#EC9C9D', // var(--blue) from layout
                    backgroundColor: 'rgba(236, 156, 157, 0.2)',
                    borderWidth: 3,
                    pointBackgroundColor: '#443025', // var(--bg-card) or similar
                    pointBorderColor: '#EC9C9D',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Smooth curves
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide legend for cleaner look
                    },
                    tooltip: {
                        backgroundColor: '#443025',
                        titleColor: '#FFE4E1',
                        bodyColor: '#FFE4E1',
                        borderColor: 'rgba(68, 48, 37, 0.1)',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Kali Disewa';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(68, 48, 37, 0.05)',
                            drawBorder: false,
                        },
                        ticks: {
                            color: 'rgba(68, 48, 37, 0.6)',
                            font: {
                                family: "'JetBrains Mono', monospace",
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            color: 'rgba(68, 48, 37, 0.6)',
                            font: {
                                family: "'Sora', sans-serif",
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    }
});

// ── NOTIFICATION SYSTEM ──
document.addEventListener('DOMContentLoaded', () => {
    const notifBtn      = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifBadge    = document.getElementById('notifBadge');

    if (!notifBtn || !notifDropdown) return;

    // Toggle open/close on bell click
    notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = notifDropdown.classList.contains('open');
        notifDropdown.classList.toggle('open', !isOpen);
        notifBtn.classList.toggle('active', !isOpen);
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.remove('open');
            notifBtn.classList.remove('active');
        }
    });

    // Mark individual item as read on click (visual feedback before navigation)
    document.querySelectorAll('.notif-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.remove('unread');
            const dot = item.querySelector('.notif-unread-dot');
            if (dot) dot.style.display = 'none';

            // Decrement badge count
            if (notifBadge) {
                const currentCount = parseInt(notifBadge.textContent, 10);
                if (currentCount > 1) {
                    notifBadge.textContent = currentCount - 1;
                } else {
                    notifBadge.style.display = 'none';
                }
            }
        });
    });
});
