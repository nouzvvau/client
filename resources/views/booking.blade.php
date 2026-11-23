@extends('layouts.main')

@section('title', __('ui.meta.booking.title'))
@section('description', __('ui.meta.booking.description'))
@section('page', 'booking')
@section('activeNav', 'booking')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/booking-acara.css') }}">
@endpush

@section('content')
@php
    $bookingExternal = \App\Support\GoogleForms::isExternal('booking');
    $bookingUrl = \App\Support\GoogleForms::url('booking');
@endphp

<section class="hero" aria-labelledby="hero-title">
    <div class="container">
        <p class="eyebrow eyebrow--red">{{ __('ui.booking.hero_eyebrow') }}</p>

        <h1 class="hero__title" id="hero-title">
            {{ __('ui.booking.hero_title_1') }}<br>
            {{ __('ui.booking.hero_title_2') }}
        </h1>

        <p class="hero__lead">
            {{ $bookingExternal ? __('ui.booking.hero_lead_external') : __('ui.booking.hero_lead_fallback') }}
        </p>
    </div>
</section>

<section class="booking-page">
    <div class="container">

        <div class="content-grid">

            {{-- FORM CARD: external Google Forms atau fallback informasi --}}
            <section class="form-card{{ $bookingExternal ? ' form-external' : '' }}" aria-labelledby="booking-form-title">

                @if ($bookingExternal)

                    <p class="eyebrow">{{ __('ui.booking.external_eyebrow') }}</p>

                    <h2 class="section-title" id="booking-form-title">
                        {{ __('ui.booking.external_title') }}
                    </h2>

                    <p class="form-external__text">
                        {{ __('ui.booking.external_text') }}
                    </p>

                    <a href="{{ $bookingUrl }}"
                       class="submit-button"
                       target="_blank"
                       rel="noopener noreferrer">
                        <span>{{ __('ui.booking.external_button') }}</span>
                    </a>

                    <p class="form-note">
                        {{ __('ui.booking.external_note') }}
                    </p>

                @else

                    <p class="eyebrow">{{ __('ui.booking.fallback_eyebrow') }}</p>

                    <h2 class="section-title" id="booking-form-title">
                        {{ __('ui.booking.fallback_title') }}
                    </h2>

                    <p class="form-external__text">
                        {{ __('ui.booking.fallback_text') }}
                    </p>

                    <a href="{{ route('kontak') }}" class="submit-button">
                        <span>{{ __('ui.booking.fallback_button') }}</span>
                    </a>

                    <p class="form-note">
                        {{ __('ui.booking.fallback_note') }}
                    </p>

                @endif

            </section>

            {{-- SIDEBAR INFORMASI --}}
            <aside class="sidebar">

                <section class="prepare-card">
                    <h2>{{ __('ui.booking.prepare_title') }}</h2>
                    <ul>
                        <li><span>✓</span> {{ __('ui.booking.prepare_1') }}</li>
                        <li><span>✓</span> {{ __('ui.booking.prepare_2') }}</li>
                        <li><span>✓</span> {{ __('ui.booking.prepare_3') }}</li>
                    </ul>
                </section>

                <section class="steps-card">
                    <h2>{{ __('ui.booking.steps_title') }}</h2>
                    <ol>
                        <li>
                            <span class="step-number">1</span>
                            <div>
                                <strong>
                                    {{ $bookingExternal ? __('ui.booking.step1_external') : __('ui.booking.step1_fallback') }}
                                </strong>
                                <p>
                                    {{ $bookingExternal ? __('ui.booking.step1_desc_external') : __('ui.booking.step1_desc_fallback') }}
                                </p>
                            </div>
                        </li>
                        <li>
                            <span class="step-number">2</span>
                            <div>
                                <strong>
                                    {{ $bookingExternal ? __('ui.booking.step2_external') : __('ui.booking.step2_fallback') }}
                                </strong>
                                <p>{{ __('ui.booking.step2_desc') }}</p>
                            </div>
                        </li>
                        <li>
                            <span class="step-number">3</span>
                            <div>
                                <strong>{{ __('ui.booking.step3_title') }}</strong>
                                <p>{{ __('ui.booking.step3_desc') }}</p>
                            </div>
                        </li>
                    </ol>
                </section>

                <section class="help-card">
                    <strong>{{ __('ui.booking.help_title') }}</strong>
                    <p>
                        {{ __('ui.booking.help_text_before') }}
                        <a href="{{ route('kontak') }}">{{ __('ui.booking.help_link') }}</a>{{ __('ui.booking.help_text_after') }}
                    </p>
                </section>

                <x-form-link form="registration" class="join-link">
                    {{ __('ui.booking.register_link') }}
                </x-form-link>

            </aside>

        </div>

    </div>
</section>
@endsection
