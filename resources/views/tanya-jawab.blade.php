<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Tanya Jawab Sanggar Cakra Aji">
    <title>Tanya Jawab | Sanggar Cakra Aji</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tanya-jawab.css') }}">
</head>
<body>
    <header class="site-header">
        <nav class="navbar container" aria-label="Navigasi utama">
            <a class="brand" href="/" aria-label="Sanggar Cakra Aji - Beranda">
                <img src="{{ asset('images/logo-cakra-aji.png') }}" alt="Logo Sanggar Cakra Aji"
                     onerror="this.hidden=true; this.nextElementSibling.hidden=false;">
                <span class="brand-fallback" hidden><strong>CA</strong><small>AKRA AJI</small></span>
            </a>

            <button class="menu-toggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-menu">
                <span></span><span></span><span></span>
            </button>

            <div class="nav-menu" id="nav-menu">
                <a href="/">Beranda</a>
                <a href="/tentang-kami">Tentang Kami</a>
                <a href="/program-kegiatan">Program &amp; Kegiatan</a>
                <a href="/galeri">Galeri</a>
                <a href="/kontak">Kontak</a>
                <a class="active" href="/tanya-jawab" aria-current="page">Tanya Jawab</a>
                <a class="nav-pill" href="/daftar-murid">Daftar Murid</a>
                <a class="nav-pill" href="/booking-acara">Booking Acara</a>
            </div>
        </nav>
    </header>

    <main class="page-main">
        <div class="container">
            <section class="intro">
                <div class="intro-labels">
                    <span class="eyebrow">TANYA JAWAB</span>
                    <span class="system-label">Dijawab otomatis oleh sistem</span>
                </div>
                <h1>Ada yang ingin<br class="desktop-break"> kamu tanyakan?</h1>
                <p>Pilih pertanyaan di sebelah kanan, atau ketik pertanyaanmu sendiri.<br class="desktop-break">
                    Jawaban muncul langsung, tanpa perlu menunggu admin.</p>
            </section>

            <section class="content-grid" aria-label="Pusat bantuan Sanggar Cakra Aji">
                <section class="chat-card" aria-label="Chat Asisten Cakra Aji">
                    <div class="chat-header">
                        <div class="assistant-avatar">CA</div>
                        <div>
                            <h2>Asisten Cakra Aji</h2>
                            <span>Menjawab otomatis</span>
                        </div>
                    </div>

                    <div class="chat-messages" id="chat-messages" aria-live="polite" aria-label="Riwayat percakapan">
                        <div class="message-row bot-row">
                            <div class="chat-bubble bot-bubble">
                                Halo! Aku asisten otomatis Sanggar Cakra Aji. Tanyakan soal pendaftaran, booking acara, jadwal, atau lokasi.
                            </div>
                        </div>
                        <div class="message-row user-row">
                            <div class="chat-bubble user-bubble">Bagaimana cara mendaftar jadi murid?</div>
                        </div>
                        <div class="message-row bot-row">
                            <div class="chat-bubble bot-bubble">
                                Cukup isi formulir di halaman Daftar Murid. Setelah terkirim, admin akan menghubungi lewat WhatsApp untuk mengatur jadwal latihan perdana.
                            </div>
                        </div>
                        <div class="message-row user-row">
                            <div class="chat-bubble user-bubble">Kapan jadwal latihan?</div>
                        </div>
                        <div class="message-row bot-row">
                            <div class="chat-bubble bot-bubble">
                                Jadwal latihan tiap kelompok ada di halaman Program &amp; Kegiatan, bagian Jadwal latihan. Jadwal terbaru: [isi admin].
                            </div>
                        </div>
                    </div>

                    <form class="chat-form" id="chat-form" autocomplete="off">
                        <label class="sr-only" for="chat-input">Tulis pertanyaan</label>
                        <input id="chat-input" name="message" type="text" placeholder="Ketik pertanyaanmu di sini..." maxlength="500" required>
                        <button type="submit" aria-label="Kirim pesan">
                            <span>Kirim</span>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 20.2 22 12 3 3.8 3.2 10l12.1 2-12.1 2z"/></svg>
                        </button>
                    </form>
                </section>

                <aside class="sidebar">
                    <section class="faq-card">
                        <p class="faq-heading">PERTANYAAN YANG SERING DITANYAKAN</p>
                        <p class="faq-description">Tekan salah satu untuk melihat jawabannya.</p>
                        <div class="faq-list">
                            <button type="button" class="faq-button" data-question="Bagaimana cara mendaftar jadi murid?">Bagaimana cara mendaftar jadi murid?</button>
                            <button type="button" class="faq-button" data-question="Bagaimana cara booking acara?">Bagaimana cara booking acara?</button>
                            <button type="button" class="faq-button" data-question="Kapan jadwal latihan?">Kapan jadwal latihan?</button>
                            <button type="button" class="faq-button" data-question="Berapa biayanya?">Berapa biayanya?</button>
                            <button type="button" class="faq-button" data-question="Di mana lokasi sanggar?">Di mana lokasi sanggar?</button>
                            <button type="button" class="faq-button" data-question="Siapa saja yang boleh ikut?">Siapa saja yang boleh ikut?</button>
                            <button type="button" class="faq-button" data-question="Bagaimana cara menghubungi admin?">Bagaimana cara menghubungi admin?</button>
                        </div>
                    </section>

                    <section class="unanswered-card">
                        <h2>Belum terjawab?</h2>
                        <p>Hubungi contact person kami langsung, atau tinggalkan kritik dan saran.</p>
                        <div class="unanswered-actions">
                            <a class="button button-primary" href="https://wa.me/628XXXXXXXXXX" target="_blank" rel="noopener noreferrer">Hubungi kami</a>
                            <a class="button button-outline" href="/kritik-saran">Kritik &amp; saran</a>
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </main>

    <script src="{{ asset('js/tanya-jawab.js') }}" defer></script>
</body>
</html>
