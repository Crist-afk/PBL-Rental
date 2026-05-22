@extends('layouts.app')

@section('title', 'About Us - CosRent')

@push('styles')
@endpush

@section('content')
    <main class="flex-grow w-full overflow-hidden bg-misty-rose relative">

        <div class="absolute inset-0 z-0 opacity-[0.15] mix-blend-color-burn pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1522383225653-ed111181a951?q=80&w=2000&auto=format&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed;"></div>

        <section class="relative min-h-screen flex items-center justify-center pt-24 pb-12 px-6">
            <div class="max-w-7xl mx-auto w-full flex flex-col md:flex-row items-center relative z-10 gap-10">

                <div class="w-full md:w-1/2 flex flex-col justify-center relative z-20 reveal" data-reveal="up">
                    <span class="text-aloewood font-bold tracking-[0.3em] uppercase text-xs md:text-sm mb-4 block">Cosplay Rental Platform</span>

                    <div class="relative inline-block">
                        <h1 class="text-[4rem] md:text-[5.5rem] lg:text-[7rem] font-black text-dark-chocolate leading-[0.88] tracking-tighter uppercase relative z-20">
                            RENT COSPLAY COSTUMES<br>
                            <span class="text-sakura drop-shadow-md">MADE EASIER.</span>
                        </h1>
                    </div>

                    <p class="text-dark-chocolate/85 text-xl md:text-2xl font-semibold mt-6 max-w-xl leading-snug">
                        CosRent helps you find, choose, and rent cosplay costumes with clear information from the start.
                    </p>

                    <p class="text-dark-chocolate/80 text-lg font-medium mt-6 max-w-xl leading-relaxed border-l-4 border-sakura pl-4 backdrop-blur-sm bg-white/20 p-2 rounded-r-xl">
                        Browse the costume catalog, check size details, choose rental dates, and follow the booking process with confidence.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3 text-[11px] font-bold uppercase tracking-[0.18em] text-dark-chocolate/70">
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Costume Catalog</span>
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Clear Sizes</span>
                        <span class="rounded-full border border-white/60 bg-white/30 px-4 py-2 backdrop-blur-sm">Rental Dates</span>
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-6">
                        <a href="{{ route('products.index') }}" class="group relative px-8 py-4 bg-dark-chocolate text-misty-rose font-bold rounded-full overflow-hidden shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
                            <span class="relative z-10 group-hover:text-dark-chocolate transition-colors duration-500">View Catalog</span>
                            <div class="absolute inset-0 bg-sakura transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white/50 text-dark-chocolate font-bold rounded-full border border-white/60 backdrop-blur-sm shadow-lg transition-all hover:bg-sakura hover:-translate-y-1">
                            Register Now
                        </a>
                        <div class="flex items-center gap-3 bg-white/40 px-4 py-2 rounded-2xl backdrop-blur-sm border border-white/50">
                            <span class="text-3xl font-black text-dark-chocolate">5K+</span>
                            <span class="text-[10px] font-bold text-aloewood uppercase tracking-widest leading-tight">Active<br>Cosplayers</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative flex justify-center md:justify-end mt-24 md:mt-0 h-[450px] md:h-[600px] reveal delay-200" data-reveal="up">

                    <div class="absolute w-[300px] h-[300px] md:w-[450px] md:h-[450px] bg-sakura rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-0 animate-pulse shadow-[0_0_50px_rgba(255,183,197,0.5)]"></div>

                    <div class="absolute z-10 w-[200px] h-[300px] md:w-[280px] md:h-[400px] right-0 md:right-4 top-0 overflow-hidden rounded-[3rem] border-4 border-misty-rose shadow-2xl hover:z-30 transform transition-all duration-500 hover:scale-105 group cursor-pointer bg-dark-chocolate">
                        <img src="{{ asset('images/Cosplayer-1.jpg') }}" alt="Cosplayer 1" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-90 group-hover:opacity-100">
                    </div>

                    <div class="absolute z-20 w-[180px] h-[260px] md:w-[240px] md:h-[340px] left-4 md:left-12 bottom-10 md:bottom-20 overflow-hidden rounded-[3rem] border-4 border-misty-rose shadow-2xl hover:z-30 transform transition-all duration-500 hover:scale-105 group cursor-pointer bg-dark-chocolate">
                        <img src="{{ asset('images/Cosplayer-2.jpg') }}" alt="Cosplayer 2" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-90 group-hover:opacity-100">
                    </div>

                    <div class="absolute bottom-0 right-1/4 text-sakura text-4xl animate-bounce z-40 drop-shadow-lg">&#10024;</div>
                </div>

            </div>
        </section>

        <section class="py-32 px-6 bg-white relative z-10 rounded-t-[4rem] shadow-[0_-20px_50px_rgba(0,0,0,0.05)]">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-3xl reveal" data-reveal="up">
                    <span class="text-sakura font-bold tracking-widest uppercase text-xs mb-2 block">01 / Why CosRent Exists</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">Finding cosplay costumes should feel exciting, not confusing.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        Many renters have to ask repeatedly about sizes, included items, prices, and rental dates. CosRent brings the key details forward so you can decide faster.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/40 p-8 shadow-lg reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-black text-sm tracking-[0.25em] uppercase">01</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Costume options are often scattered</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Photos, prices, sizes, and included items are not always easy to compare when the information is spread across many places.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-black text-sm tracking-[0.25em] uppercase">02</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">Rental dates need clarity</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Renters want to know whether their chosen costume is available on the dates they need without a long back-and-forth.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/40 p-8 shadow-lg reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-black text-sm tracking-[0.25em] uppercase">03</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-4">The community needs a place to share</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Cosplayers also need a place to ask questions, share experiences, and find inspiration for their next costume.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="solusi" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-full overflow-hidden opacity-5 pointer-events-none select-none text-right">
                <h2 class="text-[10rem] md:text-[14rem] font-black whitespace-nowrap leading-none">COSRENT.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row gap-16 items-start">
                <div class="md:w-5/12 reveal" data-reveal="left">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">02 / What Can You Do on CosRent?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">From finding costumes to checking rental history, every step is easier to follow.</h2>
                    <p class="text-misty-rose/75 text-lg font-medium leading-relaxed border-t-2 border-white/10 pt-6">
                        CosRent helps visitors choose costumes with clear information, create online bookings, and interact through the cosplay forum.
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-10">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">Easy</p>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sakura mt-2">Search, choose, and book</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <p class="text-2xl font-black text-white">Clear</p>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-aloewood mt-2">Sizes, details, dates</p>
                        </div>
                    </div>
                </div>

                <div class="md:w-7/12 grid gap-6 w-full">
                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Find costumes</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Browse the cosplay catalog and view costume details before choosing.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            You can view characters, costume photos, sizes, prices, and included items so your choice feels more confident.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Book online</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Choose rental dates and continue booking without a complicated process.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            Rental information is arranged clearly so you know the next step after finding the right costume.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-white/10 bg-white/10 p-8 backdrop-blur-md shadow-2xl reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-bold tracking-[0.2em] uppercase text-xs">Join the community</span>
                        <h3 class="text-2xl md:text-3xl font-black text-white mt-3 mb-4">Use the cosplay forum to share stories, ask questions, and find inspiration.</h3>
                        <p class="text-misty-rose/70 font-medium leading-relaxed">
                            CosRent is not only a place to rent costumes, but also a small space to meet fellow cosplay fans.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 bg-white relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-3xl reveal" data-reveal="up">
                    <span class="text-aloewood font-bold tracking-widest uppercase text-xs mb-2 block">03 / Main Features</span>
                    <h2 class="text-4xl md:text-5xl font-black text-dark-chocolate leading-tight mb-6">The essentials you need before and after renting a costume.</h2>
                    <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed border-t-2 border-dark-chocolate/10 pt-6">
                        CosRent features are designed to be simple, helping visitors view options, understand details, book costumes, and join community discussions.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mt-16">
                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-100" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Costume Catalog</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Find favorite costumes faster</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            View cosplay costume options with character information, photos, prices, and included items.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-200" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Size Details</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Understand sizes before booking</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Size details and included items help you choose the most suitable costume.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-300" data-reveal="up">
                        <span class="text-milk-tea font-bold tracking-[0.2em] uppercase text-xs">Online Booking</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Choose dates and submit a rental</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            The rental process is more practical, from choosing a costume to submitting a booking.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-white p-8 shadow-lg reveal delay-500" data-reveal="up">
                        <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs">Rental History</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Check previous bookings</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            After renting, you can review your rental history and booking details.
                        </p>
                    </article>

                    <article class="rounded-[2rem] border border-dark-chocolate/10 bg-misty-rose/35 p-8 shadow-lg reveal delay-500" data-reveal="up">
                        <span class="text-aloewood font-bold tracking-[0.2em] uppercase text-xs">Cosplay Forum</span>
                        <h3 class="text-2xl font-black text-dark-chocolate mt-4 mb-3">Share stories with the community</h3>
                        <p class="text-dark-chocolate/70 font-medium leading-relaxed">
                            Join discussions, ask for recommendations, and find inspiration with other cosplay fans.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="tim" class="py-32 px-6 bg-dark-chocolate text-misty-rose relative overflow-hidden">
            <div class="absolute top-10 left-0 w-full overflow-hidden opacity-5 pointer-events-none select-none">
                <h2 class="text-[12rem] md:text-[15rem] font-black whitespace-nowrap leading-none">TEAM.</h2>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="text-center mb-24 reveal" data-reveal="up">
                    <span class="text-sakura font-bold tracking-[0.2em] uppercase text-xs mb-4 block">CosRent Team</span>
                    <h2 class="text-5xl md:text-6xl font-black text-white">CosRent Development Team</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 md:gap-8">
                    <div class="group flex flex-col items-center cursor-pointer reveal delay-100" data-reveal="up">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-sakura rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="{{ asset('images/rangga-minato.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Rangga</h3>
                        <p class="text-sakura font-bold text-xs tracking-widest uppercase mb-4">Lead Programmer</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Develops core features so the rental experience on CosRent feels organized and easy to use.
                        </p>
                    </div>

                    <div class="group flex flex-col items-center md:mt-12 cursor-pointer reveal delay-200" data-reveal="up">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-aloewood rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="{{ asset('images/Vergil_Akbar.png') }}" class="w-full h-full object-cover object-top grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Akbar</h3>
                        <p class="text-aloewood font-bold text-xs tracking-widest uppercase mb-4">Full-Stack Developer</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Connects the website experience with user needs so browsing and renting feel smooth.
                        </p>
                    </div>

                    <div class="group flex flex-col items-center cursor-pointer reveal delay-300" data-reveal="up">
                        <div class="relative w-64 h-64 mb-8 flex justify-center items-center">
                            <div class="absolute w-56 h-56 bg-milk-tea rounded-full z-0 transition-transform duration-500 group-hover:scale-110"></div>
                            <div class="relative z-10 w-48 h-60 overflow-hidden rounded-t-full border-b-4 border-misty-rose shadow-xl">
                                <img src="{{ asset('images/crist-uciha.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-1">Crist</h3>
                        <p class="text-milk-tea font-bold text-xs tracking-widest uppercase mb-4">Project Manager</p>
                        <p class="text-misty-rose/60 text-sm font-medium text-center max-w-xs leading-relaxed">
                            Guides product development so CosRent stays aligned with renters and the cosplay community.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 bg-misty-rose flex flex-col items-center justify-center relative reveal" data-reveal="up">
            <div class="text-center mt-16 mb-10 max-w-2xl relative z-10">
                 <h3 class="text-3xl font-bold text-dark-chocolate mb-4">
                    Ready to find your next cosplay costume?
                </h3>
                <p class="text-dark-chocolate/70 text-lg font-medium leading-relaxed">
                    Explore the catalog, create an account to start renting, then join the forum to share inspiration with the cosplay community.
                </p>
            </div>
            <div class="text-center relative z-10 bg-white/40 backdrop-blur-md p-14 rounded-[3rem] border border-white/50 shadow-xl">
                <h2 class="text-4xl md:text-6xl font-black text-dark-chocolate mb-4">Start Now.</h2>
                <p class="text-dark-chocolate/70 mb-10 font-medium text-lg">The CosRent catalog, account features, and community are ready for you.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="inline-block bg-dark-chocolate text-misty-rose px-8 py-4 rounded-full font-bold text-lg hover:bg-sakura hover:text-dark-chocolate transition-all duration-300 shadow-2xl hover:-translate-y-1">
                        View Catalog
                    </a>
                    <a href="{{ route('register') }}" class="inline-block bg-sakura text-dark-chocolate px-8 py-4 rounded-full font-bold text-lg hover:bg-dark-chocolate hover:text-misty-rose transition-all duration-300 shadow-2xl hover:-translate-y-1">
                        Create Account
                    </a>
                    <a href="{{ route('forum') }}" class="inline-block bg-white/60 text-dark-chocolate px-8 py-4 rounded-full font-bold text-lg border border-white/60 hover:bg-aloewood hover:text-misty-rose transition-all duration-300 shadow-2xl hover:-translate-y-1">
                        Join Forum
                    </a>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
@endpush
