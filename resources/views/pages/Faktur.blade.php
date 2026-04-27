@extends('layouts.app')

@section('title', 'Faktur #' . str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) . ' - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-4xl mx-auto w-full">
        
        <!-- Action Buttons (Hidden on Print) -->
        <div class="flex justify-between items-center mb-8 print:hidden">
            <a href="{{ route('riwayat.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-dark-chocolate/60 hover:text-dark-chocolate transition-colors uppercase tracking-widest">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="px-6 py-3 bg-dark-chocolate text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Faktur
            </button>
        </div>

        <!-- Invoice Card -->
        <div class="glass-card rounded-[3rem] border-2 border-dark-chocolate/10 bg-white shadow-2xl overflow-hidden print:shadow-none print:border-0 print:rounded-none">
            
            <!-- Invoice Header -->
            <div class="p-10 md:p-16 bg-dark-chocolate text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                
                <div>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-2">FAKTUR</h1>
                    <p class="text-white/60 font-bold uppercase tracking-[0.3em] text-xs">Bukti Penyewaan Resmi</p>
                </div>
                
                <div class="text-left md:text-right">
                    <p class="text-xs font-black uppercase tracking-widest text-sakura mb-1">Nomor Transaksi</p>
                    <p class="text-2xl font-black tracking-widest">TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Invoice Body -->
            <div class="p-10 md:p-16 space-y-12">
                
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 border-b border-dark-chocolate/5 pb-12">
                    <!-- Client Info -->
                    <div>
                        <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-4">Penyewa</h4>
                        <div class="space-y-1">
                            <p class="text-xl font-black text-dark-chocolate">{{ $transaksi->user->nama }}</p>
                            <p class="text-sm font-bold text-dark-chocolate/60">{{ $transaksi->user->email }}</p>
                        </div>
                    </div>
                    
                    <!-- Dates -->
                    <div class="md:text-right">
                        <h4 class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-4">Periode Sewa</h4>
                        <div class="flex flex-col md:items-end gap-2">
                            <div class="flex items-center gap-3 text-sm font-bold text-dark-chocolate">
                                <span class="text-dark-chocolate/40 uppercase text-[10px]">Mulai:</span>
                                <span>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold text-dark-chocolate">
                                <span class="text-dark-chocolate/40 uppercase text-[10px]">Kembali:</span>
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
                                <th class="py-4 text-[10px] font-black text-aloewood uppercase tracking-widest">Kostum</th>
                                <th class="py-4 px-4 text-[10px] font-black text-aloewood uppercase tracking-widest text-center">Durasi</th>
                                <th class="py-4 text-[10px] font-black text-aloewood uppercase tracking-widest text-right">Harga / Hari</th>
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
                                                <p class="text-[10px] font-bold text-dark-chocolate/40 uppercase tracking-widest">{{ $detail->kostum->kategori->nama_kategori ?? 'Kostum' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-4 text-center font-bold text-dark-chocolate">
                                        {{ $days }} Hari
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
                        <span class="text-sm font-bold text-dark-chocolate/40 uppercase tracking-widest">Denda</span>
                        <span class="text-sm font-bold text-dark-chocolate">Rp {{ number_format($transaksi->total_denda, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between w-full md:w-64 pt-4 border-t border-dark-chocolate/5">
                        <span class="text-lg font-black text-dark-chocolate uppercase tracking-widest">Total</span>
                        <span class="text-2xl font-black text-sakura">Rp {{ number_format($transaksi->total_biaya + $transaksi->total_denda, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="pt-12 mt-12 border-t border-dark-chocolate/5 flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
                    <div>
                        <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-2">Metode Pembayaran</p>
                        <p class="text-sm font-bold text-dark-chocolate">Transfer Bank / E-Wallet</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-aloewood uppercase tracking-[0.3em] mb-2">Status Pembayaran</p>
                        <span class="px-4 py-1 rounded-full text-[10px] font-black border border-green-200 bg-green-100 text-green-700 uppercase tracking-wider">
                            LUNAS
                        </span>
                    </div>
                    <div class="md:text-right">
                        <p class="text-[10px] font-black text-dark-chocolate/40 mb-1">Dicetak pada:</p>
                        <p class="text-[10px] font-bold text-dark-chocolate">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Stripe -->
            <div class="h-2 bg-sakura w-full"></div>
        </div>

        <!-- Thank You Note -->
        <div class="mt-12 text-center">
            <p class="text-dark-chocolate/40 font-black text-sm uppercase tracking-widest">Terima kasih telah menyewa di CosRent!</p>
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
