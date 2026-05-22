    const tglSewa    = document.getElementById('tanggal_sewa');
    const tglKembali = document.getElementById('tanggal_kembali');

    if (tglSewa && tglKembali) {
        tglSewa.addEventListener('change', function () {
            tglKembali.min = this.value;
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
        });
    }

    // Tampilkan sisa stok berdasarkan ukuran yang dipilih
    const sizeRadios = document.querySelectorAll('input[name="size"]');
    const stockInfo = document.getElementById('stock-info');
    const selectedSizeText = document.getElementById('selected-size-text');

    if (sizeRadios.length > 0 && stockInfo && selectedSizeText) {
        sizeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectedSizeText.textContent = this.value;
                    stockInfo.classList.remove('hidden');
                }
            });
        });
    }
