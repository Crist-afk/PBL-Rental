<div class="fixed w-full top-0 z-50 px-6 py-4">
    <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        <div class="flex items-center gap-2 font-bold text-xl">
            <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">🛍️</span>
            <a href="{{ route('home') }}">CosRent</a>
        </div>
        <nav class="hidden md:flex gap-6 font-medium text-sm">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">About</a>
            <a href="{{ route('product') }}" class="{{ request()->routeIs('product') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Product</a>
            <a href="{{ route('forum') }}" class="{{ request()->routeIs('forum') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Forum</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Contact</a>
        </nav>
        <div class="flex gap-4 items-center text-sm font-medium">
            @auth
                <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'text-sakura font-bold hover:underline transition' : 'hover:text-sakura transition' }}">
                    <i class="fa-solid fa-user-circle mr-1"></i> {{ Auth::user()->nama ?? 'User' }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-misty-rose/20 text-misty-rose px-3 py-1.5 rounded-full hover:bg-sakura hover:text-dark-chocolate transition text-[10px] font-bold shadow-sm">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow">Register</a>
            @endauth
        </div>
    </header>
</div>
