@extends('layouts.app')

@section('title', 'Riwayat Sewa Kostum - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full">
        
        <!-- Header -->
        <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-8 md:p-12 shadow-xl text-center mb-12 bg-white/30 backdrop-blur-lg">
            <span class="mb-2 block text-[10px] font-black uppercase tracking-[0.5em] text-aloewood">Pusat Transaksi</span>
            <h1 class="text-3xl md:text-6xl font-black text-dark-chocolate mb-4 tracking-tighter">Riwayat Sewa</h1>
            <p class="text-sm md:text-lg font-medium text-dark-chocolate/60 max-w-xl mx-auto leading-relaxed">
                Pantau semua aktivitas penyewaan kostum kamu.
            </p>
        </div>

        <!-- History List -->
        <div class="space-y-8 w-full">
            @php
                $historyItems = [
                    [
                        'id' => 'TRX-2024-001',
                        'title' => 'Raiden Shogun - Genshin Impact',
                        'date' => '15 April 2026',
                        'return_date' => '18 April 2026',
                        'price' => 180000,
                        'status' => 'Selesai',
                        'status_color' => 'bg-green-100 text-green-700 border-green-200',
                        'image_color' => 'bg-dark-chocolate'
                    ],
                    [
                        'id' => 'TRX-2024-002',
                        'title' => 'Kafka - Honkai: Star Rail',
                        'date' => '05 April 2026',
                        'return_date' => '08 April 2026',
                        'price' => 200000,
                        'status' => 'Selesai',
                        'status_color' => 'bg-green-100 text-green-700 border-green-200',
                        'image_color' => 'bg-aloewood'
                    ],
                    [
                        'id' => 'TRX-2024-003',
                        'title' => 'Spider-Man (Marvel Classic)',
                        'date' => '28 Maret 2026',
                        'return_date' => '31 Maret 2026',
                        'price' => 150000,
                        'status' => 'Dibatalkan',
                        'status_color' => 'bg-red-100 text-red-700 border-red-200',
                        'image_color' => 'bg-sakura'
                    ],
                ];
            @endphp

            @foreach($historyItems as $item)
                <article class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-6 md:p-10 shadow-lg bg-white/60 flex flex-col lg:flex-row gap-10 items-center lg:items-center w-full">
                    
                    <!-- Image Area -->
                    <div class="w-full lg:w-40 h-40 {{ $item['image_color'] }} rounded-[2rem] flex-shrink-0 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-mask text-white/20 text-5xl"></i>
                    </div>

                    <!-- Information Area -->
                    <div class="flex-grow w-full text-center lg:text-left space-y-4">
                        <div class="flex flex-wrap justify-center lg:justify-start items-center gap-3">
                            <span class="bg-dark-chocolate/10 px-3 py-1 rounded-lg text-[10px] font-black text-dark-chocolate tracking-widest">{{ $item['id'] }}</span>
                            <span class="px-4 py-1 rounded-full text-[10px] font-black border {{ $item['status_color'] }} uppercase tracking-wider">
                                {{ $item['status'] }}
                            </span>
                        </div>
                        
                        <h3 class="text-2xl md:text-4xl font-black text-dark-chocolate leading-tight tracking-tight">{{ $item['title'] }}</h3>
                        
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start items-center gap-6 text-sm font-bold text-dark-chocolate/60">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sakura/10 flex items-center justify-center text-sakura"><i class="fa-regular fa-calendar-plus"></i></div>
                                <span>{{ $item['date'] }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-aloewood/10 flex items-center justify-center text-aloewood"><i class="fa-regular fa-calendar-check"></i></div>
                                <span>{{ $item['return_date'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Actions Area -->
                    <div class="w-full lg:w-auto flex flex-col items-center lg:items-end gap-6 pt-8 lg:pt-0 border-t lg:border-0 border-dark-chocolate/10">
                        <div class="text-center lg:text-right">
                            <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-1 opacity-60">Total Biaya</p>
                            <p class="text-4xl font-black text-sakura tracking-tighter">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex gap-3 w-full lg:w-auto">
                            <button class="flex-1 lg:flex-none px-6 py-3 bg-white/80 border-2 border-dark-chocolate/5 rounded-full text-[10px] font-black text-dark-chocolate uppercase tracking-[0.2em] hover:bg-dark-chocolate hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-file-invoice mr-2"></i>Faktur
                            </button>
                            <button class="flex-1 lg:flex-none px-8 py-3 bg-dark-chocolate text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl">
                                Detail
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Back Button -->
        <div class="mt-20 text-center">
            <a href="{{ route('dashboard.pelanggan') }}" class="inline-flex items-center gap-3 px-10 py-4 rounded-full bg-white/40 border border-white/60 text-dark-chocolate font-black text-[10px] uppercase tracking-[0.4em] hover:bg-white/80 transition-all duration-300 hover:shadow-xl">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dasbor
            </a>
        </div>

    </main>
@endsection
