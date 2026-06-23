@extends('layouts.app')

@section('title', 'Costume Rental History - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-green-100/80 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-8 p-4 bg-red-100/80 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-8 p-4 bg-red-100/80 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                    <p class="font-bold text-sm">An Error Occurred:</p>
                </div>
                <ul class="list-disc list-inside text-sm font-medium ml-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-8 md:p-12 shadow-xl text-center mb-12 bg-white/30 backdrop-blur-lg">
            <span class="mb-2 block text-[10px] font-black uppercase tracking-[0.5em] text-aloewood">Transaction Center</span>
            <h1 class="text-3xl md:text-6xl font-black text-dark-chocolate mb-4 tracking-tighter">Rental History</h1>
            <p class="text-sm md:text-lg font-medium text-dark-chocolate/60 max-w-xl mx-auto leading-relaxed">
                Track all of your costume rental activity.
            </p>
        </div>

        <!-- History List -->
        <div class="space-y-8 w-full">
            @php
                // Status colors and labels are sourced from Transaksi model accessors
            @endphp

            @forelse($historyItems as $item)
                @php
                    $firstDetail = $item->detailTransaksi->first();
                    $kostum = $firstDetail ? $firstDetail->kostum : null;
                    $statusColor = $item->status_color;
                    $penalty = $item->pengembalian?->total_denda ?? 0;
                    $hasPaymentProof = !empty($item->bukti_pembayaran);

                    // Denda berjalan hanya untuk status Disewa (sudah diambil)
                    $dendaBerjalan = 0;
                    $daysLate = 0;
                    if ($item->status === 'Disewa' && \Carbon\Carbon::now()->startOfDay()->greaterThan(\Carbon\Carbon::parse($item->tanggal_selesai)->startOfDay())) {
                        $daysLate = \Carbon\Carbon::parse($item->tanggal_selesai)->startOfDay()->diffInDays(\Carbon\Carbon::now()->startOfDay());
                        $dendaBerjalan = $daysLate * 50000;
                        $penalty += $dendaBerjalan;
                    }

                    $totalCost = $item->total_biaya + $penalty;
                    $paymentDeadline = \Carbon\Carbon::parse($item->created_at)->addHours(12);
                @endphp
                <article class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-6 md:p-10 shadow-lg bg-white/60 flex flex-col lg:flex-row gap-10 items-center lg:items-center w-full">
                    
                    <!-- Image Area -->
                    <div class="w-full lg:w-40 h-40 bg-dark-chocolate/5 rounded-[2rem] flex-shrink-0 overflow-hidden shadow-inner flex items-center justify-center">
                        @if($kostum && $kostum->gambar)
                            <img src="{{ $kostum->gambar_url }}" alt="{{ $kostum->nama_kostum }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-mask text-dark-chocolate/20 text-5xl"></i>
                        @endif
                    </div>

                    <!-- Information Area -->
                    <div class="flex-grow w-full text-center lg:text-left space-y-4">
                        <div class="flex flex-wrap justify-center lg:justify-start items-center gap-3">
                            <span class="bg-dark-chocolate/10 px-3 py-1 rounded-lg text-[10px] font-black text-dark-chocolate tracking-widest">TRX-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="px-4 py-1 rounded-full text-[10px] font-black border {{ $statusColor }} uppercase tracking-wider flex items-center gap-1">
                                @if($item->status === 'Selesai')
                                    <i class="fa-solid fa-rotate-left text-[8px]"></i>
                                @endif
                                @if($item->status === 'Menunggu Pembayaran' && $hasPaymentProof)
                                    Payment Proof Uploaded
                                @else
                                    {{ $item->status_label }}
                                @endif
                            </span>
                        </div>
                        
                        <h3 class="text-2xl md:text-4xl font-black text-dark-chocolate leading-tight tracking-tight">
                            @if($kostum)
                                {{ $kostum->nama_kostum }}
                            @else
                                Transaction #{{ $item->id }}
                            @endif
                            @if($item->detailTransaksi->count() > 1)
                                <span class="text-sm font-bold text-dark-chocolate/40 ml-2">+{{ $item->detailTransaksi->count() - 1 }} more</span>
                            @endif
                        </h3>
                        
                        {{-- Info kontekstual berdasarkan status --}}
                        @if($item->status === 'Menunggu Pembayaran')
                            <div class="text-xs font-bold mt-2 p-3 rounded-xl border inline-block w-full" style="background:rgba(239,68,68,0.06);border-color:rgba(239,68,68,0.2);color:#ef4444;">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                ⚠️ Upload bukti pembayaran sebelum <strong>{{ $paymentDeadline->format('d M Y, H:i') }}</strong>
                                @if($paymentDeadline->isPast())
                                    — <span style="color:#dc2626;">Batas waktu lewat, hubungi admin.</span>
                                @endif
                            </div>
                        @elseif($item->status === 'Menunggu Verifikasi')
                            <div class="text-xs font-bold mt-2 p-3 rounded-xl border inline-block w-full" style="background:rgba(245,158,11,0.06);border-color:rgba(245,158,11,0.2);color:#f59e0b;">
                                <i class="fa-regular fa-clock mr-1"></i>
                                ⏳ Bukti pembayaran sedang diverifikasi admin. Mohon tunggu.
                            </div>
                        @elseif($item->status === 'Sudah Dibayar')
                            <div class="text-xs font-bold mt-2 p-3 rounded-xl border inline-block w-full" style="background:rgba(16,185,129,0.06);border-color:rgba(16,185,129,0.2);color:#10b981;">
                                <i class="fa-solid fa-check-circle mr-1"></i>
                                ✅ Pembayaran diterima! Silakan ambil kostum pada tanggal mulai sewa.
                            </div>
                        @elseif($item->status === 'Batal' && !empty($item->catatan_admin))
                            <p class="text-xs font-bold text-red-500 mt-2 bg-red-50 p-3 rounded-lg border border-red-100 inline-block w-full">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i> Alasan: {{ $item->catatan_admin }}
                            </p>
                        @endif
                        
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start items-center gap-6 text-sm font-bold text-dark-chocolate/60">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sakura/10 flex items-center justify-center text-sakura"><i class="fa-regular fa-calendar-plus"></i></div>
                                <span>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-aloewood/10 flex items-center justify-center text-aloewood"><i class="fa-regular fa-calendar-check"></i></div>
                                <span>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Actions Area -->
                    <div class="w-full lg:w-auto flex flex-col items-center lg:items-end gap-6 pt-8 lg:pt-0 border-t lg:border-0 border-dark-chocolate/10">
                        <div class="text-center lg:text-right">
                            <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-1 opacity-60">Total Cost</p>
                            <p class="text-4xl font-black text-sakura tracking-tighter">Rp {{ number_format($totalCost, 0, ',', '.') }}</p>
                            @if($penalty > 0)
                                @if(isset($dendaBerjalan) && $dendaBerjalan > 0)
                                    <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] mt-1">Late {{ $daysLate }} Days (Penalty Rp {{ number_format($penalty, 0, ',', '.') }})</p>
                                @else
                                    <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] mt-1">Includes penalty Rp {{ number_format($penalty, 0, ',', '.') }}</p>
                                @endif
                            @endif
                        </div>
                        
                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                            {{-- Tombol Invoice: tampilkan untuk status selain Menunggu Pembayaran & Menunggu Verifikasi --}}
                            @if(!in_array($item->status, ['Menunggu Pembayaran', 'Menunggu Verifikasi']))
                            <a href="{{ route('riwayat.faktur', $item->id) }}" class="flex-1 lg:flex-none px-6 py-3 bg-white/80 border-2 border-dark-chocolate/5 rounded-full text-[10px] font-black text-dark-chocolate uppercase tracking-[0.2em] hover:bg-dark-chocolate hover:text-white transition-all shadow-sm flex items-center justify-center">
                                <i class="fa-solid fa-file-invoice mr-2"></i>Invoice
                            </a>
                            @endif
                            {{-- Tombol Upload: hanya untuk Menunggu Pembayaran --}}
                            @if($item->status === 'Menunggu Pembayaran')
                            <button onclick="openUploadModal({{ $item->id }})" class="flex-1 lg:flex-none px-6 py-3 bg-sakura text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-sakura/80 transition-all shadow-xl text-center flex items-center justify-center">
                                <i class="fa-solid fa-upload mr-2"></i>{{ $hasPaymentProof ? 'Ganti Bukti' : 'Upload Bukti' }}
                            </button>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-12 text-center bg-white/40">
                    <div class="w-20 h-20 bg-dark-chocolate/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-receipt text-dark-chocolate/20 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-dark-chocolate mb-2">No history yet</h3>
                    <p class="text-dark-chocolate/60 text-sm font-medium">You have not rented any costumes yet.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-8 px-8 py-3 bg-sakura text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-sakura/80 transition-all shadow-lg">
                        Start Renting Now
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Back Button -->
        <div class="mt-20 text-center">
            <a href="{{ route('dashboard.pelanggan') }}" class="inline-flex items-center gap-3 px-10 py-4 rounded-full bg-white/40 border border-white/60 text-dark-chocolate font-black text-[10px] uppercase tracking-[0.4em] hover:bg-white/80 transition-all duration-300 hover:shadow-xl">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
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
<script>
    // Auto-open modal if session variable exists
    @if(session('open_upload_modal'))
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                openUploadModal({{ session('open_upload_modal') }});
            }, 500); // Slight delay for smoother UX
        });
    @endif
</script>
@endpush
