@extends('layouts.app')

@section('title', 'Invoice #' . str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) . ' - CosRent')

@section('content')
    @php
        $pengembalian = $transaksi->pengembalian;
        $returnPenalty = $pengembalian?->total_denda ?? 0;
        $returnNote = $pengembalian?->catatan_qc;
    @endphp

    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-4xl mx-auto w-full">
        
        <!-- Action Buttons (Hidden on Print) -->
        <div class="flex justify-between items-center mb-8 print:hidden">
            <a href="{{ route('riwayat.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-dark-chocolate/60 hover:text-dark-chocolate transition-colors uppercase tracking-widest">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="px-6 py-3 bg-dark-chocolate text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Print Invoice
            </button>
        </div>

        <!-- Invoice Card -->
        <div class="glass-card rounded-[3rem] border-2 border-dark-chocolate/10 bg-white shadow-2xl overflow-hidden print:shadow-none print:border-0 print:rounded-none">
            
            <!-- Invoice Header -->
            <div class="p-10 md:p-16 bg-dark-chocolate text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                
                <div>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-2">INVOICE</h1>
                    <p class="text-white/60 font-bold uppercase tracking-[0.3em] text-xs">Official Rental Receipt</p>
                </div>
                
                <div class="text-left md:text-right">
                    <p class="text-xs font-black uppercase tracking-widest text-sakura mb-1">Transaction Number</p>
                    <p class="text-2xl font-black tracking-widest">TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Invoice Body -->
            <div class="p-10 md:p-16 space-y-12">
                
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 border-b border-dark-chocolate/5 pb-12">
                    <!-- Client Info -->
                    <div>
                        <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-4">Renter</h4>
                        <div class="space-y-1">
                            <p class="text-xl font-black text-dark-chocolate">{{ $transaksi->user->nama }}</p>
                            <p class="text-sm font-bold text-dark-chocolate/60">{{ $transaksi->user->email }}</p>
                        </div>
                    </div>
                    
                    <!-- Dates -->
                    <div class="md:text-right">
                        <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-4">Rental Period</h4>
                        <div class="flex flex-col md:items-end gap-2">
                            <div class="flex items-center gap-3 text-sm font-bold text-dark-chocolate">
                                <span class="text-dark-chocolate/40 uppercase text-[10px]">Start:</span>
                                <span>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold text-dark-chocolate">
                                <span class="text-dark-chocolate/40 uppercase text-[10px]">Return:</span>
                                <span>{{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b-2 border-dark-chocolate/10">
                                <th class="py-4 text-[10px] font-black text-aloewood uppercase tracking-widest">Costume</th>
                                <th class="py-4 px-4 text-[10px] font-black text-aloewood uppercase tracking-widest text-center">Duration</th>
                                <th class="py-4 text-[10px] font-black text-aloewood uppercase tracking-widest text-right">Price / Day</th>
                                <th class="py-4 text-[10px] font-black text-aloewood uppercase tracking-widest text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-chocolate/5">
                            @php
                                $start = \Carbon\Carbon::parse($transaksi->tanggal_mulai);
                                $end = \Carbon\Carbon::parse($transaksi->tanggal_selesai);
                                $days = max(1, $start->diffInDays($end));
                            @endphp
                            @foreach($transaksi->detailTransaksi as $detail)
                                <tr>
                                    <td class="py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-dark-chocolate/5 overflow-hidden flex-shrink-0">
                                                <img src="{{ $detail->kostum->gambar_url }}" alt="{{ $detail->kostum->nama_kostum }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <p class="font-black text-dark-chocolate">{{ $detail->kostum->nama_kostum }}</p>
                                                <p class="text-[10px] font-bold text-dark-chocolate/40 uppercase tracking-widest">
                                                    {{ $detail->kostum->kategori->nama_kategori ?? 'Costume' }}
                                                    @if($detail->ukuran)
                                                        / Size {{ $detail->ukuran }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-4 text-center font-bold text-dark-chocolate">
                                        {{ $days }} Days
                                    </td>
                                    <td class="py-6 text-right font-bold text-dark-chocolate">
                                        Rp {{ number_format($detail->harga_sewa_saat_transaksi / $days, 0, ',', '.') }}
                                    </td>
                                    <td class="py-6 text-right font-black text-dark-chocolate">
                                        Rp {{ number_format($detail->harga_sewa_saat_transaksi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="pt-8 border-t-2 border-dark-chocolate/10 flex flex-col items-end gap-4">
                    <div class="flex justify-between w-full md:w-64">
                        <span class="text-sm font-bold text-dark-chocolate/40 uppercase tracking-widest">Subtotal</span>
                        <span class="text-sm font-bold text-dark-chocolate">Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between w-full md:w-64">
                        <span class="text-sm font-bold text-dark-chocolate/40 uppercase tracking-widest">Penalty</span>
                        <span class="text-sm font-bold text-dark-chocolate">Rp {{ number_format($returnPenalty, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between w-full md:w-64 pt-4 border-t border-dark-chocolate/5">
                        <span class="text-lg font-black text-dark-chocolate uppercase tracking-widest">Total</span>
                        <span class="text-2xl font-black text-sakura">Rp {{ number_format($transaksi->total_biaya + $returnPenalty, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Catatan Pelanggan (jika ada) -->
                @if($transaksi->catatan)
                <div class="pt-8 border-t border-dark-chocolate/5">
                    <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-3">Customer Notes</h4>
                    <p class="text-sm font-medium text-dark-chocolate/80 bg-dark-chocolate/5 rounded-2xl px-5 py-4">{{ $transaksi->catatan }}</p>
                </div>
                @endif

                <!-- Catatan Admin (jika ada) -->
                @if($transaksi->catatan_admin)
                <div class="pt-8 border-t border-dark-chocolate/5">
                    <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-3">Admin Notes</h4>
                    <p class="text-sm font-medium text-dark-chocolate/80 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">{{ $transaksi->catatan_admin }}</p>
                </div>
                @endif

                <!-- Catatan QC Pengembalian (jika ada) -->
                @if($returnNote)
                <div class="pt-8 border-t border-dark-chocolate/5">
                    <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-3">Return QC Notes</h4>
                    <p class="text-sm font-medium text-dark-chocolate/80 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">{{ $returnNote }}</p>
                </div>
                @endif

                {{-- ── Metode Pembayaran ── --}}
                <div class="pt-8 border-t border-dark-chocolate/5 print:border-t-2 print:border-dark-chocolate/20">
                    <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-6">Metode Pembayaran</h4>

                    {{-- Grid: 3 kolom --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                        {{-- BCA Bank Transfer --}}
                        <div class="rounded-2xl border-2 border-dark-chocolate/10 p-5 bg-white/60 flex flex-col gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 bg-blue-500/10 text-blue-600 rounded-xl flex items-center justify-center text-sm font-black">🏦</span>
                                <span class="text-[10px] font-black text-aloewood uppercase tracking-widest">Bank Transfer</span>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-black text-dark-chocolate uppercase tracking-wide">BCA</p>
                                <p class="text-lg font-black text-dark-chocolate tracking-widest">1234567890</p>
                                <p class="text-[10px] font-bold text-dark-chocolate/50 uppercase tracking-widest">a.n CosRent</p>
                            </div>
                        </div>

                        {{-- DANA E-Wallet --}}
                        <div class="rounded-2xl border-2 border-dark-chocolate/10 p-5 bg-white/60 flex flex-col gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 bg-blue-400/10 text-blue-500 rounded-xl flex items-center justify-center text-sm font-black">📱</span>
                                <span class="text-[10px] font-black text-aloewood uppercase tracking-widest">E-Wallet</span>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-black text-dark-chocolate uppercase tracking-wide">DANA</p>
                                <p class="text-lg font-black text-dark-chocolate tracking-widest">081234567890</p>
                                <p class="text-[10px] font-bold text-dark-chocolate/50 uppercase tracking-widest">a.n CosRent</p>
                            </div>
                        </div>

                        {{-- QRIS --}}
                        <div class="rounded-2xl border-2 border-dark-chocolate/10 p-5 bg-white/60 flex flex-col gap-3">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 bg-sakura/10 text-sakura rounded-xl flex items-center justify-center text-sm font-black">⚡</span>
                                <span class="text-[10px] font-black text-aloewood uppercase tracking-widest">QRIS</span>
                            </div>
                            <div class="flex-1 flex items-center justify-center">
                                @if(file_exists(public_path('images/qris-placeholder.png')))
                                    <img src="{{ asset('images/qris-placeholder.png') }}"
                                         alt="QRIS CosRent"
                                         class="w-full max-w-[120px] h-auto object-contain mx-auto rounded-xl border border-dark-chocolate/10">
                                @else
                                    <div class="w-full max-w-[120px] h-[120px] mx-auto rounded-xl border-2 border-dashed border-dark-chocolate/20 bg-dark-chocolate/5 flex flex-col items-center justify-center text-center p-2">
                                        <i class="fa-solid fa-qrcode text-2xl text-dark-chocolate/30 mb-2"></i>
                                        <p class="text-[9px] font-black text-dark-chocolate/40 uppercase tracking-wider leading-tight">QRIS IMAGE<br>PLACEHOLDER</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Langkah Pembayaran --}}
                    <div class="rounded-2xl border border-dark-chocolate/10 bg-dark-chocolate/3 p-5 mb-4">
                        <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-4">Cara Pembayaran</p>
                        <ol class="space-y-2">
                            @foreach([
                                ['icon' => 'fa-money-bill-transfer', 'text' => 'Transfer sesuai total tagihan di atas'],
                                ['icon' => 'fa-camera',              'text' => 'Simpan / screenshot bukti pembayaran'],
                                ['icon' => 'fa-upload',              'text' => 'Upload bukti pembayaran di halaman Riwayat'],
                                ['icon' => 'fa-clock',               'text' => 'Tunggu verifikasi dari admin (maks 1×24 jam)'],
                                ['icon' => 'fa-box-open',            'text' => 'Ambil kostum setelah pembayaran disetujui admin'],
                            ] as $idx => $step)
                            <li class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-sakura/15 text-sakura flex items-center justify-center flex-shrink-0 text-[10px] font-black mt-0.5">{{ $idx + 1 }}</span>
                                <div class="flex items-center gap-2 text-sm font-medium text-dark-chocolate/80">
                                    <i class="fa-solid {{ $step['icon'] }} text-sakura/70 w-4 text-center text-xs"></i>
                                    {{ $step['text'] }}
                                </div>
                            </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Catatan Peringatan --}}
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 flex-shrink-0"></i>
                        <p class="text-xs font-bold text-amber-700">
                            Pembayaran yang tidak valid (jumlah tidak sesuai, bukti tidak terbaca, atau bukti palsu) dapat ditolak oleh admin. Pastikan jumlah transfer sesuai total tagihan.
                        </p>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="pt-12 mt-12 border-t border-dark-chocolate/5 flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
                    <div>
                        <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-2">Payment Method</p>
                        <p class="text-sm font-bold text-dark-chocolate">Transfer Bank / E-Wallet</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-2">Payment Status</p>
                        <span class="px-4 py-1 rounded-full text-[10px] font-black border {{ $transaksi->status_color }} uppercase tracking-wider">
                            {{ $transaksi->status_label }}
                        </span>
                    </div>
                    @if($transaksi->bukti_pembayaran)
                    <div class="md:text-right">
                        <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-2">Payment Proof</p>
                        <a href="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" target="_blank"
                           class="inline-flex items-center gap-2 text-xs font-bold text-sakura hover:text-dark-chocolate transition">
                            <i class="fa-solid fa-image"></i> View Proof
                        </a>
                    </div>
                    @endif
                    <div class="md:text-right">
                        <p class="text-[10px] font-black text-dark-chocolate/40 mb-1">Printed on:</p>
                        <p class="text-[10px] font-bold text-dark-chocolate">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Stripe -->
            <div class="h-2 bg-sakura w-full"></div>
        </div>

        <!-- Thank You Note -->
        <div class="mt-12 text-center">
            <p class="text-dark-chocolate/40 font-black text-sm uppercase tracking-widest">Thank you for renting with CosRent!</p>
        </div>

    </main>

    <style>
        @media print {
            body {
                background: white !important;
            }
            .pt-32 {
                padding-top: 0 !important;
            }
            .pb-20 {
                padding-bottom: 0 !important;
            }
            nav, footer {
                display: none !important;
            }
            .glass-card {
                backdrop-filter: none !important;
                background: white !important;
            }
        }
    </style>
@endsection
