import './bootstrap';
import '../css/app.css';
import 'flowbite';
// public/js/app.js

// --- LOGIKA TOGGLE PASSWORD COSRENT ---
document.addEventListener('DOMContentLoaded', function() {

    // Fungsi dinamis untuk mengubah tipe input dan ikon
    function setupPasswordToggle(btnId, inputId, iconId) {
        const toggleBtn = document.getElementById(btnId);
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(iconId);

        if (toggleBtn && passwordInput && eyeIcon) {
            toggleBtn.addEventListener('click', function () {
                // Toggle tipe input
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                // Toggle ikon FontAwesome
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');

                // Beri warna 'sakura' (#EC9C9D) saat mata terbuka (password terlihat)
                eyeIcon.classList.toggle('text-sakura');
            });
        }
    }

    // Eksekusi untuk Halaman Login & Kolom Pertama Register
    setupPasswordToggle('togglePassword', 'password', 'eyeIcon');

    // Eksekusi khusus untuk Kolom Konfirmasi Password di Halaman Register
    setupPasswordToggle('togglePasswordConfirm', 'password_confirmation', 'eyeIconConfirm');

    // --- LOGIKA REVEAL ANIMATION (GLOBAL) ---
    const reveals = document.querySelectorAll('.reveal');
    if (reveals.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px',
        });

        reveals.forEach((reveal) => {
            observer.observe(reveal);
        });
    }
});
