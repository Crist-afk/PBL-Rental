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
                                    <option value="1" data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s" {{ (isset($kostum_id) && $kostum_id == 1) ? 'selected' : '' }}>Raiden Shogun (Genshin Impact)</option>
                                    <option value="2" data-image="https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e" {{ (isset($kostum_id) && $kostum_id == 2) ? 'selected' : '' }}>Monkey D. Luffy (One Piece)</option>
                                    <option value="3" data-image="https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg" {{ (isset($kostum_id) && $kostum_id == 3) ? 'selected' : '' }}>Kafka (Honkai: Star Rail)</option>
                                    <option value="4" data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s" {{ (isset($kostum_id) && $kostum_id == 4) ? 'selected' : '' }}>Spider-Man (Marvel)</option>
                                    <option value="5" data-image="https://ae01.alicdn.com/kf/S5c23516ed69b45b3ae3f35e3fbad217d6.jpg" {{ (isset($kostum_id) && $kostum_id == 5) ? 'selected' : '' }}>Yae Miko (Genshin Impact)</option>
                                    <option value="6" data-image="https://images-cdn.ubuy.co.in/65179920f4977158b35cafa6-gojo-satoru-costume-jujutsu-kaisen.jpg" {{ (isset($kostum_id) && $kostum_id == 6) ? 'selected' : '' }}>Gojo Satoru (Jujutsu Kaisen)</option>
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
                            <label class="flex items-center gap-2 text-sm font-black text-dark-chocolate uppercase tracking-widest">
                                <i class="fa-solid fa-ruler-combined text-sakura"></i> Pilih Ukuran
                            </label>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach(['S', 'M', 'L', 'XL'] as $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size }}" class="peer sr-only" {{ (isset($selected_size) && $selected_size == $size) ? 'checked' : ($loop->first && !isset($selected_size) ? 'required' : '') }}>
                                        <div class="w-full py-4 flex items-center justify-center rounded-2xl border-2 border-dark-chocolate/10 font-black text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition-all duration-300 shadow-sm hover:scale-105 bg-white/40 hover:border-sakura/50 peer-checked:shadow-sakura/20 peer-checked:shadow-lg">
                                            {{ $size }}
                                        </div>
                                    </label>
                                @endforeach
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

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#443025',
                background: '#FFE4E1',
                customClass: {
                    title: 'text-dark-chocolate font-black',
                    popup: 'rounded-[2rem] border-2 border-sakura/20 shadow-2xl'
                }
            });
        @endif

        const tglSewa = document.getElementById('tanggal_sewa');
        const tglKembali = document.getElementById('tanggal_kembali');

        tglSewa.addEventListener('change', function() {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
        });

        // Costume Preview Logic
        const kostumSelect = document.getElementById('kostum_id');
        const previewContainer = document.getElementById('costume-preview');
        const previewImage = document.getElementById('preview-image');
        const previewName = document.getElementById('preview-name');

        function updatePreview() {
            const selectedOption = kostumSelect.options[kostumSelect.selectedIndex];
            const imageUrl = selectedOption.getAttribute('data-image');
            const costumeName = selectedOption.text;

            if (imageUrl) {
                previewImage.src = imageUrl;
                previewName.textContent = costumeName;
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('animate-fade-in');
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        kostumSelect.addEventListener('change', updatePreview);

        // Run on load in case of pre-selected value
        if (kostumSelect.value) {
            updatePreview();
        }

        // Simple animation on input focus
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const label = input.parentElement.closest('.space-y-4').querySelector('label');
                if (label) label.classList.add('text-sakura');
            });
            input.addEventListener('blur', () => {
                const label = input.parentElement.closest('.space-y-4').querySelector('label');
                if (label) label.classList.remove('text-sakura');
            });
        });
    </script>

    <style>
        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Fix for double arrow issue in some browsers */
        select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: none !important;
        }
        select::-ms-expand {
            display: none !important;
        }
    </style>
@endsection
