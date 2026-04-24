@props(['authPage' => null])

@php
    $isAuthPage = in_array($authPage, ['login', 'register'], true);

    $homeLabel = 'Home';
    $homeRoute = 'home';

    if (Auth::check()) {
        if (Auth::user()->role === 'pelanggan') {
            $homeLabel = 'Dashboard';
            $homeRoute = 'dashboard.pelanggan';
        } elseif (Auth::user()->role === 'admin') {
            $homeLabel = 'Dashboard';
            $homeRoute = 'admin.dashboard';
        }
    }
@endphp

<div class="fixed w-full top-0 z-50 px-4 sm:px-6 py-4">
    <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-4 sm:px-6 py-3 flex justify-between items-center">

        {{-- ── Brand Logo ── --}}
        <div class="flex items-center gap-2 font-bold text-xl flex-shrink-0">
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

        {{-- ── Desktop Navigation ── --}}
        <nav class="hidden md:flex gap-6 font-medium text-sm">
            @if ($isAuthPage)
                <a href="{{ route('home') }}" class="hover:text-sakura transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-sakura transition">About</a>
                @if ($authPage === 'login')
                    <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                @else
                    <a href="{{ route('register') }}" class="hover:text-sakura transition">Register</a>
                @endif
                <a href="{{ route('forum') }}" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            @else
                <a href="{{ route($homeRoute) }}" class="{{ request()->routeIs($homeRoute) ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">{{ $homeLabel }}</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">About</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Product</a>
                <a href="{{ route('forum') }}" class="{{ request()->routeIs('forum') || request()->routeIs('forum.show') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Forum</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Contact</a>
            @endif
        </nav>

        {{-- ── Right Side: Auth Actions ── --}}
        <div class="flex gap-3 items-center text-sm font-medium">
            @if ($isAuthPage)
                @if ($authPage === 'register')
                    <a href="{{ route('login') }}" class="hover:text-sakura transition hidden sm:inline">Login</a>
                @endif
                <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow">Register</a>
            @else
                @auth
                    {{-- ── Avatar Dropdown ── --}}
                    <div class="relative" id="avatarDropdownWrapper">
                        <button
                            id="avatarDropdownBtn"
                            type="button"
                            aria-expanded="false"
                            aria-haspopup="true"
                            class="flex items-center gap-2 focus:outline-none group"
                        >
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                     alt="Profile"
                                     class="w-9 h-9 rounded-full object-cover border-2 border-sakura shadow-sm group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-9 h-9 flex items-center justify-center rounded-full bg-sakura text-dark-chocolate font-bold border-2 border-sakura shadow-sm group-hover:scale-105 transition-transform text-sm select-none">
                                    {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                            {{-- Chevron icon --}}
                            <svg id="avatarChevron" class="w-3.5 h-3.5 text-misty-rose/70 transition-transform duration-200 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div
                            id="avatarDropdownMenu"
                            class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-2xl border border-dark-chocolate/10 overflow-hidden origin-top-right scale-95 opacity-0 pointer-events-none transition-all duration-200 ease-out"
                            role="menu"
                        >
                            {{-- User info header --}}
                            <div class="px-4 py-3 bg-misty-rose/60 border-b border-dark-chocolate/10">
                                <p class="text-xs font-semibold text-dark-chocolate/60 uppercase tracking-wide">Masuk sebagai</p>
                                <p class="text-sm font-bold text-dark-chocolate truncate">{{ Auth::user()->nama }}</p>
                            </div>

                            {{-- Menu items --}}
                            <div class="py-1.5">
                                {{-- Profile --}}
                                <a
                                    href="{{ Auth::user()->role === 'admin' ? route('admin.profile') : route('profile') }}"
                                    role="menuitem"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-dark-chocolate hover:bg-misty-rose/70 transition-colors"
                                >
                                    <svg class="w-4 h-4 text-aloewood flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>

                                {{-- Dashboard --}}
                                <a
                                    href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard.pelanggan') }}"
                                    role="menuitem"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-dark-chocolate hover:bg-misty-rose/70 transition-colors"
                                >
                                    <svg class="w-4 h-4 text-aloewood flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-dark-chocolate/10 my-1"></div>

                            {{-- Logout --}}
                            <div class="py-1.5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        role="menuitem"
                                        class="flex w-full items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors"
                                    >
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hover:text-sakura transition hidden sm:inline">Login</a>
                    <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-4 py-2 rounded-full hover:bg-opacity-80 transition shadow text-sm">Register</a>
                @endauth
            @endif

            {{-- ── Hamburger (mobile only) ── --}}
            <button
                id="mobileMenuBtn"
                type="button"
                aria-expanded="false"
                aria-label="Toggle mobile menu"
                class="md:hidden flex flex-col gap-1.5 p-1 focus:outline-none"
            >
                <span class="hamburger-line block w-5 h-0.5 bg-misty-rose rounded transition-all duration-300"></span>
                <span class="hamburger-line block w-5 h-0.5 bg-misty-rose rounded transition-all duration-300"></span>
                <span class="hamburger-line block w-5 h-0.5 bg-misty-rose rounded transition-all duration-300"></span>
            </button>
        </div>
    </header>

    {{-- ── Mobile Menu Panel ── --}}
    <div
        id="mobileMenu"
        class="md:hidden hidden mt-2 bg-dark-chocolate text-misty-rose rounded-2xl shadow-xl max-w-7xl mx-auto px-6 py-4 flex flex-col gap-1 font-medium text-sm"
    >
        @if ($isAuthPage)
            <a href="{{ route('home') }}" class="py-2 hover:text-sakura transition">Home</a>
            <a href="{{ route('about') }}" class="py-2 hover:text-sakura transition">About</a>
            <a href="{{ route('forum') }}" class="py-2 hover:text-sakura transition">Forum</a>
            <a href="{{ route('contact') }}" class="py-2 hover:text-sakura transition">Contact</a>
            <div class="border-t border-misty-rose/20 mt-2 pt-3 flex gap-3">
                <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-4 py-1.5 rounded-full hover:bg-opacity-80 transition">Register</a>
            </div>
        @else
            <a href="{{ route($homeRoute) }}" class="py-2 {{ request()->routeIs($homeRoute) ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">{{ $homeLabel }}</a>
            <a href="{{ route('about') }}" class="py-2 {{ request()->routeIs('about') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">About</a>
            <a href="{{ route('products.index') }}" class="py-2 {{ request()->routeIs('products.*') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Product</a>
            <a href="{{ route('forum') }}" class="py-2 {{ request()->routeIs('forum') || request()->routeIs('forum.show') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Forum</a>
            <a href="{{ route('contact') }}" class="py-2 {{ request()->routeIs('contact') ? 'text-sakura font-bold' : 'hover:text-sakura transition' }}">Contact</a>

            @guest
                <div class="border-t border-misty-rose/20 mt-2 pt-3 flex gap-3">
                    <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-4 py-1.5 rounded-full hover:bg-opacity-80 transition">Register</a>
                </div>
            @endguest

            @auth
                <div class="border-t border-misty-rose/20 mt-2 pt-3 flex flex-col gap-1">
                    <p class="text-xs text-misty-rose/50 uppercase tracking-wide mb-1">Masuk sebagai {{ Auth::user()->nama }}</p>
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.profile') : route('profile') }}" class="py-2 hover:text-sakura transition">Profil Saya</a>
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard.pelanggan') }}" class="py-2 hover:text-sakura transition">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-1">
                        @csrf
                        <button type="submit" class="text-left py-2 text-red-400 hover:text-red-300 transition font-bold">Keluar</button>
                    </form>
                </div>
            @endauth
        @endif
    </div>
</div>

{{-- ── Navbar JavaScript (scoped to this component) ── --}}
<script>
(function () {
    // ── Avatar Dropdown ──
    var dropdownBtn    = document.getElementById('avatarDropdownBtn');
    var dropdownMenu   = document.getElementById('avatarDropdownMenu');
    var dropdownChevron = document.getElementById('avatarChevron');

    function openDropdown() {
        dropdownMenu.classList.remove('scale-95', 'opacity-0', 'pointer-events-none');
        dropdownMenu.classList.add('scale-100', 'opacity-100');
        if (dropdownChevron) dropdownChevron.style.transform = 'rotate(180deg)';
        dropdownBtn && dropdownBtn.setAttribute('aria-expanded', 'true');
    }

    function closeDropdown() {
        dropdownMenu.classList.add('scale-95', 'opacity-0', 'pointer-events-none');
        dropdownMenu.classList.remove('scale-100', 'opacity-100');
        if (dropdownChevron) dropdownChevron.style.transform = 'rotate(0deg)';
        dropdownBtn && dropdownBtn.setAttribute('aria-expanded', 'false');
    }

    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = dropdownMenu.classList.contains('opacity-100');
            isOpen ? closeDropdown() : openDropdown();
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            var wrapper = document.getElementById('avatarDropdownWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeDropdown();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDropdown();
        });
    }

    // ── Mobile Hamburger Menu ──
    var mobileBtn  = document.getElementById('mobileMenuBtn');
    var mobileMenu = document.getElementById('mobileMenu');

    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) {
                mobileMenu.classList.add('hidden');
                mobileBtn.setAttribute('aria-expanded', 'false');
            } else {
                mobileMenu.classList.remove('hidden');
                mobileBtn.setAttribute('aria-expanded', 'true');
            }
        });

        // Close mobile menu on outside click
        document.addEventListener('click', function (e) {
            var navbar = document.querySelector('[id="mobileMenuBtn"]');
            if (navbar && !mobileMenu.contains(e.target) && e.target !== mobileBtn && !mobileBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                mobileBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }
})();
</script>
