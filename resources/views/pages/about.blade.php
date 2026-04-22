@extends('layouts.app')

@section('title', 'Tentang Kami - CosRent')

@push('styles')
    <style>
        .reveal {
            opacity: 0;
            transition: opacity 0.9s cubic-bezier(0.5, 0, 0, 1), transform 0.9s cubic-bezier(0.5, 0, 0, 1);
        }

        .reveal[data-reveal="up"] {
            transform: translateY(60px);
        }

        .reveal[data-reveal="left"] {
            transform: translateX(-60px);
        }

        .reveal[data-reveal="right"] {
            transform: translateX(60px);
        }

        .reveal.active {
            opacity: 1;
            transform: translate(0, 0);
        }
    </style>
@endpush

@section('content')
    <main class="flex-grow w-full overflow-hidden bg-misty-rose relative">

        <div class="absolute inset-0 z-0 opacity-[0.15] mix-blend-color-burn pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1522383225653-ed111181a951?q=80&w=2000&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed;"></div>

        <section class="relative min-h-screen flex items-center justify-center pt-24 pb-12 px-6">
            <div class="max-w-7xl mx-auto w-full flex flex-col md:flex-row items-center relative z-10 gap-10">

                <div class="w-full md:w-1/2 flex flex-col justify-center relative z-20 reveal" data-reveal="up">
                    <span class="text-aloewood font-bold tracking-[0.3em] uppercase text-xs md:text-sm mb-4 block">Platform Rental Cosplay</span>

                    <div class="relative inline-block">
                        <h1 class="text-[4rem] md:text-[5.5rem] lg:text-[7rem] font-black text-dark-chocolate leading-[0.88] tracking-tighter uppercase relative z-20">
                            SEWA KOSTUM<br>
                            <span class="text-sakura drop-shadow-md">TANPA DOUBLE BOOKING.</span>
                        </h1>
                    </div>

                    <p class="text-dark-chocolate/85 text-xl md:text-2xl font-semibold mt-6 max-w-xl leading-snug">
                        CosRent adalah platform rental cosplay untuk mengelola stok, ukuran, dan jadwal booking dalam satu alur yang lebih jelas.
                    </p>

                    <p class="text-dark-chocolate/80 text-lg font-medium mt-6 max-w-xl leading-relaxed border-l-4 border-sakura pl-4 backdrop-blur-sm bg-white/20 p-2 rounded-r-xl">
                        Dari cek ketersediaan sampai konfirmasi sewa, CosRent membantu tim rental dan pelanggan mengambil keputusan lebih cepat tanpa bergantung pada catatan manual yang rawan tertukar.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3 text-[11px] font-bold uppercase tracking-[0.18em] text-dark-chocolate/70">
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Stok Terpantau</span>
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Ukuran Lebih Jelas</span>
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Jadwal Lebih Aman</span>
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-6">
                        <a href="#solusi" class="group relative px-8 py-4 bg-dark-chocolate text-misty-rose font-bold rounded-full overflow-hidden shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
                            <span class="relative z-10 group-hover:text-dark-chocolate transition-colors duration-500">Lihat Solusi CosRent</span>
                            <div class="absolute inset-0 bg-sakura transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        </a>
                        <div class="flex items-center gap-3 bg-white/40 px-4 py-2 rounded-2xl backdrop-blur-sm border border-white/50">
                            <span class="text-3xl font-black text-dark-chocolate">5K+</span>
                            <span class="text-[10px] font-bold text-aloewood uppercase tracking-widest leading-tight">Cosplayer<br>Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative flex justify-center md:justify-end mt-24 md:mt-0 h-[450px] md:h-[600px] reveal delay-200" data-reveal="up">

                    <div class="absolute w-[300px] h-[300px] md:w-[450px] md:h-[450px] bg-sakura rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-0 animate-pulse shadow-[0_0_50px_rgba(255,183,197,0.5)]"></div>

                    <div class="absolute z-10 w-[200px] h-[300px] md:w-[280px] md:h-[400px] right-0 md:right-4 top-0 overflow-hidden rounded-[3rem] border-4 border-misty-rose shadow-2xl hover:z-30 transform transition-all duration-500 hover:scale-105 group cursor-pointer bg-dark-chocolate">
                        <img src="{{ asset('images/Cosplayer-1.jpg') }}" alt="Cosplayer 1" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-90 group-hover:opacity-100">
                    </div>

                    <div class="absolute z-20 w-[180px] h-[260px] md:w-[240px] md:h-[340px] left-4 md:left-12 bottom-10 md:bottom-20 overflow-hidden rounded-[3rem] border-4 border-misty-rose shadow-2xl hover:z-30 transform transition-all duration-500 hover:scale-105 group cursor-pointer bg-dark-chocolate">
                        <img src="{{ asset('images/Cosplayer-2.jpg') }}" alt="Cosplayer 2" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-90 group-hover:opacity-100">
                    </div>

                    <div class="absolute bottom-0 right-1/4 text-sakura text-4xl animate-bounce z-40 drop-shadow-lg">&#10024;</div>
                </div>

            </div>
        </section>

        <section class="py-32 px-6 bg-white relative z-10 rounded-t-[4rem] shadow-[0_-20px_50px_rgba(0,0,0,0.05)]">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-3xl reveal" data-reveal="up">
                    <span class="text-sakura font-bold tracking-widest uppercase text-xs mb-2 block">01 / Problem</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Masalah rental kostum biasanya muncul saat semuanya masih dicatat manual.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        Saat permintaan meningkat, tim rental harus menjaga jadwal, stok, dan ukuran tetap sinkron. Tanpa alur yang rapi, kesalahan kecil cepat berubah menjadi pengalaman buruk bagi pelanggan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/40 p-8 shadow-lg reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-black text-sm tracking-[0.25em] uppercase">01</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Double booking mudah terjadi</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Reservasi dari chat, DM, dan catatan manual membuat satu kostum berisiko disewakan ke dua pelanggan pada tanggal yang berdekatan.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-black text-sm tracking-[0.25em] uppercase">02</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Inventaris sulit dibaca cepat</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Detail karakter, kondisi kostum, dan status ketersediaan sering tersebar di banyak tempat sehingga tim harus mengecek berulang kali.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/40 p-8 shadow-lg reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-black text-sm tracking-[0.25em] uppercase">03</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Sizing sering baru jelas di akhir</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Pelanggan kerap harus bertanya ulang soal ukuran, detail fitting, atau kelengkapan kostum sebelum berani lanjut ke booking.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="solusi" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-full overflow-hidden opacity-5 pointer-events-none select-none text-right">
                <h2 class="text-[10rem] md:text-[14rem] font-black whitespace-nowrap leading-none">SYSTEM.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row gap-16 items-start">
                <div class="md:w-5/12 reveal" data-reveal="left">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">02 / Solution</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">CosRent menata proses sewa menjadi alur yang lebih pasti.</h2>
                    <p class="text-misty-rose/75 text-lg font-medium leading-relaxed border-t-2 border-white/10 pt-6">
                        Kami tidak hanya menampilkan katalog. CosRent dirancang untuk membantu rental cosplay menjaga informasi tetap rapi, memandu pelanggan memilih dengan lebih percaya diri, dan membuat proses booking terasa lebih jelas dari awal.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-10">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">1 Alur</p>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sakura mt-2">Untuk stok, ukuran, booking</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">Lebih cepat</p>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-aloewood mt-2">Saat cek ketersediaan dan detail</p>
                        </div>
                    </div>
                </div>

                <div class="md:w-7/12 grid gap-6 w-full">
                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Reservasi yang lebih terbaca</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Ketersediaan kostum ditampilkan lebih jelas sebelum pelanggan memutuskan booking.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            Tim rental tidak perlu terus memverifikasi ulang dari percakapan yang tersebar. Alur yang lebih rapi membantu mengurangi risiko jadwal tumpang tindih.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Inventaris yang lebih tertata</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Detail karakter, kondisi, dan kebutuhan pelanggan dapat dirujuk dari satu pengalaman yang sama.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            Semakin sedikit informasi yang tercecer, semakin cepat tim bisa fokus pada pelayanan dan kualitas rental, bukan pada pencarian data.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-bold tracking-[0.2em] uppercase text-xs">Kepastian sebelum checkout</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Informasi ukuran dan konteks produk tampil lebih awal agar pelanggan tidak ragu di langkah terakhir.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            CosRent membantu memperpendek proses tanya-jawab yang berulang sehingga pengalaman sewa terasa lebih cepat, jelas, dan profesional.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 bg-white relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-3xl reveal" data-reveal="up">
                    <span class="text-aloewood font-bold tracking-widest uppercase text-xs mb-2 block">03 / Feature Highlights</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Fitur yang membuat pengalaman sewa terasa lebih terarah.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        Semua dirancang untuk membantu pelanggan membaca informasi lebih cepat sekaligus memberi tim rental alur yang lebih mudah dikelola.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-16">
                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Booking System</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Jadwal booking langsung terbaca</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Tanggal sewa dan status kostum bisa dicek lebih cepat sebelum reservasi dikunci.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Inventory</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Stok dan detail kostum lebih rapi</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Karakter, kondisi, dan ketersediaan tersusun dalam satu alur yang mudah dipantau tim rental.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-bold tracking-[0.2em] uppercase text-xs">Size & Fit</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Ukuran tampil sebelum pelanggan ragu</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Informasi fit dan detail ukuran muncul lebih awal saat pelanggan memilih kostum.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-500" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Status Flow</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Proses sewa tetap mudah diikuti</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Dari pilih kostum sampai riwayat booking, pelanggan bisa melihat progresnya dengan lebih jelas.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="tim" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute top-10 left-0 w-full overflow-hidden opacity-5 pointer-events-none select-none">
                <h2 class="text-[12rem] md:text-[15rem] font-black whitespace-nowrap leading-none">CREATORS.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="text-center mb-24 reveal" data-reveal="up">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Arsitek CosRent</span>
                    <h2 class="text-5xl md:text-6xl font-black text-white">Pikiran di Balik Sistem.</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-8">
                    <div class="group flex flex-col items-center cursor-pointer reveal delay-100" data-reveal="up">
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

                    <div class="group flex flex-col items-center md:mt-12 cursor-pointer reveal delay-200" data-reveal="up">
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

                    <div class="group flex flex-col items-center cursor-pointer reveal delay-300" data-reveal="up">
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

        <section class="py-32 px-6 bg-misty-rose flex flex-col items-center justify-center relative reveal" data-reveal="up">
            <div class="text-center mt-16 mb-10 max-w-2xl relative z-10">
                 <h3 class="text-3xl font-bold text-dark-chocolate mb-4">
                    Saatnya pindah ke alur rental yang lebih rapi.
                </h3>
                <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed">
                    Jika stok, ukuran, dan booking bisa dibaca dalam satu tempat, tim rental bergerak lebih cepat dan pelanggan bisa menyewa dengan lebih yakin.
                </p>
            </div>
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
    <script src="{{ asset('js/about.js') }}"></script>
@endpush
