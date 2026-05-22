@extends('layouts.app')

@section('title', 'CosRent - Bring Your Dream Character to Life')

@push('styles')
    @vite(['resources/css/pages/home.css'])
@endpush

@section('content')
    <section class="min-h-screen flex flex-col items-center justify-center pt-32 px-6 text-center">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-sm inline-flex flex-col items-center border-2 border-dark-chocolate/10 reveal" data-reveal="up">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-tight">
                Bring Your Dream <br>
                <span class="text-sakura">Character to Life</span>
            </h1>
            <p class="mt-4 max-w-2xl text-dark-chocolate font-medium text-lg">
                Rent premium-quality cosplay costumes at affordable prices. Explore character options from anime, games, and your favorite films.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <a href="{{ Auth::check() ? route('products.index') : route('login') }}" 
                class="bg-dark-chocolate text-misty-rose px-8 py-3 rounded-full font-semibold hover:bg-opacity-90 transition shadow-md">
                    Explore Catalog
                </a>
                <a href="{{ Auth::check() ? route('products.index') : route('login') }}" 
                class="border-2 border-dark-chocolate text-dark-chocolate px-8 py-3 rounded-full font-semibold hover:bg-dark-chocolate hover:text-misty-rose transition shadow-md">
                    Find Products
                </a>
            </div>
        </div>

        <div class="mt-16 w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl border-4 border-dark-chocolate bg-dark-chocolate reveal delay-200" data-reveal="up">
            <img src="{{ asset('images/pixel_cosrent.png') }}" alt="CosRent Banner" class="w-full h-auto object-cover opacity-80">
        </div>
    </section>

    <section class="relative py-24 px-6 overflow-hidden">
        <!-- Background Kanji Decor -->
        <div class="absolute top-20 right-10 text-[12rem] font-bold text-dark-chocolate/5 select-none pointer-events-none leading-none">
            カテゴリー
        </div>
        <div class="absolute bottom-20 left-10 text-[12rem] font-bold text-sakura/5 select-none pointer-events-none leading-none vertical-text">
            コスプレ
        </div>
        
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-block mb-16 reveal" data-reveal="up">
                <span class="text-sakura font-bold tracking-[0.3em] uppercase text-sm block mb-2">— Costume Categories —</span>
                <h2 class="text-5xl md:text-6xl font-bold text-dark-chocolate">Choose Your Character</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="group relative bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden reveal delay-100" data-reveal="up">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">アニメ</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">🎭</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Anime & Manga</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">A-N-I-M-E</p>
                </div>
                <div class="group relative bg-dark-chocolate p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden reveal delay-200" data-reveal="up">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">ゲーム</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">🎮</div>
                    <h3 class="font-bold text-lg text-misty-rose mb-1">Video Games</h3>
                    <p class="text-xs text-misty-rose/40 uppercase tracking-widest">G-A-M-E</p>
                </div>
                <div class="group relative bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden reveal delay-300" data-reveal="up">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">映画</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">🎬</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Film & Toku</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">M-O-V-I-E</p>
                </div>
                <div class="group relative bg-sakura p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-dark-chocolate cursor-pointer overflow-hidden reveal delay-500" data-reveal="up">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-dark-chocolate/10 group-hover:text-dark-chocolate/20 transition-colors">オリジナル</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">✨</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">Original</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">O-R-I-G-I-N-A-L</p>
                </div>
                <div class="group relative bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition-all duration-500 border-b-8 border-sakura cursor-pointer overflow-hidden reveal delay-700" data-reveal="up">
                    <div class="absolute top-0 right-0 p-4 text-xs font-bold text-sakura/20 group-hover:text-sakura/40 transition-colors">道具</div>
                    <div class="text-5xl mb-6 transform group-hover:scale-110 transition-transform">💇‍♀️</div>
                    <h3 class="font-bold text-lg text-dark-chocolate mb-1">VTuber</h3>
                    <p class="text-xs text-dark-chocolate/40 uppercase tracking-widest">W-I-G-S</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section with Torii Background -->
    <section class="relative py-32 bg-misty-rose overflow-hidden">
        <img src="{{ asset('images/torii.png') }}" class="absolute -bottom-20 -right-20 w-96 opacity-10 pointer-events-none transform rotate-12" alt="Torii Decor">
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24 reveal" data-reveal="up">
                <span class="text-sakura font-bold tracking-[0.3em] uppercase text-sm block mb-2">— HOW IT WORKS —</span>
                <h2 class="text-5xl font-bold text-dark-chocolate">Easy Rental Process</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative">
                <!-- Steps with Japanese numbers -->
                <div class="flex flex-col items-center text-center group reveal delay-100" data-reveal="up">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            一
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            1
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Choose & Schedule</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Choose your favorite costume and set your rental dates on our calendar.</p>
                </div>

                <div class="flex flex-col items-center text-center group reveal delay-200" data-reveal="up">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            二
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            2
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Payment</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Pay by bank transfer, e-wallet, or at our store.</p>
                </div>

                <div class="flex flex-col items-center text-center group reveal delay-300" data-reveal="up">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            三
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            3
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Pickup</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">Pick up your costume at our store.</p>
                </div>

                <div class="flex flex-col items-center text-center group reveal delay-500" data-reveal="up">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-dark-chocolate text-sakura rounded-full flex items-center justify-center text-3xl shadow-2xl group-hover:rotate-12 transition-transform border-4 border-sakura/20">
                            四
                        </div>
                        <div class="absolute -top-2 -right-2 w-10 h-10 bg-sakura text-dark-chocolate rounded-lg flex items-center justify-center font-bold text-xl shadow-lg border-2 border-dark-chocolate">
                            4
                        </div>
                    </div>
                    <h4 class="font-bold text-2xl mb-3">Return</h4>
                    <p class="text-dark-chocolate/60 leading-relaxed">When you are done, return the costume on time so others can enjoy it too.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 max-w-7xl mx-auto relative overflow-hidden">
        <!-- Decorative Kanji for Products -->
        <div class="absolute -top-10 left-0 text-[15rem] font-bold text-dark-chocolate/5 select-none pointer-events-none leading-none vertical-text">
            注目
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 relative z-10 reveal" data-reveal="up">
            <div class="max-w-xl">
                <span class="text-sakura font-bold tracking-[0.3em] uppercase text-sm block mb-2">— FEATURED COLLECTION —</span>
                <h2 class="text-5xl font-bold text-dark-chocolate">Popular Picks</h2>
            </div>
            <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="group flex items-center gap-3 text-dark-chocolate font-bold mt-6 md:mt-0 transition-all hover:text-sakura">
                <span>View Full Catalog</span>
                <span class="w-12 h-12 bg-dark-chocolate text-white rounded-full flex items-center justify-center group-hover:bg-sakura transition-colors">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Card 1: Raiden Shogun -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Popular</span>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s" alt="Raiden Shogun" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">GENSHIN IMPACT</span>
                    <h3 class="font-bold text-xl mb-4">Raiden Shogun</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 180.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: M, L</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Costume Details</a>
                </div>
            </div>

            <!-- Card 2: Monkey D. Luffy -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Popular</span>
                    <img src="https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e" alt="Monkey D. Luffy" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">ONE PIECE</span>
                    <h3 class="font-bold text-xl mb-4">Monkey D. Luffy</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 120.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: All Size</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Costume Details</a>
                </div>
            </div>

            <!-- Card 3: Kafka -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Popular</span>
                    <img src="https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg" alt="Kafka" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">HONKAI: STAR RAIL</span>
                    <h3 class="font-bold text-xl mb-4">Kafka</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 200.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: S, M, L</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Costume Details</a>
                </div>
            </div>

            <!-- Card 4: Spider-Man -->
            <div class="glass-card rounded-3xl overflow-hidden border-2 border-dark-chocolate/20 shadow-lg flex flex-col">
                <div class="h-64 bg-dark-chocolate relative">
                    <span class="absolute top-4 left-4 bg-sakura text-dark-chocolate text-xs font-bold px-3 py-1 rounded-full z-10">Popular</span>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s" alt="Spider-Man" class="w-full h-full object-cover opacity-90">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-sakura text-xs font-bold tracking-wider mb-1">MARVEL</span>
                    <h3 class="font-bold text-xl mb-4">Spider-Man</h3>
                    <div class="flex justify-between items-center mb-6 mt-auto">
                        <span class="font-bold text-lg">Rp 150.000</span>
                        <span class="text-xs font-medium text-dark-chocolate/60">Size: L, XL</span>
                    </div>
                    <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="block w-full text-center bg-dark-chocolate text-misty-rose py-3 rounded-xl font-medium hover:bg-opacity-90 transition">Costume Details</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 px-6 max-w-7xl mx-auto">
        <div class="glass-card rounded-[3rem] p-8 md:p-16 border-2 border-dark-chocolate/10 flex flex-col md:flex-row items-center gap-12 shadow-xl reveal" data-reveal="up">
            <div class="md:w-1/2">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Why Choose <br><span class="text-sakura">CosRent?</span></h2>
                <p class="text-dark-chocolate/80 mb-10 text-lg">
                    We understand what cosplayers need. Comfort, cleanliness, and accurate details are our top priorities.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">✨</div>
                        <div>
                            <h4 class="font-bold">Premium Fabric</h4>
                            <p class="text-sm opacity-80">High-quality materials for maximum comfort.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">🛡️</div>
                        <div>
                            <h4 class="font-bold">Hygienic</h4>
                            <p class="text-sm opacity-80">Every costume is cleaned and sanitized.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">📏</div>
                        <div>
                            <h4 class="font-bold">Costume Fitting Service</h4>
                            <p class="text-sm opacity-80">Try costumes directly at our offline store.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-sakura/50 p-3 rounded-full text-dark-chocolate">👕</div>
                        <div>
                            <h4 class="font-bold">Complete Size Options</h4>
                            <p class="text-sm opacity-80">Available in sizes from XS to XXXL.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 w-full">
                <div class="rounded-[2rem] overflow-hidden shadow-2xl h-[500px] bg-dark-chocolate">
                    <img src="https://images.unsplash.com/photo-1519750783826-e2420f4d687f?auto=format&fit=crop&w=800&q=80" alt="Cosplay Event" class="w-full h-full object-cover opacity-80">
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-6 max-w-7xl mx-auto text-center">
        <div class="glass-card inline-block px-8 py-4 rounded-3xl border-2 border-dark-chocolate/10 shadow-sm mb-12 reveal" data-reveal="up">
            <h2 class="text-4xl font-bold mb-2">What Do They Say?</h2>
            <p class="text-dark-chocolate/80">Real experiences from cosplayers</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative reveal delay-100" data-reveal="up">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"The costume smelled fresh and was very clean! The size fit perfectly as described. The admin was friendly and the process was fast. I will definitely rent here again!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Customer #1</h4>
                        <p class="text-xs opacity-70">Verified Cosplayer</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative reveal delay-200" data-reveal="up">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"The costume smelled fresh and was very clean! The size fit perfectly as described. The admin was friendly and the process was fast. I will definitely rent here again!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Customer #2</h4>
                        <p class="text-xs opacity-70">Verified Cosplayer</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-8 rounded-3xl border-2 border-dark-chocolate/10 shadow-lg relative reveal delay-300" data-reveal="up">
                <div class="text-sakura mb-4">⭐⭐⭐⭐⭐</div>
                <p class="italic mb-8 opacity-90">"The costume smelled fresh and was very clean! The size matched the description really well. The admin was friendly and the process was super quick. I will rent here again!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-aloewood rounded-full"></div>
                    <div>
                        <h4 class="font-bold">Customer #3</h4>
                        <p class="text-xs opacity-70">Verified Cosplayer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
