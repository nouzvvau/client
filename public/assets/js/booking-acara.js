(() => {
    "use strict";
    const menuToggle = document.querySelector(".menu-toggle");
    const navMenu = document.getElementById("nav-menu");
    const form = document.getElementById("booking-form");
    const submitButton = document.getElementById("submit-button");
    const whatsappInput = document.getElementById("whatsapp");
    const eventDate = document.getElementById("event_date");

    if (menuToggle && navMenu) {
        menuToggle.addEventListener("click", () => {
            const isOpen = navMenu.classList.toggle("open");
            menuToggle.setAttribute("aria-expanded", String(isOpen));
            menuToggle.setAttribute("aria-label", isOpen ? "Tutup menu" : "Buka menu");
        });
        navMenu.querySelectorAll("a").forEach(link => link.addEventListener("click", () => {
            navMenu.classList.remove("open");
            menuToggle.setAttribute("aria-expanded", "false");
        }));
    }

    if (whatsappInput) {
        whatsappInput.addEventListener("input", () => {
            whatsappInput.value = whatsappInput.value.replace(/[^0-9+() -]/g, "");
        });
    }

    if (eventDate) {
        const today = new Date();
        const localToday = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
        eventDate.min = localToday;
    }

    if (form) {
        form.addEventListener("submit", event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                form.reportValidity();
                return;
            }
            if (eventDate && eventDate.value) {
                const chosen = new Date(`${eventDate.value}T00:00:00`);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                if (chosen < today) {
                    event.preventDefault();
                    alert("Tanggal acara tidak boleh berada di masa lalu.");
                    eventDate.focus();
                    return;
                }
            }
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.querySelector("span").textContent = "Mengirim permintaan...";
            }
            // Browser mengirim form POST ke Laravel. Data disimpan oleh BookingController.
        });
    }
})();
