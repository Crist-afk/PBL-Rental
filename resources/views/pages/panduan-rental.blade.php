@extends('layouts.app')

@section('title', 'Rental Guide - CosRent')

@section('content')
<main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-6xl mx-auto w-full">

    {{-- ══════════════════════════════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════════════════════════════ --}}
    <div class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-10 md:px-12 md:py-14 shadow-xl text-center relative overflow-hidden mb-12">
        {{-- Decorative circles --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-sakura/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-aloewood/10 rounded-full blur-3xl"></div>

        <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood relative z-10">Complete Guide</span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-dark-chocolate relative z-10">
            Rental Guide
            <span class="text-sakura">CosRent</span>
        </h1>
        <p class="mt-5 text-base md:text-lg font-medium leading-relaxed text-dark-chocolate/70 max-w-2xl mx-auto relative z-10">
            Learn the complete costume rental workflow at CosRent — from choosing a costume to returning it. Easy, secure, and transparent.
        </p>

        {{-- Scroll indicator --}}
        <div class="mt-8 flex justify-center relative z-10">
            <div class="animate-bounce w-10 h-10 bg-dark-chocolate/10 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-chevron-down text-dark-chocolate/50"></i>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 1 — CARA MENYEWA
    ══════════════════════════════════════════════════════════════ --}}
    <section class="mb-16" id="cara-menyewa">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-sakura/20 rounded-2xl flex items-center justify-center text-sakura text-xl flex-shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-aloewood">Step 1</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-dark-chocolate">How to Rent</h2>
            </div>
        </div>

        {{-- Timeline Steps --}}
        <div class="relative">
            {{-- Vertical line --}}
            <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-sakura via-aloewood to-dark-chocolate/20 hidden md:block"></div>

            <div class="space-y-6 md:ml-16">
                @php
                    $steps = [
                        ['icon' => 'fa-shirt', 'color' => 'sakura', 'title' => 'Choose Costume', 'desc' => 'Explore our cosplay costume catalog and select your favorite character.'],
                        ['icon' => 'fa-ruler', 'color' => 'aloewood', 'title' => 'Choose Size', 'desc' => 'Determine the correct size (S, M, L, XL) so that the costume fits you well.'],
                        ['icon' => 'fa-calendar-days', 'color' => 'sakura', 'title' => 'Select Rental Dates', 'desc' => 'Set the start and end dates. The system will automatically check availability.'],
                        ['icon' => 'fa-pen-to-square', 'color' => 'aloewood', 'title' => 'Add Notes (Optional)', 'desc' => 'Add special notes if you have specific requests, such as extra accessories.'],
                        ['icon' => 'fa-cart-shopping', 'color' => 'sakura', 'title' => 'Click Book Now', 'desc' => 'After filling everything out, press the Book Now button to place your order.'],
                        ['icon' => 'fa-cloud-arrow-up', 'color' => 'aloewood', 'title' => 'Upload Payment Proof', 'desc' => 'Make a payment and upload the transaction proof on your Transaction History page.'],
                    ];
                @endphp

                @foreach ($steps as $i => $step)
                    <div class="glass-card rounded-2xl border border-dark-chocolate/10 p-5 md:p-6 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative flex items-start gap-5 group"
                         style="animation: fadeInUp 0.5s ease-out {{ ($i * 0.1) }}s both;">
                        {{-- Timeline dot (desktop) --}}
                        <div class="hidden md:block absolute -left-[3.25rem] top-6 w-5 h-5 rounded-full bg-{{ $step['color'] }} border-4 border-white shadow-lg z-10"></div>

                        {{-- Step number badge --}}
                        <div class="w-14 h-14 bg-{{ $step['color'] }}/15 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $step['icon'] }} text-{{ $step['color'] }} text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-dark-chocolate text-white text-xs font-black">{{ $i + 1 }}</span>
                                <h3 class="text-lg font-bold text-dark-chocolate">{{ $step['title'] }}</h3>
                            </div>
                            <p class="text-sm text-dark-chocolate/65 font-medium leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 2 — CARA PEMBAYARAN
    ══════════════════════════════════════════════════════════════ --}}
    <section class="mb-16" id="cara-pembayaran">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-aloewood/20 rounded-2xl flex items-center justify-center text-aloewood text-xl flex-shrink-0">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-aloewood">Step 2</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-dark-chocolate">Payment Methods</h2>
            </div>
        </div>

        <p class="text-dark-chocolate/65 font-medium mb-8 max-w-2xl">
            Make a payment to one of the following methods. After transferring, upload the payment proof on the <strong class="text-dark-chocolate">Transaction History</strong> page.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card: Transfer Bank BCA --}}
            <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-7 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center relative overflow-hidden group">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-building-columns text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-extrabold text-dark-chocolate mb-1">Bank Transfer</h3>
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-black rounded-full uppercase tracking-wider mb-4">BCA</span>
                <div class="bg-dark-chocolate/5 rounded-xl p-4 space-y-2">
                    <p class="text-sm font-medium text-dark-chocolate/60">Account Number</p>
                    <p class="text-xl font-black text-dark-chocolate tracking-wider">1234567890</p>
                    <p class="text-sm font-bold text-aloewood">a.n CosRent</p>
                </div>
            </div>

            {{-- Card: DANA --}}
            <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-7 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center relative overflow-hidden group">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-400 to-cyan-500"></div>
                <div class="w-16 h-16 bg-cyan-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-wallet text-cyan-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-extrabold text-dark-chocolate mb-1">E-Wallet</h3>
                <span class="inline-block px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-black rounded-full uppercase tracking-wider mb-4">DANA</span>
                <div class="bg-dark-chocolate/5 rounded-xl p-4 space-y-2">
                    <p class="text-sm font-medium text-dark-chocolate/60">Phone Number</p>
                    <p class="text-xl font-black text-dark-chocolate tracking-wider">081234567890</p>
                    <p class="text-sm font-bold text-aloewood">a.n CosRent</p>
                </div>
            </div>

            {{-- Card: QRIS --}}
            <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-7 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center relative overflow-hidden group">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sakura to-aloewood"></div>
                <div class="w-16 h-16 bg-sakura/15 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-qrcode text-sakura text-2xl"></i>
                </div>
                <h3 class="text-lg font-extrabold text-dark-chocolate mb-1">Scan & Pay</h3>
                <span class="inline-block px-3 py-1 bg-sakura/20 text-dark-chocolate text-xs font-black rounded-full uppercase tracking-wider mb-4">QRIS</span>
                <div class="bg-dark-chocolate/5 rounded-xl p-4">
                    <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS CosRent" class="w-full max-w-[180px] mx-auto rounded-lg shadow-sm">
                    <p class="text-xs font-bold text-dark-chocolate/50 mt-3">Scan using your e-wallet app</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 3 — VERIFIKASI PEMBAYARAN
    ══════════════════════════════════════════════════════════════ --}}
    <section class="mb-16" id="verifikasi-pembayaran">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-aloewood">Step 3</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-dark-chocolate">Payment Verification</h2>
            </div>
        </div>

        <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-8 md:p-10 shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Left: Explanation --}}
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-sakura/15 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-cloud-arrow-up text-sakura"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-chocolate mb-1">Upload Payment Proof</h4>
                            <p class="text-sm text-dark-chocolate/60 font-medium">After transferring, upload the payment proof on the <strong>Transaction History</strong> page.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-aloewood/15 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-user-check text-aloewood"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-chocolate mb-1">Verification by Admin</h4>
                            <p class="text-sm text-dark-chocolate/60 font-medium">The admin will review and verify your payment proof. Payments are <strong>not instantly confirmed</strong> without admin verification.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-rotate text-red-500"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-dark-chocolate mb-1">What if Rejected?</h4>
                            <p class="text-sm text-dark-chocolate/60 font-medium">If the payment proof is invalid, the order status changes to <strong class="text-red-500">Rejected</strong>. You can re-upload the correct payment proof.</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Visual Flow --}}
                <div class="bg-dark-chocolate/5 rounded-2xl p-6 flex flex-col items-center justify-center gap-4">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-hourglass-half text-yellow-600 text-xl"></i>
                        </div>
                        <p class="text-sm font-bold text-dark-chocolate">Awaiting Verification</p>
                    </div>
                    <i class="fa-solid fa-arrow-down text-dark-chocolate/30"></i>
                    <div class="flex gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-check text-green-600"></i>
                            </div>
                            <p class="text-xs font-bold text-green-700">Approved</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-xmark text-red-500"></i>
                            </div>
                            <p class="text-xs font-bold text-red-500">Rejected</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-arrow-down text-dark-chocolate/30"></i>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-sakura/20 rounded-full flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-redo text-sakura"></i>
                        </div>
                        <p class="text-xs font-bold text-dark-chocolate/60">Re-upload <br>(if rejected)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 4 — PENGAMBILAN KOSTUM
    ══════════════════════════════════════════════════════════════ --}}
    <section class="mb-16" id="pengambilan-kostum">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-aloewood">Step 4</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-dark-chocolate">Costume Pickup</h2>
            </div>
        </div>

        <p class="text-dark-chocolate/65 font-medium mb-8 max-w-2xl">
            Once payment is verified, the order status will progress through the following stages:
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Status: Sudah Dibayar --}}
            <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-7 shadow-xl relative overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-green-400 to-emerald-500"></div>
                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-black rounded-full uppercase tracking-wider mb-3">Payment Confirmed</span>
                        <h3 class="text-lg font-bold text-dark-chocolate mb-2">Valid Payment</h3>
                        <p class="text-sm text-dark-chocolate/60 font-medium leading-relaxed">
                            Payment has been verified and marked valid by the admin. The costume is prepared and <strong>ready for pickup</strong> at CosRent.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Status: Disewa --}}
            <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-7 shadow-xl relative overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sakura to-aloewood"></div>
                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 bg-sakura/15 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-person-walking-luggage text-sakura text-2xl"></i>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 bg-sakura/20 text-dark-chocolate text-xs font-black rounded-full uppercase tracking-wider mb-3">Rental Active</span>
                        <h3 class="text-lg font-bold text-dark-chocolate mb-2">Costume Picked Up</h3>
                        <p class="text-sm text-dark-chocolate/60 font-medium leading-relaxed">
                            The costume has been <strong>picked up by the customer</strong>. This status is active during the rental period until the return date.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 5 — PENGEMBALIAN KOSTUM
    ══════════════════════════════════════════════════════════════ --}}
    <section class="mb-16" id="pengembalian-kostum">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-[0.3em] text-aloewood">Step 5</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-dark-chocolate">Costume Return</h2>
            </div>
        </div>

        <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-8 md:p-10 shadow-xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div class="flex items-start gap-4 p-5 bg-dark-chocolate/5 rounded-2xl hover:bg-dark-chocolate/8 transition-colors">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-calendar-check text-amber-600 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-dark-chocolate mb-1">On Time</h4>
                        <p class="text-sm text-dark-chocolate/60 font-medium">The costume must be returned according to the <strong>return date</strong> specified in the order.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 bg-dark-chocolate/5 rounded-2xl hover:bg-dark-chocolate/8 transition-colors">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-clock text-red-500 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-dark-chocolate mb-1">Late Return Penalties</h4>
                        <p class="text-sm text-dark-chocolate/60 font-medium">Late returns will incur <strong>automatic late fees</strong> calculated by the system.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 bg-dark-chocolate/5 rounded-2xl hover:bg-dark-chocolate/8 transition-colors">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-magnifying-glass text-blue-500 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-dark-chocolate mb-1">Condition Inspection</h4>
                        <p class="text-sm text-dark-chocolate/60 font-medium">The admin will inspect the condition of the costume upon return to ensure quality is maintained.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-5 bg-dark-chocolate/5 rounded-2xl hover:bg-dark-chocolate/8 transition-colors">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-screwdriver-wrench text-orange-500 text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-dark-chocolate mb-1">Damage Fees</h4>
                        <p class="text-sm text-dark-chocolate/60 font-medium">If there is damage, <strong>fines will be assessed</strong> by the admin based on the costume condition.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         CTA / ONBOARDING COMPLETION
    ══════════════════════════════════════════════════════════════ --}}
    <section class="text-center mb-8">
        <div class="glass-card rounded-[2.5rem] border-2 border-sakura/30 bg-gradient-to-br from-misty-rose/60 to-white px-8 py-12 shadow-xl relative overflow-hidden">
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-sakura/15 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-aloewood/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-20 h-20 bg-sakura/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-graduation-cap text-sakura text-3xl"></i>
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold text-dark-chocolate mb-3">Guide Completed!</h2>
                <p class="text-dark-chocolate/60 font-medium max-w-md mx-auto mb-8">
                    You have understood the complete rental process at CosRent. Now it is time to start renting your dream costume!
                </p>

                @auth
                    @if ($showOnboarding)
                        {{-- Tombol onboarding: user baru yang belum pernah melihat panduan --}}
                        <form action="{{ route('panduan.mark-seen') }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-3 px-10 py-4 bg-dark-chocolate text-white rounded-full text-sm font-black uppercase tracking-[0.15em] hover:bg-black hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 shadow-xl">
                                <i class="fa-solid fa-rocket"></i>
                                I Understand — Start Renting
                            </button>
                        </form>
                    @else
                        {{-- User lama yang sudah pernah melihat panduan --}}
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-dark-chocolate text-white rounded-full text-sm font-black uppercase tracking-[0.15em] hover:bg-black hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 shadow-xl">
                                <i class="fa-solid fa-bag-shopping"></i>
                                Explore Costumes
                            </a>
                            <a href="{{ route('dashboard.pelanggan') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-sakura text-dark-chocolate rounded-full text-sm font-black uppercase tracking-[0.15em] hover:bg-sakura/80 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 shadow-xl">
                                <i class="fa-solid fa-gauge-high"></i>
                                Dashboard
                            </a>
                        </div>
                    @endif
                @else
                    {{-- Guest user --}}
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-dark-chocolate text-white rounded-full text-sm font-black uppercase tracking-[0.15em] hover:bg-black hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 shadow-xl">
                            <i class="fa-solid fa-user-plus"></i>
                            Register Now
                        </a>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-sakura text-dark-chocolate rounded-full text-sm font-black uppercase tracking-[0.15em] hover:bg-sakura/80 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 shadow-xl">
                            <i class="fa-solid fa-bag-shopping"></i>
                            View Costumes
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </section>

</main>

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
@endsection
