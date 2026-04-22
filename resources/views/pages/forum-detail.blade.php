@extends('layouts.app')

@section('title', $post->title . ' - Forum CosRent')

@section('content')
    <main class="flex-grow pt-32 pb-20 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col gap-8">
        @if(session('forum_success'))
            <div class="rounded-[2rem] border-2 border-green-200 bg-green-50 px-6 py-4 text-green-800 shadow-sm">
                <p class="font-bold"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('forum_success') }}</p>
            </div>
        @endif

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <a href="{{ route('forum') }}" class="inline-flex items-center gap-2 text-sm font-bold text-aloewood transition hover:text-sakura">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Forum
                </a>
                <h1 class="mt-3 max-w-4xl text-4xl font-extrabold leading-tight text-dark-chocolate md:text-5xl">{{ $post->title }}</h1>
            </div>

            <div class="flex flex-wrap gap-3">
                <span class="rounded-full border border-aloewood/20 bg-[#FFE4E1] px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] text-aloewood">
                    {{ $post->category->name }}
                </span>
                <span class="rounded-full border border-dark-chocolate/10 bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.25em] text-dark-chocolate">
                    {{ $post->comments_count }} komentar
                </span>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
            <section class="space-y-8">
                <article class="glass-card rounded-[2.5rem] border-2 border-dark-chocolate/10 p-6 shadow-xl md:p-8">
                    <div class="mb-6 flex flex-col gap-4 border-b border-dark-chocolate/10 pb-6 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-misty-rose bg-sakura text-lg font-bold text-dark-chocolate">
                                {{ strtoupper(substr($post->user->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-base font-bold text-dark-chocolate">{{ $post->user->nama }}</p>
                                <p class="text-sm font-medium text-dark-chocolate/60">{{ $post->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        @if(auth()->check() && auth()->id() === $post->user_id)
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-5 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">
                                    <i class="fa-solid fa-user"></i>
                                    Lihat di Profilku
                                </a>
                                <form action="{{ route('forum.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus diskusi ini? Seluruh komentar di dalamnya juga akan ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full border-2 border-red-200 bg-white px-5 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50">
                                        <i class="fa-solid fa-trash"></i>
                                        Hapus Diskusi
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <p class="whitespace-pre-line text-base font-medium leading-relaxed text-dark-chocolate/80">{{ $post->content }}</p>

                        @if($post->image_path)
                            <div class="relative overflow-hidden rounded-[2rem] border-2 border-misty-rose/50 group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $post->image_path) }}')">
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Lampiran diskusi {{ $post->title }}" class="max-h-[540px] w-full object-cover transition duration-500 group-hover:scale-105" onclick="event.stopPropagation()">
                                <div class="absolute inset-0 flex items-center justify-center bg-dark-chocolate/20 opacity-0 transition duration-300 group-hover:opacity-100">
                                    <div class="rounded-full bg-dark-chocolate/70 px-5 py-3 text-sm font-bold text-misty-rose shadow-lg">
                                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>Lihat Penuh
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                @if(auth()->check() && auth()->id() === $post->user_id)
                    <section class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                        <details @if(old('editing_post') == $post->id) open @endif>
                            <summary class="cursor-pointer list-none">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h2 class="text-2xl font-bold text-dark-chocolate">Kelola Diskusi</h2>
                                        <p class="mt-1 text-sm font-medium text-dark-chocolate/70">Perbarui konten diskusi tanpa mengubah bahasa visual forum yang sudah ada.</p>
                                    </div>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-5 py-3 text-sm font-bold text-misty-rose">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit Diskusi
                                    </span>
                                </div>
                            </summary>

                            <div class="mt-5 border-t border-dark-chocolate/10 pt-5">
                                @if($errors->getBag('postUpdate')->any())
                                    <div class="mb-5 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-red-700">
                                        <p class="font-bold">Perubahan diskusi belum bisa disimpan.</p>
                                        <ul class="mt-2 space-y-1 text-sm font-medium">
                                            @foreach($errors->getBag('postUpdate')->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('forum.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="editing_post" value="{{ $post->id }}">

                                    <div class="grid gap-4 md:grid-cols-[1.4fr_0.8fr]">
                                        <div>
                                            <label for="edit_title" class="mb-1 block text-sm font-bold text-dark-chocolate">Judul Diskusi</label>
                                            <input id="edit_title" type="text" name="edit_title" value="{{ old('edit_title', $post->title) }}" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>
                                        </div>
                                        <div>
                                            <label for="edit_forum_category_id" class="mb-1 block text-sm font-bold text-dark-chocolate">Kategori</label>
                                            <select id="edit_forum_category_id" name="edit_forum_category_id" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>
                                                @foreach(\App\Models\ForumCategory::where('slug', '!=', 'semua-diskusi')->orderBy('id')->get() as $category)
                                                    <option value="{{ $category->id }}" @selected(old('edit_forum_category_id', $post->forum_category_id) == $category->id)>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="edit_content" class="mb-1 block text-sm font-bold text-dark-chocolate">Isi Diskusi</label>
                                        <textarea id="edit_content" name="edit_content" rows="5" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>{{ old('edit_content', $post->content) }}</textarea>
                                    </div>

                                    <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                                        <div>
                                            <label for="edit_image" class="mb-1 block text-sm font-bold text-dark-chocolate">Ganti Lampiran Gambar</label>
                                            <input id="edit_image" type="file" name="edit_image" accept="image/*" class="block w-full cursor-pointer rounded-xl border-2 border-dark-chocolate/10 bg-white text-xs text-dark-chocolate file:mr-4 file:border-0 file:bg-dark-chocolate file:px-4 file:py-2 file:font-bold file:text-misty-rose hover:file:bg-black">
                                        </div>
                                        @if($post->image_path)
                                            <label class="inline-flex items-center gap-3 rounded-xl border border-dark-chocolate/10 bg-white/70 px-4 py-3 text-sm font-bold text-dark-chocolate">
                                                <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image')) class="rounded border-dark-chocolate/20 text-sakura focus:ring-sakura">
                                                Hapus gambar saat ini
                                            </label>
                                        @endif
                                    </div>

                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-6 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </details>
                    </section>
                @endif

                <section id="komentar" class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-dark-chocolate">Komentar Komunitas</h2>
                            <p class="mt-1 text-sm font-medium text-dark-chocolate/70">Bangun percakapan yang sopan, jelas, dan membantu cosplayer lain.</p>
                        </div>
                        <div class="rounded-full bg-sakura/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-dark-chocolate">
                            {{ $post->comments_count }} total
                        </div>
                    </div>

                    @auth
                        <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                            @if($errors->getBag('commentCreate')->any())
                                <div class="mb-5 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-red-700">
                                    <p class="font-bold">Komentar belum bisa dikirim.</p>
                                    <ul class="mt-2 space-y-1 text-sm font-medium">
                                        @foreach($errors->getBag('commentCreate')->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('forum.comments.store', $post) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="content" class="mb-1 block text-sm font-bold text-dark-chocolate">Tulis Komentar</label>
                                    <textarea id="content" name="content" rows="4" placeholder="Bagikan solusi, saran, atau pengalamanmu di sini..." class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>{{ old('content') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-6 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Kirim Komentar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="rounded-[2rem] border-2 border-sakura/30 bg-gradient-to-r from-misty-rose/80 to-white/80 p-6 shadow-sm">
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-dark-chocolate">Login untuk ikut berdiskusi</h3>
                                    <p class="mt-1 text-sm font-medium text-dark-chocolate/70">Komentar dan balasanmu akan ikut memperkaya aktivitas forum di halaman profile.</p>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('login') }}" class="rounded-full bg-dark-chocolate px-5 py-3 text-sm font-bold text-misty-rose transition hover:bg-black">Login</a>
                                    <a href="{{ route('register') }}" class="rounded-full border-2 border-dark-chocolate/20 px-5 py-3 text-sm font-bold text-dark-chocolate transition hover:bg-sakura">Register</a>
                                </div>
                            </div>
                        </div>
                    @endauth

                    <div class="space-y-5">
                        @forelse($comments as $comment)
                            <article class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-5 shadow-sm">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full border-2 border-misty-rose bg-sakura font-bold text-dark-chocolate">
                                        {{ strtoupper(substr($comment->user->nama, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <p class="font-bold text-dark-chocolate">{{ $comment->user->nama }}</p>
                                                <p class="text-xs font-medium text-dark-chocolate/60">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-aloewood">Komentar</span>
                                        </div>

                                        <p class="mt-3 whitespace-pre-line text-sm font-medium leading-relaxed text-dark-chocolate/80">{{ $comment->content }}</p>

                                        @if(auth()->check() && auth()->id() === $comment->user_id)
                                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                                <details class="rounded-xl border border-dark-chocolate/10 bg-white/60 p-4" @if(old('editing_comment') == $comment->id) open @endif>
                                                    <summary class="cursor-pointer text-sm font-bold text-aloewood">Edit komentar</summary>
                                                    @if($errors->getBag('commentUpdate')->any() && old('editing_comment') == $comment->id)
                                                        <div class="mt-4 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-red-700">
                                                            <ul class="space-y-1 text-sm font-medium">
                                                                @foreach($errors->getBag('commentUpdate')->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <form action="{{ route('forum.comments.update', [$post, $comment]) }}" method="POST" class="mt-4 space-y-3">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="editing_comment" value="{{ $comment->id }}">
                                                        <div>
                                                            <textarea name="edit_comment_content" rows="3" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 text-sm font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>{{ old('editing_comment') == $comment->id ? old('edit_comment_content') : $comment->content }}</textarea>
                                                        </div>
                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-5 py-2.5 text-xs font-bold text-misty-rose transition hover:bg-black">
                                                            <i class="fa-solid fa-floppy-disk"></i>
                                                            Simpan Edit
                                                        </button>
                                                    </form>
                                                </details>

                                                <form action="{{ route('forum.comments.destroy', [$post, $comment]) }}" method="POST" onsubmit="return confirm('Hapus komentar ini? Balasan di bawahnya juga akan ikut terhapus.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">
                                                        <i class="fa-solid fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        @if($comment->replies->isNotEmpty())
                                            <div class="mt-4 space-y-3 border-l-2 border-sakura/40 pl-4">
                                                @foreach($comment->replies as $reply)
                                                    <div class="rounded-[1.5rem] bg-white/70 p-4">
                                                        <div class="flex items-center justify-between gap-3">
                                                            <div class="flex items-center gap-3">
                                                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-dark-chocolate text-sm font-bold text-misty-rose">
                                                                    {{ strtoupper(substr($reply->user->nama, 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm font-bold text-dark-chocolate">{{ $reply->user->nama }}</p>
                                                                    <p class="text-xs font-medium text-dark-chocolate/60">{{ $reply->created_at->diffForHumans() }}</p>
                                                                </div>
                                                            </div>
                                                            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-sakura">Balasan</span>
                                                        </div>
                                                        <p class="mt-3 whitespace-pre-line text-sm font-medium leading-relaxed text-dark-chocolate/80">{{ $reply->content }}</p>

                                                        @if(auth()->check() && auth()->id() === $reply->user_id)
                                                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                                                <details class="rounded-xl border border-dark-chocolate/10 bg-white/80 p-4" @if(old('editing_comment') == $reply->id) open @endif>
                                                                    <summary class="cursor-pointer text-xs font-bold text-aloewood">Edit balasan</summary>
                                                                    @if($errors->getBag('commentUpdate')->any() && old('editing_comment') == $reply->id)
                                                                        <div class="mt-4 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-red-700">
                                                                            <ul class="space-y-1 text-sm font-medium">
                                                                                @foreach($errors->getBag('commentUpdate')->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                    <form action="{{ route('forum.comments.update', [$post, $reply]) }}" method="POST" class="mt-4 space-y-3">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="editing_comment" value="{{ $reply->id }}">
                                                                        <div>
                                                                            <textarea name="edit_comment_content" rows="3" class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 text-sm font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required>{{ old('editing_comment') == $reply->id ? old('edit_comment_content') : $reply->content }}</textarea>
                                                                        </div>
                                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-5 py-2.5 text-xs font-bold text-misty-rose transition hover:bg-black">
                                                                            <i class="fa-solid fa-floppy-disk"></i>
                                                                            Simpan
                                                                        </button>
                                                                    </form>
                                                                </details>

                                                                <form action="{{ route('forum.comments.destroy', [$post, $reply]) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-4 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        @auth
                                            <details class="mt-4 rounded-xl border border-dark-chocolate/10 bg-white/60 p-4">
                                                <summary class="cursor-pointer text-sm font-bold text-aloewood">Balas komentar ini</summary>
                                                <form action="{{ route('forum.comments.store', $post) }}" method="POST" class="mt-4 space-y-3">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <div>
                                                        <textarea name="content" rows="3" placeholder="Tulis balasanmu..." class="w-full rounded-xl border-2 border-dark-chocolate/10 bg-white px-4 py-3 text-sm font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura" required></textarea>
                                                    </div>
                                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-dark-chocolate px-5 py-2.5 text-xs font-bold text-misty-rose transition hover:bg-black">
                                                        <i class="fa-solid fa-reply"></i>
                                                        Kirim Balasan
                                                    </button>
                                                </form>
                                            </details>
                                        @endauth
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-[2rem] border-2 border-dashed border-dark-chocolate/15 bg-white/70 px-6 py-12 text-center shadow-sm">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sakura/20 text-2xl text-dark-chocolate">
                                    <i class="fa-regular fa-comment-dots"></i>
                                </div>
                                <h3 class="mt-5 text-2xl font-bold text-dark-chocolate">Belum ada komentar.</h3>
                                <p class="mx-auto mt-2 max-w-xl text-sm font-medium text-dark-chocolate/70">
                                    Jadilah orang pertama yang memulai percakapan di topik ini.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </section>

            <aside class="space-y-6">
                <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                    <h2 class="mb-4 border-b border-dark-chocolate/10 pb-3 text-lg font-bold text-dark-chocolate">Ringkasan Diskusi</h2>
                    <div class="space-y-4 text-sm font-medium text-dark-chocolate/75">
                        <div class="flex items-center justify-between">
                            <span>Penulis</span>
                            <span class="font-bold text-dark-chocolate">{{ $post->user->nama }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Kategori</span>
                            <span class="font-bold text-dark-chocolate">{{ $post->category->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Dibuat</span>
                            <span class="font-bold text-dark-chocolate">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Komentar</span>
                            <span class="font-bold text-dark-chocolate">{{ $post->comments_count }}</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-[2rem] border-2 border-dark-chocolate/10 p-6 shadow-xl">
                    <h2 class="mb-4 border-b border-dark-chocolate/10 pb-3 text-lg font-bold text-dark-chocolate">
                        <i class="fa-solid fa-layer-group mr-2 text-sakura"></i>Topik Terkait
                    </h2>

                    <div class="space-y-5">
                        @forelse($relatedPosts as $relatedPost)
                            <article>
                                <p class="mb-1 text-xs font-bold uppercase tracking-wide text-aloewood">{{ $relatedPost->category->name }}</p>
                                <h3 class="line-clamp-2 text-sm font-bold text-dark-chocolate">
                                    <a href="{{ route('forum.show', $relatedPost) }}" class="transition hover:text-sakura">{{ $relatedPost->title }}</a>
                                </h3>
                                <p class="mt-1 text-xs font-medium text-dark-chocolate/60">oleh {{ $relatedPost->user->nama }} • {{ $relatedPost->comments_count }} komentar</p>
                            </article>
                        @empty
                            <p class="text-sm font-medium text-dark-chocolate/70">Belum ada topik lain di kategori ini.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <x-forum.image-modal />
@endsection
