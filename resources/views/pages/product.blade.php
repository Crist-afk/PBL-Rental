@extends('layouts.app')

@section('title', 'Katalog Produk - CosRent')

@push('styles')
    <style>
        body {
            background-color: #FFE4E1;   /* Warna misty-rose */
        }
        .glass-card {
            background-color: rgba(68, 48, 37, 0.05);
            backdrop-filter: blur(10px);
        }
    </style>
@endpush

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">

        {{-- ── HEADER ── --}}
        <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-8 md:px-10 md:py-10 shadow-xl text-center reveal" data-reveal="up">
            <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood">Katalog Produk</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate mb-4">Pilih kostum cosplay favoritmu</h1>
            <p class="text-dark-chocolate/75 text-lg font-medium leading-relaxed max-w-2xl mx-auto">
                Kualitas kain terbaik, higienis, dan pilihan ukuran lengkap untuk kebutuhan event cosplay-mu.
            </p>
        </section>

        {{-- ── FILTER ── --}}
        <section class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl reveal delay-100" data-reveal="up">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <input type="text" placeholder="Cari kostum..."
                    class="w-full md:w-1/3 rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition">

                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <select class="w-full sm:w-auto rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition">
                        <option>Semua Kategori</option>
                        <option>Anime</option>
                        <option>Game</option>
                        <option>Film</option>
                    </select>

                    <select class="w-full sm:w-auto rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition">
                        <option>Urutkan</option>
                        <option>Harga Termurah</option>
                        <option>Harga Termahal</option>
                    </select>
                </div>
            </div>
        </section>

        {{-- ── PRODUCT GRID ── --}}
        <section>
            @if($products->isEmpty())
                {{-- Empty state --}}
                <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-16 shadow-xl text-center reveal delay-200" data-reveal="up">
                    <i class="fa-solid fa-shirt text-6xl text-dark-chocolate/20 mb-4 block"></i>
                    <h2 class="text-2xl font-bold text-dark-chocolate mb-2">Belum Ada Kostum</h2>
                    <p class="text-dark-chocolate/60 font-medium">Kostum akan segera ditambahkan. Pantau terus!</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $kostum)
                    {{-- Product Card --}}
                    <article class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-4 shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col reveal" data-reveal="up" style="transition-delay: {{ ($loop->index % 4) * 100 }}ms;">

                        {{-- Image --}}
                        <div class="h-60 rounded-[1.5rem] mb-4 overflow-hidden bg-dark-chocolate/10">
                            @if($kostum->gambar && str_starts_with($kostum->gambar, 'http'))
                                <img src="{{ $kostum->gambar }}"
                                     alt="{{ $kostum->nama_kostum }}"
                                     class="w-full h-full object-cover transition duration-300 hover:scale-105">
                            @elseif($kostum->gambar)
                                <img src="{{ asset('storage/' . $kostum->gambar) }}"
                                     alt="{{ $kostum->nama_kostum }}"
                                     class="w-full h-full object-cover transition duration-300 hover:scale-105">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-dark-chocolate/20 gap-2">
                                    <i class="fa-solid fa-shirt text-5xl"></i>
                                    <span class="text-xs font-bold uppercase tracking-widest">Foto belum ada</span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="flex flex-col flex-grow px-2 pb-2">
                            <span class="mb-1 text-xs font-bold uppercase tracking-wide text-aloewood">
                                {{ $kostum->kategori->nama_kategori ?? '—' }}
                            </span>
                            <h3 class="font-bold text-xl text-dark-chocolate mb-1 line-clamp-2">
                                {{ $kostum->nama_kostum }}
                            </h3>
                            <span class="text-xs font-medium text-dark-chocolate/50 mb-3">
                                Ukuran: {{ $kostum->ukuran }}
                            </span>

                            {{-- Footer --}}
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-dark-chocolate/10">
                                <span class="font-bold text-lg text-dark-chocolate">
                                    Rp {{ number_format($kostum->harga_sewa, 0, ',', '.') }}
                                </span>

                                @if($kostum->stok > 0)
                                    <a href="{{ route('products.show', $kostum->id) }}"
                                       class="rounded-full bg-dark-chocolate px-4 py-2 text-sm font-bold text-misty-rose transition hover:bg-black">
                                        Detail
                                    </a>
                                @else
                                    <span class="rounded-full bg-dark-chocolate/20 px-4 py-2 text-sm font-bold text-dark-chocolate/40 cursor-not-allowed">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ── PAGINATION (Laravel built-in) ── --}}
        @if($products->hasPages())
            <section class="mt-4 mb-8 flex justify-center">
                <div class="flex gap-3 flex-wrap justify-center">
                    {{-- Previous Page --}}
                    @if($products->onFirstPage())
                        <span class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-dark-chocolate/10 text-dark-chocolate/30 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}"
                           class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-dark-chocolate/20 font-bold text-dark-chocolate bg-white/50 transition hover:border-sakura hover:bg-sakura shadow-sm">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @for($i = 1; $i <= $products->lastPage(); $i++)
                        <a href="{{ $products->url($i) }}"
                           class="flex h-11 w-11 items-center justify-center rounded-full border-2 font-bold transition shadow-sm
                                  {{ $products->currentPage() == $i
                                     ? 'bg-sakura text-dark-chocolate border-sakura'
                                     : 'border-dark-chocolate/20 text-dark-chocolate bg-white/50 hover:border-sakura hover:bg-sakura hover:text-dark-chocolate' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Next Page --}}
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}"
                           class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-dark-chocolate/20 font-bold text-dark-chocolate bg-white/50 transition hover:border-sakura hover:bg-sakura shadow-sm">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-dark-chocolate/10 text-dark-chocolate/30 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </span>
                    @endif
                </div>
            </section>
        @endif

    </main>
@endsection