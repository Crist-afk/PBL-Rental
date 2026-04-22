<div class="rounded-3xl border-2 border-dark-chocolate/10 bg-white p-6 shadow-sm" id="aktivitas" role="tabpanel" aria-labelledby="aktivitas-tab">
    <h3 class="mb-6 text-xl font-bold text-dark-chocolate">Postingan Terakhir</h3>

    @forelse($latestForumPosts as $post)
        <div class="mb-6 border-b border-dark-chocolate/10 pb-6 last:mb-0 last:border-b-0 last:pb-0">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sakura font-bold text-dark-chocolate">
                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-dark-chocolate">
                        {{ $user->nama }}
                        <span class="ml-2 text-xs font-normal text-aloewood">{{ $post->created_at->diffForHumans() }}</span>
                    </p>
                    <p class="text-xs font-bold text-sakura">
                        Topik: {{ optional($post->category)->name ?? 'Tanpa Kategori' }}
                    </p>
                </div>
            </div>

            <p class="mb-2 font-bold text-dark-chocolate">{{ $post->title }}</p>
            <p class="mb-3 text-sm font-medium text-dark-chocolate/80">
                {{ \Illuminate\Support\Str::limit($post->content, 140) }}
            </p>
        </div>
    @empty
        <div class="rounded-2xl border-2 border-dashed border-dark-chocolate/10 bg-misty-rose/20 px-6 py-10 text-center">
            <i class="fa-regular fa-comments text-4xl text-sakura"></i>
            <p class="mt-4 font-bold text-dark-chocolate">Kamu belum punya aktivitas forum.</p>
            <p class="mt-1 text-sm font-medium text-dark-chocolate/60">
                Mulai diskusi pertama supaya halaman profilmu terasa lebih hidup.
            </p>
            <a href="{{ route('forum') }}" class="mt-4 inline-block rounded-full bg-dark-chocolate px-5 py-2 text-sm font-bold text-misty-rose transition hover:bg-black">
                Buka Forum
            </a>
        </div>
    @endforelse

    @if($latestForumPosts->isNotEmpty())
        <div class="text-center">
            <a href="{{ route('forum') }}" class="text-sm font-bold text-sakura transition hover:text-aloewood">
                Lihat Semua Aktivitas <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
    @endif
</div>
