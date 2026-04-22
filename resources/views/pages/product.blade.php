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
        
        <!-- HEADER -->
        <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-8 md:px-10 md:py-10 shadow-xl text-center">
            <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood">Katalog Produk</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate mb-4">Pilih kostum cosplay favoritmu</h1>
            <p class="text-dark-chocolate/75 text-lg font-medium leading-relaxed max-w-2xl mx-auto">
                Kualitas kain terbaik, higienis, dan pilihan ukuran lengkap untuk kebutuhan event cosplay-mu.
            </p>
        </section>

        <!-- FILTER -->
        <section class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <input type="text" placeholder="Cari kostum..." 
                    class="w-full md:w-1/3 rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura">

                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <select class="w-full sm:w-auto rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura">
                        <option>Semua Kategori</option>
                        <option>Anime</option>
                        <option>Game</option>
                        <option>Film</option>
                    </select>

                    <select class="w-full sm:w-auto rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura">
                        <option>Urutkan</option>
                        <option>Harga Termurah</option>
                        <option>Harga Termahal</option>
                    </select>
                </div>
            </div>
        </section>

        <!-- PRODUCT GRID -->
        <section>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach($products as $product)
                <!-- Product Card -->
                <article class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-4 shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col">
                    <div class="h-60 rounded-[1.5rem] mb-4 overflow-hidden {{ $product['color'] ?? 'bg-dark-chocolate/10' }}">
                        @if(isset($product['image']))
                            <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-dark-chocolate/20">
                                <i class="fa-solid fa-image text-5xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col flex-grow px-2 pb-2">
                        <span class="mb-2 text-xs font-bold uppercase tracking-wide text-aloewood">{{ $product['category'] }}</span>
                        <h3 class="font-bold text-xl text-dark-chocolate mb-2 line-clamp-2">{{ $product['title'] }}</h3>
                        <div class="mt-auto flex justify-between items-center pt-4 border-t border-dark-chocolate/10">
                            <span class="font-bold text-lg text-dark-chocolate">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                            <a href="{{ route('products.show', $product['id']) }}" 
                               class="rounded-full bg-dark-chocolate px-4 py-2 text-sm font-bold text-misty-rose transition hover:bg-black">
                                Detail
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach

            </div>
        </section>

        <!-- PAGINATION -->
        @if($totalPages > 1)
        <section class="mt-4 mb-8 flex justify-center gap-3">
            @for($i = 1; $i <= $totalPages; $i++)
            <a href="{{ route('products.index', ['page' => $i]) }}" 
               class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-dark-chocolate/20 font-bold {{ $page == $i ? 'bg-sakura text-dark-chocolate border-sakura' : 'text-dark-chocolate bg-white/50' }} transition hover:border-sakura hover:bg-sakura hover:text-dark-chocolate shadow-sm">
                {{ $i }}
            </a>
            @endfor
        </section>
        @endif

    </main>
@endsection