@extends('layouts.app')

@section('title', 'Tentang Kami - CosRent')

@section('content')

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>

    <main class="flex-grow w-full overflow-hidden">
        <section class="relative pt-40 pb-20 px-6 max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
            <div class="absolute top-20 left-10 w-72 h-72 bg-sakura rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-aloewood rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

            <div class="md:w-1/2 relative z-10">
                <span class="text-aloewood font-black tracking-widest uppercase text-sm mb-4 block drop-shadow-md">Cerita Kami</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-dark-chocolate leading-tight mb-6 drop-shadow-lg">
                    Mewujudkan <br>
                    <span class="text-sakura drop-shadow-md">Imajinasi</span><br>
                    Tanpa Batas.
                </h1>
                <p class="text-lg text-dark-chocolate/80 mb-8 max-w-lg font-medium leading-relaxed">
                    CosRent hadir bukan sekadar sebagai tempat penyewaan, melainkan sebagai panggung bagi para kreator untuk mengekspresikan karakter impian mereka dengan kualitas premium.
                </p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="#tim" class="bg-dark-chocolate text-misty-rose px-8 py-4 rounded-full font-bold shadow-lg hover:bg-black hover:-translate-y-1 transition duration-300">Kenali Tim Kami</a>
                    <div class="flex items-center gap-3 text-dark-chocolate font-bold">
                        <span class="text-3xl text-sakura">5K+</span>
                        <span class="text-sm leading-tight text-dark-chocolate/70">Cosplayer<br>Bergabung</span>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 relative z-10 w-full mt-10 md:mt-0">
                <div class="relative w-full h-[400px] md:h-[500px]">
                    <div class="absolute top-0 right-0 w-4/5 h-4/5 rounded-[3rem] overflow-hidden border-4 border-misty-rose shadow-2xl z-20 hover:scale-105 transition duration-500">
                        <img src="{{ asset('images/Cosplayer-1.jpg') }}" alt="Cosplayer 1" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute bottom-0 left-0 w-3/5 h-3/5 rounded-[3rem] overflow-hidden border-4 border-misty-rose shadow-2xl z-30 hover:scale-105 transition duration-500">
                        <img src="{{ asset('images/Cosplayer-2.jpg') }}" alt="Cosplayer 2" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute top-1/2 left-1/4 text-sakura text-4xl animate-bounce z-40">✨</div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6 relative">
            <div class="max-w-7xl mx-auto space-y-24">
                <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
                    <div class="md:w-1/2 order-2 md:order-1">
                        <div class="glass-card p-10 md:p-14 rounded-[3rem] border-2 border-dark-chocolate/10 shadow-xl relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-sakura to-misty-rose rounded-[3rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                            <div class="relative">
                                <div class="w-16 h-16 bg-dark-chocolate text-misty-rose rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg rotate-3 group-hover:rotate-12 transition">👁️</div>
                                <h2 class="text-4xl font-bold text-dark-chocolate mb-6">Visi Kami</h2>
                                <p class="text-dark-chocolate/80 text-lg font-medium leading-relaxed">
                                    Menjadi platform nomor satu bagi komunitas kreatif di Indonesia, di mana teknologi dan seni peran bertemu untuk menciptakan ekosistem hobi yang transparan, aman, dan dapat diakses oleh siapa saja.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 order-1 md:order-2 hidden md:block">
                        <h3 class="text-5xl lg:text-7xl font-black text-dark-chocolate/40 leading-none select-none drop-shadow-sm">Melihat Ke<br>Masa Depan.</h3>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">
                    <div class="md:w-1/2 text-right hidden md:block">
                        <h3 class="text-5xl lg:text-7xl font-black text-dark-chocolate/40 leading-none select-none drop-shadow-sm">Langkah<br>Nyata Kami.</h3>
                    </div>
                    <div class="md:w-1/2">
                        <div class="bg-dark-chocolate text-misty-rose p-10 md:p-14 rounded-[3rem] shadow-2xl relative group transform hover:-translate-y-2 transition duration-500">
                            <div class="w-16 h-16 bg-sakura text-dark-chocolate rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg -rotate-3 group-hover:-rotate-12 transition">🎯</div>
                            <h2 class="text-4xl font-bold mb-6 text-misty-rose">Misi Utama</h2>
                            <ul class="space-y-5 opacity-90 text-lg font-medium">
                                <li class="flex items-start gap-4">
                                    <span class="text-sakura mt-1"><i class="fa-solid fa-check-circle"></i></span>
                                    <span>Membangun sistem reservasi cerdas anti double-booking untuk kenyamanan vendor dan penyewa.</span>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="text-sakura mt-1"><i class="fa-solid fa-check-circle"></i></span>
                                    <span>Menyediakan katalog transparan dengan standarisasi kualitas kostum yang ketat.</span>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="text-sakura mt-1"><i class="fa-solid fa-check-circle"></i></span>
                                    <span>Memberdayakan UMKM penyewa kostum lokal agar dapat menjangkau pasar nasional.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tim" class="py-24 px-6 max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <span class="text-sakura font-bold tracking-widest uppercase text-sm mb-4 block">Arsitek CosRent</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate">Pikiran di Balik Sistem</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                <div class="group relative rounded-[2.5rem] overflow-hidden h-[400px] md:h-[500px] shadow-xl border-4 border-misty-rose cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=600" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-chocolate via-dark-chocolate/50 to-transparent opacity-80 group-hover:opacity-95 transition duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 translate-y-12 group-hover:translate-y-0 transition duration-500">
                        <div class="w-12 h-12 bg-sakura text-dark-chocolate rounded-full flex items-center justify-center mb-4 opacity-0 group-hover:opacity-100 transition duration-500 delay-100 shadow-lg">
                            <i class="fa-solid fa-server"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-misty-rose mb-1">Rangga</h3>
                        <p class="text-sakura font-bold text-sm tracking-wide uppercase mb-4">Lead Programmer</p>
                        <p class="text-misty-rose/80 text-sm font-medium opacity-0 group-hover:opacity-100 transition duration-500 delay-200">
                            "Arsitek utama di balik layar. Bertanggung jawab merancang fondasi logika, keamanan database, dan memastikan seluruh sistem CosRent berjalan efisien tanpa celah."
                        </p>
                    </div>
                </div>

                <div class="group relative rounded-[2.5rem] overflow-hidden h-[400px] md:h-[500px] shadow-xl border-4 border-misty-rose cursor-pointer mt-0 md:mt-12">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=600" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-chocolate via-dark-chocolate/50 to-transparent opacity-80 group-hover:opacity-95 transition duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 translate-y-12 group-hover:translate-y-0 transition duration-500">
                        <div class="w-12 h-12 bg-aloewood text-misty-rose rounded-full flex items-center justify-center mb-4 opacity-0 group-hover:opacity-100 transition duration-500 delay-100 shadow-lg">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-misty-rose mb-1">Akbar</h3>
                        <p class="text-aloewood font-bold text-sm tracking-wide uppercase mb-4">Full-Stack Developer</p>
                        <p class="text-misty-rose/80 text-sm font-medium opacity-0 group-hover:opacity-100 transition duration-500 delay-200">
                            "Menjembatani antarmuka visual dengan mesin server. Memastikan aliran data dari database hingga ke layar pengguna tereksekusi dengan mulus, interaktif, dan responsif."
                        </p>
                    </div>
                </div>

                <div class="group relative rounded-[2.5rem] overflow-hidden h-[400px] md:h-[500px] shadow-xl border-4 border-misty-rose cursor-pointer mt-0 md:mt-24">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=600" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-chocolate via-dark-chocolate/50 to-transparent opacity-80 group-hover:opacity-95 transition duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 translate-y-12 group-hover:translate-y-0 transition duration-500">
                        <div class="w-12 h-12 bg-milk-tea text-dark-chocolate rounded-full flex items-center justify-center mb-4 opacity-0 group-hover:opacity-100 transition duration-500 delay-100 shadow-lg">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-misty-rose mb-1">Crist</h3>
                        <p class="text-milk-tea font-bold text-sm tracking-wide uppercase mb-4">Project Manager</p>
                        <p class="text-misty-rose/80 text-sm font-medium opacity-0 group-hover:opacity-100 transition duration-500 delay-200">
                            "Nahkoda yang memastikan setiap baris kode sejalan dengan visi PBL. Mengarahkan tim, mengelola timeline, dan mengubah ide abstrak menjadi produk nyata yang berkualitas."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-6">
            <div class="max-w-5xl mx-auto glass-card rounded-[3rem] p-10 md:p-16 text-center border-2 border-sakura/30 shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 bg-sakura/5"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-dark-chocolate mb-6">Siap Memulai Petualangan Barumu?</h2>
                    <p class="text-dark-chocolate/80 mb-10 max-w-2xl mx-auto font-medium text-lg">Bergabunglah dengan CosRent hari ini. Ribuan kostum menunggu untuk dihidupkan oleh imajinasimu.</p>
                    @guest
                        <a href="{{ route('register') }}" class="inline-block bg-sakura text-dark-chocolate px-10 py-4 rounded-full font-bold text-lg hover:bg-dark-chocolate hover:text-sakura transition duration-300 shadow-xl">
                            Buat Akun Sekarang
                        </a>
                    @else
                        <a href="{{ route('product') }}" class="inline-block bg-dark-chocolate text-misty-rose px-10 py-4 rounded-full font-bold text-lg hover:bg-black transition duration-300 shadow-xl">
                            Jelajahi Katalog
                        </a>
                    @endguest
                </div>
            </div>
        </section>
    </main>
@endsection
