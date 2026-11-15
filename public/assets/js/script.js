
// =================================
// MOBILE MENU
// =================================

const menuToggle = document.getElementById("menuToggle");
const navMenu = document.getElementById("navMenu");

menuToggle.addEventListener("click", function () {
    navMenu.classList.toggle("show");
});


// Menutup menu setelah memilih navigasi
document.querySelectorAll(".nav-menu > a").forEach(function (link) {

    link.addEventListener("click", function () {
        navMenu.classList.remove("show");
    });

});


// =================================
// LANGUAGE SWITCH
// =================================

const languageButtons = document.querySelectorAll(".language");

languageButtons.forEach(function (button) {

    button.addEventListener("click", function () {

        languageButtons.forEach(function (item) {
            item.classList.remove("active");
        });

        button.classList.add("active");

        const selectedLanguage = button.dataset.lang;

        document.documentElement.lang =
            selectedLanguage === "en" ? "en" : "id";

    });

});