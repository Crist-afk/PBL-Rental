@extends('layouts.app')

@section('title', 'CosRent - Wujudkan Karakter Impianmu')

@push('styles')
    <style>
        body {
            background-color: #FFE4E1;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            opacity: 0.15;
            mix-blend-mode: color-burn;
            pointer-events: none;
            background-image: url('https://images.unsplash.com/photo-1522383225653-ed111181a951?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        body > * {
            position: relative;
            z-index: 1;
        }
        .glass-card {
            background-color: rgba(68, 48, 37, 0.05);
            backdrop-filter: blur(10px);
        }
    </style>
@endpush

@section('content')
    <section class="min-h-screen flex flex-col items-center justify-center pt-32 px-6 text-center">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-sm inline-flex flex-col items-center border-2 border-dark-chocolate/10">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-tight">
                Wujudkan Karakter <br>
                <span class="text-sakura">Impianmu Jadi Nyata</span>
            </h1>
            <p class="mt-4 max-w-2xl text-dark-chocolate font-medium text-lg">
                Sewa kostum cosplay kualitas premium dengan harga terjangkau. Ribuan pilihan karakter dari anime, game, hingga film favoritmu.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ Auth::check() ? route('products.index') : route('login') }}" 
                class="bg-dark-chocolate text-misty-rose px-8 py-3 rounded-full font-semibold hover:bg-opacity-90 transition shadow-md">
                    Jelajahi Katalog
                </a>
                <a href="{{ Auth::check() ? route('products.index') : route('login') }}" 
                class="border-2 border-dark-chocolate text-dark-chocolate px-8 py-3 rounded-full font-semibold hover:bg-dark-chocolate hover:text-misty-rose transition shadow-md">
                    Cari Produk
                </a>
            </div>
        </div>

        <div class="mt-16 w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl border-4 border-dark-chocolate bg-dark-chocolate">
            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1200&q=80" alt="Cosplay Landscape" class="w-full h-auto object-cover opacity-80">
        </div>
    </section>

    <section class="relative py-24 px-6 overflow-hidden">
        <!-- Background Kanji Decor -->
        <div class="absolute top-20 right-10 text-[12rem] font-bold text-dark-chocolate/5 select-none pointer-events-none leading-none">
            カテゴリー
        </div>
        <div class="absolute bottom-20 left-10 text-[12rem] font-bold text-sakura/5 select-none pointer-events-none leading-none vertical-text">
            コスプレ
        </div>
        
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-block mb-16">
                <span class="text-sakura font-bold tracking-[0.3em] uppercase text-sm block mb-2">— Kategori Kostum —</span>
                <h2 class="text-5xl md:text-6xl font-bold text-dark-chocolate">Pilih Karaktermu</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="group relative bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">アニメ</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">🎭</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Anime & Manga</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">A-N-I-M-E</p>
                </div>
                <div class="group relative bg-dark-chocolate p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">ゲーム</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">🎮</div>
                    <h3 class="font-bold text-lg text-misty-rose mb-1">Permainan Video</h3>
                    <p class="text-xs text-misty-rose/40 uppercase tracking-widest">G-A-M-E</p>
                </div>
                <div class="group relative bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">映画</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">🎬</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Film & Toku</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">M-O-V-I-E</p>
                </div>
                <div class="group relative bg-sakura p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-dark-chocolate cursor-pointer overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-dark-chocolate/10 group-hover:text-dark-chocolate/20 transition-colors">オリジナル</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">✨</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Original</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">O-R-I-G-I-N-A-L</p>
                </div>
                <div class="group relative bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">道具</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">💇‍♀️</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Aksesori</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">W-I-G-S</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section with Torii Background -->
    <section class="relative py-32 bg-misty-rose overflow-hidden">
        <img src="{{ asset('images/torii.png') }}" class="absolute -bottom-20 -right-20 w-96 opacity-10 pointer-events-none transform rotate-12" alt="Torii Decor">
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24">
                <span class="text-sakura font-bold tracking-[0.3em] uppercase text-sm block mb-2">— TATA CARA —</span>
                <h2 class="text-5xl font-bold text-dark-chocolate">Proses Sewa Mudah</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative">
                <!-- Steps with Japanese numbers -->
                <div class="flex flex-col items-center text-center group">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            一
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            1
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Pilih & Jadwal</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Pilih kostum favoritmu dan tentukan tanggal sewa di kalender kami.</p>
                </div>

                <div class="flex flex-col items-center text-center group">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            二
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            2
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Pembayaran</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Lakukan pembayaran melalui transfer atau e-wallet dengan bayar di tempat kami</p>
                </div>

                <div class="flex flex-col items-center text-center group">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            三
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            3
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Ambil</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Kostum dapat diambil di tempat kami.</p>
                </div>

                <div class="flex flex-col items-center text-center group">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            四
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            4
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Kembalikan</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Setelah selesai, kembalikan kostum tepat waktu agar dapat dinikmati yang lain.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 max-w-7xl mx-auto relative overflow-hidden">
        <!-- Decorative Kanji for Products -->
        <div class="absolute -top-10 left-0 text-[15rem] font-bold text-dark-chocolate/5 select-none pointer-events-none leading-none vertical-text">
            注目
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 relative z-10">
            <div class="max-w-xl">
                <span class="text-sakura font-bold tracking-[0.3em] uppercase text-sm block mb-2">— KOLEKSI UNGGULAN —</span>
                <h2 class="text-5xl font-bold text-dark-chocolate">Pilihan Populer</h2>
            </div>
            <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="group flex items-center gap-3 text-dark-chocolate font-bold mt-6 md:mt-0 transition-all hover:text-sakura">
                <span>Lihat Semua Katalog</span>
                <span class="w-12 h-12 bg-dark-chocolate text-white rounded-full flex items-center justify-center group-hover:bg-sakura transition-colors">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Card 1: Raiden Shogun -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Populer</span>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s" alt="Raiden Shogun" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">GENSHIN IMPACT</span>
                    <h3 class="font-bold text-xl mb-4">Raiden Shogun</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 180.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: M, L</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</a>
                </div>
            </div>

            <!-- Card 2: Monkey D. Luffy -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Populer</span>
                    <img src="https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e" alt="Monkey D. Luffy" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">ONE PIECE</span>
                    <h3 class="font-bold text-xl mb-4">Monkey D. Luffy</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 120.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: All Size</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</a>
                </div>
            </div>

            <!-- Card 3: Kafka -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Populer</span>
                    <img src="https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg" alt="Kafka" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">HONKAI: STAR RAIL</span>
                    <h3 class="font-bold text-xl mb-4">Kafka</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 200.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: S, M, L</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</a>
                </div>
            </div>

            <!-- Card 4: Spider-Man -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Populer</span>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s" alt="Spider-Man" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">MARVEL</span>
                    <h3 class="font-bold text-xl mb-4">Spider-Man</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 150.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: L, XL</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 px-6 max-w-7xl mx-auto">
        <div class="glass-card rounded-[3rem] p-8 md:p-16 border-2 border-dark-chocolate/10 flex flex-col md:flex-row items-center gap-12 shadow-xl">
            <div class="md:w-1/2">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Kenapa Memilih <br><span class="text-sakura">CosRent?</span></h2>
                <p class="text-dark-chocolate/80 mb-10 text-lg">
                    Kami memahami kebutuhan cosplayer. Kenyamanan, kebersihan, dan akurasi adalah prioritas utama kami.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">✨</div>
                        <div>
                            <h4 class="font-bold">Kain Premium</h4>
                            <p class="text-sm opacity-80">Kualitas kain terbaik untuk kenyamanan maksimal.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">🛡️</div>
                        <div>
                            <h4 class="font-bold">Higienis</h4>
                            <p class="text-sm opacity-80">Setiap kostum dicuci bersih dan disterilkan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">📏</div>
                        <div>
                            <h4 class="font-bold">Layanan Pas Kostum</h4>
                            <p class="text-sm opacity-80">Bisa mencoba langsung di toko luring kami.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">👕</div>
                        <div>
                            <h4 class="font-bold">Pilihan Ukuran Lengkap</h4>
                            <p class="text-sm opacity-80">Tersedia ukuran lengkap dari XS hingga XXXL.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 w-full">
                <div class="rounded-[2rem] overflow-hidden shadow-2xl h-[500px] bg-dark-chocolate">
                    <img src="https://images.unsplash.com/photo-1519750783826-e2420f4d687f?auto=format&fit=crop&w=800&q=80" alt="Cosplay Event" class="w-full h-full object-cover opacity-80">
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-6 max-w-7xl mx-auto text-center">
        <div class="glass-card inline-block px-8 py-4 rounded-3xl border-2 border-dark-chocolate/10 shadow-sm mb-12">
            <h2 class="text-4xl font-bold mb-2">Apa Kata Mereka?</h2>
            <p class="text-dark-chocolate/80">Pengalaman nyata dari para cosplayer</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"Kostumnya sangat wangi dan bersih! Ukurannya juga sangat pas sesuai deskripsi. Adminnya ramah dan prosesnya sangat cepat. Pasti akan sewa di sini lagi!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Pelanggan #1</h4>
                        <p class="text-xs opacity-70">Cosplayer Terverifikasi</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"Kostumnya sangat wangi dan bersih! Ukurannya juga sangat pas sesuai deskripsi. Adminnya ramah dan prosesnya sangat cepat. Pasti akan sewa di sini lagi!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Pelanggan #2</h4>
                        <p class="text-xs opacity-70">Cosplayer Terverifikasi</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"Kostumnya sangat wangi dan bersih! Ukurannya juga pas banget sesuai deskripsi. Adminnya ramah dan prosesnya cepet banget. Pasti bakal sewa di sini lagi!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Pelanggan #3</h4>
                        <p class="text-xs opacity-70">Cosplayer Terverifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection