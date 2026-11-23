(() => {
    const body = document.body;
    const sidebar = document.querySelector('[data-admin-sidebar]');
    const overlay = document.querySelector('[data-admin-overlay]');
    const openButton = document.querySelector('[data-admin-menu-open]');
    const closeButton = document.querySelector('[data-admin-menu-close]');

    const setMenuOpen = (open) => {
        body.classList.toggle('admin-nav-open', open);

        if (openButton) {
            openButton.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
    };

    if (sidebar && openButton) {
        openButton.addEventListener('click', () => setMenuOpen(true));
    }

    if (closeButton) {
        closeButton.addEventListener('click', () => setMenuOpen(false));
    }

    if (overlay) {
        overlay.addEventListener('click', () => setMenuOpen(false));
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.getAttribute('data-confirm') || 'Lanjutkan tindakan ini?';

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('[data-preview-input]').forEach((input) => {
        const selector = input.getAttribute('data-preview-input');
        const target = selector ? document.querySelector(selector) : null;

        if (!target) {
            return;
        }

        input.addEventListener('change', () => {
            target.innerHTML = '';

            Array.from(input.files || []).forEach((file) => {
                if (!file.type || !file.type.startsWith('image/')) {
                    return;
                }

                const image = document.createElement('img');
                image.className = 'admin-preview__img';
                image.alt = file.name;
                image.src = URL.createObjectURL(file);
                image.addEventListener('load', () => URL.revokeObjectURL(image.src), { once: true });
                target.appendChild(image);
            });
        });
    });

    document.querySelectorAll('.admin-alert--success').forEach((alert) => {
        window.setTimeout(() => {
            alert.style.transition = 'opacity .3s ease';
            alert.style.opacity = '0';

            window.setTimeout(() => {
                alert.remove();
            }, 320);
        }, 6000);
    });
})();
