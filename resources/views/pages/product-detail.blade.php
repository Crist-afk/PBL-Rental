@extends('layouts.app')

@section('title', 'Sewa ' . $kostum->nama_kostum . ' - CosRent')

@push('styles')
    @vite(['resources/css/pages/product-detail.css'])
@endpush

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">

        {{-- ── Breadcrumb / Back Button ── --}}
        <div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-dark-chocolate transition hover:text-sakura">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_1.2fr] gap-8">

            {{-- ── Left Side: Product Image ── --}}
            <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-4 shadow-xl flex items-center justify-center">
                <div class="w-full h-[400px] md:h-[500px] bg-dark-chocolate/10 rounded-[2rem] flex flex-col items-center justify-center relative overflow-hidden group">

                    <img src="{{ $kostum->gambar_url }}"
                         alt="{{ $kostum->nama_kostum }}"
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                         onerror="this.onerror=null;this.src='https://via.placeholder.com/400x500.png?text=No+Image';">

                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none">
                        <span class="text-misty-rose font-bold">
                            <i class="fa-solid fa-image mr-2"></i>{{ $kostum->nama_kostum }}
                        </span>
                    </div>
                </div>
            </section>

            {{-- ── Right Side: Details & Action ── --}}
            <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-6 md:p-8 shadow-xl flex flex-col">

                {{-- Category & Title --}}
                <span class="mb-2 block text-xs font-black uppercase tracking-[0.35em] text-aloewood">
                    {{ $kostum->kategori->nama_kategori ?? 'Kostum' }}
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate mb-2">
                    {{ $kostum->nama_kostum }}
                </h1>

                {{-- Price & Availability --}}
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-dark-chocolate/10">
                    <span class="text-3xl font-black text-sakura">
                        Rp {{ number_format($kostum->harga_sewa, 0, ',', '.') }}
                        <span class="text-lg font-medium text-dark-chocolate/60">/ hari</span>
                    </span>
                    @if($kostum->stok > 0)
                        <span class="px-3 py-1 bg-green-100 text-green-700 font-bold text-xs rounded-full uppercase tracking-wider border border-green-200">
                            Tersedia ({{ $kostum->stok }} unit)
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 font-bold text-xs rounded-full uppercase tracking-wider border border-red-200">
                            Habis
                        </span>
                    @endif
                </div>

                {{-- Description & Equipment --}}
                <div class="space-y-4 mb-8 flex-grow">

                    {{-- Deskripsi / Kelengkapan dari kolom DB --}}
                    @if($kostum->kelengkapan)
                        <h3 class="text-lg font-bold text-dark-chocolate">Deskripsi & Kelengkapan</h3>
                        <p class="text-dark-chocolate/80 text-sm font-medium leading-relaxed">
                            {{ $kostum->kelengkapan }}
                        </p>

                        {{-- Parse list items jika format bullet (baris per item) --}}
                        @php
                            $items = array_filter(array_map('trim', explode("\n", $kostum->kelengkapan)));
                        @endphp
                        @if(count($items) > 1)
                            <h3 class="text-lg font-bold text-dark-chocolate pt-2">Termasuk dalam Paket</h3>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm font-medium text-dark-chocolate/80">
                                @foreach($items as $item)
                                    <li class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full bg-sakura/20 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-check text-[10px] text-sakura"></i>
                                        </div>
                                        {{ ltrim($item, '-• ') }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <h3 class="text-lg font-bold text-dark-chocolate">Deskripsi Kostum</h3>
                        <p class="text-dark-chocolate/80 text-sm font-medium leading-relaxed italic">
                            Deskripsi lengkap kostum ini belum tersedia.
                        </p>
                    @endif

                    {{-- Ukuran dari DB --}}
                    @if($kostum->ukuran)
                        <div class="flex items-center gap-3 pt-2">
                            <span class="text-sm font-bold text-dark-chocolate">Ukuran Tersedia:</span>
                            <span class="px-4 py-1.5 bg-sakura/20 text-dark-chocolate font-black text-sm rounded-full border border-sakura/30">
                                {{ $kostum->ukuran }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- ── Booking Form ── --}}
                @if($kostum->stok > 0)
                    <form action="{{ route('booking.index') }}" method="GET"
                          class="space-y-6 bg-white/40 p-5 md:p-6 rounded-[2rem] border-2 border-dark-chocolate/10">

                        {{-- Pass the real DB id --}}
                        <input type="hidden" name="kostum_id" value="{{ $kostum->id }}">

                        {{-- Size Selection --}}
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-bold text-dark-chocolate">Pilih Ukuran</label>
                                <button type="button" onclick="document.getElementById('sizeChartModal').classList.remove('hidden')" class="text-xs font-bold text-sakura hover:text-dark-chocolate transition flex items-center gap-1">
                                    <i class="fa-solid fa-ruler"></i> Panduan Ukuran (cm)
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @php
                                    $availableSizes = $kostum->ukuran ? array_map('trim', explode(',', $kostum->ukuran)) : ['All Size'];
                                @endphp
                                @foreach($availableSizes as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size }}" class="peer sr-only"
                                               {{ $loop->first ? 'required' : '' }}>
                                        <div class="min-w-[3rem] px-3 h-12 flex items-center justify-center rounded-xl border-2 border-dark-chocolate/20 font-bold text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition shadow-sm hover:border-sakura">
                                            {{ $size }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Date Range --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_sewa" class="block text-sm font-bold text-dark-chocolate mb-2">
                                    Tanggal Mulai Sewa
                                </label>
                                <input type="date" id="tanggal_sewa" name="tanggal_sewa"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition"
                                       required>
                            </div>
                            <div>
                                <label for="tanggal_kembali" class="block text-sm font-bold text-dark-chocolate mb-2">
                                    Tanggal Selesai Sewa
                                </label>
                                <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition"
                                       required>
                            </div>
                        </div>

                        {{-- CTA Button --}}
                        @auth
                            <button type="submit"
                                    class="w-full rounded-full bg-dark-chocolate px-6 py-4 text-center font-bold text-misty-rose shadow-lg transition hover:bg-black hover:shadow-xl hover:-translate-y-0.5 text-lg flex justify-center items-center gap-2">
                                <i class="fa-solid fa-cart-shopping"></i> Sewa Sekarang
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full rounded-full bg-dark-chocolate px-6 py-4 text-center font-bold text-misty-rose shadow-lg transition hover:bg-black hover:shadow-xl hover:-translate-y-0.5 text-lg flex justify-center items-center gap-2">
                                <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Menyewa
                            </a>
                        @endauth
                    </form>
                @else
                    {{-- Out of stock state --}}
                    <div class="bg-red-50 border-2 border-red-100 rounded-[2rem] p-6 text-center">
                        <i class="fa-solid fa-box-open text-3xl text-red-300 mb-3 block"></i>
                        <p class="font-bold text-red-600">Kostum ini sedang tidak tersedia.</p>
                        <p class="text-sm text-red-500 mt-1">Silakan cek kembali nanti atau pilih kostum lain.</p>
                        <a href="{{ route('products.index') }}"
                           class="mt-4 inline-block rounded-full bg-dark-chocolate px-6 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">
                            Lihat Kostum Lainnya
                        </a>
                    </div>
                @endif

            </section>
        </div>

    </main>

    {{-- Size Chart Modal --}}
    <div id="sizeChartModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300">
        <div class="glass-card bg-white/95 rounded-[2rem] border-2 border-sakura/20 p-6 md:p-8 shadow-2xl max-w-lg w-full relative">
            <button type="button" onclick="document.getElementById('sizeChartModal').classList.add('hidden')" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center bg-dark-chocolate/10 text-dark-chocolate rounded-full hover:bg-dark-chocolate hover:text-misty-rose transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h3 class="text-2xl font-black text-dark-chocolate mb-6 text-center"><i class="fa-solid fa-ruler-combined text-sakura mr-2"></i>Panduan Ukuran (cm)</h3>
            <div class="overflow-x-auto rounded-[1.5rem] border border-dark-chocolate/10">
                <table class="w-full text-sm text-left text-dark-chocolate">
                    <thead class="bg-sakura/20 font-bold uppercase text-[10px] tracking-widest text-dark-chocolate text-center">
                        <tr>
                            <th class="px-4 py-4">Ukuran</th>
                            <th class="px-4 py-4">Dada</th>
                            <th class="px-4 py-4">Pinggang</th>
                            <th class="px-4 py-4">Tinggi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-chocolate/10 text-center font-medium bg-white/50">
                        <tr class="hover:bg-dark-chocolate/5 transition">
                            <td class="px-4 py-3 font-black text-sakura">S</td>
                            <td class="px-4 py-3">80 - 84</td>
                            <td class="px-4 py-3">60 - 64</td>
                            <td class="px-4 py-3">150 - 155</td>
                        </tr>
                        <tr class="hover:bg-dark-chocolate/5 transition">
                            <td class="px-4 py-3 font-black text-sakura">M</td>
                            <td class="px-4 py-3">85 - 89</td>
                            <td class="px-4 py-3">65 - 69</td>
                            <td class="px-4 py-3">156 - 160</td>
                        </tr>
                        <tr class="hover:bg-dark-chocolate/5 transition">
                            <td class="px-4 py-3 font-black text-sakura">L</td>
                            <td class="px-4 py-3">90 - 94</td>
                            <td class="px-4 py-3">70 - 74</td>
                            <td class="px-4 py-3">161 - 165</td>
                        </tr>
                        <tr class="hover:bg-dark-chocolate/5 transition">
                            <td class="px-4 py-3 font-black text-sakura">XL</td>
                            <td class="px-4 py-3">95 - 99</td>
                            <td class="px-4 py-3">75 - 79</td>
                            <td class="px-4 py-3">166 - 170</td>
                        </tr>
                        <tr class="hover:bg-dark-chocolate/5 transition">
                            <td class="px-4 py-3 font-black text-sakura">XXL</td>
                            <td class="px-4 py-3">100 - 104</td>
                            <td class="px-4 py-3">80 - 84</td>
                            <td class="px-4 py-3">171 - 175</td>
                        </tr>
                        <tr class="hover:bg-dark-chocolate/5 transition">
                            <td class="px-4 py-3 font-black text-sakura">All Size</td>
                            <td class="px-4 py-3" colspan="3">Menyesuaikan bentuk tubuh (fit S to L)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-[10px] font-bold text-dark-chocolate/50 text-center mt-4 uppercase tracking-widest">*Toleransi ukuran 1-3 cm dari aslinya</p>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/pages/product-detail.js'])
@endpush
