<div id="image-modal" role="dialog" aria-modal="true" aria-hidden="true" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 p-4 opacity-0 transition-opacity duration-300 backdrop-blur-md" onclick="closeImageModal()">
    <button type="button" aria-label="Tutup pratinjau gambar" onclick="closeImageModal()" class="absolute right-6 top-6 text-4xl text-white/50 transition hover:text-sakura">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <img id="modal-image" src="" alt="Pratinjau gambar forum" class="max-h-full max-w-full scale-95 rounded-2xl object-contain shadow-2xl transition-transform duration-300" onclick="event.stopPropagation()">
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/forum-image-modal.js') }}"></script>
    @endpush
@endonce
