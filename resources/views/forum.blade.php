<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Komunitas - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <a href="{{ route('about') }}" class="hover:text-sakura transition">About</a>
                <a href="#" class="hover:text-sakura transition">Product</a>
                <a href="#" class="text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            </nav>
            <div class="flex gap-4 items-center text-sm font-medium">
                @auth
                    <a href="{{ route('profile') }}" class="text-sakura font-bold hover:underline transition">
                        <i class="fa-solid fa-user-circle mr-1"></i> {{ Auth::user()->nama }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                @endauth
            </div>
        </header>
    </div>

    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col lg:flex-row gap-8">
        
        <aside class="lg:w-1/4 hidden lg:block">
            <div class="glass-card p-6 rounded-[2rem] sticky top-32 border-2 border-dark-chocolate/10 shadow-xl">
                <h3 class="text-lg font-bold text-dark-chocolate mb-4 border-b border-dark-chocolate/10 pb-2">Jelajahi Topik</h3>
                <ul class="space-y-2 font-medium">
                    <li><a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-dark-chocolate text-misty-rose shadow-md transition"><i class="fa-solid fa-fire text-sakura"></i> Semua Diskusi</a></li>
                    <li><a href="#" class="flex items-center gap-3 p-3 rounded-xl text-dark-chocolate/80 hover:bg-misty-rose/50 hover:text-dark-chocolate transition"><i class="fa-solid fa-magnifying-glass"></i> Cari Kostum</a></li>
                    <li><a href="#" class="flex items-center gap-3 p-3 rounded-xl text-dark-chocolate/80 hover:bg-misty-rose/50 hover:text-dark-chocolate transition"><i class="fa-solid fa-lightbulb"></i> Tips Cosplay</a></li>
                    <li><a href="#" class="flex items-center gap-3 p-3 rounded-xl text-dark-chocolate/80 hover:bg-misty-rose/50 hover:text-dark-chocolate transition"><i class="fa-solid fa-calendar-star"></i> Jadwal Event</a></li>
                </ul>
            </div>
        </aside>

        <section class="lg:w-2/4 w-full flex flex-col gap-6">
            
            <div class="glass-card p-4 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-sm flex gap-2">
                <input type="text" placeholder="Cari pembahasan menarik di sini..." class="w-full bg-white/50 border-none text-dark-chocolate rounded-xl focus:ring-2 focus:ring-sakura font-medium px-4 py-2">
                <button class="bg-sakura text-dark-chocolate px-4 py-2 rounded-xl font-bold hover:bg-opacity-80 transition"><i class="fa-solid fa-search"></i></button>
            </div>

            <article class="glass-card p-6 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-sakura rounded-full flex items-center justify-center font-bold text-dark-chocolate border-2 border-misty-rose">A</div>
                        <div>
                            <p class="font-bold text-dark-chocolate text-sm hover:underline cursor-pointer">Akbar Z.</p>
                            <p class="text-xs text-dark-chocolate/60 font-medium">2 jam yang lalu</p>
                        </div>
                    </div>
                    <span class="bg-[#FFE4E1] text-aloewood border border-aloewood/30 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Tips Cosplay</span>
                </div>
                
                <h2 class="text-xl font-bold text-dark-chocolate mb-2 hover:text-sakura transition cursor-pointer">Cara styling wig agar tidak gampang kusut saat event outdoor?</h2>
                <p class="text-dark-chocolate/80 text-sm font-medium mb-4 line-clamp-3">
                    Halo semua! Minggu depan aku ada rencana ikut event jejepangan outdoor di Batam. Masalahnya wig karakterku panjang banget dan pengalaman sebelumnya selalu kusut kena angin parah. Ada yang punya rekomendasi hairspray atau teknik nyisir yang aman?
                </p>

                <div class="flex items-center gap-4 pt-4 border-t border-dark-chocolate/10 font-bold text-sm text-dark-chocolate/70">
                    <button class="flex items-center gap-1.5 hover:text-sakura transition"><i class="fa-regular fa-heart"></i> 24 Suka</button>
                    <button class="flex items-center gap-1.5 hover:text-sakura transition"><i class="fa-regular fa-comment"></i> 12 Balasan</button>
                    <button class="flex items-center gap-1.5 hover:text-sakura transition ml-auto"><i class="fa-solid fa-share-nodes"></i> Bagikan</button>
                </div>
            </article>

            <article class="glass-card p-6 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-milk-tea rounded-full flex items-center justify-center font-bold text-dark-chocolate border-2 border-misty-rose">C</div>
                        <div>
                            <p class="font-bold text-dark-chocolate text-sm hover:underline cursor-pointer">Crist G.</p>
                            <p class="text-xs text-dark-chocolate/60 font-medium">5 jam yang lalu</p>
                        </div>
                    </div>
                    <span class="bg-[#FFE4E1] text-sakura border border-sakura/30 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Cari Kostum</span>
                </div>
                
                <h2 class="text-xl font-bold text-dark-chocolate mb-2 hover:text-sakura transition cursor-pointer">[WTB/WTR] Kostum Zhongli Genshin Impact Ukuran L</h2>
                
                <div class="w-full rounded-xl overflow-hidden mb-4 border-2 border-misty-rose/50">
                    <img src="{{ asset('images/Zhongli.jpg') }}" class="w-full h-full object-cover">
                </div>

                <p class="text-dark-chocolate/80 text-sm font-medium mb-4">
                    Ada yang menyewakan atau jual preloved kostum Zhongli size L di area Batam Centre? Kebutuhan untuk bulan depan, kalau bisa lengkap dengan weapon-nya. Budget menyesuaikan!
                </p>

                <div class="flex items-center gap-4 pt-4 border-t border-dark-chocolate/10 font-bold text-sm text-dark-chocolate/70">
                    <button class="flex items-center gap-1.5 hover:text-sakura transition"><i class="fa-regular fa-heart"></i> 45 Suka</button>
                    <button class="flex items-center gap-1.5 hover:text-sakura transition"><i class="fa-regular fa-comment"></i> 8 Balasan</button>
                    <button class="flex items-center gap-1.5 hover:text-sakura transition ml-auto"><i class="fa-solid fa-share-nodes"></i> Bagikan</button>
                </div>
            </article>

        </section>

        <aside class="lg:w-1/4 hidden lg:block">
            <div class="sticky top-32 space-y-6">
                <button class="w-full bg-dark-chocolate text-misty-rose font-bold text-lg py-4 rounded-[2rem] shadow-xl hover:bg-black hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-2 border-2 border-sakura/20">
                    <i class="fa-solid fa-pen-nib"></i> Buat Diskusi Baru
                </button>

                <div class="glass-card p-6 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl">
                    <h3 class="text-lg font-bold text-dark-chocolate mb-4 border-b border-dark-chocolate/10 pb-2"><i class="fa-solid fa-arrow-trend-up text-sakura mr-2"></i>Sedang Hangat</h3>
                    <ul class="space-y-4">
                        <li>
                            <p class="text-xs text-sakura font-bold mb-1">Event Jejepangan</p>
                            <a href="#" class="font-bold text-dark-chocolate text-sm hover:underline line-clamp-2">Batam Anime Fest 2026: List Guest Star & Jadwal Stage</a>
                        </li>
                        <li>
                            <p class="text-xs text-aloewood font-bold mb-1">Diskusi Anime</p>
                            <a href="#" class="font-bold text-dark-chocolate text-sm hover:underline line-clamp-2">Review jujur anime season ini, mana yang overated?</a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

    </main>

</body>
</html>