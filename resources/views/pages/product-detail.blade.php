@extends('layouts.app')

@section('title', 'Sewa ' . $kostum->nama_kostum . ' - CosRent')

@push('styles')
    <style>
        body {
            background-color: #FFE4E1; /* misty-rose */
        }
        .glass-card {
            background-color: rgba(68, 48, 37, 0.05);
            backdrop-filter: blur(10px);
        }
    </style>
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
                            <label class="block text-sm font-bold text-dark-chocolate mb-3">Pilih Ukuran</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach(['S', 'M', 'L', 'XL'] as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size }}" class="peer sr-only"
                                               {{ $loop->first ? 'required' : '' }}>
                                        <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-dark-chocolate/20 font-bold text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition shadow-sm hover:border-sakura">
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
@endsection

@push('scripts')
<script>
    const tglSewa    = document.getElementById('tanggal_sewa');
    const tglKembali = document.getElementById('tanggal_kembali');

    if (tglSewa && tglKembali) {
        tglSewa.addEventListener('change', function () {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
        });
    }
</script>
@endpush
