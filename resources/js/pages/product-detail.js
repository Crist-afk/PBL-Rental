    const tglSewa    = document.getElementById('tanggal_sewa');
    const tglKembali = document.getElementById('tanggal_kembali');
    const sizeRadios = document.querySelectorAll('input[name="size"]');
    const stockInfo = document.getElementById('stock-info');
    const selectedSizeText = document.getElementById('selected-size-text');
    const selectedSizeStock = document.getElementById('selected-size-stock');
    const sewaBtn = document.getElementById('btn-sewa-sekarang');
    const kostumIdInput = document.querySelector('input[name="kostum_id"]');

    // Stok aktual per ukuran dari server (tanpa filter tanggal)
    // Diisi dari window.stokAktualPerUkuran yang di-inject via blade
    const stokAwalPerUkuran = window.stokAktualPerUkuran || {};

    /**
     * Tampilkan stok awal (dari server-side, tanpa tanggal)
     * saat user memilih ukuran tapi belum mengisi tanggal.
     */
    function tampilkanStokAwal(size) {
        if (!stockInfo || !selectedSizeText || !selectedSizeStock) return;
        const stok = stokAwalPerUkuran[size] ?? '—';
        selectedSizeText.textContent = size;
        selectedSizeStock.textContent = stok;
        stockInfo.classList.remove('hidden');

        // Update tombol berdasarkan stok awal
        if (sewaBtn) {
            if (stok === '—' || stok > 0) {
                sewaBtn.disabled = false;
                sewaBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                sewaBtn.innerHTML = '<i class="fa-solid fa-cart-shopping"></i> Rent Now';
            } else {
                sewaBtn.disabled = true;
                sewaBtn.classList.add('opacity-50', 'cursor-not-allowed');
                sewaBtn.innerHTML = '<i class="fa-solid fa-ban"></i> Out of Stock';
            }
        }
    }

    function checkAvailability() {
        if (!kostumIdInput) return;
        
        let selectedSize = null;
        sizeRadios.forEach(r => { if (r.checked) selectedSize = r.value; });
        
        if (!selectedSize) return;

        // Jika tanggal belum diisi, tampilkan stok awal dari server
        const startParam = tglSewa ? tglSewa.value : '';
        const endParam = tglKembali ? tglKembali.value : '';
        if (!startParam || !endParam) {
            tampilkanStokAwal(selectedSize);
            return;
        }

        if (sewaBtn) {
            sewaBtn.disabled = true;
            sewaBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Checking Stock...';
        }

        fetch(`${window.apiCheckAvailabilityUrl}?kostum_id=${kostumIdInput.value}&size=${encodeURIComponent(selectedSize)}&start=${startParam}&end=${endParam}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                
                if (selectedSizeText) selectedSizeText.textContent = selectedSize;
                if (selectedSizeStock) selectedSizeStock.textContent = data.stok_aktual;
                if (stockInfo) stockInfo.classList.remove('hidden');

                if (sewaBtn) {
                    if (data.stok_aktual <= 0) {
                        sewaBtn.disabled = true;
                        sewaBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        sewaBtn.innerHTML = '<i class="fa-solid fa-ban"></i> Out of Stock for these dates';
                    } else {
                        sewaBtn.disabled = false;
                        sewaBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        sewaBtn.innerHTML = '<i class="fa-solid fa-cart-shopping"></i> Rent Now';
                    }
                }
            })
            .catch(err => {
                console.error("Error checking availability:", err);
                if (sewaBtn) {
                    sewaBtn.disabled = false;
                    sewaBtn.innerHTML = '<i class="fa-solid fa-cart-shopping"></i> Rent Now';
                }
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

    // ── REVISI 3: Restore booking intent dari localStorage ──────────────────────
    // Restore hanya jika: (1) user sudah login (sewaBtn ada), (2) kostum_id cocok
    (function restoreBookingIntent() {
        try {
            const raw = localStorage.getItem('cosrent_booking_intent');
            if (!raw) return;

            const intent = JSON.parse(raw);
            if (!intent) return;

            // Pastikan intent untuk kostum yang sama
            const currentKostumId = window.kostumId ? String(window.kostumId) : null;
            if (!currentKostumId || String(intent.kostum_id) !== currentKostumId) return;

            // Hanya restore jika user sudah login (form submit button ada)
            if (!sewaBtn) return;

            let restored = false;

            // Restore size — hanya jika ukuran tersebut masih tersedia
            if (intent.size) {
                sizeRadios.forEach(radio => {
                    if (radio.value === intent.size) {
                        radio.checked = true;
                        restored = true;
                    }
                });
            }

            // Restore tanggal
            const today = new Date().toISOString().split('T')[0];
            if (intent.tanggal_sewa && intent.tanggal_sewa >= today && tglSewa) {
                tglSewa.value = intent.tanggal_sewa;
                if (tglKembali) tglKembali.min = intent.tanggal_sewa;
            }
            if (intent.tanggal_kembali && tglKembali) {
                const minDate = tglSewa?.value || today;
                if (intent.tanggal_kembali >= minDate) {
                    tglKembali.value = intent.tanggal_kembali;
                }
            }

            // Restore catatan
            const catatanField = document.getElementById('catatan_guest');
            if (catatanField && intent.catatan) {
                catatanField.value = intent.catatan;
            }

            // Trigger availability check jika ada size & tanggal
            if (restored) {
                checkAvailability();
            }

            // Tampilkan notifikasi restore yang tidak mengganggu
            if (restored || intent.tanggal_sewa) {
                const notif = document.createElement('div');
                notif.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-5 py-3 rounded-2xl shadow-2xl text-sm font-bold text-white flex items-center gap-2 transition-all duration-500';
                notif.style.cssText = 'background:rgba(68,48,37,0.95);backdrop-filter:blur(8px);';
                notif.innerHTML = '<i class="fa-solid fa-rotate-left text-sakura"></i> Booking form restored from your previous selection.';
                document.body.appendChild(notif);
                setTimeout(() => { notif.style.opacity = '0'; setTimeout(() => notif.remove(), 500); }, 3500);
            }
        } catch (e) {
            // localStorage unavailable atau data corrupt — silent fail
        }
    })();
