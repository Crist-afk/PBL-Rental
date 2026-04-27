import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/css/admin/layout.css',
                'resources/css/admin/dashboard.css',
                'resources/css/admin/kostum.css',
                'resources/css/admin/pembayaran.css',
                'resources/css/admin/pengembalian.css',
                'resources/css/admin/riwayat.css',
                'resources/css/admin/pengguna.css',
                'resources/js/admin/dashboard.js',
                'resources/js/admin/kostum.js',
                'resources/js/admin/pembayaran.js',
                'resources/js/admin/pengembalian.js',
                'resources/js/admin/riwayat.js',
                'resources/js/admin/pengguna.js',
                'resources/js/admin/theme.js',
                'resources/css/admin/profile.css',
                'resources/css/pages/home.css',
                'resources/css/pages/product.css',
                'resources/css/pages/product-detail.css',
                'resources/css/pages/booking.css',
                'resources/css/pages/welcome.css',
                'resources/js/pages/product-detail.js',
                'resources/js/pages/booking.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
