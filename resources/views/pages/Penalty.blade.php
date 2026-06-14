@extends('layouts.app')

@section('title', 'Late Penalties - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full">
        
        <!-- Header -->
        <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-8 md:p-12 shadow-xl text-center mb-12 bg-white/30 backdrop-blur-lg">
            <span class="mb-2 block text-[10px] font-black uppercase tracking-[0.5em] text-aloewood">Penalty Center</span>
            <h1 class="text-3xl md:text-6xl font-black text-red-600 mb-4 tracking-tighter">Late Costume Penalties</h1>
            <p class="text-sm md:text-lg font-medium text-dark-chocolate/60 max-w-xl mx-auto leading-relaxed">
                Review your late costume returns and associated fees.
            </p>
        </div>

        <!-- Penalty List -->
        <div class="space-y-8 w-full">
            @forelse($late_rentals as $rental)
                <article class="glass-card rounded-[2.5rem] border-2 border-red-500/20 p-6 md:p-10 shadow-lg bg-red-50 flex flex-col lg:flex-row gap-10 items-center lg:items-center w-full">
                    
                    <!-- Image Area -->
                    <div class="w-full lg:w-40 h-40 bg-dark-chocolate/5 rounded-[2rem] flex-shrink-0 overflow-hidden shadow-inner flex items-center justify-center">
                        @if($rental['image'])
                            <img src="{{ $rental['image'] }}" alt="{{ $rental['title'] }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-mask text-dark-chocolate/20 text-5xl"></i>
                        @endif
                    </div>

                    <!-- Information Area -->
                    <div class="flex-grow w-full text-center lg:text-left space-y-4">
                        <div class="flex flex-wrap justify-center lg:justify-start items-center gap-3">
                            <span class="bg-dark-chocolate/10 px-3 py-1 rounded-lg text-[10px] font-black text-dark-chocolate tracking-widest">TRX-{{ str_pad($rental['id'], 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="px-4 py-1 rounded-full text-[10px] font-black border border-red-500 text-red-600 uppercase tracking-wider flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> LATE
                            </span>
                        </div>
                        
                        <h3 class="text-2xl md:text-4xl font-black text-dark-chocolate leading-tight tracking-tight">
                            {{ $rental['title'] }}
                        </h3>
                        
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start items-center gap-6 text-sm font-bold text-dark-chocolate/60">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-aloewood/10 flex items-center justify-center text-aloewood"><i class="fa-regular fa-calendar-xmark"></i></div>
                                <span>Return Date: {{ $rental['return_date'] }}</span>
                            </div>
                        </div>

                        <p class="text-sm font-bold text-red-600 mt-2">
                            <i class="fa-solid fa-clock mr-1"></i> You are {{ $rental['days_late'] }} day(s) late.
                        </p>
                    </div>

                    <!-- Price & Actions Area -->
                    <div class="w-full lg:w-auto flex flex-col items-center lg:items-end gap-6 pt-8 lg:pt-0 border-t lg:border-0 border-red-500/10">
                        <div class="text-center lg:text-right">
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.3em] mb-1 opacity-80">Total Penalty</p>
                            <p class="text-4xl font-black text-red-600 tracking-tighter">Rp {{ number_format($rental['denda'], 0, ',', '.') }}</p>
                            <p class="text-[10px] font-black text-dark-chocolate uppercase tracking-[0.2em] mt-1">Rp 50.000 / day</p>
                        </div>
                    </div>
                </article>
            @empty
                <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-12 text-center bg-white/40">
                    <div class="w-20 h-20 bg-dark-chocolate/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-face-smile-beam text-green-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-dark-chocolate mb-2">No Late Penalties</h3>
                    <p class="text-dark-chocolate/60 text-sm font-medium">Great job! You have no late costumes.</p>
                    <a href="{{ route('dashboard.pelanggan') }}" class="inline-block mt-8 px-8 py-3 bg-sakura text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] hover:bg-sakura/80 transition-all shadow-lg">
                        Back to Dashboard
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

@endsection
