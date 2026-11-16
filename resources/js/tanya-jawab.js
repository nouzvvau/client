(() => {
    "use strict";

    const chatMessages = document.getElementById("chat-messages");
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const faqButtons = document.querySelectorAll(".faq-button");
    const menuToggle = document.querySelector(".menu-toggle");
    const navMenu = document.getElementById("nav-menu");

    // Ganti nilai ini dengan nomor WhatsApp admin sebenarnya (format internasional tanpa +).
    const ADMIN_WHATSAPP = "628XXXXXXXXXX";

    const answers = [
        {
            keywords: ["daftar", "pendaftaran", "murid", "siswa", "gabung"],
            answer: "Untuk mendaftar, silakan buka halaman Daftar Murid dan isi formulir yang tersedia. Setelah formulir dikirim, admin akan menghubungi melalui WhatsApp untuk informasi berikutnya."
        },
        {
            keywords: ["booking", "acara", "tampil", "undang", "pertunjukan"],
            answer: "Untuk booking acara, silakan buka halaman Booking Acara dan lengkapi informasi acara. Tim Sanggar Cakra Aji akan menghubungi Anda untuk konfirmasi. Detail ketersediaan jadwal dapat ditanyakan kepada admin."
        },
        {
            keywords: ["jadwal", "latihan", "hari", "jam"],
            answer: "Jadwal latihan setiap kelompok tersedia di halaman Program & Kegiatan, pada bagian Jadwal Latihan. Jadwal terbaru: [silakan isi jadwal resmi dari admin]."
        },
        {
            keywords: ["biaya", "harga", "bayar", "tarif", "iuran"],
            answer: "Informasi biaya belum tersedia di sistem ini. Silakan hubungi admin melalui WhatsApp untuk mendapatkan informasi biaya terbaru yang resmi."
        },
        {
            keywords: ["lokasi", "alamat", "tempat", "sanggar", "dimana", "di mana"],
            answer: "Informasi alamat sanggar perlu dilengkapi oleh admin. Silakan hubungi admin melalui halaman Kontak untuk mendapatkan petunjuk lokasi yang benar."
        },
        {
            keywords: ["siapa", "umur", "usia", "boleh", "ikut", "anak", "dewasa"],
            answer: "Informasi kelompok usia dan persyaratan peserta dapat berbeda sesuai program. Silakan hubungi admin agar mendapatkan informasi persyaratan yang sesuai."
        },
        {
            keywords: ["kontak", "hubungi", "admin", "whatsapp", "wa", "nomor"],
            answer: "Kamu dapat menghubungi admin melalui tombol Hubungi Kami di halaman ini. Pastikan nomor WhatsApp admin sudah diatur oleh pengelola website."
        }
    ];

    function addMessage(text, type) {
        const row = document.createElement("div");
        row.className = `message-row ${type === "user" ? "user-row" : "bot-row"}`;

        const bubble = document.createElement("div");
        bubble.className = `chat-bubble ${type === "user" ? "user-bubble" : "bot-bubble"}`;
        bubble.textContent = text;

        row.appendChild(bubble);
        chatMessages.appendChild(row);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function getAnswer(question) {
        const normalized = question.toLocaleLowerCase("id");
        const match = answers.find(item => item.keywords.some(keyword => normalized.includes(keyword)));
        return match
            ? match.answer
            : "Terima kasih atas pertanyaannya. Aku belum memiliki informasi tersebut. Silakan hubungi admin melalui halaman Kontak agar pertanyaanmu dapat dijawab dengan tepat.";
    }

    function sendQuestion(question) {
        const cleanQuestion = question.trim();
        if (!cleanQuestion) return;

        addMessage(cleanQuestion, "user");
        window.setTimeout(() => addMessage(getAnswer(cleanQuestion), "bot"), 250);
    }

    chatForm.addEventListener("submit", event => {
        event.preventDefault();
        sendQuestion(chatInput.value);
        chatInput.value = "";
        chatInput.focus();
    });

    faqButtons.forEach(button => {
        button.addEventListener("click", () => sendQuestion(button.dataset.question || button.textContent));
    });

    if (menuToggle && navMenu) {
        menuToggle.addEventListener("click", () => {
            const isOpen = navMenu.classList.toggle("open");
            menuToggle.setAttribute("aria-expanded", String(isOpen));
            menuToggle.setAttribute("aria-label", isOpen ? "Tutup menu" : "Buka menu");
        });

        navMenu.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                navMenu.classList.remove("open");
                menuToggle.setAttribute("aria-expanded", "false");
                menuToggle.setAttribute("aria-label", "Buka menu");
            });
        });
    }

    // Hindari mengarahkan pengguna ke nomor placeholder yang belum diganti.
    document.querySelectorAll('a[href*="628XXXXXXXXXX"]').forEach(link => {
        link.addEventListener("click", event => {
            if (ADMIN_WHATSAPP.includes("X")) {
                event.preventDefault();
                alert("Nomor WhatsApp admin belum diatur. Silakan ganti placeholder 628XXXXXXXXXX pada file tanya-jawab.blade.php dan tanya-jawab.js.");
            } else {
                link.href = `https://wa.me/${ADMIN_WHATSAPP}`;
            }
        });
    });

    chatMessages.scrollTop = chatMessages.scrollHeight;
})();
