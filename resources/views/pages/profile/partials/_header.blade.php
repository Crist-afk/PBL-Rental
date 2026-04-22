<div class="glass-card mb-8 overflow-hidden rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl">
    <div class="relative h-48 w-full group md:h-64">
        <img
            src="https://images.unsplash.com/photo-1541959833400-049d37f98ccd?q=80&w=1200&auto=format&fit=crop"
            alt="Sampul profil"
            class="h-full w-full object-cover"
        >
        <div class="absolute inset-0 bg-dark-chocolate/30 transition duration-300 group-hover:bg-dark-chocolate/10"></div>
        <button
            type="button"
            title="Fitur ubah sampul belum tersedia"
            class="absolute right-4 top-4 rounded-full border border-white/20 bg-dark-chocolate/60 px-4 py-2 text-xs font-bold text-misty-rose backdrop-blur-sm transition hover:bg-sakura hover:text-dark-chocolate"
        >
            <i class="fa-solid fa-camera mr-2"></i> Sampul
        </button>
    </div>

    <div class="relative px-6 pb-8 md:px-10">
        <div class="-mt-16 mb-6 flex flex-col gap-4 md:-mt-20 md:flex-row md:items-end md:justify-between">
            <div class="flex flex-col gap-5 md:flex-row md:items-end">
                <div class="relative z-10 inline-block">
                    @if($user->avatar)
                        <img
                            class="h-32 w-32 rounded-full border-4 border-[#FFE4E1] bg-white object-cover shadow-2xl md:h-40 md:w-40"
                            src="{{ asset('storage/' . $user->avatar) }}"
                            alt="Foto profil {{ $user->nama }}"
                        >
                    @else
                        <div class="flex h-32 w-32 items-center justify-center rounded-full border-4 border-[#FFE4E1] bg-sakura text-6xl font-bold text-dark-chocolate shadow-2xl md:h-40 md:w-40">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="mb-2 md:mb-4">
                    <h1 class="text-3xl font-bold text-dark-chocolate">{{ $user->nama }}</h1>
                    <p class="flex items-center gap-2 font-medium text-dark-chocolate/70">
                        <i class="fa-solid fa-envelope text-sm text-aloewood"></i>
                        {{ $user->email }}
                    </p>
                </div>
            </div>

            <div class="mb-2 flex gap-3 md:mb-4">
                <button
                    type="button"
                    data-modal-target="edit-profile-modal"
                    data-modal-toggle="edit-profile-modal"
                    class="flex items-center gap-2 rounded-full border-2 border-dark-chocolate bg-dark-chocolate px-6 py-2.5 text-sm font-bold text-misty-rose shadow-md transition hover:bg-black"
                >
                    <i class="fa-solid fa-pen-to-square"></i> Edit Profil
                </button>
                <button
                    type="button"
                    title="Fitur berbagi belum tersedia"
                    class="rounded-full border-2 border-dark-chocolate/20 bg-white/50 px-4 py-2.5 text-sm font-bold text-dark-chocolate shadow-sm transition hover:bg-sakura"
                >
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <p class="mb-6 max-w-3xl text-sm font-medium leading-relaxed text-dark-chocolate/80 md:text-base">
                {{ filled($user->bio) ? $user->bio : 'Belum ada deskripsi profil. Klik Edit Profil untuk menambahkan bio singkatmu.' }}
            </p>

            <div class="flex gap-6 border-y border-dark-chocolate/10 py-4">
                <div class="text-center">
                    <span class="block text-2xl font-bold text-dark-chocolate">{{ $profileStats['forum_posts'] }}</span>
                    <span class="text-xs font-bold uppercase tracking-wide text-aloewood">Postingan Forum</span>
                </div>
                <div class="text-center">
                    <span class="block text-2xl font-bold text-dark-chocolate">{{ $profileStats['rental_count'] }}</span>
                    <span class="text-xs font-bold uppercase tracking-wide text-aloewood">Kostum Disewa</span>
                </div>
                <div class="text-center">
                    <span class="block text-2xl font-bold text-dark-chocolate">{{ $profileStats['rating_label'] }}</span>
                    <span class="text-xs font-bold uppercase tracking-wide text-aloewood">Rating Penyewa</span>
                </div>
            </div>
        </div>
    </div>
</div>
