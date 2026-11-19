(() => {
    "use strict";

    const chatMessages = document.getElementById("chat-messages");
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const faqButtons = document.querySelectorAll(".faq-button");

    if (!chatMessages || !chatForm || !chatInput) return;

    const answers = [
        {
            keywords: ["daftar", "pendaftaran", "murid", "siswa", "gabung"],
            answer: "Untuk mendaftar sebagai murid, tekan tombol Daftar Murid pada navbar atau halaman Pendaftaran. Kamu akan diarahkan ke formulir pendaftaran resmi, lalu admin akan menghubungi melalui WhatsApp."
        },
        {
            keywords: ["booking", "acara", "tampil", "undang", "pertunjukan"],
            answer: "Untuk booking acara, tekan tombol Booking Acara pada navbar atau halaman Booking Acara. Isi formulir resmi yang tersedia, lalu tim Sanggar Cakra Aji akan menghubungi kamu untuk konfirmasi."
        },
        {
            keywords: ["jadwal", "latihan"],
            answer: "Informasi jadwal latihan tersedia di halaman Program & Kegiatan. Silakan periksa jadwal sesuai kelompok yang ingin diikuti."
        },
        {
            keywords: ["biaya", "harga", "bayar", "tarif", "iuran"],
            answer: "Informasi biaya belum tersedia di sistem ini. Silakan hubungi admin melalui halaman Kontak untuk mendapatkan informasi resmi."
        },
        {
            keywords: ["lokasi", "alamat", "tempat", "sanggar"],
            answer: "Untuk mengetahui lokasi Sanggar Cakra Aji, silakan kunjungi halaman Lokasi pada website."
        },
        {
            keywords: ["umur", "usia", "persyaratan", "anak", "dewasa"],
            answer: "Persyaratan usia dan peserta dapat berbeda pada setiap program. Silakan hubungi admin melalui halaman Kontak untuk informasi lebih lanjut."
        },
        {
            keywords: ["kontak", "hubungi", "admin", "whatsapp", "nomor"],
            answer: "Untuk menghubungi admin, silakan buka halaman Kontak yang tersedia pada website."
        }
    ];

    function addMessage(text, type) {
        const row = document.createElement("div");
        row.className = `faq-message-row ${type === "user" ? "faq-user-row" : "faq-bot-row"}`;

        const bubble = document.createElement("div");
        bubble.className = `faq-chat-bubble ${type === "user" ? "faq-user-bubble" : "faq-bot-bubble"}`;
        bubble.textContent = text;

        row.appendChild(bubble);
        chatMessages.appendChild(row);

        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function getAnswer(question) {
        const normalized = question.toLowerCase();

        const match = answers.find(item =>
            item.keywords.some(keyword => normalized.includes(keyword))
        );

        return match
            ? match.answer
            : "Maaf, pertanyaan tersebut belum tersedia dalam informasi FAQ. Silakan hubungi admin melalui halaman Kontak untuk mendapatkan jawaban yang lebih tepat.";
    }

    function sendQuestion(question) {
        const cleanQuestion = question.trim();

        if (!cleanQuestion) return;

        addMessage(cleanQuestion, "user");

        window.setTimeout(() => {
            addMessage(getAnswer(cleanQuestion), "bot");
        }, 250);
    }

    chatForm.addEventListener("submit", event => {
        event.preventDefault();

        sendQuestion(chatInput.value);

        chatInput.value = "";
        chatInput.focus();
    });

    faqButtons.forEach(button => {
        button.addEventListener("click", () => {
            sendQuestion(button.dataset.question || button.textContent);
        });
    });

    chatMessages.scrollTop = chatMessages.scrollHeight;
})();
