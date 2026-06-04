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
                    label: 'Rentals',
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
                                return context.parsed.y + ' Times Rented';
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
    const notifHeaderCount = document.getElementById('notifHeaderCount');
    const notifMarkAllRead = document.getElementById('notifMarkAllRead');

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
        if (notifBtn && !notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
            notifDropdown.classList.remove('open');
            notifBtn.classList.remove('active');
        }
    });

    // Load read notifications from localStorage
    let readNotifs = [];
    try {
        readNotifs = JSON.parse(localStorage.getItem('read_admin_notifications')) || [];
    } catch (e) {
        readNotifs = [];
    }

    const notifItems = document.querySelectorAll('.notif-item');
    
    function updateNotifCounts() {
        let unreadCount = 0;
        notifItems.forEach(item => {
            const notifId = item.getAttribute('data-notif-id');
            const dot = item.querySelector('.notif-unread-dot');
            if (readNotifs.includes(notifId)) {
                item.classList.remove('unread');
                if (dot) dot.style.display = 'none';
            } else {
                item.classList.add('unread');
                if (dot) dot.style.display = 'block';
                unreadCount++;
            }
        });

        if (notifBadge) {
            if (unreadCount > 0) {
                notifBadge.textContent = unreadCount;
                notifBadge.style.display = 'flex'; // Use flex to center text properly
            } else {
                notifBadge.style.display = 'none';
            }
        }

        if (notifHeaderCount) {
            notifHeaderCount.textContent = `${unreadCount} belum dibaca`;
        }
    }

    // Initialize counts on page load
    updateNotifCounts();

    // Click handler for individual item
    notifItems.forEach(item => {
        item.addEventListener('click', (e) => {
            const notifId = item.getAttribute('data-notif-id');
            if (notifId && !readNotifs.includes(notifId)) {
                readNotifs.push(notifId);
                localStorage.setItem('read_admin_notifications', JSON.stringify(readNotifs));
            }
            updateNotifCounts();
        });
    });

    // Mark all as read
    if (notifMarkAllRead) {
        notifMarkAllRead.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            notifItems.forEach(item => {
                const notifId = item.getAttribute('data-notif-id');
                if (notifId && !readNotifs.includes(notifId)) {
                    readNotifs.push(notifId);
                }
            });
            localStorage.setItem('read_admin_notifications', JSON.stringify(readNotifs));
            updateNotifCounts();
        });
    }
});
