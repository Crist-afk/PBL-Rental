@extends('layouts.app')

@section('title', 'Tentang Kami - CosRent')

@push('styles')
    <style>
        .reveal {
            opacity: 0;
            transform: translateY(60px);
            transition: all 0.9s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left { transform: translateX(-60px) translateY(0); }
        .reveal-right { transform: translateX(60px) translateY(0); }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
    </style>
@endpush

@section('content')
    <main class="flex-grow w-full overflow-hidden bg-misty-rose relative">

        <div class="absolute inset-0 z-0 opacity-[0.15] mix-blend-color-burn pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1522383225653-ed111181a951?q=80&w=2000&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed;"></div>

        <section class="relative min-h-screen flex items-center justify-center pt-24 pb-12 px-6">
            <div class="max-w-7xl mx-auto w-full flex flex-col md:flex-row items-center relative z-10 gap-10">

                <div class="w-full md:w-1/2 flex flex-col justify-center relative z-20 reveal">
                    <span class="text-aloewood font-bold tracking-[0.3em] uppercase text-xs md:text-sm mb-4 block">CosRent Studio</span>

                    <div class="relative inline-block">
                        <h1 class="text-[5rem] md:text-[6.5rem] lg:text-[8rem] font-black text-dark-chocolate leading-[0.85] tracking-tighter uppercase relative z-20">
                            LESS IS<br>
                            <span class="text-sakura drop-shadow-md">MORE.</span>
                        </h1>
                    </div>

                    <p class="text-dark-chocolate/80 text-lg font-medium mt-8 max-w-md leading-relaxed border-l-4 border-sakura pl-4 backdrop-blur-sm bg-white/20 p-2 rounded-r-xl">
                        Bukan sekadar penyewaan. Kami adalah panggung bagi para kreator untuk mengekspresikan karakter impian dengan kualitas premium dan kesederhanaan.
                    </p>

                    <div class="mt-10 flex items-center gap-6">
                        <a href="#tim" class="group relative px-8 py-4 bg-dark-chocolate text-misty-rose font-bold rounded-full overflow-hidden shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
                            <span class="relative z-10 group-hover:text-dark-chocolate transition-colors duration-500">Kenali Tim Kami</span>
                            <div class="absolute inset-0 bg-sakura transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        </a>
                        <div class="flex items-center gap-3 bg-white/40 px-4 py-2 rounded-2xl backdrop-blur-sm border border-white/50">
                            <span class="text-3xl font-black text-dark-chocolate">5K+</span>
                            <span class="text-[10px] font-bold text-aloewood uppercase tracking-widest leading-tight">Cosplayer<br>Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative flex justify-center md:justify-end mt-24 md:mt-0 h-[450px] md:h-[600px] reveal delay-200">

                    <div class="absolute w-[300px] h-[300px] md:w-[450px] md:h-[450px] bg-sakura rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-0 animate-pulse shadow-[0_0_50px_rgba(255,183,197,0.5)]"></div>

                    <div class="absolute z-10 w-[200px] h-[300px] md:w-[280px] md:h-[400px] right-0 md:right-4 top-0 overflow-hidden rounded-[3rem] border-4 border-misty-rose shadow-2xl hover:z-30 transform transition-all duration-500 hover:scale-105 group cursor-pointer bg-dark-chocolate">
                        <img src="{{ asset('images/Cosplayer-1.jpg') }}" alt="Cosplayer 1" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-90 group-hover:opacity-100">
                    </div>

                    <div class="absolute z-20 w-[180px] h-[260px] md:w-[240px] md:h-[340px] left-4 md:left-12 bottom-10 md:bottom-20 overflow-hidden rounded-[3rem] border-4 border-misty-rose shadow-2xl hover:z-30 transform transition-all duration-500 hover:scale-105 group cursor-pointer bg-dark-chocolate">
                        <img src="{{ asset('images/Cosplayer-2.jpg') }}" alt="Cosplayer 2" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-90 group-hover:opacity-100">
                    </div>

                    <div class="absolute bottom-0 right-1/4 text-sakura text-4xl animate-bounce z-40 drop-shadow-lg">✨</div>
                </div>

            </div>
        </section>

        <section class="py-32 px-6 bg-white relative z-10 rounded-t-[4rem] shadow-[0_-20px_50px_rgba(0,0,0,0.05)]">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-20">
                <div class="md:w-1/2 reveal reveal-left">
                    <span class="text-sakura font-bold tracking-widest uppercase text-xs mb-2 block">01 / Visi</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Melihat Ke<br>Masa Depan.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        Menjadi platform nomor satu bagi komunitas kreatif di Indonesia, di mana teknologi dan seni peran bertemu untuk menciptakan ekosistem hobi yang transparan, aman, dan dapat diakses oleh siapa saja.
                    </p>
                </div>
                <div class="md:w-1/2 reveal reveal-right delay-200">
                    <span class="text-aloewood font-bold tracking-widest uppercase text-xs mb-2 block">02 / Misi</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Langkah<br>Nyata Kami.</h2>
                    <ul class="space-y-6 text-dark-chocolate/70 text-lg font-medium border-t-2 border-dark-chocolate/10 pt-6">
                        <li class="flex items-start gap-4">
                            <span class="text-sakura font-black text-xl">.</span>
                            <span>Membangun sistem reservasi cerdas anti double-booking.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="text-sakura font-black text-xl">.</span>
                            <span>Menyediakan katalog transparan dengan standarisasi kualitas.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="text-sakura font-black text-xl">.</span>
                            <span>Memberdayakan UMKM penyewa kostum lokal ke pasar nasional.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="tim" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute top-10 left-0 w-full overflow-hidden opacity-5 pointer-events-none select-none">
                <h2 class="text-[12rem] md:text-[15rem] font-black whitespace-nowrap leading-none">CREATORS.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="text-center mb-24 reveal">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Arsitek CosRent</span>
                    <h2 class="text-5xl md:text-6xl font-black text-white">Pikiran di Balik Sistem.</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-8">
                    <div class="group flex flex-col items-center cursor-pointer reveal delay-100">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-sakura rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Rangga</h3>
                        <p class="text-sakura font-bold text-xs tracking-widest uppercase mb-4">Lead Programmer</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Fondasi logika & keamanan database. Memastikan sistem CosRent berjalan tanpa celah.
                        </p>
                    </div>

                    <div class="group flex flex-col items-center md:translate-y-12 cursor-pointer reveal delay-200">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-aloewood rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Akbar</h3>
                        <p class="text-aloewood font-bold text-xs tracking-widest uppercase mb-4">Full-Stack Dev</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Menjembatani antarmuka visual dengan mesin server agar mulus & responsif.
                        </p>
                    </div>

                    <div class="group flex flex-col items-center cursor-pointer reveal delay-300">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-milk-tea rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=600" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Crist</h3>
                        <p class="text-milk-tea font-bold text-xs tracking-widest uppercase mb-4">Project Manager</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Nahkoda visi PBL. Mengarahkan tim & mengubah ide abstrak menjadi produk nyata.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 bg-misty-rose flex justify-center relative reveal">
            <div class="text-center relative z-10 bg-white/40 backdrop-blur-md p-14 rounded-[3rem] border border-white/50 shadow-xl">
                <h2 class="text-4xl md:text-6xl font-black text-dark-chocolate mb-4">Mulai Sekarang.</h2>
                <p class="text-dark-chocolate/70 mb-10 font-medium text-lg">Ribuan kostum menunggu untuk dihidupkan.</p>
                <a href="{{ route('register') }}" class="inline-block bg-dark-chocolate text-misty-rose px-12 py-5 rounded-full font-bold text-lg hover:bg-sakura hover:text-dark-chocolate transition-all duration-300 shadow-2xl hover:-translate-y-1">
                    Buat Akun Cosplay
                </a>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengambil semua elemen dengan class 'reveal'
            const reveals = document.querySelectorAll(".reveal");

            // Membuat sensor pengamat scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    // Jika elemen masuk ke dalam layar
                    if (entry.isIntersecting) {
                        entry.target.classList.add("active"); // Tambahkan class active untuk memicu animasi CSS
                    }
                });
            }, {
                threshold: 0.1, // Berjalan saat 10% elemen terlihat
                rootMargin: "0px 0px -50px 0px" // Sedikit margin agar animasi muncul sebelum terlalu bawah
            });

            // Menempelkan sensor ke semua elemen 'reveal'
            reveals.forEach(reveal => {
                observer.observe(reveal);
            });
        });
    </script>
@endpush
