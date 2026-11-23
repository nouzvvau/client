@extends('layouts.main')

@section('title', __('ui.meta.feedback.title'))
@section('description', __('ui.meta.feedback.description'))
@section('page', 'feedback')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kritik-saran.css') }}">
@endpush

@section('content')
<div class="feedback-page">
    <div class="container">

        <header class="feedback-heading">
            <p class="feedback-eyebrow">{{ __('ui.feedback.eyebrow') }}</p>
            <h1>{{ __('ui.feedback.title') }}</h1>
            <p class="feedback-lead">{{ __('ui.feedback.lead') }}</p>
        </header>

        <div class="feedback-grid">

            {{-- FORM MASUKAN --}}
            <section class="feedback-card" aria-labelledby="feedback-form-title">

                @if (session('success'))
                    <div class="feedback-alert feedback-alert--success" role="status">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="feedback-alert feedback-alert--error" role="alert">
                        <strong>{{ __('ui.feedback.errors_title') }}</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="feedback-section-title" id="feedback-form-title">
                    {{ __('ui.feedback.form_title') }}
                </h2>

                <form action="{{ route('kritik-saran.store') }}" method="POST">
                    @csrf

                    <div class="feedback-field">
                        <label for="feedback-name">
                            {{ __('ui.feedback.field_name') }}
                            <span>{{ __('ui.feedback.field_name_hint') }}</span>
                        </label>
                        <input
                            id="feedback-name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            maxlength="255"
                            autocomplete="name"
                        >
                        @error('name')
                            <small class="feedback-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="feedback-field">
                        <label for="feedback-sender-type">{{ __('ui.feedback.field_sender_type') }}</label>
                        <select id="feedback-sender-type" name="sender_type">
                            <option value="">{{ __('ui.feedback.sender_type_placeholder') }}</option>
                            @foreach (\App\Models\Feedback::SENDER_TYPES as $senderType)
                                <option value="{{ $senderType }}" @selected(old('sender_type') === $senderType)>
                                    {{ __('ui.feedback.sender_'.$senderType) }}
                                </option>
                            @endforeach
                        </select>
                        @error('sender_type')
                            <small class="feedback-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="feedback-field">
                        <label for="feedback-message-type">
                            {{ __('ui.feedback.field_message_type') }}
                            <b>*</b>
                        </label>
                        <select id="feedback-message-type" name="message_type" required>
                            <option value="">{{ __('ui.feedback.message_type_placeholder') }}</option>
                            @foreach (\App\Models\Feedback::MESSAGE_TYPES as $messageType)
                                <option value="{{ $messageType }}" @selected(old('message_type') === $messageType)>
                                    {{ __('ui.feedback.type_'.$messageType) }}
                                </option>
                            @endforeach
                        </select>
                        @error('message_type')
                            <small class="feedback-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="feedback-field">
                        <label for="feedback-subject">
                            {{ __('ui.feedback.field_subject') }}
                            <b>*</b>
                        </label>
                        <input
                            id="feedback-subject"
                            name="subject"
                            type="text"
                            value="{{ old('subject') }}"
                            maxlength="255"
                            placeholder="{{ __('ui.feedback.field_subject_placeholder') }}"
                            required
                        >
                        @error('subject')
                            <small class="feedback-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="feedback-field">
                        <label for="feedback-message">
                            {{ __('ui.feedback.field_message') }}
                            <b>*</b>
                        </label>
                        <textarea
                            id="feedback-message"
                            name="message"
                            rows="7"
                            maxlength="2000"
                            placeholder="{{ __('ui.feedback.field_message_placeholder') }}"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <small class="feedback-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="feedback-field">
                        <label for="feedback-reply-contact">
                            {{ __('ui.feedback.field_reply_contact') }}
                            <span>{{ __('ui.feedback.field_reply_contact_hint') }}</span>
                        </label>
                        <input
                            id="feedback-reply-contact"
                            name="reply_contact"
                            type="text"
                            value="{{ old('reply_contact') }}"
                            maxlength="255"
                        >
                        @error('reply_contact')
                            <small class="feedback-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="feedback-submit">
                        <button type="submit" class="submit-btn">
                            {{ __('ui.feedback.submit_button') }}
                        </button>
                    </div>
                </form>

            </section>

            {{-- SIDEBAR INFORMASI --}}
            <aside class="feedback-sidebar">

                <section class="feedback-side-card feedback-side-card--dark">
                    <h2>{{ __('ui.feedback.side_about_title') }}</h2>
                    <p>{{ __('ui.feedback.side_about_text') }}</p>
                </section>

                <section class="feedback-side-card">
                    <h2>{{ __('ui.feedback.side_privacy_title') }}</h2>
                    <p>{{ __('ui.feedback.side_privacy_text') }}</p>
                </section>

                <section class="feedback-side-card feedback-side-card--light">
                    <h2>{{ __('ui.feedback.side_links_title') }}</h2>
                    <p>{{ __('ui.feedback.side_links_text') }}</p>
                    <p class="feedback-side-links">
                        <a href="{{ route('faq') }}">{{ __('ui.feedback.faq_link') }}</a>
                        <a href="{{ route('kontak') }}">{{ __('ui.feedback.contact_link') }}</a>
                    </p>
                </section>

            </aside>

        </div>

    </div>
</div>
@endsection
