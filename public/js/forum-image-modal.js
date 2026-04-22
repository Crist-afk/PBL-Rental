(function () {
    if (window.__forumImageModalInitialized) {
        return;
    }

    window.__forumImageModalInitialized = true;

    function getModalElements() {
        return {
            modal: document.getElementById('image-modal'),
            modalImg: document.getElementById('modal-image'),
        };
    }

    window.openImageModal = function (imageSrc) {
        const elements = getModalElements();
        const modal = elements.modal;
        const modalImg = elements.modalImg;

        if (!modal || !modalImg) {
            return;
        }

        modalImg.src = imageSrc;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');

        setTimeout(function () {
            modal.classList.remove('opacity-0');
            modalImg.classList.remove('scale-95');
            modalImg.classList.add('scale-100');
        }, 10);
    };

    window.closeImageModal = function () {
        const elements = getModalElements();
        const modal = elements.modal;
        const modalImg = elements.modalImg;

        if (!modal || !modalImg) {
            return;
        }

        modal.classList.add('opacity-0');
        modalImg.classList.remove('scale-100');
        modalImg.classList.add('scale-95');

        setTimeout(function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.setAttribute('aria-hidden', 'true');
            modalImg.src = '';
        }, 300);
    };

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            window.closeImageModal();
        }
    });
})();
