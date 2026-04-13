<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - CosRent</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body class="bg-[#FFFDFB] text-dark-choco flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-dark-choco tracking-tight">CosRent<span class="text-sakura">.</span></a>
                </div>

                <div class="hidden md:flex space-x-6 lg:space-x-8 items-center text-sm md:text-base">
                    <a href="{{ route('home') }}" class="text-milk-tea hover:text-aloewood font-medium transition duration-200">Home</a>
                    <a href="#" class="text-milk-tea hover:text-aloewood font-medium transition duration-200">Cari Kostum</a>
                    <a href="#" class="text-milk-tea hover:text-aloewood font-medium transition duration-200">Product</a>
                    <a href="{{ route('about') }}" class="text-aloewood border-b-2 border-aloewood font-semibold transition duration-200 pb-1">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="text-milk-tea hover:text-aloewood font-medium transition duration-200">Contact</a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-milk-tea hover:text-aloewood transition duration-200">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-aloewood hover:bg-dark-choco px-4 py-2 rounded-full transition duration-200 shadow-sm">
                        Buat Akun
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <header class="max-w-5xl mx-auto px-4 pt-16 pb-12 text-center">
            <div class="inline-block bg-sakura/20 text-aloewood font-semibold px-4 py-1.5 rounded-full text-sm mb-6 border border-sakura/50">
                Mengenal Kami Lebih Dekat
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-dark-choco tracking-tight mb-6">
                Lebih dari Sekadar <span class="text-aloewood">Rental.</span>
            </h1>
            <p class="text-lg text-milk-tea max-w-2xl mx-auto leading-relaxed">
                CosRent lahir dari kegelisahan para cosplayer yang sering kesulitan mencari kostum impian karena sistem pemesanan manual yang berantakan. Kami hadir untuk memastikan setiap "transformasi" Anda berjalan sempurna tanpa pusing memikirkan stok yang bentrok.
            </p>
        </header>

        <section class="max-w-7xl mx-auto px-4 pb-20">
            <div class="grid lg:grid-cols-2 gap-12 items-stretch">
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden group hover:shadow-md transition">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-sakura/10 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                    <div class="w-14 h-14 bg-aloewood text-white rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-dark-choco mb-4">Visi Kami</h2>
                    <p class="text-milk-tea text-lg leading-relaxed">
                        Menjadi "ruang ganti digital" nomor satu bagi komunitas kreatif di Indonesia, di mana teknologi dan seni peran bertemu untuk menciptakan pengalaman hobi yang transparan, mudah, dan tanpa batas.
                    </p>
                </div>

                <div class="bg-dark-choco p-10 rounded-3xl shadow-md flex flex-col justify-center text-white relative overflow-hidden">
                    <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/5 rounded-tl-full -z-10"></div>
                    <h2 class="text-3xl font-bold mb-6 text-[#F2CF2A]">Misi Kami</h2> <ul class="space-y-5">
                        <li class="flex items-start gap-4">
                            <i class="fa-solid fa-shield-halved text-sakura mt-1"></i>
                            <span class="text-slate-200 text-lg">Membangun sistem reservasi cerdas yang kebal dari *double-booking* dan antrean fiktif.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i class="fa-solid fa-magnifying-glass text-sakura mt-1"></i>
                            <span class="text-slate-200 text-lg">Menyediakan katalog terpusat yang transparan dan mudah dijelajahi oleh siapapun.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i class="fa-solid fa-handshake text-sakura mt-1"></i>
                            <span class="text-slate-200 text-lg">Mendukung pertumbuhan UMKM penyewa kostum lokal melalui digitalisasi operasional.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="bg-slate-50 py-20 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-dark-choco mb-4">Dibalik Layar CosRent</h2>
                    <p class="text-milk-tea max-w-xl mx-auto">Tiga pengembang dengan dedikasi tinggi yang merangkai ribuan baris kode demi kenyamanan hobi Anda.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100 group">
                        <div class="h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=400" alt="Rangga Surya" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-dark-choco mb-1">Rangga</h3>
                            <p class="text-sakura font-medium text-sm mb-4">Logic & Data Architect</p>
                            <p class="text-milk-tea text-sm">Mengamankan jantung aplikasi. Bertanggung jawab atas arsitektur database, algoritma anti-double booking, dan keamanan sistem back-end.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100 group">
                        <div class="h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=400" alt="Akbar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-dark-choco mb-1">Akbar</h3>
                            <p class="text-sakura font-medium text-sm mb-4">Integration Specialist</p>
                            <p class="text-milk-tea text-sm">Sang pembuka jalan. Memastikan setiap rute, halaman, dan fitur pengguna saling terhubung tanpa ada tautan yang terputus.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100 group">
                        <div class="h-64 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400" alt="Crist" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-dark-choco mb-1">Crist</h3>
                            <p class="text-sakura font-medium text-sm mb-4">Visual & UI Engineer</p>
                            <p class="text-milk-tea text-sm">Seniman antarmuka. Bertugas menerjemahkan logika sistem menjadi desain visual yang memanjakan mata dan mudah digunakan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full py-8 text-center border-t border-slate-200 bg-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-dark-choco tracking-tight">CosRent<span class="text-sakura">.</span></span>
                <p class="text-sm text-milk-tea border-l border-slate-300 pl-2 ml-2">&copy; 2026 Hak Cipta Dilindungi</p>
            </div>

            <div class="flex space-x-6 text-sm font-medium">
                <a href="#" class="text-milk-tea hover:text-aloewood transition-colors"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                <a href="#" class="text-milk-tea hover:text-aloewood transition-colors"><i class="fa-brands fa-instagram text-lg"></i></a>
                <a href="#" class="text-milk-tea hover:text-aloewood transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="text-milk-tea hover:text-aloewood transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>
