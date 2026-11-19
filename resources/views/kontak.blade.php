@extends('layouts.main')

@section('title', 'Kontak | Sanggar Seni Cakra Aji')
@section('description', 'Hubungi Sanggar Seni Cakra Aji: contact person, alamat sanggar, jadwal latihan, dan cara mendaftar atau booking acara.')
@section('page', 'kontak')
@section('activeNav', 'kontak')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kontak.css') }}">
@endpush


@section('content')
<div class="contact-page">
    <div class="contact-container">

        {{-- HERO --}}
        <section class="contact-hero">
            <p class="contact-eyebrow">Kontak</p>

            <h1 class="contact-hero-title">
                Mari bicara,<br>
                mari bermain bunyi.
            </h1>

            <p class="contact-hero-lead">
                Ada pertanyaan tentang pendaftaran, jadwal latihan, atau ingin
                mengundang Sanggar Cakra Aji ke acaramu? Hubungi kami melalui
                kanal yang tersedia di halaman ini.
            </p>
        </section>

        {{-- CONTACT PERSON --}}
        <section class="contact-persons" aria-labelledby="contact-persons-title">
            <h2 class="contact-section-title" id="contact-persons-title">
                Contact person
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

                    <article class="contact-person-card">
                        <div class="contact-person-avatar contact-avatar--{{ ['olive', 'gold', 'cream', 'red'][$loop->iteration % 4] }}">
                            @if ($person->photo)
                                <img src="{{ Storage::url($person->photo) }}" alt="{{ $person->name }}">
                            @else
                                <span aria-hidden="true">{{ $inisial }}</span>
                            @endif
                        </div>

                        <div class="contact-person-info">
                            <h3 class="contact-person-name">{{ $person->name }}</h3>
                            <span class="contact-person-role">{{ $person->position }}</span>

                            @if ($person->description)
                                <p class="contact-person-desc">{{ $person->description }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <article class="contact-person-card">
                        <div class="contact-person-avatar contact-avatar--olive">
                            <span aria-hidden="true">CA</span>
                        </div>

                        <div class="contact-person-info">
                            <h3 class="contact-person-name">Pengurus Sanggar</h3>
                            <span class="contact-person-role">Admin</span>
                            <p class="contact-person-desc">
                                Informasi contact person akan ditambahkan setelah
                                data tersedia. Sementara ini silakan datang langsung
                                ke sanggar pada jadwal latihan.
                            </p>
                        </div>
                    </article>
                @endforelse
            </div>
        </section>
    </div>

    {{-- SECTION GOLD --}}
    <section class="contact-actions" aria-labelledby="contact-actions-title">
        <div class="contact-container">
            <h2 class="sr-only" id="contact-actions-title">Informasi kontak dan arahan layanan</h2>

            <div class="contact-actions-grid">

                <div class="contact-actions-intro">
                    <h3 class="contact-actions-heading">Mau melakukan apa?</h3>
                    <p class="contact-actions-text">
                        Pilih kebutuhanmu di bawah ini. Setiap layanan punya
                        halaman tersendiri dengan formulir dan informasi lengkap.
                    </p>

                    <x-form-link form="registration" class="contact-action-card">
                        <span class="contact-action-label">Untuk calon murid</span>
                        <span class="contact-action-title">Daftar jadi murid baru</span>
                        <span class="contact-action-desc">
                            Isi formulir pendaftaran murid Sanggar Cakra Aji.
                            Admin akan menghubungi kamu untuk langkah berikutnya.
                        </span>
                        <span class="contact-action-link">Buka halaman pendaftaran</span>
                    </x-form-link>

                    <x-form-link form="booking" class="contact-action-card">
                        <span class="contact-action-label">Untuk penyelenggara acara</span>
                        <span class="contact-action-title">Booking acara</span>
                        <span class="contact-action-desc">
                            Ingin mengundang Sanggar Cakra Aji tampil atau
                            mengisi acara? Kirim permintaan booking melalui
                            formulir yang tersedia.
                        </span>
                        <span class="contact-action-link">Buka halaman booking</span>
                    </x-form-link>
                </div>

                <div class="contact-meet">
                    <h3 class="contact-actions-heading">Temui kami</h3>

                    <article class="contact-info-card">
                        <dl class="contact-info-list">
                            @forelse ($locations as $location)
                                <div class="contact-info-item">
                                    <dt>{{ $loop->first ? 'Alamat' : 'Alamat lain' }}</dt>
                                    <dd>
                                        {{ $location->name }} —
                                        {{ $location->address ?? 'Alamat lengkap belum tersedia.' }}
                                    </dd>
                                </div>

                                @php
                                    $jamLatihan = $location->schedules
                                        ->map(fn ($schedule) => trim(($schedule->day_of_week ?? '')
                                            . (isset($schedule->start_time)
                                                ? ', '.substr($schedule->start_time, 0, 5).'–'.substr($schedule->end_time, 0, 5)
                                                : '')))
                                        ->filter()
                                        ->unique()
                                        ->values();
                                @endphp

                                <div class="contact-info-item">
                                    <dt>Jam latihan</dt>
                                    <dd>
                                        @if ($jamLatihan->isNotEmpty())
                                            {{ $jamLatihan->implode('; ') }} (sesuai jadwal kelompok)
                                        @else
                                            Belum tersedia. Ikuti jadwal terbaru di
                                            halaman Program &amp; Kegiatan.
                                        @endif
                                    </dd>
                                </div>
                            @empty
                                <div class="contact-info-item">
                                    <dt>Alamat</dt>
                                    <dd>Alamat sanggar belum tersedia.</dd>
                                </div>
                            @endforelse

                            <div class="contact-info-item">
                                <dt>Email &amp; media sosial</dt>
                                <dd>
                                    Belum tersedia. Kanal resmi akan ditambahkan
                                    setelah data pengelola lengkap.
                                </dd>
                            </div>
                        </dl>

                        @forelse ($locations as $location)
                            <div class="contact-map">
                                @if ($location->address || $location->google_maps_url)
                                    @php
                                        $mapsQuery = rawurlencode($location->address ?? $location->name);
                                        $mapsLink = $location->google_maps_url
                                            ?: 'https://www.google.com/maps/search/?api=1&query='.$mapsQuery;
                                    @endphp
                                    <iframe
                                        src="https://www.google.com/maps?q={{ $mapsQuery }}&amp;output=embed"
                                        title="Peta {{ $location->name }}"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        allowfullscreen></iframe>
                                @else
                                    <div class="contact-map contact-map--pending" role="img"
                                         aria-label="Peta {{ $location->name }} belum tersedia">
                                        <strong>Peta menyusul</strong>
                                        <span>Alamat lengkap dan koordinat belum tersedia.</span>
                                    </div>
                                @endif
                            </div>

                            <div class="contact-map-actions">
                                @if ($location->address || $location->google_maps_url)
                                    <a class="contact-btn contact-btn--brown"
                                       href="{{ $mapsLink }}"
                                       target="_blank"
                                       rel="noopener">Buka di Google Maps</a>
                                @endif
                            </div>
                        @empty
                            <div class="contact-map contact-map--pending" role="img"
                                 aria-label="Peta sanggar belum tersedia">
                                <strong>Peta menyusul</strong>
                                <span>Alamat lengkap dan koordinat belum tersedia.</span>
                            </div>
                        @endforelse
                    </article>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
