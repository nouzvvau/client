
@extends('layouts.main')

@section('title', __('ui.meta.program_detail.title', ['name' => $program->localized_name]))
@section('description', \Illuminate\Support\Str::limit(strip_tags($program->localized_description ?? ''), 150))
@section('page', 'program')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/detail-kegiatan.css') }}">
@endpush

@section('content')
<div class="program-detail-page">

    {{-- HEADER KEGIATAN --}}
    <section class="hero hero--detail">
        <div class="container">
            <p class="eyebrow">{{ __('ui.detail.eyebrow') }}</p>

            <h1>{{ $program->localized_name }}</h1>

            @if (filled($program->year))
                <p class="hero__meta">
                    {{ __('ui.detail.year_label') }}: {{ $program->year }}
                </p>
            @endif

            @if (filled($program->localized_schedule))
                <p class="hero__meta">
                    {{ __('ui.detail.schedule_label') }}: {{ $program->localized_schedule }}
                </p>
            @endif
        </div>
    </section>

    {{-- PERSIAPAN DATA ARTIKEL --}}
    @php
        $description = trim((string) ($program->localized_description ?? ''));

        // Estimasi waktu baca.
        $wordCount = str_word_count(strip_tags($description));

        $readingMinutes = $wordCount > 0
            ? max(1, (int) ceil($wordCount / 200))
            : 0;

        // Pisahkan deskripsi menjadi paragraf.
        $paragraphs = $description !== ''
            ? preg_split('/\R+/u', $description, -1, PREG_SPLIT_NO_EMPTY)
            : [];

        // Ambil seluruh foto dokumentasi.
        $documentationPhotos = $program->documentations
            ->flatMap(function ($documentation) {
                return $documentation->photos;
            })
            ->values();

        // Foto pertama menjadi foto utama.
        $featuredPhoto = $documentationPhotos->first();

        // Foto sisanya menjadi kandidat foto artikel.
        $inlinePhotos = $documentationPhotos->slice(1)->values();

        /*
         * Maksimal satu foto sisipan untuk setiap paragraf.
         * Foto yang tidak mendapatkan tempat akan masuk galeri bawah.
         */
        $paragraphCount = count($paragraphs);

        $articlePhotoCount = min(
            $inlinePhotos->count(),
            $paragraphCount
        );

        $articlePhotos = $inlinePhotos->take($articlePhotoCount)->values();

        $remainingPhotos = $inlinePhotos
            ->slice($articlePhotoCount)
            ->values();

        // Susun paragraf dan foto secara bergantian.
        $articleBlocks = [];

        $photoIndex = 0;

        foreach ($paragraphs as $index => $paragraph) {
            $articleBlocks[] = [
                'type' => 'paragraph',
                'content' => trim($paragraph),
            ];

            // Sisipkan foto jika masih tersedia.
            if ($photoIndex < $articlePhotoCount) {
                $articleBlocks[] = [
                    'type' => 'photo',
                    'content' => $articlePhotos[$photoIndex],
                ];

                $photoIndex++;
            }
        }
    @endphp

    {{-- ARTIKEL KEGIATAN --}}
    @if ($featuredPhoto || count($articleBlocks) > 0)
        <section class="activity-article">
            <div class="container">

                <article class="activity-article__inner">

                    {{-- JUDUL ARTIKEL --}}
                    <header class="activity-article__heading">
                        <p class="eyebrow">
                            {{ __('ui.detail.story_eyebrow') }}
                        </p>

                        <h2>{{ __('ui.detail.story_title') }}</h2>

                        @if (filled($program->year) || filled($program->localized_schedule) || $readingMinutes > 0)
                            <div class="activity-article__meta">

                                @if (filled($program->year))
                                    <span>{{ $program->year }}</span>
                                @endif

                                @if (filled($program->year) && filled($program->localized_schedule))
                                    <span class="activity-article__meta-dot">&bull;</span>
                                @endif

                                @if (filled($program->localized_schedule))
                                    <span>{{ $program->localized_schedule }}</span>
                                @endif

                                @if ((filled($program->year) || filled($program->localized_schedule)) && $readingMinutes > 0)
                                    <span class="activity-article__meta-dot">&bull;</span>
                                @endif

                                @if ($readingMinutes > 0)
                                    <span>{{ $readingMinutes }} min read</span>
                                @endif

                            </div>
                        @endif
                    </header>

                    {{-- KONTEN EDITORIAL --}}
                    <div class="activity-article__content">

                        {{-- FOTO UTAMA --}}
                        @if ($featuredPhoto)
                            <figure class="activity-article__figure activity-article__figure--featured">

                                <div class="activity-article__media">
                                    <img
                                        src="{{ $featuredPhoto->thumbnail_url ?: $featuredPhoto->url }}"
                                        alt="{{ $featuredPhoto->caption ?: $program->localized_name }}"
                                        loading="eager"
                                        decoding="async"
                                    >
                                </div>

                                @if (filled($featuredPhoto->caption))
                                    <figcaption class="activity-article__caption">
                                        {{ $featuredPhoto->caption }}
                                    </figcaption>
                                @endif

                            </figure>
                        @endif

                        {{-- PARAGRAF DAN FOTO SISIPAN --}}
                        @php
                            $inlinePhotoPosition = 0;
                        @endphp

                        @foreach ($articleBlocks as $block)

                            @if ($block['type'] === 'paragraph')

                                <p class="activity-article__paragraph">
                                    {{ $block['content'] }}
                                </p>

                            @else

                                @php
                                    $photo = $block['content'];

                                    $photoSide = $inlinePhotoPosition % 2 === 0
                                        ? 'left'
                                        : 'right';

                                    $inlinePhotoPosition++;
                                @endphp

                                <figure class="activity-article__figure activity-article__figure--{{ $photoSide }}">

                                    <div class="activity-article__media">
                                        <img
                                            src="{{ $photo->url }}"
                                            alt="{{ $photo->caption ?: $program->localized_name }}"
                                            loading="lazy"
                                            decoding="async"
                                        >
                                    </div>

                                    @if (filled($photo->caption))
                                        <figcaption class="activity-article__caption">
                                            {{ $photo->caption }}
                                        </figcaption>
                                    @endif

                                </figure>

                            @endif

                        @endforeach

                    </div>

                </article>

                {{-- GALERI FOTO TAMBAHAN --}}
                @if ($remainingPhotos->isNotEmpty())
                    <section class="activity-gallery">

                        <header class="activity-gallery__heading">
                            <p class="eyebrow">
                                {{ __('ui.detail.story_eyebrow') }}
                            </p>

                            <h2>Dokumentasi Kegiatan</h2>

                            <p>
                                Beberapa momen lainnya dari kegiatan ini.
                            </p>
                        </header>

                        <div class="activity-gallery__grid">

                            @foreach ($remainingPhotos as $photo)
                                <figure class="activity-gallery__item">

                                    <div class="activity-gallery__media">
                                        <img
                                            src="{{ $photo->thumbnail_url ?: $photo->url }}"
                                            alt="{{ $photo->caption ?: $program->localized_name }}"
                                            loading="lazy"
                                            decoding="async"
                                        >
                                    </div>

                                    @if (filled($photo->caption))
                                        <figcaption class="activity-gallery__caption">
                                            {{ $photo->caption }}
                                        </figcaption>
                                    @endif

                                </figure>
                            @endforeach

                        </div>

                    </section>
                @endif

            </div>
        </section>
    @endif

    {{-- KEGIATAN LAINNYA --}}
    @if ($others->isNotEmpty())
        <section class="more">
            <div class="container">

                <p class="eyebrow">
                    {{ __('ui.detail.others_eyebrow') }}
                </p>

                <h2>{{ __('ui.detail.others_title') }}</h2>

                <div class="chips">
                    @foreach ($others as $other)
                        <a
                            class="chip"
                            href="{{ route('program.detail', ['slug' => $other->slug]) }}"
                        >
                            {{ $other->localized_name }}
                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="cta">
        <div class="container">

            <h2>{{ __('ui.detail.cta_title') }}</h2>

            <x-form-link form="booking" class="btn">
                {{ __('ui.detail.cta_button') }}
            </x-form-link>

        </div>
    </section>

</div>
@endsection