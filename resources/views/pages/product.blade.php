@extends('layouts.app')

@section('title', 'Product Catalog - CosRent')

@push('styles')
    @vite(['resources/css/pages/product.css'])
@endpush

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">

        {{-- ── HEADER ── --}}
        <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-8 md:px-10 md:py-10 shadow-xl text-center reveal" data-reveal="up">
            <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood">Product Catalog</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate mb-4">Choose your favorite cosplay costume</h1>
            <p class="text-dark-chocolate/75 text-lg font-medium leading-relaxed max-w-2xl mx-auto">
                Premium fabric quality, clean costumes, and complete size options for your cosplay events.
            </p>
        </section>

        {{-- ── FILTER ── --}}
        <section class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl reveal delay-100" data-reveal="up">
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-between">
                {{-- Keep 'sort' and 'kategori' when searching --}}
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                
                <div class="relative w-full md:w-1/3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search costumes..."
                        class="w-full rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 pr-12 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition"
                        onchange="this.form.submit()">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-dark-chocolate/50 hover:text-sakura transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <select name="kategori" class="w-full sm:w-auto rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition cursor-pointer" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <select name="sort" class="w-full sm:w-auto rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition cursor-pointer" onchange="this.form.submit()">
                        <option value="">Sort By Latest</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Price</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Price</option>
                    </select>
                </div>
            </form>
        </section>

        {{-- ── PRODUCT GRID ── --}}
        <section>
            @if($products->isEmpty())
                {{-- Empty state --}}
                <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-16 shadow-xl text-center reveal delay-200" data-reveal="up">
                    <i class="fa-solid fa-shirt text-6xl text-dark-chocolate/20 mb-4 block"></i>
                    <h2 class="text-2xl font-bold text-dark-chocolate mb-2">No Costumes Yet</h2>
                    <p class="text-dark-chocolate/60 font-medium">Costumes will be added soon. Stay tuned!</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $kostum)
                    {{-- Product Card --}}
                    <article class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-4 shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl flex flex-col reveal" data-reveal="up" style="transition-delay: {{ ($loop->index % 4) * 100 }}ms;">

                        {{-- Image --}}
                        <div class="h-60 rounded-[1.5rem] mb-4 overflow-hidden bg-dark-chocolate/10 p-2">
                            <img src="{{ $kostum->gambar_url }}"
                                 alt="{{ $kostum->nama_kostum }}"
                                 class="w-full h-full object-contain transition duration-300 hover:scale-105"
                                 onerror="this.onerror=null;this.src='https://via.placeholder.com/400x500.png?text=No+Image';">
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
                                Size: {{ $kostum->ukuran }}
                            </span>

                            {{-- Footer --}}
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-dark-chocolate/10">
                                <span class="font-bold text-lg text-dark-chocolate">
                                    Rp {{ number_format($kostum->harga_sewa, 0, ',', '.') }}
                                </span>

                                {{-- Di catalog, cek stok permanen (user belum pilih tanggal).
                                     Stok aktual akan dicek ketat saat user membuka halaman detail & booking. --}}
                                @if($kostum->stok_permanen > 0)
                                    <a href="{{ route('products.show', $kostum->id) }}"
                                       class="rounded-full bg-dark-chocolate px-4 py-2 text-sm font-bold text-misty-rose transition hover:bg-black">
                                        Details
                                    </a>
                                @else
                                    <span class="rounded-full bg-dark-chocolate/20 px-4 py-2 text-sm font-bold text-dark-chocolate/40 cursor-not-allowed">
                                        Out of Stock
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
