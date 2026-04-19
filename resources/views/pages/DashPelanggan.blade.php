<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CosRent</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

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
            background-color: #FFE4E1;
            background-image: radial-gradient(#443025 10%, transparent 10%);
            background-size: 20px 20px;
        }
        .glass-card {
            background-color: rgba(68, 48, 37, 0.06);
            backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="text-dark-chocolate antialiased flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <div class="fixed w-full top-0 z-50 px-6 py-4">
        <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-xl">
                <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">🛍️</span>
                <a href="{{ route('home') }}">CosRent</a>
            </div>

            <nav class="hidden md:flex gap-6 font-medium text-sm">
                <a href="{{ route('home') }}" class="hover:text-sakura transition">Home</a>
                <a href="#" class="text-sakura font-semibold">Dashboard</a>
                <a href="{{ route('products.index') }}" class="hover:text-sakura transition">Product</a>
                <a href="{{ route('forum') }}" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            </nav>

            <div class="flex items-center gap-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-user-circle text-2xl"></i>
                    <span class="hidden md:inline font-medium">Masamune</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-misty-rose/20 hover:bg-sakura hover:text-dark-chocolate transition text-xs font-bold px-5 py-2 rounded-full flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i> 
                        Keluar
                    </button>
                </form>
            </div>
        </header>
    </div>

    <main class="flex-grow pt-28 pb-12 px-4 sm:px-6 max-w-7xl mx-auto w-full">

        <!-- Greeting -->
        <div class="mb-10">
            <h1 class="text-4xl font-bold">Selamat Datang, Masamune! 👋</h1>
            <p class="text-dark-chocolate/70 mt-2">Ini adalah dashboard pelangganmu. Lihat aktivitas sewa dan kostum favoritmu.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

            <div class="glass-card rounded-3xl p-6 border border-dark-chocolate/20 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-aloewood">Kostum Sedang Disewa</p>
                        <p class="text-4xl font-bold mt-3">3</p>
                    </div>
                    <div class="w-12 h-12 bg-sakura/10 rounded-2xl flex items-center justify-center text-3xl">🛍️</div>
                </div>
                <p class="text-xs text-green-600 mt-4 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> +1 minggu ini
                </p>
            </div>

            <div class="glass-card rounded-3xl p-6 border border-dark-chocolate/20 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-aloewood">Total Sewa</p>
                        <p class="text-4xl font-bold mt-3">17</p>
                    </div>
                    <div class="w-12 h-12 bg-aloewood/10 rounded-2xl flex items-center justify-center text-3xl">📦</div>
                </div>
                <p class="text-xs text-dark-chocolate/60 mt-4">Sejak bergabung</p>
            </div>

            <div class="glass-card rounded-3xl p-6 border border-dark-chocolate/20 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-aloewood">Poin Reward</p>
                        <p class="text-4xl font-bold mt-3 text-sakura">450</p>
                    </div>
                    <div class="w-12 h-12 bg-milk-tea/20 rounded-2xl flex items-center justify-center text-3xl">⭐</div>
                </div>
                <p class="text-xs text-aloewood mt-4">Bisa ditukar diskon</p>
            </div>

            <div class="glass-card rounded-3xl p-6 border border-dark-chocolate/20 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-aloewood">Rating Kamu</p>
                        <p class="text-4xl font-bold mt-3">4.9 <span class="text-2xl">⭐</span></p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-400/10 rounded-2xl flex items-center justify-center text-3xl">🌟</div>
                </div>
                <p class="text-xs text-dark-chocolate/60 mt-4">Dari 12 penyewaan</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Kostum Sedang Disewa -->
            <div class="lg:col-span-7">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Kostum Sedang Disewa</h2>
                    <a href="#" class="text-sakura hover:text-aloewood font-medium text-sm flex items-center gap-2">
                        Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="space-y-4">

                    <!-- Item 1 -->
                    <div class="glass-card rounded-3xl p-5 flex gap-5 items-center border border-dark-chocolate/20">
                        <div class="w-20 h-20 bg-dark-chocolate rounded-2xl flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg">Raiden Shogun - Genshin Impact</h3>
                            <p class="text-sm text-aloewood">Ukuran M • Kembali 18 April 2026</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs text-dark-chocolate/60">Total</span>
                            <span class="font-bold text-lg">Rp 180.000</span>
                        </div>
                        <button class="bg-sakura text-dark-chocolate px-6 py-2.5 rounded-2xl text-sm font-bold hover:bg-dark-chocolate hover:text-misty-rose transition">
                            Detail
                        </button>
                    </div>

                    <!-- Item 2 -->
                    <div class="glass-card rounded-3xl p-5 flex gap-5 items-center border border-dark-chocolate/20">
                        <div class="w-20 h-20 bg-aloewood rounded-2xl flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg">Monkey D. Luffy - One Piece</h3>
                            <p class="text-sm text-aloewood">Ukuran L • Kembali 20 April 2026</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs text-dark-chocolate/60">Total</span>
                            <span class="font-bold text-lg">Rp 120.000</span>
                        </div>
                        <button class="bg-sakura text-dark-chocolate px-6 py-2.5 rounded-2xl text-sm font-bold hover:bg-dark-chocolate hover:text-misty-rose transition">
                            Detail
                        </button>
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-5 space-y-8">

                <!-- Quick Actions -->
                <div class="glass-card rounded-3xl p-7 border border-dark-chocolate/20">
                    <h3 class="font-bold text-xl mb-6">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('products.index') }}" class="bg-white/60 hover:bg-sakura hover:text-dark-chocolate transition p-6 rounded-3xl text-center border border-dark-chocolate/10">
                            <i class="fa-solid fa-magnifying-glass text-3xl mb-3 block"></i>
                            <p class="font-semibold">Cari Kostum</p>
                        </a>
                        <a href="#" class="bg-white/60 hover:bg-sakura hover:text-dark-chocolate transition p-6 rounded-3xl text-center border border-dark-chocolate/10">
                            <i class="fa-solid fa-calendar-days text-3xl mb-3 block"></i>
                            <p class="font-semibold">Perpanjang Sewa</p>
                        </a>
                    </div>
                </div>

                <!-- Riwayat Terbaru -->
                <div class="glass-card rounded-3xl p-7 border border-dark-chocolate/20">
                    <h3 class="font-bold text-xl mb-5">Riwayat Sewa Terbaru</h3>
                    
                    <div class="space-y-6 text-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">Kafka - Honkai: Star Rail</p>
                                <p class="text-xs text-dark-chocolate/60">5 April 2026 • Rp 200.000</p>
                            </div>
                            <span class="text-green-600 text-xs font-bold">Selesai</span>
                        </div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">Spider-Man (Marvel)</p>
                                <p class="text-xs text-dark-chocolate/60">28 Maret 2026 • Rp 150.000</p>
                            </div>
                            <span class="text-green-600 text-xs font-bold">Selesai</span>
                        </div>
                    </div>
                </div>

                <!-- Rekomendasi -->
                <div class="glass-card rounded-3xl p-7 border border-dark-chocolate/20">
                    <h3 class="font-bold text-xl mb-5">Rekomendasi Untukmu</h3>
                    <div class="flex gap-4 overflow-x-auto pb-4">
                        <div class="min-w-[145px] bg-white/70 rounded-2xl overflow-hidden border border-dark-chocolate/10">
                            <div class="h-32 bg-milk-tea"></div>
                            <div class="p-3">
                                <p class="font-bold text-sm">Yae Miko</p>
                                <p class="text-xs text-aloewood">Genshin Impact</p>
                            </div>
                        </div>
                        <div class="min-w-[145px] bg-white/70 rounded-2xl overflow-hidden border border-dark-chocolate/10">
                            <div class="h-32 bg-sakura"></div>
                            <div class="p-3">
                                <p class="font-bold text-sm">Gojo Satoru</p>
                                <p class="text-xs text-aloewood">Jujutsu Kaisen</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>