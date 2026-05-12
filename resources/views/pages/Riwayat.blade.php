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
                $statusColors = [
                    'Menunggu Pembayaran' => 'bg-amber-100 text-amber-700 border-amber-200',
                    'Disewa' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                    'Batal' => 'bg-red-100 text-red-700 border-red-200',
                ];
            @endphp

            @forelse($historyItems as $item)
                @php
                    $firstDetail = $item->detailTransaksi->first();
                    $kostum = $firstDetail ? $firstDetail->kostum : null;
                    $statusColor = $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                @endphp
                <article class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-6 md:p-10 shadow-lg bg-white/60 flex flex-col lg:flex-row gap-10 items-center lg:items-center w-full">
                    
                    <!-- Image Area -->
                    <div class="w-full lg:w-40 h-40 bg-dark-chocolate/5 rounded-[2rem] flex-shrink-0 overflow-hidden shadow-inner flex items-center justify-center">
                        @if($kostum && $kostum->gambar)
                            <img src="{{ $kostum->gambar_url }}" alt="{{ $kostum->nama_kostum }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-mask text-dark-chocolate/20 text-5xl"></i>
                        @endif
                    </div>

                    <!-- Information Area -->
                    <div class="flex-grow w-full text-center lg:text-left space-y-4">
                        <div class="flex flex-wrap justify-center lg:justify-start items-center gap-3">
                            <span class="bg-dark-chocolate/10 px-3 py-1 rounded-lg text-[10px] font-black text-dark-chocolate tracking-widest">TRX-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="px-4 py-1 rounded-full text-[10px] font-black border {{ $statusColor }} uppercase tracking-wider">
                                {{ $item->status }}
                            </span>
                        </div>
                        
                        <h3 class="text-2xl md:text-4xl font-black text-dark-chocolate leading-tight tracking-tight">
                            @if($kostum)
                                {{ $kostum->nama_kostum }}
                            @else
                                Transaksi #{{ $item->id }}
                            @endif
                            @if($item->detailTransaksi->count() > 1)
                                <span class="text-sm font-bold text-dark-chocolate/40 ml-2">+{{ $item->detailTransaksi->count() - 1 }} lainnya</span>
                            @endif
                        </h3>
                        
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start items-center gap-6 text-sm font-bold text-dark-chocolate/60">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sakura/10 flex items-center justify-center text-sakura"><i class="fa-regular fa-calendar-plus"></i></div>
                                <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-aloewood/10 flex items-center justify-center text-aloewood"><i class="fa-regular fa-calendar-check"></i></div>
                                <span>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Actions Area -->
                    <div class="w-full lg:w-auto flex flex-col items-center lg:items-end gap-6 pt-8 lg:pt-0 border-t lg:border-0 border-dark-chocolate/10">
                        <div class="text-center lg:text-right">
                            <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-1 opacity-60">Total Biaya</p>
                            <p class="text-4xl font-black text-sakura tracking-tighter">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex gap-3 w-full lg:w-auto">
                            <a href="{{ route('riwayat.faktur', $item->id) }}" class="flex-1 lg:flex-none px-6 py-3 bg-white/80 border-2 border-dark-chocolate/5 rounded-full text-[10px] font-black text-dark-chocolate uppercase tracking-[0.2em] hover:bg-dark-chocolate hover:text-white transition-all shadow-sm flex items-center justify-center">
                                <i class="fa-solid fa-file-invoice mr-2"></i>Faktur
                            </a>
                            @if($kostum)
                            <a href="{{ route('products.show', $kostum->id) }}" class="flex-1 lg:flex-none px-8 py-3 bg-dark-chocolate text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl text-center flex items-center justify-center">
                                Detail
                            </a>
                            @else
                            <button disabled class="flex-1 lg:flex-none px-8 py-3 bg-dark-chocolate/50 text-white/70 rounded-full text-[10px] font-black uppercase tracking-[0.2em] cursor-not-allowed shadow-xl">
                                Detail
                            </button>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-12 text-center bg-white/40">
                    <div class="w-20 h-20 bg-dark-chocolate/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-receipt text-dark-chocolate/20 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-dark-chocolate mb-2">Belum ada riwayat</h3>
                    <p class="text-dark-chocolate/60 text-sm font-medium">Kamu belum pernah melakukan penyewaan kostum.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-8 px-8 py-3 bg-sakura text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-sakura/80 transition-all shadow-lg">
                        Mulai Sewa Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Back Button -->
        <div class="mt-20 text-center">
            <a href="{{ route('dashboard.pelanggan') }}" class="inline-flex items-center gap-3 px-10 py-4 rounded-full bg-white/40 border border-white/60 text-dark-chocolate font-black text-[10px] uppercase tracking-[0.4em] hover:bg-white/80 transition-all duration-300 hover:shadow-xl">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dasbor
            </a>
        </div>

    </main>
@endsection
