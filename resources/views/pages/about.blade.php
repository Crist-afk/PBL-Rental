@extends('layouts.app')

@section('title', 'Tentang Kami - CosRent')

@push('styles')
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
                            SEWA KOSTUM COSPLAY<br>
                            <span class="text-sakura drop-shadow-md">JADI LEBIH MUDAH.</span>
                        </h1>
                    </div>

                    <p class="text-dark-chocolate/85 text-xl md:text-2xl font-semibold mt-6 max-w-xl leading-snug">
                        CosRent membantu kamu menemukan, memilih, dan menyewa kostum cosplay dengan informasi yang jelas dari awal.
                    </p>

                    <p class="text-dark-chocolate/80 text-lg font-medium mt-6 max-w-xl leading-relaxed border-l-4 border-sakura pl-4 backdrop-blur-sm bg-white/20 p-2 rounded-r-xl">
                        Lihat katalog kostum, cek detail ukuran, pilih jadwal sewa, lalu ikuti proses pemesanan dengan lebih tenang.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3 text-[11px] font-bold uppercase tracking-[0.18em] text-dark-chocolate/70">
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Katalog Kostum</span>
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Ukuran Jelas</span>
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Jadwal Sewa</span>
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-6">
                        <a href="{{ route('products.index') }}" class="group relative px-8 py-4 bg-dark-chocolate text-misty-rose font-bold rounded-full overflow-hidden shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
                            <span class="relative z-10 group-hover:text-dark-chocolate transition-colors duration-500">Lihat Katalog</span>
                            <div class="absolute inset-0 bg-sakura transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white/50 text-dark-chocolate font-bold rounded-full border border-white/60 backdrop-blur-sm shadow-lg transition-all hover:bg-sakura hover:-translate-y-1">
                            Daftar Sekarang
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
                    <span class="text-sakura font-bold tracking-widest uppercase text-xs mb-2 block">01 / Kenapa CosRent Hadir?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Mencari kostum cosplay seharusnya terasa seru, bukan membingungkan.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        Banyak calon penyewa perlu bertanya berkali-kali soal ukuran, kelengkapan, harga, dan jadwal sewa. CosRent hadir agar informasi penting bisa dilihat lebih cepat sebelum kamu memutuskan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/40 p-8 shadow-lg reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-black text-sm tracking-[0.25em] uppercase">01</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Pilihan kostum sering tersebar</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Foto, harga, ukuran, dan kelengkapan kostum tidak selalu mudah dibandingkan saat informasinya ada di banyak tempat.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-black text-sm tracking-[0.25em] uppercase">02</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Jadwal sewa perlu kepastian</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Penyewa ingin tahu apakah kostum yang diincar tersedia di tanggal yang dibutuhkan tanpa proses tanya-jawab yang panjang.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/40 p-8 shadow-lg reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-black text-sm tracking-[0.25em] uppercase">03</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Komunitas butuh ruang berbagi</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Cosplayer juga butuh tempat untuk bertanya, berbagi pengalaman, dan saling menemukan inspirasi kostum berikutnya.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="solusi" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-full overflow-hidden opacity-5 pointer-events-none select-none text-right">
                <h2 class="text-[10rem] md:text-[14rem] font-black whitespace-nowrap leading-none">COSRENT.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row gap-16 items-start">
                <div class="md:w-5/12 reveal" data-reveal="left">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">02 / Apa yang Bisa Kamu Lakukan di CosRent?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">Mulai dari cari kostum sampai melihat riwayat sewa, semuanya dibuat lebih mudah diikuti.</h2>
                    <p class="text-misty-rose/75 text-lg font-medium leading-relaxed border-t-2 border-white/10 pt-6">
                        CosRent membantu pengunjung memilih kostum dengan informasi yang jelas, membuat pemesanan online, dan ikut berinteraksi lewat forum cosplay.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-10">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">Mudah</p>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sakura mt-2">Cari, pilih, dan pesan</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">Jelas</p>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-aloewood mt-2">Ukuran, detail, jadwal</p>
                        </div>
                    </div>
                </div>

                <div class="md:w-7/12 grid gap-6 w-full">
                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Temukan kostum</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Jelajahi katalog cosplay dan lihat detail kostum sebelum memilih.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            Kamu bisa melihat karakter, foto kostum, ukuran, harga, dan kelengkapan agar pilihan terasa lebih percaya diri.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Pesan online</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Pilih jadwal sewa dan lanjutkan pemesanan tanpa proses yang berbelit.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            Informasi sewa dibuat lebih runtut sehingga kamu tahu langkah berikutnya setelah menemukan kostum yang cocok.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-bold tracking-[0.2em] uppercase text-xs">Ikut komunitas</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Gunakan forum cosplay untuk berbagi cerita, bertanya, dan mencari inspirasi.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            CosRent bukan hanya tempat menyewa kostum, tetapi juga ruang kecil untuk bertemu sesama penggemar cosplay.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 bg-white relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-3xl reveal" data-reveal="up">
                    <span class="text-aloewood font-bold tracking-widest uppercase text-xs mb-2 block">03 / Fitur Utama</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Hal penting yang kamu butuhkan sebelum dan sesudah menyewa kostum.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        Fitur CosRent dibuat sederhana agar pengunjung bisa melihat pilihan, memahami detail, memesan, dan ikut berdiskusi dengan komunitas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mt-16">
                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Katalog Kostum</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Cari kostum favorit lebih cepat</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Lihat pilihan kostum cosplay dengan informasi karakter, foto, harga, dan kelengkapan.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Detail Ukuran</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Pahami ukuran sebelum pesan</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Detail ukuran dan kelengkapan membantu kamu memilih kostum yang paling sesuai.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-bold tracking-[0.2em] uppercase text-xs">Pemesanan Online</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Pilih jadwal dan ajukan sewa</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Proses sewa dibuat lebih praktis dari pemilihan kostum sampai pengajuan pemesanan.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-500" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Riwayat Sewa</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Cek pesanan yang pernah dibuat</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Setelah menyewa, kamu bisa melihat kembali riwayat sewa dan detail pesanan.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-500" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Forum Cosplay</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Berbagi cerita dengan komunitas</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Ikut diskusi, tanya rekomendasi, dan temukan inspirasi bersama penggemar cosplay lain.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="tim" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute top-10 left-0 w-full overflow-hidden opacity-5 pointer-events-none select-none">
                <h2 class="text-[12rem] md:text-[15rem] font-black whitespace-nowrap leading-none">TIM.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="text-center mb-24 reveal" data-reveal="up">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">Tim CosRent</span>
                    <h2 class="text-5xl md:text-6xl font-black text-white">Tim Pengembang CosRent</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-8">
                    <div class="group flex flex-col items-center cursor-pointer reveal delay-100" data-reveal="up">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-sakura rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="{{ asset('images/rangga-minato.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Rangga</h3>
                        <p class="text-sakura font-bold text-xs tracking-widest uppercase mb-4">Pemrogram Utama</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Mengembangkan fitur utama agar pengalaman sewa di CosRent berjalan lebih rapi dan nyaman digunakan.
                        </p>
                    </div>

                    <div class="group flex flex-col items-center md:mt-12 cursor-pointer reveal delay-200" data-reveal="up">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-aloewood rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="{{ asset('images/Vergil_Akbar.png') }}" class="w-full h-full object-cover object-top grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Akbar</h3>
                        <p class="text-aloewood font-bold text-xs tracking-widest uppercase mb-4">Pengembang Full-Stack</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Menghubungkan tampilan website dengan kebutuhan pengguna agar proses jelajah dan sewa terasa lancar.
                        </p>
                    </div>

                    <div class="group flex flex-col items-center cursor-pointer reveal delay-300" data-reveal="up">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-milk-tea rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="{{ asset('images/crist-uciha.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Crist</h3>
                        <p class="text-milk-tea font-bold text-xs tracking-widest uppercase mb-4">Manajer Proyek</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Mengarahkan pengembangan produk agar CosRent tetap sesuai dengan kebutuhan penyewa dan komunitas cosplay.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 bg-misty-rose flex flex-col items-center justify-center relative reveal" data-reveal="up">
            <div class="text-center mt-16 mb-10 max-w-2xl relative z-10">
                 <h3 class="text-3xl font-bold text-dark-chocolate mb-4">
                    Siap menemukan kostum cosplay berikutnya?
                </h3>
                <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed">
                    Jelajahi katalog, buat akun untuk mulai menyewa, lalu bergabung di forum untuk berbagi inspirasi dengan komunitas cosplay.
                </p>
            </div>
            <div class="text-center relative z-10 bg-white/40 backdrop-blur-md p-14 rounded-[3rem] border border-white/50 shadow-xl">
                <h2 class="text-4xl md:text-6xl font-black text-dark-chocolate mb-4">Mulai Sekarang.</h2>
                <p class="text-dark-chocolate/70 mb-10 font-medium text-lg">Katalog, akun, dan komunitas CosRent siap kamu jelajahi.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="inline-block bg-dark-chocolate text-misty-rose px-8 py-4 rounded-full font-bold text-lg hover:bg-sakura hover:text-dark-chocolate transition-all duration-300 shadow-2xl hover:-translate-y-1">
                        Lihat Katalog
                    </a>
                    <a href="{{ route('register') }}" class="inline-block bg-sakura text-dark-chocolate px-8 py-4 rounded-full font-bold text-lg hover:bg-dark-chocolate hover:text-misty-rose transition-all duration-300 shadow-2xl hover:-translate-y-1">
                        Buat Akun
                    </a>
                    <a href="{{ route('forum') }}" class="inline-block bg-white/60 text-dark-chocolate px-8 py-4 rounded-full font-bold text-lg border border-white/60 hover:bg-aloewood hover:text-misty-rose transition-all duration-300 shadow-2xl hover:-translate-y-1">
                        Gabung Forum
                    </a>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
@endpush
