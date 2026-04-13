<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">

    <div class="fixed w-full top-0 z-50 px-6 py-4">
        <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-xl">
                <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">🛍️</span>
                <a href="{{ route('home') }}">CosRent</a>
            </div>
            <nav class="hidden md:flex gap-6 font-medium text-sm">
                <a href="{{ route('home') }}" class="hover:text-sakura transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-sakura transition">About</a>
                <a href="#" class="hover:text-sakura transition">Product</a>
                <a href="#" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="hover:text-sakura transition">Contact</a>
            </nav>
            <div class="flex gap-4 items-center text-sm font-medium">
                <a href="{{ route('profile') }}" class="text-sakura font-bold hover:underline transition">
                    <i class="fa-solid fa-user-circle mr-1"></i> Halo, {{ Auth::user()->nama }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-misty-rose/20 text-misty-rose px-4 py-2 rounded-full hover:bg-sakura hover:text-dark-chocolate transition text-xs font-bold shadow-sm">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </header>
    </div>

    <main class="flex-grow pt-28 pb-20 px-4 sm:px-6 max-w-5xl mx-auto w-full">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-100 text-green-800 border-2 border-green-200 font-bold shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-xl"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl overflow-hidden mb-8">
            <div class="h-48 md:h-64 w-full relative group">
                <img src="https://images.unsplash.com/photo-1541959833400-049d37f98ccd?q=80&w=1200&auto=format&fit=crop" alt="Cover" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-dark-chocolate/30 group-hover:bg-dark-chocolate/10 transition duration-300"></div>
                <button class="absolute top-4 right-4 bg-dark-chocolate/60 backdrop-blur-sm text-misty-rose px-4 py-2 rounded-full text-xs font-bold hover:bg-sakura hover:text-dark-chocolate transition border border-white/20">
                    <i class="fa-solid fa-camera mr-2"></i> Ubah Sampul
                </button>
            </div>

            <div class="px-6 md:px-10 pb-8 relative">
                <div class="flex flex-col md:flex-row md:items-end justify-between -mt-16 md:-mt-20 mb-6 gap-4">
                    <div class="flex flex-col md:flex-row md:items-end gap-5">
                        <div class="relative inline-block z-10">
                            @if(Auth::user()->avatar)
                                <img class="w-32 h-32 md:w-40 md:h-40 rounded-full shadow-2xl border-4 border-[#FFE4E1] object-cover bg-white" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil"/>
                            @else
                                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full shadow-2xl border-4 border-[#FFE4E1] bg-sakura text-dark-chocolate flex items-center justify-center text-6xl font-bold">
                                    {{ substr(Auth::user()->nama, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-2 md:mb-4">
                            <h1 class="text-3xl font-bold text-dark-chocolate">{{ Auth::user()->nama }}</h1>
                            <p class="text-dark-chocolate/70 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-sm text-aloewood"></i> {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 mb-2 md:mb-4">
                        <button data-modal-target="edit-profile-modal" data-modal-toggle="edit-profile-modal" class="bg-dark-chocolate text-misty-rose px-6 py-2.5 rounded-full font-bold hover:bg-black transition shadow-md text-sm border-2 border-dark-chocolate flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Profil
                        </button>
                        <button class="bg-white/50 text-dark-chocolate px-4 py-2.5 rounded-full font-bold hover:bg-sakura transition shadow-sm text-sm border-2 border-dark-chocolate/20">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-dark-chocolate/80 text-sm md:text-base leading-relaxed max-w-3xl font-medium mb-6">
                        {{ Auth::user()->bio ?? 'Belum ada deskripsi profil. Klik "Edit Profil" untuk menceritakan siapa kamu! ✨' }}
                    </p>

                    <div class="flex gap-6 border-y border-dark-chocolate/10 py-4">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-dark-chocolate">12</span>
                            <span class="text-xs font-bold text-aloewood uppercase tracking-wide">Postingan Forum</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-dark-chocolate">4</span>
                            <span class="text-xs font-bold text-aloewood uppercase tracking-wide">Kostum Disewa</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-dark-chocolate">⭐ 4.8</span>
                            <span class="text-xs font-bold text-aloewood uppercase tracking-wide">Rating Penyewa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 border-b-2 border-dark-chocolate/10">
            <ul class="flex flex-wrap -mb-px text-sm font-bold text-center" id="profile-tabs" data-tabs-toggle="#profile-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-4 rounded-t-lg hover:text-aloewood hover:border-aloewood text-dark-chocolate border-sakura" id="aktivitas-tab" data-tabs-target="#aktivitas" type="button" role="tab" aria-controls="aktivitas" aria-selected="true">
                        <i class="fa-regular fa-comments mr-2"></i>Aktivitas Forum
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-4 rounded-t-lg hover:text-aloewood hover:border-aloewood text-dark-chocolate/60 border-transparent" id="sewa-tab" data-tabs-target="#sewa" type="button" role="tab" aria-controls="sewa" aria-selected="false">
                        <i class="fa-solid fa-bag-shopping mr-2"></i>Riwayat Sewa
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-4 rounded-t-lg hover:text-aloewood hover:border-aloewood text-dark-chocolate/60 border-transparent" id="pengaturan-tab" data-tabs-target="#pengaturan" type="button" role="tab" aria-controls="pengaturan" aria-selected="false">
                        <i class="fa-solid fa-gear mr-2"></i>Pengaturan Akun
                    </button>
                </li>
            </ul>
        </div>

        <div id="profile-tab-content">
            <div class="p-6 rounded-3xl bg-white border-2 border-dark-chocolate/10 shadow-sm" id="aktivitas" role="tabpanel" aria-labelledby="aktivitas-tab">
                <h3 class="text-xl font-bold text-dark-chocolate mb-6">Postingan Terakhir</h3>

                <div class="border-b border-dark-chocolate/10 pb-6 mb-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-sakura text-dark-chocolate flex items-center justify-center font-bold">{{ substr(Auth::user()->nama, 0, 1) }}</div>
                        <div>
                            <p class="font-bold text-dark-chocolate text-sm">{{ Auth::user()->nama }} <span class="text-aloewood font-normal text-xs ml-2">2 hari yang lalu</span></p>
                            <p class="text-xs text-sakura font-bold">Topik: Tips & Trik</p>
                        </div>
                    </div>
                    <p class="text-dark-chocolate/80 text-sm font-medium mb-3">Ada yang punya rekomendasi tempat sewa wig murah di sekitar Batam Centre? Lagi butuh buat event minggu depan nih!</p>
                    <div class="flex gap-4 text-sm font-bold text-aloewood">
                        <button class="hover:text-sakura transition"><i class="fa-regular fa-heart mr-1"></i> 12 Suka</button>
                        <button class="hover:text-sakura transition"><i class="fa-regular fa-comment mr-1"></i> 5 Balasan</button>
                    </div>
                </div>

                <div class="text-center">
                    <button class="text-sm font-bold text-sakura hover:text-aloewood transition">Lihat Semua Aktivitas <i class="fa-solid fa-arrow-right ml-1"></i></button>
                </div>
            </div>

            <div class="hidden p-6 rounded-3xl bg-white border-2 border-dark-chocolate/10 shadow-sm" id="sewa" role="tabpanel" aria-labelledby="sewa-tab">
                <h3 class="text-xl font-bold text-dark-chocolate mb-6">Kostum Sedang Disewa</h3>
                <div class="text-center py-10 bg-misty-rose/30 rounded-2xl border-2 border-dashed border-sakura/50">
                    <i class="fa-solid fa-box-open text-4xl text-sakura mb-3"></i>
                    <p class="font-bold text-dark-chocolate">Belum ada transaksi aktif.</p>
                    <p class="text-sm text-dark-chocolate/60 mt-1">Ayo mulai cari kostum impianmu di katalog!</p>
                    <a href="#" class="mt-4 inline-block bg-dark-chocolate text-misty-rose px-6 py-2 rounded-full text-sm font-bold hover:bg-aloewood transition">Mulai Jelajah</a>
                </div>
            </div>

            <div class="hidden p-6 rounded-3xl bg-white border-2 border-dark-chocolate/10 shadow-sm" id="pengaturan" role="tabpanel" aria-labelledby="pengaturan-tab">
                <h3 class="text-xl font-bold text-dark-chocolate mb-6">Keamanan Privasi</h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-misty-rose/20 rounded-xl border border-dark-chocolate/10">
                        <div>
                            <p class="font-bold text-dark-chocolate">Ubah Password</p>
                            <p class="text-xs text-dark-chocolate/60 mt-1">Terakhir diubah: Belum pernah</p>
                        </div>
                        <button class="bg-white text-dark-chocolate px-4 py-2 rounded-lg text-sm font-bold border border-dark-chocolate/20 hover:bg-sakura transition">Ubah</button>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-misty-rose/20 rounded-xl border border-dark-chocolate/10">
                        <div>
                            <p class="font-bold text-dark-chocolate">Autentikasi Dua Langkah (2FA)</p>
                            <p class="text-xs text-dark-chocolate/60 mt-1">Amankan akun dari akses tidak sah.</p>
                        </div>
                        <button class="bg-sakura text-dark-chocolate px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-dark-chocolate hover:text-sakura transition">Aktifkan</button>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-red-50 rounded-xl border border-red-100 mt-8">
                        <div>
                            <p class="font-bold text-red-700">Hapus Akun</p>
                            <p class="text-xs text-red-500/80 mt-1">Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-red-700 transition">Hapus Permanen</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="edit-profile-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-dark-chocolate/50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-[#FFE4E1] rounded-[2rem] shadow-2xl border-2 border-dark-chocolate/10">
                <div class="flex items-center justify-between p-6 border-b border-dark-chocolate/10">
                    <h3 class="text-xl font-bold text-dark-chocolate">Edit Akun Cosplayer</h3>
                    <button type="button" class="text-dark-chocolate/50 hover:text-dark-chocolate rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="edit-profile-modal">❌</button>
                </div>
                <div class="p-6">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Nama Tampilan</label>
                            <input type="text" name="nama" class="bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-sakura focus:border-sakura block w-full p-2.5 font-medium" value="{{ Auth::user()->nama }}" required />
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Deskripsi Profil (Bio)</label>
                            <textarea name="bio" rows="3" class="bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-sakura focus:border-sakura block w-full p-2.5 font-medium resize-none" placeholder="Ceritakan hobimu atau spesialisasi cosplay-mu...">{{ Auth::user()->bio }}</textarea>
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Foto Profil Baru</label>
                            <input type="file" name="avatar" class="block w-full text-xs text-dark-chocolate border-2 border-dark-chocolate/10 rounded-xl cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:font-bold file:bg-dark-chocolate file:text-misty-rose hover:file:bg-opacity-90" accept="image/*">
                        </div>

                        <button type="submit" class="w-full text-misty-rose bg-dark-chocolate hover:bg-opacity-90 font-bold rounded-xl text-sm px-5 py-3 text-center shadow-lg transition mt-4">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
