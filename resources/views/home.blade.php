<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosRent - Wujudkan Karakter Impianmu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'dark-chocolate': '#443025',
                        'sakura': '#EC9C9D',
                        'misty-rose': '#FFE4E1', /* Diperbarui: Menjadi Soft Pink */
                        'aloewood': '#8B5A2B',
                        'milk-tea': '#D2B48C',
                    },
                    backgroundImage: {
                        'dotted-pattern': 'radial-gradient(#443025 1px, transparent 1px)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            /* Menerapkan dotted pattern dengan background Soft Pink */
            background-color: #FFE4E1;
            background-image: radial-gradient(#443025 10%, transparent 10%);
            background-size: 20px 20px;
        }
        /* Menghindari background transparan menjadi putih */
        .glass-card {
            background-color: rgba(68, 48, 37, 0.05); /* Dark chocolate transparan sbg ganti putih */
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="text-dark-chocolate antialiased">

    <div class="fixed w-full top-0 z-50 px-6 py-4">
        <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-xl">
                <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">🛍️</span>
                CosRent
            </div>
            <nav class="hidden md:flex gap-6 font-medium text-sm">
                <a href="{{ route('home') }}" class="text-sakura hover:text-misty-rose transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-sakura transition">About</a>
                <a href="{{ route('product') }}" class="hover:text-sakura transition">Product</a>
                <a href="{{ route('forum') }}" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            </nav>
            <div class="flex gap-4 items-center text-sm font-medium">
                <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow">Register</a>
            </div>
        </header>
    </div>

    <section class="min-h-screen flex flex-col items-center justify-center pt-32 px-6 text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-tight">
            Wujudkan Karakter <br>
            <span class="text-sakura">Impianmu Jadi Nyata</span>
        </h1>
        <p class="mt-4 max-w-2xl text-dark-chocolate/80 text-lg">
            Sewa kostum cosplay kualitas premium dengan harga terjangkau. Ribuan pilihan karakter dari anime, game, hingga film favoritmu.
        </p>
        <div class="mt-8 flex gap-4">
            <a href="#" class="bg-dark-chocolate text-misty-rose px-8 py-3 rounded-full font-semibold hover:bg-opacity-90 transition shadow-md">Jelajahi Katalog</a>
            <a href="#" class="border-2 border-dark-chocolate text-dark-chocolate px-8 py-3 rounded-full font-semibold hover:bg-dark-chocolate hover:text-misty-rose transition shadow-md">Cari Produk</a>
        </div>

        <div class="mt-16 w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl border-4 border-dark-chocolate bg-dark-chocolate">
            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1200&q=80" alt="Cosplay Landscape" class="w-full h-auto object-cover opacity-80">
        </div>
    </section>

    <section class="py-20 px-6 max-w-7xl mx-auto text-center">
        <h2 class="text-4xl font-bold mb-2">Kategori Kostum</h2>
        <p class="text-dark-chocolate/80 mb-12">Temukan kostum berdasarkan genre favoritmu</p>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-sakura p-6 rounded-2xl shadow-md hover:-translate-y-1 transition border-2 border-dark-chocolate/10 cursor-pointer">
                <div class="text-3xl mb-3">🎭</div>
                <h3 class="font-semibold text-dark-chocolate">Anime & Manga</h3>
            </div>
            <div class="bg-dark-chocolate text-misty-rose p-6 rounded-2xl shadow-md hover:-translate-y-1 transition cursor-pointer">
                <div class="text-3xl mb-3">🎮</div>
                <h3 class="font-semibold">Video Games</h3>
            </div>
            <div class="bg-milk-tea p-6 rounded-2xl shadow-md hover:-translate-y-1 transition border-2 border-dark-chocolate/10 cursor-pointer">
                <div class="text-3xl mb-3">🎬</div>
                <h3 class="font-semibold text-dark-chocolate">Film & Tokusatsu</h3>
            </div>
            <div class="bg-sakura p-6 rounded-2xl shadow-md hover:-translate-y-1 transition border-2 border-dark-chocolate/10 cursor-pointer">
                <div class="text-3xl mb-3">✨</div>
                <h3 class="font-semibold text-dark-chocolate">Original Character</h3>
            </div>
            <div class="bg-aloewood text-misty-rose p-6 rounded-2xl shadow-md hover:-translate-y-1 transition cursor-pointer">
                <div class="text-3xl mb-3">💇‍♀️</div>
                <h3 class="font-semibold">Accessories & Wigs</h3>
            </div>
        </div>
    </section>

    <section class="bg-dark-chocolate text-misty-rose py-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-2">Proses Sewa Mudah</h2>
            <p class="text-sakura mb-16">Hanya butuh 4 langkah untuk mendapatkan kostum impianmu</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <div class="hidden md:block absolute top-8 left-[12%] right-[12%] h-[2px] bg-sakura/30 border-dashed border-b-2 border-sakura/50 z-0"></div>

                <div class="flex flex-col items-center relative z-10">
                    <div class="bg-sakura text-dark-chocolate w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-lg">🔍</div>
                    <h4 class="font-bold text-lg mb-2">Pilih & Jadwal</h4>
                    <p class="text-sm opacity-80">Pilih kostum favoritmu dan tentukan tanggal sewa.</p>
                </div>
                <div class="flex flex-col items-center relative z-10">
                    <div class="bg-sakura text-dark-chocolate w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-lg">💳</div>
                    <h4 class="font-bold text-lg mb-2">Bayar & Deposit</h4>
                    <p class="text-sm opacity-80">Lakukan pembayaran sewa dan deposit keamanan.</p>
                </div>
                <div class="flex flex-col items-center relative z-10">
                    <div class="bg-sakura text-dark-chocolate w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-lg">📦</div>
                    <h4 class="font-bold text-lg mb-2">Kirim / Ambil</h4>
                    <p class="text-sm opacity-80">Kostum dikirim ke alamatmu atau ambil di toko.</p>
                </div>
                <div class="flex flex-col items-center relative z-10">
                    <div class="bg-sakura text-dark-chocolate w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-4 shadow-lg">🔄</div>
                    <h4 class="font-bold text-lg mb-2">Kembalikan</h4>
                    <p class="text-sm opacity-80">Kembalikan kostum setelah masa sewa berakhir.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-4xl font-bold mb-2">Produk Unggulan</h2>
                <p class="text-dark-chocolate/80">Kostum paling populer minggu ini</p>
            </div>
            <a href="#" class="text-dark-chocolate font-medium hover:text-sakura transition hidden md:block">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full">Populer</span>
                    <div class="w-full h-full bg-aloewood opacity-50"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">GENSHIN IMPACT</span>
                    <h3 class="font-bold text-xl mb-4">Raiden Shogun</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 180.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: M, L</span>
                    </div>
                    <button class="w-full bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</button>
                </div>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full">Populer</span>
                    <div class="w-full h-full bg-milk-tea opacity-50"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">ONE PIECE</span>
                    <h3 class="font-bold text-xl mb-4">Monkey D. Luffy</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 120.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: All Size</span>
                    </div>
                    <button class="w-full bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</button>
                </div>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full">Populer</span>
                    <div class="w-full h-full bg-aloewood opacity-80"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">HONKAI: STAR RAIL</span>
                    <h3 class="font-bold text-xl mb-4">Kafka</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 200.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: S, M, L</span>
                    </div>
                    <button class="w-full bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</button>
                </div>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full">Populer</span>
                    <div class="w-full h-full bg-sakura opacity-50"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">MARVEL</span>
                    <h3 class="font-bold text-xl mb-4">Spider-Man</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 150.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: L, XL</span>
                    </div>
                    <button class="w-full bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Detail Kostum</button>
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
                            <h4 class="font-bold">Premium Fabric</h4>
                            <p class="text-sm opacity-80">Kualitas kain terbaik untuk kenyamanan maksimal.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">🛡️</div>
                        <div>
                            <h4 class="font-bold">Hygienic</h4>
                            <p class="text-sm opacity-80">Setiap kostum dicuci bersih dan disterilkan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">📏</div>
                        <div>
                            <h4 class="font-bold">Fitting Available</h4>
                            <p class="text-sm opacity-80">Bisa fitting langsung di offline store kami.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">👕</div>
                        <div>
                            <h4 class="font-bold">Full Size Options</h4>
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
        <h2 class="text-4xl font-bold mb-2">Apa Kata Mereka?</h2>
        <p class="text-dark-chocolate/80 mb-12">Pengalaman nyata dari para cosplayer</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"Kostumnya sangat wangi dan bersih! Ukurannya juga pas banget sesuai deskripsi. Adminnya ramah dan prosesnya cepet banget. Pasti bakal sewa di sini lagi!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Customer #1</h4>
                        <p class="text-xs opacity-70">Verified Cosplayer</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"Kostumnya sangat wangi dan bersih! Ukurannya juga pas banget sesuai deskripsi. Adminnya ramah dan prosesnya cepet banget. Pasti bakal sewa di sini lagi!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Customer #2</h4>
                        <p class="text-xs opacity-70">Verified Cosplayer</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"Kostumnya sangat wangi dan bersih! Ukurannya juga pas banget sesuai deskripsi. Adminnya ramah dan prosesnya cepet banget. Pasti bakal sewa di sini lagi!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Customer #3</h4>
                        <p class="text-xs opacity-70">Verified Cosplayer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
