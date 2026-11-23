@extends('layouts.admin')

@section('title', 'Galeri Acara')
@section('admin_eyebrow', 'Galeri Acara')
@section('admin_title', 'Galeri Acara')

@section('content')
    <div class="admin-page-head">
        <div>
            <h2 class="admin-page-head__title">Dokumentasi acara</h2>
            <p class="admin-page-head__desc">
                Unggah dan kelola dokumentasi kegiatan sanggar. Dokumentasi yang
                ditambahkan di sini tampil pada halaman galeri acara di website.
            </p>
        </div>

        <div class="admin-page-head__actions">
            <a href="{{ route('galeri') }}" target="_blank" rel="noopener noreferrer" class="admin-btn">
                <x-admin.icon name="external" />
                Lihat galeri publik
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="admin-btn admin-btn--primary">
                <x-admin.icon name="plus" />
                Tambah dokumentasi
            </a>
        </div>
    </div>

    <div class="admin-stat-grid">
        <div class="admin-stat">
            <span class="admin-stat__label">Total Dokumentasi</span>
            <strong class="admin-stat__value">{{ $stats['total'] }}</strong>
            <span class="admin-stat__hint">Album dokumentasi acara</span>
        </div>
        <div class="admin-stat admin-stat--olive">
            <span class="admin-stat__label">Total Foto</span>
            <strong class="admin-stat__value">{{ $stats['photos'] }}</strong>
            <span class="admin-stat__hint">Foto tersimpan</span>
        </div>
        <div class="admin-stat admin-stat--brown">
            <span class="admin-stat__label">Tahun Ini</span>
            <strong class="admin-stat__value">{{ $stats['this_year'] }}</strong>
            <span class="admin-stat__hint">Dokumentasi tahun {{ now()->year }}</span>
        </div>
        <div class="admin-stat admin-stat--red">
            <span class="admin-stat__label">Dengan Foto</span>
            <strong class="admin-stat__value">{{ $stats['with_photos'] }}</strong>
            <span class="admin-stat__hint">Dokumentasi berisi foto</span>
        </div>
    </div>

    <section class="admin-card">
        <form method="GET" action="{{ route('admin.gallery.index') }}" class="admin-filter">
            <div class="admin-field">
                <label for="q">Cari dokumentasi</label>
                <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Judul, deskripsi, atau lokasi" class="admin-input">
            </div>

            <div class="admin-field">
                <label for="year">Tahun acara</label>
                <select id="year" name="year" class="admin-select">
                    <option value="">Semua tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="admin-filter__actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <x-admin.icon name="search" />
                    Cari
                </button>
                @if (request()->filled('q') || request()->filled('year'))
                    <a href="{{ route('admin.gallery.index') }}" class="admin-btn">Reset</a>
                @endif
            </div>
        </form>
    </section>

    <section style="margin-top: 20px;">
        @if ($documentations->isNotEmpty())
            <div class="admin-gallery-grid">
                @foreach ($documentations as $documentation)
                    <article class="admin-gallery-card">
                        <a href="{{ route('admin.gallery.show', $documentation) }}" class="admin-gallery-card__media">
                            @if ($documentation->cover_url)
                                <img src="{{ $documentation->cover_url }}" alt="{{ $documentation->title }}" loading="lazy">
                            @else
                                <div class="admin-gallery-card__media--empty" style="width:100%;height:100%;">Belum ada foto</div>
                            @endif
                        </a>

                        <div class="admin-gallery-card__body">
                            <h3 class="admin-gallery-card__title">
                                <a href="{{ route('admin.gallery.show', $documentation) }}" style="color:inherit;text-decoration:none;">
                                    {{ $documentation->title }}
                                </a>
                            </h3>

                            <div class="admin-gallery-card__meta">
                                <span>{{ $documentation->event_date?->format('d/m/Y') ?? 'Tanggal belum diisi' }}</span>
                                <span>{{ $documentation->photos_count }} foto</span>
                                @if ($documentation->location)
                                    <span>{{ $documentation->location }}</span>
                                @endif
                            </div>

                            <div class="admin-gallery-card__actions">
                                <a href="{{ route('admin.gallery.show', $documentation) }}" class="admin-btn admin-btn--sm">
                                    <x-admin.icon name="eye" />
                                    Detail
                                </a>
                                <a href="{{ route('admin.gallery.edit', $documentation) }}" class="admin-btn admin-btn--sm">
                                    <x-admin.icon name="pencil" />
                                    Ubah
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $documentation) }}" method="POST" data-confirm="Hapus dokumentasi {{ $documentation->title }} beserta semua fotonya?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">
                                        <x-admin.icon name="trash" />
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="admin-card" style="margin-top: 18px;">
                <x-admin.pagination :paginator="$documentations" />
            </div>
        @else
            <div class="admin-card">
                <div class="admin-empty">
                    <span class="admin-empty__title">
                        @if (request()->filled('q') || request()->filled('year'))
                            Dokumentasi tidak ditemukan
                        @else
                            Belum ada dokumentasi acara
                        @endif
                    </span>
                    @if (request()->filled('q') || request()->filled('year'))
                        Coba ubah kata kunci atau filter tahun.
                    @else
                        Tambahkan dokumentasi acara pertama untuk ditampilkan di website.
                    @endif
                    <div class="admin-empty__actions">
                        <a href="{{ route('admin.gallery.create') }}" class="admin-btn admin-btn--primary">
                            <x-admin.icon name="plus" />
                            Tambah dokumentasi
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
