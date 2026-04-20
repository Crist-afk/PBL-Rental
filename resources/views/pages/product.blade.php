@extends('layouts.app')

@section('title', 'CosRent - Produk')

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
    <!-- HEADER -->
    <section class="pt-32 pb-10 text-center px-6">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Katalog Produk</h1>
        <p class="text-dark-chocolate/80 text-lg">Pilih kostum cosplay favoritmu</p>
    </section>

    <!-- FILTER -->
    <section class="max-w-7xl mx-auto px-6 mb-12">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <input type="text" placeholder="Cari kostum..." 
                class="px-5 py-3 rounded-full border border-dark-chocolate/20 w-full md:w-1/3 focus:outline-none focus:border-sakura transition">

            <select class="px-5 py-3 rounded-full border border-dark-chocolate/20 focus:outline-none focus:border-sakura transition">
                <option>Semua Kategori</option>
                <option>Anime</option>
                <option>Game</option>
                <option>Film</option>
            </select>

            <select class="px-5 py-3 rounded-full border border-dark-chocolate/20 focus:outline-none focus:border-sakura transition">
                <option>Urutkan</option>
                <option>Harga Termurah</option>
                <option>Harga Termahal</option>
            </select>
        </div>
    </section>

    <!-- PRODUCT GRID -->
    <section class="pb-20 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Product Card 1 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-dark-chocolate"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">GENSHIN IMPACT</span>
                    <h3 class="font-bold text-xl mb-2">Raiden Shogun</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 180.000</span>
                        <a href="{{ route('products.show', 1) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-aloewood"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">ONE PIECE</span>
                    <h3 class="font-bold text-xl mb-2">Monkey D. Luffy</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 120.000</span>
                        <a href="{{ route('products.show', 2) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-milk-tea"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">HONKAI</span>
                    <h3 class="font-bold text-xl mb-2">Kafka</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 200.000</span>
                        <a href="{{ route('products.show', 3) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-60 bg-sakura"></div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-widest">MARVEL</span>
                    <h3 class="font-bold text-xl mb-2">Spider-Man</h3>
                    <div class="mt-auto flex justify-between items-center">
                        <span class="font-bold text-lg">Rp 150.000</span>
                        <a href="{{ route('products.show', 4) }}" 
                           class="bg-dark-chocolate text-misty-rose px-4 py-2 rounded-lg text-sm hover:bg-sakura hover:text-dark-chocolate transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- PAGINATION -->
    <section class="pb-20 text-center">
        <div class="flex justify-center gap-3">
            <button class="px-4 py-2 border border-dark-chocolate/30 rounded-full hover:bg-sakura hover:text-dark-chocolate hover:border-sakura transition">1</button>
            <button class="px-4 py-2 border border-dark-chocolate/30 rounded-full hover:bg-sakura hover:text-dark-chocolate hover:border-sakura transition">2</button>
            <button class="px-4 py-2 border border-dark-chocolate/30 rounded-full hover:bg-sakura hover:text-dark-chocolate hover:border-sakura transition">3</button>
        </div>
    </section>
@endsection