import './bootstrap';
import '../css/app.css';
import 'flowbite';
// public/js/app.js

document.addEventListener('DOMContentLoaded', function() {
    
    // --- FITUR: TOGGLE LIHAT PASSWORD (Halaman Login) ---
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    // Hanya jalankan logika ini jika tombol toggle password ditemukan di halaman
    if (togglePassword && password && eyeIcon) {
        togglePassword.addEventListener('click', function (e) {
            // Cek apakah tipe saat ini adalah password, jika ya ubah jadi text
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Ganti ikon mata (FontAwesome)
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    }

    // --- Anda bisa menambahkan fungsi JavaScript lainnya di bawah sini nanti ---
    // console.log('CosRent Frontend Scripts Loaded!');
});