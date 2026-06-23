if (window.bookingSuccessMessage) {
    Swal.fire({
        title: 'Success!',
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
        const submitBtn = document.querySelector('button[type="submit"]');

        function checkAvailability() {
            const kostumSelect = document.getElementById('kostum_id');
            const sizeRadio = document.querySelector('input[name="size"]:checked');
            
            if (!kostumSelect.value || !sizeRadio || !tglSewa.value || !tglKembali.value) return;

            const selectedSize = sizeRadio.value;
            const originalBtnContent = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="relative flex items-center justify-center gap-3 text-xl uppercase tracking-widest"><i class="fa-solid fa-spinner fa-spin"></i> Checking Stock...</span>';

            fetch(`${window.apiCheckAvailabilityUrl}?kostum_id=${kostumSelect.value}&size=${encodeURIComponent(selectedSize)}&start=${tglSewa.value}&end=${tglKembali.value}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    
                    const infoLabel = sizeRadio.nextElementSibling;
                    const stockSpan = infoLabel.querySelector('.stock-status');
                    
                    if (data.stok_aktual <= 0) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        submitBtn.innerHTML = '<span class="relative flex items-center justify-center gap-3 text-xl uppercase tracking-widest"><i class="fa-solid fa-ban"></i> Out of Stock</span>';
                        if (stockSpan) stockSpan.innerHTML = '<span class="text-[10px] ml-1 font-bold text-red-500">(Out of Stock for these dates)</span>';
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitBtn.innerHTML = '<span class="relative flex items-center justify-center gap-3 text-xl uppercase tracking-widest"><i class="fa-solid fa-paper-plane animate-bounce-slow"></i> Confirm Booking</span>';
                        if (stockSpan) stockSpan.innerHTML = `<span class="text-[10px] ml-1 font-bold text-sakura">(${data.stok_aktual} left)</span>`;
                    }
                })
                .catch(err => {
                    console.error("Error checking availability:", err);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span class="relative flex items-center justify-center gap-3 text-xl uppercase tracking-widest"><i class="fa-solid fa-paper-plane animate-bounce-slow"></i> Confirm Booking</span>';
                });
        }

        tglSewa.addEventListener('change', function() {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
            checkAvailability();
        });

        tglKembali.addEventListener('change', checkAvailability);

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
                let selectedSize = sizeContainer.getAttribute('data-selected');
                
                sizeContainer.innerHTML = '';
                
                if (finalSizes.length > 0 && (!selectedSize || !finalSizes.includes(selectedSize))) {
                    selectedSize = finalSizes[0];
                }

                finalSizes.forEach((size, index) => {
                    const isChecked = selectedSize === size;
                    
                    // Jika ini bukan size yang dipilih, jangan render (Lock)
                    if (!isChecked) return;
                    
                    const label = document.createElement('label');
                    label.className = 'cursor-not-allowed opacity-60 pointer-events-none'; // Locked styling
                    label.innerHTML = `
                        <input type="radio" name="size" value="${size}" class="peer sr-only size-radio-btn" ${isChecked ? 'checked' : ''} required>
                        <div class="min-w-[3rem] px-4 py-4 flex items-center justify-center rounded-2xl border-2 border-dark-chocolate/20 bg-dark-chocolate/5 font-black text-dark-chocolate/60 transition-all duration-300">
                            ${size} <span class="stock-status"></span>
                        </div>
                    `;
                    sizeContainer.appendChild(label);
                });
                
                document.querySelectorAll('.size-radio-btn').forEach(radio => {
                    radio.addEventListener('change', checkAvailability);
                });
                
                checkAvailability();
            } else if (sizeContainer) {
                sizeContainer.innerHTML = '<p class="text-sm font-medium text-dark-chocolate/50 italic py-2">Select a costume first to see available sizes.</p>';
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
