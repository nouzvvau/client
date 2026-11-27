
@extends('layouts.main')

@section('title', __('ui.meta.kontak.title'))
@section('description', __('ui.meta.kontak.description'))
@section('page', 'kontak')
@section('activeNav', 'kontak')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kontak.css') }}">
@endpush

@section('content')
<div class="contact-page">

    {{-- HERO DAN CONTACT PERSON --}}
    <div class="contact-container">

        <section class="contact-hero">
            <p class="contact-eyebrow">
                {{ __('ui.kontak.hero_eyebrow') }}
            </p>

            <h1 class="contact-hero-title">
                {{ __('ui.kontak.hero_title_1') }}<br>
                {{ __('ui.kontak.hero_title_2') }}
            </h1>

            <p class="contact-hero-lead">
                {{ __('ui.kontak.hero_lead') }}
            </p>
        </section>

        {{-- CONTACT PERSON --}}
        <section class="contact-persons" aria-labelledby="contact-persons-title">
            <h2 class="contact-section-title" id="contact-persons-title">
                {{ __('ui.kontak.contact_person_title') }}
            </h2>

            <div class="contact-person-grid">
                @forelse ($contactPersons as $person)
                    @php
                        $inisial = strtoupper(
                            collect(explode(' ', trim($person->name ?? '')))
                                ->filter()
                                ->take(2)
                                ->map(fn ($kata) => mb_substr($kata, 0, 1))
                                ->implode('')
                        );
                    @endphp

                    @if ($whatsappLink)
                        <a
                            href="{{ $whatsappLink }}"
                            class="contact-person-card"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Hubungi {{ $person->name }} melalui WhatsApp"
                        >
                    @else
                        <article class="contact-person-card">
                    @endif

                        <div class="contact-person-avatar contact-avatar--{{ ['olive', 'gold', 'cream', 'red'][$loop->iteration % 4] }}">
                            @if ($person->photo)
                                <img
                                    src="{{ Storage::url($person->photo) }}"
                                    alt="{{ $person->name }}"
                                >
                            @else
                                <span aria-hidden="true">{{ $inisial }}</span>
                            @endif
                        </div>

                        <div class="contact-person-info">
                            <h3 class="contact-person-name">
                                {{ $person->name }}
                            </h3>

                            <span class="contact-person-role">
                                {{ $person->position }}
                            </span>

                            @if ($person->description)
                                <p class="contact-person-desc">
                                    {{ $person->description }}
                                </p>
                            @endif
                        </div>

                    @if ($whatsappLink)
                        </a>
                    @else
                        </article>
                    @endif

                @empty
                    <article class="contact-person-card">
                        <div class="contact-person-avatar contact-avatar--olive">
                            <span aria-hidden="true">CA</span>
                        </div>

                        <div class="contact-person-info">
                            <h3 class="contact-person-name">
                                {{ __('ui.kontak.fallback_name') }}
                            </h3>

                            <span class="contact-person-role">
                                {{ __('ui.kontak.fallback_role') }}
                            </span>

                            <p class="contact-person-desc">
                                {{ __('ui.kontak.fallback_desc') }}
                            </p>
                        </div>
                    </article>
                @endforelse

                @if ($whatsappLink)
                    <div class="contact-whatsapp-cta">
                        <a
                            href="{{ $whatsappLink }}"
                            class="contact-btn contact-btn--brown"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            {{ $whatsappCtaLabel }}
                        </a>
                    </div>
                @endif
            </div>
        </section>

    </div>

    {{-- SECTION GOLD --}}
    <section class="contact-actions" aria-labelledby="contact-actions-title">
        <div class="contact-container">

            <h2 class="sr-only" id="contact-actions-title">
                {{ __('ui.kontak.actions_sr_title') }}
            </h2>

            <div class="contact-actions-grid">

                {{-- REGISTRATION AND BOOKING --}}
                <div class="contact-actions-intro">

                    <h3 class="contact-actions-heading">
                        {{ __('ui.kontak.actions_heading') }}
                    </h3>

                    <p class="contact-actions-text">
                        {{ __('ui.kontak.actions_text') }}
                    </p>

                    {{-- REGISTRATION --}}
                    <x-form-link form="registration" class="contact-action-card">
                        <span class="contact-action-label">
                            {{ __('ui.kontak.registration_label') }}
                        </span>

                        <span class="contact-action-title">
                            {{ __('ui.kontak.registration_title') }}
                        </span>

                        <span class="contact-action-desc">
                            {{ __('ui.kontak.registration_desc') }}
                        </span>

                        <span class="contact-action-link">
                            {{ __('ui.kontak.registration_link') }}
                        </span>
                    </x-form-link>

                    {{-- BOOKING --}}
                    <x-form-link form="booking" class="contact-action-card">
                        <span class="contact-action-label">
                            {{ __('ui.kontak.booking_label') }}
                        </span>

                        <span class="contact-action-title">
                            {{ __('ui.kontak.booking_title') }}
                        </span>

                        <span class="contact-action-desc">
                            {{ __('ui.kontak.booking_desc') }}
                        </span>

                        <span class="contact-action-link">
                            {{ __('ui.kontak.booking_link') }}
                        </span>
                    </x-form-link>

                </div>

                {{-- LOCATION INFORMATION --}}
                <div class="contact-meet">

                    <h3 class="contact-actions-heading">
                        {{ __('ui.kontak.meet_heading') }}
                    </h3>

                    <article class="contact-info-card">

                        <dl class="contact-info-list">

                            {{-- BEJI ADDRESS --}}
                            <div class="contact-info-item">
                                <dt>
                                    {{ __('ui.kontak.address_first') }}
                                </dt>

                                <dd>
                                    {{ __('ui.lokasi.beji_name') }} —
                                    {{ __('ui.lokasi.beji_address') }}
                                </dd>
                            </div>

                            {{-- BEJI SCHEDULE --}}
                            <div class="contact-info-item">
                                <dt>
                                    {{ __('ui.kontak.practice_hours') }}
                                </dt>

                                <dd>
                                    {{ __('ui.lokasi.beji_schedule') }}
                                </dd>
                            </div>

                            {{-- PLOSOKANDANG ADDRESS --}}
                            <div class="contact-info-item">
                                <dt>
                                    {{ __('ui.kontak.address_other') }}
                                </dt>

                                <dd>
                                    {{ __('ui.lokasi.plosokandang_name') }} —
                                    {{ __('ui.lokasi.plosokandang_address') }}
                                </dd>
                            </div>

                            {{-- PLOSOKANDANG SCHEDULE --}}
                            <div class="contact-info-item">
                                <dt>
                                    {{ __('ui.kontak.practice_hours') }}
                                </dt>

                                <dd>
                                    {{ __('ui.lokasi.plosokandang_schedule') }}
                                </dd>
                            </div>

                            {{-- EMAIL AND SOCIAL MEDIA --}}
                            <div class="contact-info-item">
                                <dt>
                                    {{ __('ui.common.email_social') }}
                                </dt>

                                <dd>
                                    {{ __('ui.kontak.email_social_unavailable') }}
                                </dd>
                            </div>

                        </dl>

                        {{-- BEJI MAP --}}
                        <div class="contact-location-map">

                            <h4 class="contact-location-map-title">
                                {{ __('ui.lokasi.beji_name') }}
                            </h4>

                            <div class="contact-map contact-map--pending">
                                <strong>
                                    {{ __('ui.common.map_coming_soon') }}
                                </strong>

                                <span>
                                    {{ __('ui.lokasi.beji_map_desc') }}
                                </span>
                            </div>

                        </div>

                        {{-- PLOSOKANDANG MAP --}}
                        <div class="contact-location-map">

                            <h4 class="contact-location-map-title">
                                {{ __('ui.lokasi.plosokandang_name') }}
                            </h4>

                            <div class="contact-map">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.249198233089!2d111.9205559!3d-8.0760474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78e3007c0fba43%3A0x7166363c489ecc1e!2sSanggar%20Karawitan%20Cakra%20Aji%2C%20Cabang%20Plosokandang!5e0!3m2!1sid!2sid!4v1795668788907!5m2!1sid!2sid"
                                    title="{{ __('ui.lokasi.plosokandang_map_title') }}"
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    allowfullscreen>
                                </iframe>
                            </div>

                        </div>

                        {{-- GOOGLE MAPS BUTTON --}}
                        <div class="contact-map-actions">
                            <a
                                class="contact-btn contact-btn--brown"
                                href="https://maps.app.goo.gl/6WFmpALAXroBMsF1A"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ __('ui.common.open_maps') }}
                            </a>
                        </div>

                    </article>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
