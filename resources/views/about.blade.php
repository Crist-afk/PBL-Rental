<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased flex flex-col min-h-screen">

    <div class="fixed w-full top-0 z-50 px-6 py-4">
        <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-xl">
                <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">🛍️</span>
                <a href="{{ route('home') }}">CosRent</a>
            </div>
            <nav class="hidden md:flex gap-6 font-medium text-sm">
                <a href="{{ route('home') }}" class="hover:text-sakura transition">Home</a>
                <a href="{{ route('about') }}" class="text-sakura transition">About</a>
                <a href="{{ route('products') }}" class="hover:text-sakura transition">Product</a>
                <a href="{{ route('forum') }}" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            </nav>
            <div class="flex gap-4 items-center text-sm font-medium">
                <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow">Register</a>
            </div>
        </header>
    </div>

    <main class="flex-grow pt-32 pb-20 px-6 max-w-7xl mx-auto w-full">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold mb-4 tracking-tight">Mengenal <span class="text-sakura">CosRent</span></h1>
            <p class="text-dark-chocolate/80 text-lg max-w-2xl mx-auto">Lebih dari sekadar tempat menyewa kostum. Kami adalah ruang ganti digital bagi para kreator impian.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="glass-card p-10 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl">
                <div class="text-4xl mb-4">👁️</div>
                <h2 class="text-3xl font-bold mb-4">Visi Kami</h2>
                <p class="text-dark-chocolate/80 text-lg">Menjadi platform nomor satu bagi komunitas kreatif di Indonesia, di mana teknologi dan seni peran bertemu untuk menciptakan pengalaman hobi yang transparan dan tanpa batas.</p>
            </div>
            <div class="bg-dark-chocolate text-misty-rose p-10 rounded-[2rem] shadow-xl">
                <div class="text-4xl mb-4">🎯</div>
                <h2 class="text-3xl font-bold mb-4">Misi Kami</h2>
                <ul class="space-y-4 opacity-90 text-lg">
                    <li>✨ Membangun sistem reservasi cerdas anti double-booking.</li>
                    <li>✨ Menyediakan katalog transparan dan mudah dijelajahi.</li>
                    <li>✨ Mendukung UMKM penyewa kostum lokal.</li>
                </ul>
            </div>
        </div>

        <h2 class="text-4xl font-bold text-center mb-10">Tim Pengembang</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-lg text-center hover:-translate-y-2 transition-transform">
                <div class="w-32 h-32 mx-auto bg-dark-chocolate rounded-full mb-4 overflow-hidden border-4 border-sakura">
                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=400" alt="Rangga" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold">Rangga</h3>
                <p class="text-sakura font-bold text-sm mb-2">Logic Architect</p>
                <p class="text-sm text-dark-chocolate/70">Arsitek database dan algoritma keamanan aplikasi.</p>
            </div>
            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-lg text-center hover:-translate-y-2 transition-transform">
                <div class="w-32 h-32 mx-auto bg-dark-chocolate rounded-full mb-4 overflow-hidden border-4 border-sakura">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=400" alt="Akbar" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold">Akbar</h3>
                <p class="text-sakura font-bold text-sm mb-2">Integration Specialist</p>
                <p class="text-sm text-dark-chocolate/70">Pengatur navigasi rute dan penghubung antarmuka.</p>
            </div>
            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-lg text-center hover:-translate-y-2 transition-transform">
                <div class="w-32 h-32 mx-auto bg-dark-chocolate rounded-full mb-4 overflow-hidden border-4 border-sakura">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400" alt="Crist" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold">Crist</h3>
                <p class="text-sakura font-bold text-sm mb-2">UI/UX Engineer</p>
                <p class="text-sm text-dark-chocolate/70">Seniman visual yang merancang identitas CosRent.</p>
            </div>
        </div>
    </main>

    <footer class="bg-dark-chocolate text-misty-rose py-16 border-t-[16px] border-sakura">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">

            <div>
                <div class="flex items-center gap-2 font-bold text-2xl mb-6">
                    <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-10 h-10 flex items-center justify-center">🛍️</span>
                    CosRent
                </div>
                <p class="text-sm opacity-80 mb-6 leading-relaxed">
                    Platform sewa kostum cosplay premium terlengkap di Indonesia. Kualitas kain terbaik, higienis, dan pilihan ukuran lengkap.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full border border-misty-rose/30 flex items-center justify-center hover:bg-sakura hover:text-dark-chocolate transition">IG</a>
                    <a href="#" class="w-10 h-10 rounded-full border border-misty-rose/30 flex items-center justify-center hover:bg-sakura hover:text-dark-chocolate transition">FB</a>
                    <a href="#" class="w-10 h-10 rounded-full border border-misty-rose/30 flex items-center justify-center hover:bg-sakura hover:text-dark-chocolate transition">TW</a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-sakura mb-6 text-lg">Layanan Kami</h4>
                <ul class="space-y-4 text-sm opacity-90">
                    <li><a href="#" class="hover:text-sakura transition">Katalog Kostum</a></li>
                    <li><a href="#" class="hover:text-sakura transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-sakura transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-sakura transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-sakura transition">Kebijakan Pengembalian</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-sakura mb-6 text-lg">Hubungi Kami</h4>
                <ul class="space-y-4 text-sm opacity-90">
                    <li class="flex items-start gap-3">
                        <span class="mt-1">📍</span>
                        <span>Jl. Cosplay No. 123, Jakarta Selatan, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span>📞</span>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span>✉️</span>
                        <span>support@cosrent.id</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-sakura mb-6 text-lg">Lokasi Toko</h4>
                <div class="w-full h-32 bg-aloewood rounded-xl border border-misty-rose/20 relative overflow-hidden flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=400&q=80" alt="Map" class="absolute inset-0 w-full h-full object-cover opacity-40">
                    <button class="relative z-10 bg-dark-chocolate/80 text-misty-rose px-4 py-2 rounded border border-misty-rose/50 text-sm hover:bg-sakura hover:text-dark-chocolate transition">Buka Maps</button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-misty-rose/10 text-center text-sm opacity-60">
            © 2024 CosRent. All rights reserved. Crafted with ❤️ for Cosplayers.
        </div>
    </footer>
</body>
</html>
