
@extends('layouts.main')

@section('title', 'Tanya Jawab | Sanggar Seni Cakra Aji')
@section('description', 'Temukan jawaban atas pertanyaan seputar pendaftaran, jadwal latihan, lokasi, dan booking acara Sanggar Seni Cakra Aji.')
@section('page', 'faq')
@section('activeNav', 'faq')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tanya-jawab.css') }}">
@endpush

@section('content')
<div class="faq-page">
    <div class="faq-container">

        <section class="faq-intro">
            <div class="faq-intro-labels">
                <span class="faq-eyebrow">TANYA JAWAB</span>
                <span class="faq-system-label">Asisten Informasi Otomatis</span>
            </div>

            <h1>Ada yang ingin<br class="faq-desktop-break"> kamu tanyakan?</h1>

            <p>
                Pilih pertanyaan yang tersedia atau ketik pertanyaanmu sendiri.
                Jawaban diberikan otomatis berdasarkan informasi yang tersedia.
            </p>
        </section>

        <section class="faq-content-grid" aria-label="Pusat bantuan Sanggar Cakra Aji">

            <section class="faq-chat-card" aria-label="Chat Asisten Cakra Aji">
                <div class="faq-chat-header">
                    <div class="faq-assistant-avatar">CA</div>
                    <div>
                        <h2>Asisten Cakra Aji</h2>
                        <span>Menjawab otomatis</span>
                    </div>
                </div>

                <div
                    class="faq-chat-messages"
                    id="chat-messages"
                    aria-live="polite"
                    aria-label="Riwayat percakapan"
                >
                    <div class="faq-message-row faq-bot-row">
                        <div class="faq-chat-bubble faq-bot-bubble">
                            Halo! Aku asisten informasi otomatis Sanggar Cakra Aji.
                            Kamu bisa bertanya tentang pendaftaran, booking acara,
                            jadwal latihan, biaya, atau lokasi sanggar.
                        </div>
                    </div>
                </div>

                <form class="faq-chat-form" id="chat-form" autocomplete="off">
                    <label class="faq-sr-only" for="chat-input">
                        Tulis pertanyaan
                    </label>

                    <input
                        id="chat-input"
                        name="message"
                        type="text"
                        placeholder="Ketik pertanyaanmu di sini..."
                        maxlength="500"
                        required
                    >

                    <button type="submit" aria-label="Kirim pesan">
                        <span>Kirim</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 20.2 22 12 3 3.8 3.2 10l12.1 2-12.1 2z"/>
                        </svg>
                    </button>
                </form>
            </section>

            <aside class="faq-sidebar">

                <section class="faq-card">
                    <p class="faq-card-heading">
                        PERTANYAAN YANG SERING DITANYAKAN
                    </p>

                    <p class="faq-card-description">
                        Tekan salah satu untuk melihat jawabannya.
                    </p>

                    <div class="faq-list">
                        <button type="button" class="faq-button"
                            data-question="Bagaimana cara mendaftar jadi murid?">
                            Bagaimana cara mendaftar jadi murid?
                        </button>

                        <button type="button" class="faq-button"
                            data-question="Bagaimana cara booking acara?">
                            Bagaimana cara booking acara?
                        </button>

                        <button type="button" class="faq-button"
                            data-question="Kapan jadwal latihan?">
                            Kapan jadwal latihan?
                        </button>

                        <button type="button" class="faq-button"
                            data-question="Berapa biayanya?">
                            Berapa biayanya?
                        </button>

                        <button type="button" class="faq-button"
                            data-question="Di mana lokasi sanggar?">
                            Di mana lokasi sanggar?
                        </button>

                        <button type="button" class="faq-button"
                            data-question="Siapa saja yang boleh ikut?">
                            Siapa saja yang boleh ikut?
                        </button>

                        <button type="button" class="faq-button"
                            data-question="Bagaimana cara menghubungi admin?">
                            Bagaimana cara menghubungi admin?
                        </button>
                    </div>
                </section>

                <section class="faq-unanswered-card">
                    <h2>Belum terjawab?</h2>

                    <p>
                        Hubungi pengelola sanggar melalui halaman Kontak
                        untuk mendapatkan informasi lebih lanjut.
                    </p>

                    <div class="faq-unanswered-actions">
                        <a class="faq-button-link faq-button-primary"
                           href="{{ route('kontak') }}">
                            Hubungi Kami
                        </a>

                        <a class="faq-button-link faq-button-outline"
                           href="{{ route('kontak') }}">
                            Kritik &amp; Saran
                        </a>
                    </div>
                </section>

            </aside>
        </section>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/tanya-jawab.js') }}" defer></script>
@endpush