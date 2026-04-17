@extends('layouts.app')

@section('title', 'Forum Komunitas - CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">
        @if(session('forum_success'))
            <div class="rounded-[2rem] border-2 border-green-200 bg-green-50 px-6 py-4 text-green-800 shadow-sm">
                <p class="font-bold"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('forum_success') }}</p>
            </div>
        @endif

        <section class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 px-6 py-8 md:px-10 md:py-10 shadow-xl">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <span class="mb-4 block text-sm font-black uppercase tracking-[0.35em] text-aloewood">Forum Komunitas</span>
                    <h1 class="text-4xl font-extrabold text-dark-chocolate md:text-5xl">Bangun diskusi nyata untuk komunitas cosplay CosRent.</h1>
                    <p class="mt-4 text-base font-medium leading-relaxed text-dark-chocolate/75 md:text-lg">
                        Cari kostum, tukar tips styling, dan kabari teman-teman soal event terbaru dalam satu ruang yang siap dikembangkan jadi forum profesional.
                    </p>
                </div>

                <form action="{{ route('forum') }}" method="GET" class="flex w-full max-w-xl gap-3">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul diskusi, isi posting, atau nama member..." class="w-full rounded-2xl border-2 border-dark-chocolate/10 bg-white/70 px-5 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura">
                    @if($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                    @endif
                    <button type="submit" class="rounded-2xl bg-dark-chocolate px-5 py-3 font-bold text-misty-rose transition hover:bg-black">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>
            </div>
        </section>

        <div class="grid gap-8 lg:grid-cols-[280px_minmax(0,1fr)_300px]">
            <aside class="space-y-6">
                <div class="glass-card sticky top-32 rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                    <h2 class="mb-4 border-b border-dark-chocolate/10 pb-3 text-lg font-bold text-dark-chocolate">Jelajahi Topik</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('forum', array_filter(['q' => $search])) }}" class="{{ $activeCategory ? 'text-dark-chocolate/80 hover:bg-misty-rose/50' : 'bg-dark-chocolate text-misty-rose' }} flex items-center justify-between gap-3 rounded-xl px-4 py-3 font-medium transition">
                                <span class="flex items-center gap-3">
                                    <i class="fa-solid fa-fire {{ $activeCategory ? 'text-sakura' : 'text-sakura' }}"></i>
                                    Semua Diskusi
                                </span>
                                <span class="text-xs font-bold uppercase tracking-wide">{{ $posts->total() }}</span>
                            </a>
                        </li>

                        @foreach($categories->where('slug', '!=', 'semua-diskusi') as $category)
                            <li>
                                <a href="{{ route('forum', array_filter(['category' => $category->slug, 'q' => $search])) }}" class="{{ optional($activeCategory)->id === $category->id ? 'bg-dark-chocolate text-misty-rose' : 'text-dark-chocolate/80 hover:bg-misty-rose/50' }} flex items-center justify-between gap-3 rounded-xl px-4 py-3 font-medium transition">
                                    <span class="flex items-center gap-3">
                                        <i class="fa-solid {{ $category->icon ?? 'fa-comments' }} {{ optional($activeCategory)->id === $category->id ? 'text-sakura' : 'text-aloewood' }}"></i>
                                        {{ $category->name }}
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-wide">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <section class="space-y-6">
                @auth
                    <div id="buat-diskusi" class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                        <div class="mb-5 flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-dark-chocolate">Buat Diskusi Baru</h2>
                                <p class="mt-1 text-sm font-medium text-dark-chocolate/70">Posting pertanyaan, info event, atau pencarian kostum supaya komunitas bisa langsung merespons.</p>
                            </div>
                            <div class="hidden rounded-full bg-sakura px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-dark-chocolate md:block">
                                {{ auth()->user()->nama }}
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="mb-5 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-red-700">
                                <p class="font-bold">Diskusi belum bisa dipublikasikan.</p>
                                <ul class="mt-2 space-y-1 text-sm font-medium">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid gap-4 md:grid-cols-[1.4fr_0.8fr]">
                                <div>
                                    <label for="title" class="mb-1 block text-sm font-bold text-dark-chocolate">Judul Diskusi</label>
                                    <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Ada vendor kostum Nezuko size M di Batam?" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>
                                </div>
                                <div>
                                    <label for="forum_category_id" class="mb-1 block text-sm font-bold text-dark-chocolate">Kategori</label>
                                    <select id="forum_category_id" name="forum_category_id" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>
                                        <option value="">Pilih kategori</option>
                                        @foreach($categories->where('slug', '!=', 'semua-diskusi') as $category)
                                            <option value="{{ $category->id }}" @selected(old('forum_category_id') == $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="content" class="mb-1 block text-sm font-bold text-dark-chocolate">Isi Diskusi</label>
                                <textarea id="content" name="content" rows="5" placeholder="Tulis konteks, kebutuhan, atau pertanyaanmu dengan jelas..." class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>{{ old('content') }}</textarea>
                            </div>

                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div class="w-full md:max-w-sm">
                                    <label for="image" class="mb-1 block text-sm font-bold text-dark-chocolate">Lampiran Gambar</label>
                                    <input id="image" type="file" name="image" accept="image/*" class="block w-full cursor-pointer rounded-xl border-2 border-dark-chocolate/10 bg-white text-xs text-dark-chocolate file:mr-4 file:border-0 file:bg-dark-chocolate file:px-4 file:py-2 file:font-bold file:text-misty-rose hover:file:bg-black">
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-dark-chocolate px-6 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Publikasikan
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="rounded-[2rem] border-2 border-sakura/30 bg-gradient-to-r from-misty-rose/80 to-white/80 p-6 shadow-sm">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-dark-chocolate">Ingin mulai berdiskusi?</h2>
                                <p class="mt-1 text-sm font-medium text-dark-chocolate/70">Login dulu agar kamu bisa membuat topik baru dan membangun jejak aktivitas forum untuk halaman profile-mu.</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('login') }}" class="rounded-full bg-dark-chocolate px-5 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">Login</a>
                                <a href="{{ route('register') }}" class="rounded-full border-2 border-dark-chocolate/20 px-5 py-3 text-sm font-bold text-dark-chocolate transition hover:bg-sakura">Register</a>
                            </div>
                        </div>
                    </div>
                @endauth

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-dark-chocolate">
                            {{ $activeCategory ? $activeCategory->name : 'Semua Diskusi' }}
                        </h2>
                        <p class="mt-1 text-sm font-medium text-dark-chocolate/70">
                            @if($search !== '')
                                Menampilkan hasil pencarian untuk "{{ $search }}".
                            @elseif($activeCategory)
                                {{ $activeCategory->description }}
                            @else
                                Lihat percakapan terbaru dari komunitas CosRent.
                            @endif
                        </p>
                    </div>
                    <a href="{{ auth()->check() ? '#buat-diskusi' : route('login') }}" class="hidden rounded-full bg-dark-chocolate px-5 py-3 text-sm font-bold text-misty-rose transition hover:bg-black md:inline-flex md:items-center md:gap-2">
                        <i class="fa-solid fa-pen-nib"></i>
                        Buat Diskusi Baru
                    </a>
                </div>

                @forelse($posts as $post)
                    <article class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="mb-4 flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-misty-rose bg-sakura font-bold text-dark-chocolate">
                                    {{ strtoupper(substr($post->user->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-dark-chocolate">{{ $post->user->nama }}</p>
                                    <p class="text-xs font-medium text-dark-chocolate/60">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="rounded-full border border-aloewood/20 bg-[#FFE4E1] px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-aloewood">
                                {{ $post->category->name }}
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-dark-chocolate">
                            <a href="{{ route('forum.show', $post) }}" class="transition hover:text-sakura">{{ $post->title }}</a>
                        </h3>
                        <p class="mt-3 whitespace-pre-line text-sm font-medium leading-relaxed text-dark-chocolate/80">{{ \Illuminate\Support\Str::limit($post->content, 280) }}</p>

                        @if($post->image_path)
                            <div class="relative mt-5 h-72 overflow-hidden rounded-[1.5rem] border-2 border-misty-rose/50 group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $post->image_path) }}')">
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Lampiran diskusi {{ $post->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onclick="event.stopPropagation()">
                                <div class="absolute inset-0 flex items-center justify-center bg-dark-chocolate/20 opacity-0 transition duration-300 group-hover:opacity-100">
                                    <div class="rounded-full bg-dark-chocolate/70 px-4 py-2 text-sm font-bold text-misty-rose shadow-lg">
                                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>Lihat Penuh
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-5 flex items-center justify-between border-t border-dark-chocolate/10 pt-4 text-sm font-bold text-dark-chocolate/70">
                            <div class="flex items-center gap-4">
                                <span>Dipublikasikan untuk komunitas CosRent</span>
                                <span class="inline-flex items-center gap-1 text-aloewood">
                                    <i class="fa-regular fa-comment"></i>
                                    {{ $post->comments_count }} komentar
                                </span>
                            </div>
                            <a href="{{ route('forum.show', $post) }}" class="transition hover:text-sakura">
                                Baca Diskusi <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[2rem] border-2 border-dashed border-dark-chocolate/15 bg-white/70 px-6 py-12 text-center shadow-sm">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sakura/20 text-2xl text-dark-chocolate">
                            <i class="fa-regular fa-comments"></i>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-dark-chocolate">Belum ada diskusi yang cocok.</h3>
                        <p class="mx-auto mt-2 max-w-xl text-sm font-medium text-dark-chocolate/70">
                            Ubah filter pencarian atau buat topik baru supaya forum ini mulai terisi dengan percakapan yang relevan.
                        </p>
                    </div>
                @endforelse

                @if($posts->hasPages())
                    <div class="pt-2">
                        {{ $posts->links() }}
                    </div>
                @endif
            </section>

            <aside class="space-y-6">
                <a href="{{ auth()->check() ? '#buat-diskusi' : route('login') }}" class="flex items-center justify-center gap-2 rounded-[2rem] border-2 border-sakura/20 bg-dark-chocolate px-6 py-4 text-lg font-bold text-misty-rose shadow-xl transition duration-300 hover:-translate-y-1 hover:bg-black">
                    <i class="fa-solid fa-pen-nib"></i>
                    Buat Diskusi Baru
                </a>

                <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                    <h2 class="mb-4 border-b border-dark-chocolate/10 pb-3 text-lg font-bold text-dark-chocolate">
                        <i class="fa-solid fa-arrow-trend-up mr-2 text-sakura"></i>Sedang Hangat
                    </h2>

                    <div class="space-y-5">
                        @forelse($trendingPosts as $trendingPost)
                            <article>
                                <p class="mb-1 text-xs font-bold uppercase tracking-wide text-aloewood">{{ $trendingPost->category->name }}</p>
                                <h3 class="line-clamp-2 text-sm font-bold text-dark-chocolate">
                                    <a href="{{ route('forum.show', $trendingPost) }}" class="transition hover:text-sakura">{{ $trendingPost->title }}</a>
                                </h3>
                                <p class="mt-1 text-xs font-medium text-dark-chocolate/60">oleh {{ $trendingPost->user->nama }} • {{ $trendingPost->created_at->diffForHumans() }}</p>
                                <p class="mt-1 text-[11px] font-bold uppercase tracking-wide text-sakura">{{ $trendingPost->comments_count }} komentar</p>
                            </article>
                        @empty
                            <p class="text-sm font-medium text-dark-chocolate/70">Belum ada diskusi hangat. Topik pertama bisa datang dari kamu.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <div id="image-modal" role="dialog" aria-modal="true" aria-hidden="true" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 p-4 opacity-0 transition-opacity duration-300 backdrop-blur-md" onclick="closeImageModal()">
        <button type="button" aria-label="Tutup pratinjau gambar" onclick="closeImageModal()" class="absolute right-6 top-6 text-4xl text-white/50 transition hover:text-sakura">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img id="modal-image" src="" alt="Pratinjau gambar forum" class="max-h-full max-w-full scale-95 rounded-2xl object-contain shadow-2xl transition-transform duration-300" onclick="event.stopPropagation()">
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('image-modal');
            const modalImg = document.getElementById('modal-image');

            modalImg.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalImg.classList.remove('scale-95');
                modalImg.classList.add('scale-100');
            }, 10);
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            const modalImg = document.getElementById('modal-image');

            modal.classList.add('opacity-0');
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.setAttribute('aria-hidden', 'true');
                modalImg.src = '';
            }, 300);
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection
