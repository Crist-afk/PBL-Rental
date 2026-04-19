<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosRent - Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            content: [],
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'dark-chocolate': '#443025',
                        'sakura': '#EC9C9D',
                        'misty-rose': '#FFE4E1',
                        'aloewood': '#8B5A2B',
                        'milk-tea': '#D2B48C',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FFE4E1;   /* Warna misty-rose */
            /* Background titik dihilangkan */
        }
        .glass-card {
            background-color: rgba(68, 48, 37, 0.05);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="text-dark-chocolate antialiased">

    <x-navbar />

    <!-- HEADER -->
    <section class="pt-32 pb-10 text-center px-6">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Katalog Produk</h1>
        <p class="text-dark-chocolate/80 text-lg">Pilih kostum cosplay favoritmu</p>
    </section>

    <!-- FILTER -->
    <section class="max-w-7xl mx-auto px-6 mb-12">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <input type="text" placeholder="Cari kostum..." 
                class="px-5 py-3 rounded-full border border-dark-chocolate/20 w-full md:w-1/3 focus:outline-none focus:border-sakura transition">

            <select class="px-5 py-3 rounded-full border border-dark-chocolate/20 focus:outline-none focus:border-sakura transition">
                <option>Semua Kategori</option>
                <option>Anime</option>
                <option>Game</option>
                <option>Film</option>
            </select>

            <select class="px-5 py-3 rounded-full border border-dark-chocolate/20 focus:outline-none focus:border-sakura transition">
                <option>Urutkan</option>
                <option>Harga Termurah</option>
                <option>Harga Termahal</option>
            </select>
        </div>
    </section>

    <!-- PRODUCT GRID -->
    <section class="pb-20 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Product Card 1 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-dark-chocolate"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">GENSHIN IMPACT</span>
                    <h3 class="font-bold text-xl mb-2">Raiden Shogun</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 180.000</span>
                        <a href="{{ route('products.show', 1) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-aloewood"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">ONE PIECE</span>
                    <h3 class="font-bold text-xl mb-2">Monkey D. Luffy</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 120.000</span>
                        <a href="{{ route('products.show', 2) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-milk-tea"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">HONKAI</span>
                    <h3 class="font-bold text-xl mb-2">Kafka</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 200.000</span>
                        <a href="{{ route('products.show', 3) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-sakura"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">MARVEL</span>
                    <h3 class="font-bold text-xl mb-2">Spider-Man</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 150.000</span>
                        <a href="{{ route('products.show', 4) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- PAGINATION -->
    <section class="pb-20 text-center">
        <div class="flex justify-center gap-3">
            <button class="px-4 py-2 border border-dark-chocolate/30 rounded-full hover:bg-sakura hover:text-dark-chocolate hover:border-sakura transition">1</button>
            <button class="px-4 py-2 border border-dark-chocolate/30 rounded-full hover:bg-sakura hover:text-dark-chocolate hover:border-sakura transition">2</button>
            <button class="px-4 py-2 border border-dark-chocolate/30 rounded-full hover:bg-sakura hover:text-dark-chocolate hover:border-sakura transition">3</button>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark-chocolate text-misty-rose py-16 border-t-[16px] border-sakura">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
            
            <!-- Brand -->
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

            <!-- Layanan Kami -->
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

            <!-- Hubungi Kami -->
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

            <!-- Lokasi Toko -->
            <div>
                <h4 class="font-bold text-sakura mb-6 text-lg">Lokasi Toko</h4>
                <div class="w-full h-32 bg-aloewood rounded-xl border border-misty-rose/20 relative overflow-hidden flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=400&q=80" 
                         alt="Map" 
                         class="absolute inset-0 w-full h-full object-cover opacity-40">
                    <button class="relative z-10 bg-dark-chocolate/80 text-misty-rose px-4 py-2 rounded border border-misty-rose/50 text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                        Buka Maps
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-misty-rose/10 text-center text-sm opacity-60">
            © 2026 CosRent. All rights reserved. Crafted with ❤️ for Cosplayers.
        </div>
    </footer>

</body>
</html>