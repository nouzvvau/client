@extends('layouts.main')

@section('title', __('ui.meta.galeri.title'))
@section('description', __('ui.meta.galeri.description'))
@section('page', 'galeri')
@section('activeNav', 'galeri')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/schedule.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/galeri.css') }}">
@endpush

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <div class="container">
            <p class="eyebrow eyebrow--red">{{ __('ui.galeri.hero_eyebrow') }}</p>
            <h1 class="hero__title" id="hero-title">
                {{ __('ui.galeri.hero_title_1') }}<br>
                {{ __('ui.galeri.hero_title_2') }}
            </h1>
        </div>
    </section>

    <section class="gallery" aria-labelledby="gallery-title">
        <div class="container">
            <div class="gallery__head">
                <div class="gallery__intro">
                    <p class="eyebrow eyebrow--red">{{ __('ui.galeri.documentation_eyebrow') }}</p>
                    <h2 class="gallery__title" id="gallery-title">{{ __('ui.galeri.gallery_title') }}</h2>
                    <p class="gallery__lead">{{ __('ui.galeri.gallery_lead') }}</p>
                </div>
            </div>

            <div class="gallery-grid">
                @forelse ($photos->chunk(3) as $row)
                    <div class="gallery-row gallery-row--split">
                        @foreach ($row as $photo)
                            <figure class="gallery-card">
                                <div class="gallery-card__media">
                                    <img
                                        src="{{ $photo->url }}"
                                        alt="{{ $photo->caption ?: 'Dokumentasi Sanggar Seni Cakra Aji' }}"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                </div>
                                <figcaption class="gallery-card__body">
                                    <span class="gallery-card__title">
                                        {{ $photo->caption ?: 'Dokumentasi Sanggar Seni Cakra Aji' }}
                                    </span>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                @empty
                    <div class="admin-empty">
                        <span class="admin-empty__title">Belum ada foto galeri</span>
                        Foto kegiatan Sanggar Seni Cakra Aji akan ditampilkan di sini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="schedule" id="jadwal" aria-labelledby="schedule-title">
        <div class="container">
            <p class="eyebrow eyebrow--amber">{{ __('ui.galeri.schedule_eyebrow') }}</p>
            <h2 class="schedule__title" id="schedule-title">{{ __('ui.galeri.schedule_title') }}</h2>

            <div class="table-wrap">
                <table class="schedule-table">
                    <colgroup>
                        <col class="col-kelompok">
                        <col class="col-hari">
                        <col class="col-jam">
                        <col class="col-tempat">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">{{ __('ui.galeri.table_group') }}</th>
                            <th scope="col">{{ __('ui.galeri.table_day') }}</th>
                            <th scope="col">{{ __('ui.galeri.table_time') }}</th>
                            <th scope="col">{{ __('ui.galeri.table_place') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (__('ui.galeri.schedule_rows') as $row)
                            <tr>
                                <td data-label="{{ __('ui.galeri.table_group') }}">{{ $row['group'] }}</td>
                                <td data-label="{{ __('ui.galeri.table_day') }}">{{ $row['day'] }}</td>
                                <td data-label="{{ __('ui.galeri.table_time') }}">{{ $row['time'] }}</td>
                                <td data-label="{{ __('ui.galeri.table_place') }}">{{ $row['place'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection