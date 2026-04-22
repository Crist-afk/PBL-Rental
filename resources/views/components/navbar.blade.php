@props(['authPage' => null])

@php
    $isAuthPage = in_array($authPage, ['login', 'register'], true);
@endphp

<div class="fixed w-full top-0 z-50 px-6 py-4">
    <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        <div class="flex items-center gap-2 font-bold text-xl">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                @if ($isAuthPage)
                    <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">&#x1F6CD;&#xFE0F;</span>
                @else
                    <img src="{{ asset('images/Logo-CosRent.png') }}"
                         alt="Logo CosRent"
                         style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; object-position: center 20%; border: 2px solid rgba(236,156,157,0.6); box-shadow: 0 2px 10px rgba(236,156,157,0.4); flex-shrink: 0;">
                @endif
                CosRent
            </a>
        </div>
        <nav class="hidden md:flex gap-6 font-medium text-sm">
            @if ($isAuthPage)
                <a href="{{ route('home') }}" class="hover:text-sakura transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-sakura transition">About</a>
                @if ($authPage === 'login')
                    <a href="{{ route('login') }}" class="hover:text-sakura transition">login</a>
                @else
                    <a href="{{ route('register') }}" class="hover:text-sakura transition">Register</a>
                @endif
                <a href="{{ route('forum') }}" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            @else
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Home</a>
                <a href="{{ Auth::check() ? route('about') : route('login') }}" class="{{ request()->routeIs('about') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">About</a>
                <a href="{{ Auth::check() ? route('products.index') : route('login') }}" class="{{ request()->routeIs('products.index') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Product</a>
                <a href="{{ Auth::check() ? route('forum') : route('login') }}" class="{{ request()->routeIs('forum') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Forum</a>
                <a href="{{ Auth::check() ? route('contact') : route('login') }}" class="{{ request()->routeIs('contact') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Contact</a>
            @endif
        </nav>
        <div class="flex gap-4 items-center text-sm font-medium">
            @if ($isAuthPage)
                @if ($authPage === 'register')
                    <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                @endif
                <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow">Register</a>
            @else
                @auth
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard.pelanggan') }}" class="{{ request()->routeIs('profile') || request()->routeIs('admin.dashboard') || request()->routeIs('dashboard.pelanggan') ? 'text-sakura font-bold hover:underline transition' : 'hover:text-sakura transition' }}">
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
            @endif
        </div>
    </header>
</div>
