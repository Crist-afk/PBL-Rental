@extends('layouts.app')

@section('title', 'Customer Dashboard - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">

        <!-- Greeting -->
        <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-8 md:px-10 md:py-10 shadow-xl text-center md:text-left">
            <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood">Dashboard Area</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-dark-chocolate">Welcome, {{ auth()->user()->nama ?? 'Customer' }}! 👋</h1>
            <p class="mt-4 text-base font-medium leading-relaxed text-dark-chocolate/75 md:text-lg max-w-3xl">This is your account hub. View active rental status, transaction history, and find your next costume.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-aloewood">Currently Rented</p>
                        <p class="text-4xl font-extrabold mt-3 text-dark-chocolate">{{ $stats['active_rentals'] ?? 3 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-sakura/20 rounded-[1.2rem] flex items-center justify-center text-2xl text-sakura"><i class="fa-solid fa-bag-shopping"></i></div>
                </div>
                <p class="text-xs font-bold text-green-600 mt-5 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> +1 this week
                </p>
            </div>

            <div class="glass-card rounded-[2rem] p-6 border-2 border-dark-chocolate/10 shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide text-aloewood">Total Rentals</p>
                        <p class="text-4xl font-extrabold mt-3 text-dark-chocolate">{{ $stats['total_rentals'] ?? 17 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-aloewood/20 rounded-[1.2rem] flex items-center justify-center text-2xl text-aloewood"><i class="fa-solid fa-box-open"></i></div>
                </div>
                <p class="text-xs font-bold text-dark-chocolate/60 mt-5">Since joining</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Kostum Sedang Disewa -->
            <div class="lg:col-span-7 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-dark-chocolate">Currently Rented Costumes</h2>
                    <a href="{{ route('products.index') }}" class="text-sm font-bold text-sakura hover:text-aloewood transition flex items-center gap-2">
                        Rent Another Costume <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($current_rentals ?? [] as $rental)
                    <article class="glass-card rounded-[2rem] p-5 flex flex-col sm:flex-row gap-5 items-start sm:items-center border-2 border-dark-chocolate/10 shadow-xl transition hover:-translate-y-1 hover:shadow-2xl">
                        <div class="w-full sm:w-24 h-40 sm:h-24 {{ $rental['color'] ?? 'bg-dark-chocolate' }} rounded-[1.5rem] flex-shrink-0 overflow-hidden">
                            @if(isset($rental['image']))
                                <img src="{{ $rental['image'] }}" alt="{{ $rental['title'] }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 w-full">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="font-bold text-xl text-dark-chocolate line-clamp-1">{{ $rental['title'] }}</h3>
                                @if(isset($rental['status']))
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full border {{ $rental['status_color'] }} whitespace-nowrap">{{ $rental['status'] }}</span>
                                @endif
                            </div>
                            <p class="text-sm font-bold text-aloewood mt-1 uppercase tracking-wide">Size {{ $rental['size'] }}</p>
                            <p class="text-xs font-medium text-dark-chocolate/70 mt-1"><i class="fa-regular fa-clock mr-1"></i> Return {{ $rental['return_date'] }}</p>
                            @if($rental['raw_status'] === 'Menunggu Pembayaran')
                                <p class="text-xs font-bold text-amber-600 mt-2 bg-amber-50 p-2 rounded-lg border border-amber-200">
                                    <i class="fa-solid fa-clock mr-1"></i> Pay before: {{ $rental['payment_deadline'] }}
                                </p>
                            @endif
                            @if($rental['denda'] > 0)
                                <p class="text-xs font-bold text-red-500 mt-2 bg-red-50 p-2 rounded-lg border border-red-100">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Late Penalty: {{ $rental['days_late'] }} Days (Rp {{ number_format($rental['denda'], 0, ',', '.') }})
                                </p>
                            @endif
                            @if($rental['status'] === 'Canceled' && !empty($rental['catatan_admin']))
                                <p class="text-xs font-bold text-red-500 mt-2 bg-red-50 p-2 rounded-lg border border-red-100">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Reason: {{ $rental['catatan_admin'] }}
                                </p>
                            @endif
                        </div>
                        <div class="text-left sm:text-right w-full sm:w-auto flex justify-between sm:block border-t sm:border-0 border-dark-chocolate/10 pt-4 sm:pt-0 mt-4 sm:mt-0 gap-4">
                            <div>
                                <span class="block text-[10px] font-bold text-dark-chocolate/60 uppercase tracking-widest">Total Price</span>
                                <span class="font-bold text-xl text-dark-chocolate">Rp {{ number_format($rental['price'], 0, ',', '.') }}</span>
                            </div>
                            @if($rental['raw_status'] === 'Menunggu Pembayaran')
                            <button onclick="openUploadModal({{ $rental['id'] }})" class="bg-sakura text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-sakura/80 transition sm:mt-3 whitespace-nowrap inline-flex items-center justify-center">
                                <i class="fa-solid fa-upload mr-1"></i> {{ $rental['has_payment_proof'] ? 'Replace Proof' : 'Upload Proof' }}
                            </button>
                            @else
                            <a href="{{ route('riwayat.faktur', $rental['id']) }}" class="bg-dark-chocolate text-misty-rose px-6 py-2.5 rounded-full text-sm font-bold hover:bg-black transition sm:mt-3 whitespace-nowrap inline-flex items-center justify-center">
                                <i class="fa-solid fa-receipt mr-1"></i> Invoice
                            </a>
                            @endif
                        </div>
                    </article>
                    @empty
                        <div class="rounded-[2.5rem] border-2 border-dashed border-dark-chocolate/15 bg-white/50 px-6 py-12 text-center shadow-sm">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sakura/20 text-2xl text-dark-chocolate mb-4">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <h3 class="text-xl font-bold text-dark-chocolate">No costumes rented yet.</h3>
                            <p class="mt-2 text-sm font-medium text-dark-chocolate/70">Start your cosplay adventure by renting a costume now!</p>
                            <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-dark-chocolate text-misty-rose px-8 py-3 rounded-full text-sm font-bold hover:bg-black transition">
                                View Catalog
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-5 space-y-8">

                <!-- Menu Khusus Pelanggan -->
                <div class="glass-card rounded-[2rem] p-6 md:p-8 border-2 border-dark-chocolate/10 shadow-xl">
                    <h3 class="font-bold text-xl mb-6 text-dark-chocolate"><i class="fa-solid fa-user-gear text-sakura mr-2"></i>Customer Menu</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('booking.index') }}" class="glass-card hover:bg-dark-chocolate hover:border-dark-chocolate hover:text-misty-rose transition p-4 rounded-[1.5rem] flex items-center gap-4 border-2 border-dark-chocolate/10 group">
                            <div class="w-12 h-12 bg-sakura/20 rounded-xl flex items-center justify-center text-xl text-sakura group-hover:bg-sakura group-hover:text-dark-chocolate transition">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Booking Form</p>
                                <p class="text-[10px] opacity-70">Book a costume now</p>
                            </div>
                        </a>
                        <a href="{{ route('riwayat.index') }}" class="glass-card hover:bg-dark-chocolate hover:border-dark-chocolate hover:text-misty-rose transition p-4 rounded-[1.5rem] flex items-center gap-4 border-2 border-dark-chocolate/10 group">
                            <div class="w-12 h-12 bg-aloewood/20 rounded-xl flex items-center justify-center text-xl text-aloewood group-hover:bg-aloewood group-hover:text-dark-chocolate transition">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Rental History</p>
                                <p class="text-[10px] opacity-70">View all transactions</p>
                            </div>
                        </a>
                        <a href="{{ route('penalty.index') }}" class="glass-card hover:bg-dark-chocolate hover:border-dark-chocolate hover:text-misty-rose transition p-4 rounded-[1.5rem] flex items-center gap-4 border-2 border-dark-chocolate/10 group">
                            <div class="w-12 h-12 bg-red-500/20 rounded-xl flex items-center justify-center text-xl text-red-500 group-hover:bg-red-500 group-hover:text-misty-rose transition">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Late Penalty</p>
                                <p class="text-[10px] opacity-70">View late costume fees</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Info Denda -->
                <div class="glass-card rounded-[2rem] p-6 border-2 border-red-500/20 bg-red-500/5 shadow-xl">
                    <h3 class="font-bold text-lg text-red-600 flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-circle-exclamation"></i> Late Return Fee Information
                    </h3>
                    <p class="text-sm font-medium text-dark-chocolate/80 leading-relaxed">
                        Late costume returns will be charged a fee of <span class="font-bold text-red-600">Rp 50.000 / day</span>. Please return on time!
                    </p>
                </div>

                <!-- Riwayat Terbaru -->
                <div class="glass-card rounded-[2rem] p-6 md:p-8 border-2 border-dark-chocolate/10 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-xl text-dark-chocolate"><i class="fa-solid fa-clock-rotate-left text-aloewood mr-2"></i>History</h3>
                        <a href="{{ route('riwayat.index') }}" class="text-xs font-bold text-sakura hover:text-dark-chocolate transition">View All</a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($recent_history as $t)
                        @php
                            $kostumName = $t->detailTransaksi->first()?->kostum?->nama_kostum ?? 'Transaksi #' . $t->id;
                        @endphp
                        <div class="flex justify-between items-start border-b border-dark-chocolate/10 pb-4 last:border-0 last:pb-0">
                            <div class="flex-1 min-w-0 mr-3">
                                <p class="font-bold text-sm text-dark-chocolate truncate">{{ $kostumName }}</p>
                                <p class="text-xs font-medium text-dark-chocolate/60 mt-1">
                                    {{ $t->tanggal_mulai->format('j M Y') }} • Rp {{ number_format($t->total_biaya, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('riwayat.faktur', $t->id) }}"
                               class="flex-shrink-0 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $t->status_color }} hover:opacity-80 transition whitespace-nowrap flex items-center gap-1">
                                @if($t->status === 'Selesai')
                                    <i class="fa-solid fa-rotate-left text-[8px]"></i>
                                @endif
                                {{ $t->status_label }}
                            </a>
                        </div>
                        @empty
                        <p class="text-sm text-center text-dark-chocolate/50 py-4">No transaction history yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Rekomendasi -->
                <div class="glass-card rounded-[2rem] p-6 md:p-8 border-2 border-dark-chocolate/10 shadow-xl">
                    <h3 class="font-bold text-xl mb-6 text-dark-chocolate"><i class="fa-solid fa-star text-yellow-500 mr-2"></i>Recommendations</h3>
                    <div class="flex gap-4 overflow-x-auto pb-2 snap-x">
                        @foreach($recommendations ?? [] as $rec)
                        <div class="min-w-[150px] snap-start bg-white/50 rounded-[1.5rem] overflow-hidden border-2 border-dark-chocolate/10 transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="h-28 {{ $rec['color'] }} overflow-hidden">
                                @if(isset($rec['image']))
                                    <img src="{{ $rec['image'] }}" alt="{{ $rec['title'] }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="font-bold text-sm text-dark-chocolate line-clamp-1">{{ $rec['title'] }}</p>
                                <p class="text-[10px] font-bold uppercase tracking-wide text-aloewood mt-1">{{ $rec['category'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Upload Bukti Modal -->
    <div id="uploadModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="glass-card rounded-[2.5rem] w-full max-w-lg bg-white/90 p-8 shadow-2xl transform scale-95 transition-transform duration-300 mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-black text-dark-chocolate">Upload Payment Proof</h3>
                <button onclick="closeUploadModal()" class="text-dark-chocolate/50 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <p class="text-sm text-dark-chocolate/70 mb-4 font-medium">
                    Please upload your payment proof (format: JPG/PNG, max 2MB).
                </p>
                <div class="flex flex-col gap-2">
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/png, image/jpeg, image/jpg" required
                        class="block w-full text-sm text-dark-chocolate/70 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:tracking-[0.1em] file:bg-sakura/10 file:text-sakura hover:file:bg-sakura/20 transition-colors">
                </div>
                
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeUploadModal()" class="flex-1 py-3 px-4 rounded-full border border-dark-chocolate/20 text-dark-chocolate font-black text-[10px] uppercase tracking-[0.2em] hover:bg-dark-chocolate/5 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 py-3 px-4 rounded-full bg-sakura text-white font-black text-[10px] uppercase tracking-[0.2em] hover:bg-sakura/80 transition-shadow shadow-lg shadow-sakura/30">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openUploadModal(transactionId) {
        const modal = document.getElementById('uploadModal');
        const form = document.getElementById('uploadForm');
        
        // Update form action URL dynamically
        form.action = `/riwayat/${transactionId}/upload-bukti`;
        
        // Show modal with animation
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        modal.querySelector('.glass-card').classList.remove('scale-95');
    }

    function closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        
        // Hide modal with animation
        modal.classList.add('opacity-0');
        modal.querySelector('.glass-card').classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            // Reset form
            document.getElementById('uploadForm').reset();
        }, 300);
    }
</script>
@endpush
