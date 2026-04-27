if (window.bookingSuccessMessage) {
    Swal.fire({
        title: 'Berhasil!',
        text: window.bookingSuccessMessage,
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#443025',
        background: '#FFE4E1',
        customClass: {
            title: 'text-dark-chocolate font-black',
            popup: 'rounded-[2rem] border-2 border-sakura/20 shadow-2xl'
        }
    });
}
        const tglSewa = document.getElementById('tanggal_sewa');
        const tglKembali = document.getElementById('tanggal_kembali');

        tglSewa.addEventListener('change', function() {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
        });

        // Costume Preview Logic
        const kostumSelect = document.getElementById('kostum_id');
        const previewContainer = document.getElementById('costume-preview');
        const previewImage = document.getElementById('preview-image');
        const previewName = document.getElementById('preview-name');

        function updatePreview() {
            const selectedOption = kostumSelect.options[kostumSelect.selectedIndex];
            const imageUrl = selectedOption.getAttribute('data-image');
            const costumeName = selectedOption.text;

            if (imageUrl) {
                previewImage.src = imageUrl;
                previewName.textContent = costumeName;
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('animate-fade-in');
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        kostumSelect.addEventListener('change', updatePreview);

        // Run on load in case of pre-selected value
        if (kostumSelect.value) {
            updatePreview();
        }

        // Simple animation on input focus
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const label = input.parentElement.closest('.space-y-4').querySelector('label');
                if (label) label.classList.add('text-sakura');
            });
            input.addEventListener('blur', () => {
                const label = input.parentElement.closest('.space-y-4').querySelector('label');
                if (label) label.classList.remove('text-sakura');
            });
        });
