@extends('layouts.admin')

@section('title', 'Profil Admin - CosRent')

@section('content')
<main class="main">
    <div class="main-inner max-w-6xl mx-auto w-full">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-[var(--text-primary,#443025)]">Profil Admin</h1>
            <p class="text-sm text-[var(--text-secondary,#8B5A2B)] mt-1">Kelola informasi akun dan pantau aktivitas sistem.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
            {{-- Left Column: Profile Card & Info --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Main Profile Card --}}
                <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-stone-800 to-stone-600 relative group">
                        @if(Auth::user()->cover_photo)
                            <img src="{{ asset('storage/' . Auth::user()->cover_photo) }}" alt="Cover" class="w-full h-full object-cover">
                        @endif
                        <form action="{{ route('admin.profile.cover') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            @csrf
                            <label for="cover_upload" class="cursor-pointer text-white flex flex-col items-center">
                                <svg class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-xs font-medium">Ubah Sampul</span>
                            </label>
                            <input type="file" id="cover_upload" name="cover_photo" class="hidden" onchange="this.form.submit()">
                        </form>
                    </div>
                    <div class="px-6 pb-6 relative">
                        <div class="flex justify-center -mt-12 mb-4 relative z-10">
                            <div class="relative group">
                                <div class="w-24 h-24 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full border-4 border-[var(--bg-card,var(--card-bg,#fff))] shadow-sm overflow-hidden">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-3xl font-bold text-[var(--text-primary,#443025)]">{{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}</span>
                                    @endif
                                </div>
                                <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                    @csrf
                                    <label for="avatar_upload" class="cursor-pointer text-white">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </label>
                                    <input type="file" id="avatar_upload" name="avatar" class="hidden" onchange="this.form.submit()">
                                </form>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-bold text-[var(--text-primary,#443025)]">{{ auth()->user()->nama ?? 'Administrator' }}</h2>
                            <div class="flex items-center justify-center gap-2 mt-2 text-sm text-[var(--text-secondary,#8B5A2B)]">
                                <div class="w-6 h-6 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                    <svg class="w-3.5 h-3.5 text-[var(--text-secondary,#8B5A2B)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                            <div class="mt-4 flex justify-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[var(--bg-card,var(--card-bg,#fff))] text-[var(--text-primary,#443025)] border border-[var(--border-color)]">
                                    <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                        <svg class="w-3 h-3 text-[var(--text-primary,#443025)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    Super Admin
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account Information Card (Edit Form) --}}
                <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm p-6">
                    <h3 class="text-xs font-bold tracking-wider uppercase text-[var(--text-secondary,#8B5A2B)] mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                            <svg class="w-4 h-4 text-[var(--text-secondary,#8B5A2B)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        Informasi Akun
                    </h3>
                    
                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="nama" class="block text-xs font-medium text-[var(--text-secondary,#8B5A2B)] mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', auth()->user()->nama) }}" class="w-full text-sm rounded-lg border-[var(--border-color)] bg-transparent text-[var(--text-primary,#443025)] focus:ring-[var(--text-primary,#443025)] focus:border-[var(--text-primary,#443025)] p-2.5">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-xs font-medium text-[var(--text-secondary,#8B5A2B)] mb-1">Surel</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full text-sm rounded-lg border-[var(--border-color)] bg-transparent text-[var(--text-primary,#443025)] focus:ring-[var(--text-primary,#443025)] focus:border-[var(--text-primary,#443025)] p-2.5">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-[var(--text-primary,#443025)] text-[var(--bg-card,var(--card-bg,#fff))] font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 pt-4 border-t border-[var(--border-color)] space-y-3 text-sm">
                        <div class="flex justify-between items-center py-1">
                            <span class="text-[var(--text-secondary,#8B5A2B)] font-medium">Peran Sistem</span>
                            <span class="text-[var(--text-primary,#443025)] font-semibold">Admin</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-[var(--text-secondary,#8B5A2B)] font-medium">Bergabung</span>
                            <span class="text-[var(--text-primary,#443025)] font-semibold">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Quick Stats Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm p-5 flex flex-col justify-between">
                        <span class="text-xs font-bold tracking-wider uppercase text-[var(--text-secondary,#8B5A2B)] mb-2">Total Pengguna</span>
                        <span class="text-3xl font-extrabold text-[var(--text-primary,#443025)]">128</span>
                        <span class="text-xs text-[var(--text-secondary,#8B5A2B)] font-medium mt-1">Pelanggan terdaftar</span>
                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">
                                <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-green-100 rounded-full">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                </div>
                                +12 bulan ini
                            </span>
                        </div>
                    </div>
                    <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm p-5 flex flex-col justify-between">
                        <span class="text-xs font-bold tracking-wider uppercase text-[var(--text-secondary,#8B5A2B)] mb-2">Transaksi Aktif</span>
                        <span class="text-3xl font-extrabold text-[var(--text-primary,#443025)]">34</span>
                        <span class="text-xs text-[var(--text-secondary,#8B5A2B)] font-medium mt-1">Sedang berjalan</span>
                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-bold">
                                <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-amber-100 rounded-full">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                5 menunggu
                            </span>
                        </div>
                    </div>
                    <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm p-5 flex flex-col justify-between">
                        <span class="text-xs font-bold tracking-wider uppercase text-[var(--text-secondary,#8B5A2B)] mb-2">Total Kostum</span>
                        <span class="text-3xl font-extrabold text-[var(--text-primary,#443025)]">72</span>
                        <span class="text-xs text-[var(--text-secondary,#8B5A2B)] font-medium mt-1">Tersedia di katalog</span>
                        <div class="mt-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-[var(--bg-card,var(--card-bg,#fff))] text-[var(--text-primary,#443025)] rounded-full text-xs font-bold">
                                <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                8 sedang disewa
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- System Permissions --}}
                    <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm p-6">
                        <h3 class="text-xs font-bold tracking-wider uppercase text-[var(--text-secondary,#8B5A2B)] mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                <svg class="w-4 h-4 text-[var(--text-secondary,#8B5A2B)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            Hak Akses Sistem
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center py-2 border-b border-[var(--border-color)]">
                                <span class="text-[var(--text-secondary,#8B5A2B)] font-medium">Kelola Kostum</span>
                                <span class="text-green-600 font-semibold flex items-center gap-1.5">
                                    <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-green-100 rounded-full">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    Aktif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[var(--border-color)]">
                                <span class="text-[var(--text-secondary,#8B5A2B)] font-medium">Validasi Pembayaran</span>
                                <span class="text-green-600 font-semibold flex items-center gap-1.5">
                                    <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-green-100 rounded-full">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    Aktif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-[var(--border-color)]">
                                <span class="text-[var(--text-secondary,#8B5A2B)] font-medium">Kelola Pengguna</span>
                                <span class="text-green-600 font-semibold flex items-center gap-1.5">
                                    <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-green-100 rounded-full">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    Aktif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-[var(--text-secondary,#8B5A2B)] font-medium">Laporan & Riwayat</span>
                                <span class="text-green-600 font-semibold flex items-center gap-1.5">
                                    <div class="w-5 h-5 shrink-0 flex items-center justify-center bg-green-100 rounded-full">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Activity --}}
                    <div class="bg-[var(--bg-card,var(--card-bg,#fff))] rounded-2xl border border-[var(--border-color)] shadow-sm p-6">
                        <h3 class="text-xs font-bold tracking-wider uppercase text-[var(--text-secondary,#8B5A2B)] mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                <svg class="w-4 h-4 text-[var(--text-secondary,#8B5A2B)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            Riwayat Aktivitas
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3 pb-3 border-b border-[var(--border-color)] last:border-0 last:pb-0">
                                <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                    <div class="w-2 h-2 rounded-full bg-[var(--text-primary,#443025)]"></div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-sm font-medium text-[var(--text-primary,#443025)] leading-tight">Memvalidasi pembayaran #TRX-0087</p>
                                    <p class="text-xs text-[var(--text-secondary,#8B5A2B)] mt-1">Hari ini, 10:32</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 pb-3 border-b border-[var(--border-color)] last:border-0 last:pb-0">
                                <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                    <div class="w-2 h-2 rounded-full bg-[var(--text-secondary,#8B5A2B)]"></div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-sm font-medium text-[var(--text-primary,#443025)] leading-tight">Menambahkan kostum: "Naruto Sage Mode"</p>
                                    <p class="text-xs text-[var(--text-secondary,#8B5A2B)] mt-1">Kemarin, 15:14</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 pb-3 border-b border-[var(--border-color)] last:border-0 last:pb-0">
                                <div class="w-8 h-8 shrink-0 flex items-center justify-center bg-[var(--bg-card,var(--card-bg,#fff))] rounded-full">
                                    <div class="w-2 h-2 rounded-full bg-[var(--text-secondary,#8B5A2B)]"></div>
                                </div>
                                <div class="pt-1.5">
                                    <p class="text-sm font-medium text-[var(--text-primary,#443025)] leading-tight">Masuk ke sistem admin</p>
                                    <p class="text-xs text-[var(--text-secondary,#8B5A2B)] mt-1">23 Apr 2026, 08:22</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
