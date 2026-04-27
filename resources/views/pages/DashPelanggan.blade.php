@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">

        <!-- Greeting -->
        <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-8 md:px-10 md:py-10 shadow-xl text-center md:text-left">
            <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood">Area Dasbor</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate">Selamat Datang, {{ auth()->user()->nama ?? 'Pelanggan' }}! 👋</h1>
            <p class="mt-4 text-base font-medium leading-relaxed text-dark-chocolate/75 md:text-lg max-w-3xl">Ini adalah pusat kendali akunmu. Lihat status persewaan aktif, riwayat transaksi, dan temukan kostum incaranmu berikutnya.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-aloewood">Sedang Disewa</p>
                        <p class="text-4xl font-extrabold mt-3 text-dark-chocolate">{{ $stats['active_rentals'] ?? 3 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-sakura/20 rounded-[1.2rem] flex items-center justify-center text-2xl text-sakura"><i class="fa-solid fa-bag-shopping"></i></div>
                </div>
                <p class="text-xs font-bold text-green-600 mt-5 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> +1 minggu ini
                </p>
            </div>

            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-aloewood">Total Penyewaan</p>
                        <p class="text-4xl font-extrabold mt-3 text-dark-chocolate">{{ $stats['total_rentals'] ?? 17 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-aloewood/20 rounded-[1.2rem] flex items-center justify-center text-2xl text-aloewood"><i class="fa-solid fa-box-open"></i></div>
                </div>
                <p class="text-xs font-bold text-dark-chocolate/60 mt-5">Sejak bergabung</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Kostum Sedang Disewa -->
            <div class="lg:col-span-7 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-dark-chocolate">Kostum Sedang Disewa</h2>
                    <a href="{{ route('products.index') }}" class="text-sm font-bold text-sakura hover:text-aloewood transition flex items-center gap-2">
                        Sewa Kostum Lain <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($current_rentals ?? [] as $rental)
                    <article class="glass-card rounded-[2rem] p-5 flex flex-col sm:flex-row gap-5 items-start sm:items-center border-2 border-dark-chocolate/10 shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                        <div class="w-full sm:w-24 h-40 sm:h-24 {{ $rental['color'] ?? 'bg-dark-chocolate' }} rounded-[1.5rem] flex-shrink-0 overflow-hidden">
                            @if(isset($rental['image']))
                                <img src="{{ $rental['image'] }}" alt="{{ $rental['title'] }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 w-full">
                            <h3 class="font-bold text-xl text-dark-chocolate line-clamp-1">{{ $rental['title'] }}</h3>
                            <p class="text-sm font-bold text-aloewood mt-1 uppercase tracking-wide">Ukuran {{ $rental['size'] }}</p>
                            <p class="text-xs font-medium text-dark-chocolate/70 mt-1"><i class="fa-regular fa-clock mr-1"></i> Kembali {{ $rental['return_date'] }}</p>
                        </div>
                        <div class="text-left sm:text-right w-full sm:w-auto flex justify-between sm:block border-t sm:border-0 border-dark-chocolate/10 pt-4 sm:pt-0 mt-4 sm:mt-0 gap-4">
                            <div>
                                <span class="block text-[10px] font-bold text-dark-chocolate/60 uppercase tracking-widest">Total Harga</span>
                                <span class="font-bold text-xl text-dark-chocolate">Rp {{ number_format($rental['price'], 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('riwayat.faktur', $rental['id']) }}" class="bg-dark-chocolate text-misty-rose px-6 py-2.5 rounded-full text-sm font-bold hover:bg-black transition sm:mt-3 whitespace-nowrap inline-flex items-center justify-center">
                                <i class="fa-solid fa-receipt mr-1"></i> Detail
                            </a>
                        </div>
                    </article>
                    @empty
                        <div class="rounded-[2.5rem] border-2 border-dashed border-dark-chocolate/15 bg-white/50 px-6 py-12 text-center shadow-sm">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sakura/20 text-2xl text-dark-chocolate mb-4">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <h3 class="text-xl font-bold text-dark-chocolate">Belum ada kostum yang disewa.</h3>
                            <p class="mt-2 text-sm font-medium text-dark-chocolate/70">Mulai petualangan cosplay-mu dengan menyewa kostum sekarang!</p>
                            <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-dark-chocolate text-misty-rose px-8 py-3 rounded-full text-sm font-bold hover:bg-black transition">
                                Lihat Katalog
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-5 space-y-8">

                <!-- Menu Khusus Pelanggan -->
                <div class="glass-card rounded-[2rem] p-6 md:p-8 border-2 border-dark-chocolate/10 shadow-xl">
                    <h3 class="font-bold text-xl mb-6 text-dark-chocolate"><i class="fa-solid fa-user-gear text-sakura mr-2"></i>Menu Pelanggan</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('booking.index') }}" class="glass-card hover:bg-dark-chocolate hover:border-dark-chocolate hover:text-misty-rose transition p-4 rounded-[1.5rem] flex items-center gap-4 border-2 border-dark-chocolate/10 group">
                            <div class="w-12 h-12 bg-sakura/20 rounded-xl flex items-center justify-center text-xl text-sakura group-hover:bg-sakura group-hover:text-dark-chocolate transition">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Formulir Pemesanan</p>
                                <p class="text-[10px] opacity-70">Pesan kostum sekarang</p>
                            </div>
                        </a>
                        <a href="{{ route('riwayat.index') }}" class="glass-card hover:bg-dark-chocolate hover:border-dark-chocolate hover:text-misty-rose transition p-4 rounded-[1.5rem] flex items-center gap-4 border-2 border-dark-chocolate/10 group">
                            <div class="w-12 h-12 bg-aloewood/20 rounded-xl flex items-center justify-center text-xl text-aloewood group-hover:bg-aloewood group-hover:text-dark-chocolate transition">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Riwayat Sewa</p>
                                <p class="text-[10px] opacity-70">Lihat semua transaksi</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Info Denda -->
                <div class="glass-card rounded-[2rem] p-6 border-2 border-red-500/20 bg-red-500/5 shadow-xl">
                    <h3 class="font-bold text-lg text-red-600 flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-circle-exclamation"></i> Informasi Denda Keterlambatan
                    </h3>
                    <p class="text-sm font-medium text-dark-chocolate/80 leading-relaxed">
                        Keterlambatan pengembalian kostum akan dikenakan denda sebesar <span class="font-bold text-red-600">Rp 50.000 / hari</span>. Harap kembalikan tepat waktu!
                    </p>
                </div>

                <!-- Riwayat Terbaru -->
                <div class="glass-card rounded-[2rem] p-6 md:p-8 border-2 border-dark-chocolate/10 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-xl text-dark-chocolate"><i class="fa-solid fa-clock-rotate-left text-aloewood mr-2"></i>Riwayat</h3>
                        <a href="{{ route('riwayat.index') }}" class="text-xs font-bold text-sakura hover:text-dark-chocolate transition">Lihat Semua</a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($recent_history ?? [] as $history)
                        <div class="flex justify-between items-start border-b border-dark-chocolate/10 pb-4 last:border-0 last:pb-0">
                            <div>
                                <p class="font-bold text-sm text-dark-chocolate">{{ $history['title'] }}</p>
                                <p class="text-xs font-medium text-dark-chocolate/60 mt-1">{{ $history['date'] }} • Rp {{ number_format($history['price'], 0, ',', '.') }}</p>
                            </div>
                            <span class="bg-green-100 border border-green-200 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">{{ $history['status'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Rekomendasi -->
                <div class="glass-card rounded-[2rem] p-6 md:p-8 border-2 border-dark-chocolate/10 shadow-xl">
                    <h3 class="font-bold text-xl mb-6 text-dark-chocolate"><i class="fa-solid fa-star text-yellow-500 mr-2"></i>Rekomendasi</h3>
                    <div class="flex gap-4 overflow-x-auto pb-2 snap-x">
                        @foreach($recommendations ?? [] as $rec)
                        <div class="min-w-[150px] snap-start bg-white/50 rounded-[1.5rem] overflow-hidden border-2 border-dark-chocolate/10 transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="h-28 {{ $rec['color'] }} overflow-hidden">
                                @if(isset($rec['image']))
                                    <img src="{{ $rec['image'] }}" alt="{{ $rec['title'] }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="font-bold text-sm text-dark-chocolate line-clamp-1">{{ $rec['title'] }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wide text-aloewood mt-1">{{ $rec['category'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection