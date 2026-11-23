// =====================================
// MOBILE NAVIGATION
// =====================================

(() => {
    "use strict";

    const menuToggle = document.getElementById("menuToggle");
    const navMenu = document.getElementById("navMenu");

    if (!menuToggle || !navMenu) return;

    const labelOpen = menuToggle.dataset.labelOpen || "Buka menu";
    const labelClose = menuToggle.dataset.labelClose || "Tutup menu";

    const setMenuOpen = (isOpen) => {
        navMenu.classList.toggle("show", isOpen);
        menuToggle.setAttribute("aria-expanded", String(isOpen));
        menuToggle.setAttribute("aria-label", isOpen ? labelClose : labelOpen);
    };

    menuToggle.addEventListener("click", () => {
        setMenuOpen(! navMenu.classList.contains("show"));
    });

    navMenu.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => setMenuOpen(false));
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && navMenu.classList.contains("show")) {
            setMenuOpen(false);
            menuToggle.focus();
        }
    });

    document.addEventListener("click", (event) => {
        if (! navMenu.classList.contains("show")) return;
        if (navMenu.contains(event.target) || menuToggle.contains(event.target)) return;

        setMenuOpen(false);
    });
})();
