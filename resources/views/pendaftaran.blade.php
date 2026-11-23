@extends('layouts.main')

@section('title', __('ui.meta.pendaftaran.title'))
@section('description', __('ui.meta.pendaftaran.description'))
@section('page', 'pendaftaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pendaftaran.css') }}">
@endpush

@section('content')
@php
    $registrationExternal = \App\Support\GoogleForms::isExternal('registration');
    $registrationUrl = \App\Support\GoogleForms::url('registration');
@endphp

<!-- MAIN -->

<div class="main">

    <!-- HEADING -->

    <section class="heading">

        <div class="heading-label">
            {{ __('ui.pendaftaran.heading_label') }}
        </div>

        <span class="version">
            {{ $registrationExternal ? __('ui.pendaftaran.version_external') : __('ui.pendaftaran.version_fallback') }}
        </span>

        <h1>
            {{ __('ui.pendaftaran.title_1') }}<br>
            {{ __('ui.pendaftaran.title_2') }}
        </h1>

        <p>
            {{ $registrationExternal ? __('ui.pendaftaran.intro_external') : __('ui.pendaftaran.intro_fallback') }}
        </p>

    </section>

    <!-- CONTENT -->

    <div class="content">

        <!-- FORM CARD -->

        <section class="form-card{{ $registrationExternal ? ' form-external' : '' }}">

            @if ($registrationExternal)

                <p class="heading-label">{{ __('ui.pendaftaran.external_label') }}</p>

                <h2 class="section-title">{{ __('ui.pendaftaran.external_title') }}</h2>

                <p class="form-external__text">
                    {{ __('ui.pendaftaran.external_text') }}
                </p>

                <a href="{{ $registrationUrl }}"
                   class="submit-btn"
                   target="_blank"
                   rel="noopener noreferrer">
                    ↗
                    {{ __('ui.pendaftaran.external_button') }}
                </a>

                <p class="form-note">
                    {{ __('ui.pendaftaran.external_note') }}
                </p>

            @else

                <p class="heading-label">{{ __('ui.pendaftaran.fallback_label') }}</p>

                <h2 class="section-title">{{ __('ui.pendaftaran.fallback_title') }}</h2>

                <p class="form-external__text">
                    {{ __('ui.pendaftaran.fallback_text') }}
                </p>

                <a href="{{ route('kontak') }}" class="submit-btn">
                    {{ __('ui.pendaftaran.fallback_button') }}
                </a>

                <p class="form-note">
                    {{ __('ui.pendaftaran.fallback_note') }}
                </p>

            @endif

        </section>

        <!-- SIDEBAR -->

        <aside class="sidebar">

            <!-- PERSIAPAN -->

            <div class="side-card dark">

                <h3 class="side-title">
                    {{ __('ui.pendaftaran.prepare_title') }}
                </h3>

                <ul class="side-list">

                    <li>
                        <span class="check">✓</span>
                        <div>{{ __('ui.pendaftaran.prepare_1') }}</div>
                    </li>

                    <li>
                        <span class="check">✓</span>
                        <div>{{ __('ui.pendaftaran.prepare_2') }}</div>
                    </li>

                    <li>
                        <span class="check">✓</span>
                        <div>{{ __('ui.pendaftaran.prepare_3') }}</div>
                    </li>

                </ul>

            </div>

            <!-- CARA PENDAFTARAN -->

            <div class="side-card">

                <h3 class="side-title">
                    {{ __('ui.pendaftaran.steps_title') }}
                </h3>

                <ul class="side-list">

                    <li>

                        <span class="step">1</span>

                        <div>

                            <strong>
                                {{ $registrationExternal ? __('ui.pendaftaran.step1_external') : __('ui.pendaftaran.step1_fallback') }}
                            </strong>

                            <span class="description">
                                {{ $registrationExternal ? __('ui.pendaftaran.step1_desc_external') : __('ui.pendaftaran.step1_desc_fallback') }}
                            </span>

                        </div>

                    </li>

                    <li>

                        <span class="step">2</span>

                        <div>

                            <strong>
                                {{ $registrationExternal ? __('ui.pendaftaran.step2_external') : __('ui.pendaftaran.step2_fallback') }}
                            </strong>

                            <span class="description">
                                {{ __('ui.pendaftaran.step2_desc') }}
                            </span>

                        </div>

                    </li>

                    <li>

                        <span class="step">3</span>

                        <div>

                            <strong>{{ __('ui.pendaftaran.step3_title') }}</strong>

                            <span class="description">
                                {{ __('ui.pendaftaran.step3_desc') }}
                            </span>

                        </div>

                    </li>

                </ul>

            </div>

            <!-- BANTUAN -->

            <div class="side-card light">

                <h3 class="side-title">
                    {{ __('ui.pendaftaran.help_title') }}
                </h3>

                <p>
                    {{ __('ui.pendaftaran.help_text_before') }}

                    <a href="{{ route('kontak') }}" class="contact-link">
                        {{ __('ui.pendaftaran.help_link') }}
                    </a>{{ __('ui.pendaftaran.help_text_after') }}
                </p>

            </div>

            <!-- BOOKING -->

            <div class="side-card">

                <p>
                    {{ __('ui.pendaftaran.booking_text') }}

                    <br><br>

                    <x-form-link form="booking" class="contact-link">
                        {{ __('ui.pendaftaran.booking_link') }}
                    </x-form-link>

                </p>

            </div>

        </aside>

    </div>

</div>
@endsection
