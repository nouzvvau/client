(function () {
  function initNavigation() {
    const page = document.body.dataset.page;

    if (page) {
      document.querySelectorAll("[data-nav]").forEach(function (link) {
        if (link.dataset.nav !== page) {
          return;
        }

        link.classList.add("is-active");
        link.setAttribute("aria-current", "page");
      });
    }

    const toggle = document.querySelector(".nav-toggle");
    const panel = document.querySelector(".navbar__panel");

    if (!toggle || !panel) {
      return;
    }

    toggle.addEventListener("change", function () {
      toggle.setAttribute(
        "aria-label",
        toggle.checked ? "Tutup menu navigasi" : "Buka menu navigasi"
      );
    });

    panel.addEventListener("click", function (event) {
      if (event.target.closest("a")) {
        toggle.checked = false;
      }
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && toggle.checked) {
        toggle.checked = false;
      }
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initNavigation, { once: true });
  } else {
    initNavigation();
  }
})();
