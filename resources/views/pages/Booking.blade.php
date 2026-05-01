@extends('layouts.app')

@section('title', 'Formulir Pemesanan Kostum - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-6xl mx-auto w-full">
        
        <!-- Header Section -->
        <div class="relative mb-10">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-sakura/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-aloewood/20 rounded-full blur-3xl"></div>
            
            <div class="glass-card relative rounded-[3rem] border-2 border-white/20 px-6 py-10 md:px-12 md:py-12 shadow-2xl text-center overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-sakura/5 to-aloewood/5 pointer-events-none"></div>
                <span class="mb-4 block text-sm font-black uppercase tracking-[0.4em] text-aloewood/80">Premium Service</span>
                <h1 class="text-4xl md:text-6xl font-black text-dark-chocolate mb-4 tracking-tight">Formulir Pemesanan</h1>
                <p class="text-base md:text-lg font-medium text-dark-chocolate/70 max-w-2xl mx-auto leading-relaxed">
                    Amankan kostum pilihanmu untuk event mendatang. Isi detail pemesanan di bawah ini dengan lengkap.
                </p>
            </div>
        </div>

        <!-- Form Section -->
        <section class="glass-card rounded-[3rem] border-2 border-white/30 p-8 md:p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <i class="fa-solid fa-calendar-days text-9xl text-dark-chocolate"></i>
            </div>

            @if($errors->any())
                <div class="mb-8 p-6 bg-red-50 border-2 border-red-200 rounded-[2rem] text-red-700">
                    <ul class="list-disc list-inside font-bold text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" class="relative">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-12">
                    <!-- Left Side: Selection & Preview -->
                    <div class="space-y-8">
                        <!-- Pilih Kostum -->
                        <div class="space-y-4">
                            <label for="kostum_id" class="flex items-center gap-2 text-sm font-black text-dark-chocolate uppercase tracking-widest">
                                <i class="fa-solid fa-mask text-sakura"></i> Pilih Kostum
                            </label>
                            <div class="relative group">
                                <select id="kostum_id" name="kostum_id" class="w-full rounded-[1.5rem] border-2 border-dark-chocolate/10 bg-white/60 px-6 py-4 font-bold text-dark-chocolate focus:border-sakura focus:ring-4 focus:ring-sakura/10 outline-none transition appearance-none cursor-pointer group-hover:border-sakura/50 relative z-10" required>
                                    <option value="" disabled {{ !isset($kostum_id) ? 'selected' : '' }}>-- Cari Kostum --</option>
                                    @foreach($kostums as $k)
                                        <option value="{{ $k->id }}" data-image="{{ $k->gambar_url }}" data-sizes="{{ $k->ukuran }}" {{ (isset($kostum_id) && $kostum_id == $k->id) ? 'selected' : '' }}>
                                            {{ $k->nama_kostum }} ({{ $k->kategori->nama_kategori ?? 'Umum' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-sakura z-20">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Container -->
                        <div id="costume-preview" class="hidden overflow-hidden rounded-[2rem] border-2 border-sakura/20 shadow-xl group bg-white/40 backdrop-blur-sm">
                            <div class="relative h-[32rem] w-full bg-dark-chocolate/5">
                                <img id="preview-image" src="" alt="Preview" class="w-full h-full object-contain p-6 transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-dark-chocolate/80 to-transparent flex items-end p-8">
                                    <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                        <p class="text-sakura text-[10px] font-black uppercase tracking-widest mb-1">Kostum Terpilih</p>
                                        <h4 id="preview-name" class="text-white font-bold text-xl leading-tight"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Booking Details -->
                    <div class="space-y-8">
                        <!-- Pilih Ukuran -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between w-full">
                                <label class="flex items-center gap-2 text-sm font-black text-dark-chocolate uppercase tracking-widest">
                                    <i class="fa-solid fa-ruler-combined text-sakura"></i> Pilih Ukuran
                                </label>
                                <button type="button" onclick="document.getElementById('sizeChartModal').classList.remove('hidden')" class="text-xs font-bold text-sakura hover:text-dark-chocolate transition flex items-center gap-1">
                                    <i class="fa-solid fa-ruler"></i> Panduan (cm)
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-3" id="size-container" data-selected="{{ old('size', $selected_size ?? '') }}">
                                <p class="text-sm font-medium text-dark-chocolate/50 italic py-2">Pilih kostum terlebih dahulu untuk melihat ukuran.</p>
                            </div>
                        </div>

                        <!-- Tanggal Sewa -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <label for="tanggal_sewa" class="flex items-center gap-2 text-sm font-black text-dark-chocolate uppercase tracking-widest">
                                    <i class="fa-solid fa-calendar-plus text-sakura"></i> Mulai Sewa
                                </label>
                                <div class="relative">
                                    <input type="date" id="tanggal_sewa" name="tanggal_sewa" value="{{ $tanggal_sewa ?? '' }}" min="{{ date('Y-m-d') }}" class="w-full rounded-[1.5rem] border-2 border-dark-chocolate/10 bg-white/60 px-6 py-4 font-bold text-dark-chocolate focus:border-sakura focus:ring-4 focus:ring-sakura/10 outline-none transition cursor-pointer" required>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <label for="tanggal_kembali" class="flex items-center gap-2 text-sm font-black text-dark-chocolate uppercase tracking-widest">
                                    <i class="fa-solid fa-calendar-check text-sakura"></i> Selesai Sewa
                                </label>
                                <div class="relative">
                                    <input type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ $tanggal_kembali ?? '' }}" min="{{ date('Y-m-d') }}" class="w-full rounded-[1.5rem] border-2 border-dark-chocolate/10 bg-white/60 px-6 py-4 font-bold text-dark-chocolate focus:border-sakura focus:ring-4 focus:ring-sakura/10 outline-none transition cursor-pointer" required>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Tambahan -->
                        <div class="space-y-4">
                            <label for="catatan" class="flex items-center gap-2 text-sm font-black text-dark-chocolate uppercase tracking-widest">
                                <i class="fa-solid fa-comment-dots text-sakura"></i> Catatan Khusus
                            </label>
                            <textarea id="catatan" name="catatan" rows="4" placeholder="Contoh: Tambahan wig, request pengiriman, dll..." class="w-full rounded-[2rem] border-2 border-dark-chocolate/10 bg-white/60 px-6 py-5 font-medium text-dark-chocolate focus:border-sakura focus:ring-4 focus:ring-sakura/10 outline-none transition resize-none placeholder:text-dark-chocolate/30"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="group relative w-full overflow-hidden rounded-full bg-dark-chocolate p-5 text-center font-black text-misty-rose shadow-2xl transition-all duration-500 hover:scale-[1.02] active:scale-95">
                                <div class="absolute inset-0 bg-gradient-to-r from-sakura to-aloewood opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                <span class="relative flex items-center justify-center gap-3 text-xl uppercase tracking-widest">
                                    <i class="fa-solid fa-paper-plane animate-bounce-slow"></i> Konfirmasi Pemesanan
                                </span>
                            </button>
                            <div class="mt-6 flex items-center justify-center gap-2 text-dark-chocolate/40 font-bold text-[10px] uppercase tracking-[0.2em]">
                                <i class="fa-solid fa-shield-halved text-green-500"></i> Data Anda Aman & Terenkripsi
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <!-- Navigation Footer -->
        <div class="mt-12 flex justify-center">
            <a href="{{ route('dashboard.pelanggan') }}" class="inline-flex items-center gap-3 px-8 py-3 rounded-full bg-white/30 border border-white/50 text-dark-chocolate font-black text-xs uppercase tracking-widest hover:bg-white/50 transition-all duration-300 hover:shadow-lg">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dasbor
            </a>
        </div>

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

    </main>

    @push('scripts')
        @vite(['resources/js/pages/booking.js'])
    @endpush

    @push('styles')
        @vite(['resources/css/pages/booking.css'])
    @endpush
@endsection
