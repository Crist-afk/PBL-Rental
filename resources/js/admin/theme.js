// ── THEME MANAGER ──
(function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark-mode');
    }
})();

window.addEventListener('load', () => {
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const themeLabel = document.getElementById('themeLabel');
    const root = document.documentElement;

    function updateThemeIcon(isDark) {
        if (!themeIcon) return;
        if (isDark) {
            themeIcon.innerHTML = '<path d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10z"></path><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>';
            if(themeToggle) themeToggle.title = "Mode Terang";
            if(themeLabel) themeLabel.textContent = "Mode Terang";
        } else {
            themeIcon.innerHTML = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>';
            if(themeToggle) themeToggle.title = "Mode Gelap";
            if(themeLabel) themeLabel.textContent = "Mode Gelap";
        }
    }

    // Initial icon state
    updateThemeIcon(root.classList.contains('dark-mode'));

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const isDark = root.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon(isDark);
        });
    }
});
