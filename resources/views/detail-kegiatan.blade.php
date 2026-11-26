
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

        // Pisahkan deskripsi menjadi beberapa paragraf.
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

        // Foto sisanya menjadi foto sisipan.
        $inlinePhotos = $documentationPhotos->slice(1)->values();

        // Susun paragraf dan foto secara berurutan.
        $articleBlocks = [];

        $photoIndex = 0;
        $paragraphCount = count($paragraphs);
        $inlinePhotoCount = $inlinePhotos->count();

        if ($paragraphCount > 0) {
            foreach ($paragraphs as $index => $paragraph) {
                $articleBlocks[] = [
                    'type' => 'paragraph',
                    'content' => trim($paragraph),
                ];

                // Sebarkan foto secara merata di antara paragraf.
                $targetPhotoCount = (int) ceil(
                    (($index + 1) / $paragraphCount) * $inlinePhotoCount
                );

                while ($photoIndex < $targetPhotoCount) {
                    $articleBlocks[] = [
                        'type' => 'photo',
                        'content' => $inlinePhotos[$photoIndex],
                    ];

                    $photoIndex++;
                }
            }
        } else {
            foreach ($inlinePhotos as $photo) {
                $articleBlocks[] = [
                    'type' => 'photo',
                    'content' => $photo,
                ];
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

                        {{-- FOTO UTAMA: POSISI KANAN --}}
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
