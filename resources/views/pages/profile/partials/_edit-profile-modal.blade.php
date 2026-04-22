<div id="edit-profile-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-x-hidden overflow-y-auto bg-dark-chocolate/50 backdrop-blur-sm md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-[2rem] border-2 border-dark-chocolate/10 bg-[#FFE4E1] shadow-2xl">
            <div class="flex items-center justify-between border-b border-dark-chocolate/10 p-6">
                <h3 class="text-xl font-bold text-dark-chocolate">Edit Akun Cosplayer</h3>
                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-sm text-dark-chocolate/50 hover:text-dark-chocolate" data-modal-hide="edit-profile-modal" aria-label="Tutup modal edit profil">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-1 block text-sm font-bold text-dark-chocolate">Nama Tampilan</label>
                        <input
                            type="text"
                            name="nama"
                            class="block w-full rounded-xl border-2 border-dark-chocolate/10 bg-white p-2.5 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura"
                            value="{{ old('nama', $user->nama) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-dark-chocolate">Deskripsi Profil (Bio)</label>
                        <textarea
                            name="bio"
                            rows="3"
                            class="block w-full resize-none rounded-xl border-2 border-dark-chocolate/10 bg-white p-2.5 font-medium text-dark-chocolate focus:border-sakura focus:ring-sakura"
                            placeholder="Ceritakan hobimu atau spesialisasi cosplay-mu..."
                        >{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-dark-chocolate">Foto Profil Baru</label>
                        <input
                            type="file"
                            name="avatar"
                            class="block w-full cursor-pointer rounded-xl border-2 border-dark-chocolate/10 bg-white text-xs text-dark-chocolate file:mr-4 file:border-0 file:bg-dark-chocolate file:px-4 file:py-2 file:font-bold file:text-misty-rose hover:file:bg-opacity-90"
                            accept="image/*"
                        >
                    </div>

                    <button type="submit" class="mt-4 w-full rounded-xl bg-dark-chocolate px-5 py-3 text-center text-sm font-bold text-misty-rose shadow-lg transition hover:bg-opacity-90">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
