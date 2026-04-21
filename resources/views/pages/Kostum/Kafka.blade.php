@extends('layouts.app')

@section('title', 'Sewa Kafka - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">
        
        <!-- Breadcrumb / Back Button -->
        <div>
            <a href="{{ route('products.index') ?? '#' }}" class="inline-flex items-center gap-2 text-sm font-bold text-dark-chocolate transition hover:text-sakura">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_1.2fr] gap-8">
            
            <!-- Left Side: Product Image -->
            <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-4 shadow-xl flex items-center justify-center">
                <div class="w-full h-[400px] md:h-[500px] bg-dark-chocolate/10 rounded-[2rem] flex flex-col items-center justify-center relative overflow-hidden group">
                    <img src="https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg" alt="Kafka" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none">
                        <span class="text-misty-rose font-bold"><i class="fa-solid fa-image mr-2"></i>Gambar Kafka</span>
                    </div>
                </div>
            </section>

            <!-- Right Side: Details & Action -->
            <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-6 md:p-8 shadow-xl flex flex-col">
                <span class="mb-2 block text-xs font-black uppercase tracking-[0.35em] text-aloewood">Honkai: Star Rail</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate mb-2">Kafka</h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-dark-chocolate/10">
                    <span class="text-3xl font-black text-sakura">Rp 200.000 <span class="text-lg font-medium text-dark-chocolate/60">/ 3 Hari</span></span>
                    <span class="px-3 py-1 bg-green-100 text-green-700 font-bold text-xs rounded-full uppercase tracking-wider border border-green-200">Tersedia</span>
                </div>

                <div class="space-y-4 mb-8 flex-grow">
                    <h3 class="text-lg font-bold text-dark-chocolate">Deskripsi Kostum</h3>
                    <p class="text-dark-chocolate/80 text-sm font-medium leading-relaxed">
                        Kostum cosplay Kafka dari Honkai: Star Rail dengan detail premium yang sangat akurat. Set lengkap mencakup jaket ungu berstruktur, kemeja putih dengan detail renda, rok pendek, kacamata hitam khas, dan berbagai aksesori logam yang memberikan kesan mewah. Bahan kain drill premium yang nyaman dan tidak mudah kusut.
                    </p>

                    <h3 class="text-lg font-bold text-dark-chocolate pt-2">Kelengkapan</h3>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm font-medium text-dark-chocolate/80">
                        <li class="flex items-center gap-2"><div class="w-5 h-5 rounded-full bg-sakura/20 flex items-center justify-center"><i class="fa-solid fa-check text-[10px] text-sakura"></i></div> Jaket Ungu Premium</li>
                        <li class="flex items-center gap-2"><div class="w-5 h-5 rounded-full bg-sakura/20 flex items-center justify-center"><i class="fa-solid fa-check text-[10px] text-sakura"></i></div> Kemeja Putih</li>
                        <li class="flex items-center gap-2"><div class="w-5 h-5 rounded-full bg-sakura/20 flex items-center justify-center"><i class="fa-solid fa-check text-[10px] text-sakura"></i></div> Rok & Stoking</li>
                        <li class="flex items-center gap-2"><div class="w-5 h-5 rounded-full bg-sakura/20 flex items-center justify-center"><i class="fa-solid fa-check text-[10px] text-sakura"></i></div> Kacamata & Aksesori</li>
                        <li class="flex items-center gap-2 opacity-50"><div class="w-5 h-5 rounded-full bg-dark-chocolate/10 flex items-center justify-center"><i class="fa-solid fa-xmark text-[10px] text-dark-chocolate"></i></div> Wig (Sewa Terpisah)</li>
                        <li class="flex items-center gap-2 opacity-50"><div class="w-5 h-5 rounded-full bg-dark-chocolate/10 flex items-center justify-center"><i class="fa-solid fa-xmark text-[10px] text-dark-chocolate"></i></div> Sepatu (Sewa Terpisah)</li>
                    </ul>
                </div>

                <form action="#" method="POST" class="space-y-6 bg-white/40 p-5 md:p-6 rounded-[2rem] border-2 border-dark-chocolate/10">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-dark-chocolate mb-3">Pilih Ukuran</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="size" value="S" class="peer sr-only" required>
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-dark-chocolate/20 font-bold text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition shadow-sm hover:border-sakura">S</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="size" value="M" class="peer sr-only">
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-dark-chocolate/20 font-bold text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition shadow-sm hover:border-sakura">M</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="size" value="L" class="peer sr-only">
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-dark-chocolate/20 font-bold text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition shadow-sm hover:border-sakura">L</div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_sewa" class="block text-sm font-bold text-dark-chocolate mb-2">Tanggal Mulai Sewa</label>
                            <input type="date" id="tanggal_sewa" name="tanggal_sewa" min="{{ date('Y-m-d') }}" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition" required>
                        </div>
                        <div>
                            <label for="tanggal_kembali" class="block text-sm font-bold text-dark-chocolate mb-2">Tanggal Selesai Sewa</label>
                            <input type="date" id="tanggal_kembali" name="tanggal_kembali" min="{{ date('Y-m-d') }}" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura outline-none transition" required>
                        </div>
                    </div>

                    <script>
                        const tglSewa = document.getElementById('tanggal_sewa');
                        const tglKembali = document.getElementById('tanggal_kembali');

                        tglSewa.addEventListener('change', function() {
                            tglKembali.min = this.value;
                            if (tglKembali.value && tglKembali.value < this.value) {
                                tglKembali.value = this.value;
                            }
                        });
                    </script>

                    <button type="submit" class="w-full rounded-full bg-dark-chocolate px-6 py-4 text-center font-bold text-misty-rose shadow-lg transition hover:bg-black hover:shadow-xl hover:-translate-y-0.5 text-lg flex justify-center items-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> Lanjutkan Penyewaan
                    </button>
                </form>

            </section>
        </div>

    </main>
@endsection
