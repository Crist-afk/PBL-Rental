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
            const sizesString = selectedOption.getAttribute('data-sizes');

            if (imageUrl) {
                previewImage.src = imageUrl;
                previewName.textContent = costumeName;
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('animate-fade-in');
            } else {
                previewContainer.classList.add('hidden');
            }

            // Update Sizes Dynamically
            const sizeContainer = document.getElementById('size-container');
            if (sizeContainer && sizesString) {
                const sizes = sizesString.split(',').map(s => s.trim()).filter(s => s.length > 0);
                const finalSizes = sizes.length > 0 ? sizes : ['All Size'];
                const selectedSize = sizeContainer.getAttribute('data-selected');
                
                sizeContainer.innerHTML = '';
                
                finalSizes.forEach((size, index) => {
                    const isChecked = selectedSize === size || (!selectedSize && index === 0);
                    const label = document.createElement('label');
                    label.className = 'cursor-pointer';
                    label.innerHTML = `
                        <input type="radio" name="size" value="${size}" class="peer sr-only" ${isChecked ? 'checked' : ''} ${index === 0 ? 'required' : ''}>
                        <div class="min-w-[3rem] px-4 py-4 flex items-center justify-center rounded-2xl border-2 border-dark-chocolate/10 font-black text-dark-chocolate peer-checked:border-sakura peer-checked:bg-sakura peer-checked:text-dark-chocolate transition-all duration-300 shadow-sm hover:scale-105 bg-white/40 hover:border-sakura/50 peer-checked:shadow-sakura/20 peer-checked:shadow-lg">
                            ${size}
                        </div>
                    `;
                    sizeContainer.appendChild(label);
                });
            } else if (sizeContainer) {
                sizeContainer.innerHTML = '<p class="text-sm font-medium text-dark-chocolate/50 italic py-2">Pilih kostum terlebih dahulu untuk melihat ukuran.</p>';
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
