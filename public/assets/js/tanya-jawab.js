(() => {
    "use strict";

    const chatMessages = document.getElementById("chat-messages");
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");
    const faqButtons = document.querySelectorAll(".faq-button");

    if (!chatMessages || !chatForm || !chatInput) return;

    const defaultFallback = "Maaf, pertanyaan tersebut belum tersedia dalam informasi FAQ. Silakan hubungi admin melalui halaman Kontak untuk mendapatkan jawaban yang lebih tepat.";

    function readChatData() {
        const dataElement = document.getElementById("faq-chat-data");

        if (!dataElement) return { answers: [], fallback: defaultFallback };

        try {
            const data = JSON.parse(dataElement.textContent);

            return {
                answers: Array.isArray(data.answers) ? data.answers : [],
                fallback: typeof data.fallback === "string" && data.fallback !== ""
                    ? data.fallback
                    : defaultFallback
            };
        } catch (error) {
            return { answers: [], fallback: defaultFallback };
        }
    }

    const chatData = readChatData();

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

        const match = chatData.answers.find(item =>
            Array.isArray(item.keywords)
            && item.keywords.some(keyword => normalized.includes(String(keyword).toLowerCase()))
        );

        return match && typeof match.answer === "string"
            ? match.answer
            : chatData.fallback;
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
