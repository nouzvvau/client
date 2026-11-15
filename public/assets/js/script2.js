// =====================================
// MOBILE NAVIGATION
// =====================================

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

// Menutup menu setelah salah satu link diklik
document.querySelectorAll('.nav-menu a').forEach(function (link) {

    link.addEventListener('click', function () {

        navMenu.classList.remove('show');

        menuToggle.setAttribute('aria-expanded', 'false');

    });

});

// =====================================
// LANGUAGE SWITCH
// =====================================

const languageOptions = document.querySelectorAll('.language-option');

languageOptions.forEach(option => {

    option.addEventListener('click', function () {

        // Menghapus status aktif dari semua tombol
        languageOptions.forEach(item => {
            item.classList.remove('active');
        });

        // Mengaktifkan tombol yang diklik
        this.classList.add('active');

    });

});