    const tglSewa    = document.getElementById('tanggal_sewa');
    const tglKembali = document.getElementById('tanggal_kembali');
    const sizeRadios = document.querySelectorAll('input[name="size"]');
    const stockInfo = document.getElementById('stock-info');
    const selectedSizeText = document.getElementById('selected-size-text');
    const stokValueSpan = stockInfo ? stockInfo.querySelector('span.text-sakura:last-child') : null;
    const sewaBtn = document.getElementById('btn-sewa-sekarang');
    const kostumIdInput = document.querySelector('input[name="kostum_id"]');

    function checkAvailability() {
        if (!kostumIdInput || !tglSewa.value || !tglKembali.value) return;
        
        let selectedSize = null;
        sizeRadios.forEach(r => { if (r.checked) selectedSize = r.value; });
        
        if (!selectedSize) return;

        sewaBtn.disabled = true;
        sewaBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Checking Stock...';

        fetch(`${window.apiCheckAvailabilityUrl}?kostum_id=${kostumIdInput.value}&size=${encodeURIComponent(selectedSize)}&start=${tglSewa.value}&end=${tglKembali.value}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                
                selectedSizeText.textContent = selectedSize;
                if (stokValueSpan) stokValueSpan.textContent = data.stok_aktual;
                stockInfo.classList.remove('hidden');

                if (data.stok_aktual <= 0) {
                    sewaBtn.disabled = true;
                    sewaBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    sewaBtn.innerHTML = '<i class="fa-solid fa-ban"></i> Out of Stock for these dates';
                } else {
                    sewaBtn.disabled = false;
                    sewaBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    sewaBtn.innerHTML = '<i class="fa-solid fa-cart-shopping"></i> Rent Now';
                }
            })
            .catch(err => {
                console.error("Error checking availability:", err);
                sewaBtn.disabled = false;
                sewaBtn.innerHTML = '<i class="fa-solid fa-cart-shopping"></i> Rent Now';
            });
    }

    if (tglSewa && tglKembali) {
        tglSewa.addEventListener('change', function () {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
            checkAvailability();
        });
        tglKembali.addEventListener('change', checkAvailability);
    }

    if (sizeRadios.length > 0) {
        sizeRadios.forEach(radio => {
            radio.addEventListener('change', checkAvailability);
        });
    }
