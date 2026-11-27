@extends('layouts.main')

@section('title', __('ui.meta.faq.title'))
@section('description', __('ui.meta.faq.description'))
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
                <span class="faq-eyebrow">{{ __('ui.faq.eyebrow') }}</span>
                <span class="faq-system-label">{{ __('ui.faq.system_label') }}</span>
            </div>

            <h1>{{ __('ui.faq.title_1') }}<br class="faq-desktop-break"> {{ __('ui.faq.title_2') }}</h1>

            <p>
                {{ __('ui.faq.intro') }}
            </p>
        </section>

        <section class="faq-content-grid" aria-label="{{ __('ui.faq.content_aria') }}">

            <section class="faq-chat-card" aria-label="{{ __('ui.faq.chat_aria') }}">
                <div class="faq-chat-header">
                    <div class="faq-assistant-avatar">CA</div>
                    <div>
                        <h2>{{ __('ui.faq.assistant_name') }}</h2>
                        <span>{{ __('ui.faq.assistant_status') }}</span>
                    </div>
                </div>

                <div
                    class="faq-chat-messages"
                    id="chat-messages"
                    aria-live="polite"
                    aria-label="{{ __('ui.faq.chat_history_aria') }}"
                >
                    <div class="faq-message-row faq-bot-row">
                        <div class="faq-chat-bubble faq-bot-bubble">
                            {{ __('ui.faq.greeting') }}
                        </div>
                    </div>
                </div>

                <form class="faq-chat-form" id="chat-form" autocomplete="off">
                    <label class="faq-sr-only" for="chat-input">
                        {{ __('ui.faq.input_label') }}
                    </label>

                    <input
                        id="chat-input"
                        name="message"
                        type="text"
                        placeholder="{{ __('ui.faq.input_placeholder') }}"
                        maxlength="500"
                        required
                    >

                    <button type="submit" aria-label="{{ __('ui.faq.send') }}">
                        <span>{{ __('ui.faq.send') }}</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 20.2 22 12 3 3.8 3.2 10l12.1 2-12.1 2z"/>
                        </svg>
                    </button>
                </form>
            </section>

            <aside class="faq-sidebar">

                <section class="faq-card">
                    <p class="faq-card-heading">
                        {{ __('ui.faq.heading') }}
                    </p>

                    <p class="faq-card-description">
                        {{ __('ui.faq.description') }}
                    </p>

                    <div class="faq-list">
                        @foreach (__('ui.faq.questions') as $question)
                            <button type="button" class="faq-button"
                                data-question="{{ $question }}">
                                {{ $question }}
                            </button>
                        @endforeach
                    </div>
                </section>

                <section class="faq-unanswered-card">
                    <h2>{{ __('ui.faq.unanswered_title') }}</h2>

                    <p>
                        {{ __('ui.faq.unanswered_text') }}
                    </p>

                    @php
                        $contactUrl = $whatsappLink ?? route('kontak');
                        $feedbackUrl = \App\Support\GoogleForms::url('feedback');
                    @endphp

                    <div class="faq-unanswered-actions">
                        <a
                            class="faq-button-link faq-button-primary"
                            href="{{ $contactUrl }}"
                            @if ($whatsappLink) target="_blank" rel="noopener noreferrer" @endif
                        >
                            {{ __('ui.faq.contact_button') }}
                        </a>

                        @if ($feedbackUrl)
                            <a
                                class="faq-button-link faq-button-outline"
                                href="{{ $feedbackUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ __('ui.faq.feedback_button') }}
                            </a>
                        @else
                            <span class="faq-button-link faq-button-outline faq-button-link--disabled" aria-disabled="true">
                                {{ __('ui.faq.feedback_button') }}
                            </span>
                        @endif
                    </div>

                    @unless ($feedbackUrl)
                        <p class="faq-feedback-unavailable">
                            {{ __('ui.common.not_available') }}
                        </p>
                    @endunless
                </section>

            </aside>
        </section>
    </div>
</div>
@endsection

@push('scripts')
    <script type="application/json" id="faq-chat-data">
        {!! json_encode([
            'fallback' => __('ui.faq.chat.fallback'),
            'answers' => __('ui.faq.chat.answers'),
        ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>
    <script src="{{ asset('assets/js/tanya-jawab.js') }}" defer></script>
@endpush
