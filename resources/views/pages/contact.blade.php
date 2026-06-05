@extends('layouts.app')

@section('title', 'Contact Us - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-6 max-w-7xl mx-auto w-full">
        <div class="text-center mb-16 reveal" data-reveal="up">
            <h1 class="text-5xl font-bold mb-4 tracking-tight text-dark-chocolate">Contact <span class="text-sakura">CosRent</span></h1>
            <p class="text-dark-chocolate/80 text-lg max-w-2xl mx-auto font-medium">Have questions about costume rentals, vendor partnerships, or need help? The CosRent team is ready to assist you!</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">

            <div class="space-y-6">
                <div class="glass-card p-8 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl reveal delay-100" data-reveal="left">
                    <h3 class="text-2xl font-bold text-dark-chocolate mb-6">CosRent Support Team</h3>
                    <p class="text-sm text-dark-chocolate/70 font-medium mb-6">Contact one of our admins below for a faster response via WhatsApp.</p>

                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Crist Garcia Pasaribu</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 896-2346-7477</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Rangga Surya Saputra</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 812-6126-0195</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Akbar Zamroni</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 811-7092-501</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-dark-chocolate text-misty-rose p-8 rounded-[2rem] shadow-xl border-2 border-dark-chocolate reveal delay-200" data-reveal="left">
                    <h3 class="text-xl font-bold mb-3 text-sakura"><i class="fa-solid fa-clock mr-2"></i>Service Hours</h3>
                    <p class="text-misty-rose/80 text-sm leading-relaxed">
                        Our team is available from <span class="font-bold text-white">Monday - Friday</span> at <span class="font-bold text-white">09:00 - 17:00 WIB</span>. Messages received outside working hours will be replied to on the next business day.
                    </p>
                </div>
            </div>

            <div class="glass-card p-8 md:p-10 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl h-fit reveal delay-300" data-reveal="right">
                <h3 class="text-2xl font-bold text-dark-chocolate mb-2">Need Help?</h3>
                <p class="text-sm text-dark-chocolate/70 font-medium mb-8">Direct message support is not available in this version. Please contact the support team by WhatsApp for the fastest response.</p>

                <div class="space-y-5">
                    <div class="p-5 bg-white/60 border-2 border-dark-chocolate/10 rounded-2xl">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate shadow-sm flex-shrink-0">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-dark-chocolate">Rental Questions</h4>
                                <p class="text-sm text-dark-chocolate/70 font-medium mt-1">Ask about costume availability, sizes, booking dates, and payment proof status.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white/60 border-2 border-dark-chocolate/10 rounded-2xl">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate shadow-sm flex-shrink-0">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-dark-chocolate">Account or Booking Issues</h4>
                                <p class="text-sm text-dark-chocolate/70 font-medium mt-1">Include your registered email and transaction ID so the team can check your request quickly.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white/60 border-2 border-dark-chocolate/10 rounded-2xl">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate shadow-sm flex-shrink-0">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-dark-chocolate">Partnership Requests</h4>
                                <p class="text-sm text-dark-chocolate/70 font-medium mt-1">For vendor or event collaboration, send a short introduction and your preferred contact method.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 rounded-2xl bg-dark-chocolate/5 border border-dark-chocolate/10 px-5 py-4">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-aloewood mb-2">Recommended details</p>
                        <p class="text-sm text-dark-chocolate/70 font-medium leading-relaxed">Name, registered email, transaction ID if available, costume name, rental date, and a brief explanation of the issue.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
