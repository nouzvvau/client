@extends('layouts.admin')

@section('title', 'Detail Dokumentasi')
@section('admin_eyebrow', 'Galeri Acara')
@section('admin_title', 'Detail Dokumentasi')

@section('content')
    <div class="admin-page-head">
        <div>
            <a href="{{ route('admin.gallery.index') }}" class="admin-btn admin-btn--sm" style="margin-bottom:10px;">
                <x-admin.icon name="arrow-left" />
                Kembali
            </a>
            <h2 class="admin-page-head__title">{{ $documentation->title }}</h2>
            <p class="admin-page-head__desc">
                {{ $documentation->event_date?->format('d/m/Y') ?? 'Tanggal belum diisi' }}
                @if ($documentation->location)
                    · {{ $documentation->location }}
                @endif
                · {{ $documentation->photos->count() }} foto
            </p>
        </div>

        <div class="admin-page-head__actions">
            <a href="{{ route('admin.gallery.edit', $documentation) }}" class="admin-btn admin-btn--gold">
                <x-admin.icon name="pencil" />
                Ubah dokumentasi
            </a>
            <form action="{{ route('admin.gallery.destroy', $documentation) }}" method="POST" data-confirm="Hapus dokumentasi {{ $documentation->title }} beserta semua fotonya?">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn--danger">
                    <x-admin.icon name="trash" />
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Foto dokumentasi</h3>
                    <p class="admin-card__desc">Foto yang tampil di halaman galeri publik.</p>
                </div>
            </div>

            @if ($documentation->photos->isNotEmpty())
                <div class="admin-photo-grid">
                    @foreach ($documentation->photos as $photo)
                        <div class="admin-photo">
                            <a href="{{ $photo->url }}" target="_blank" rel="noopener noreferrer" class="admin-photo__media">
                                <img src="{{ $photo->url }}" alt="{{ $photo->caption ?: $documentation->title }}" loading="lazy">
                            </a>

                            <div class="admin-photo__body">
                                <p style="margin:0 0 6px;">{{ $photo->caption ?: 'Tanpa keterangan' }}</p>

                                <form action="{{ route('admin.gallery.photo.destroy', $photo) }}" method="POST" data-confirm="Hapus foto ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">
                                        <x-admin.icon name="trash" />
                                        Hapus foto
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="admin-empty">
                    <span class="admin-empty__title">Belum ada foto</span>
                    Tambahkan foto melalui halaman ubah dokumentasi.
                    <div class="admin-empty__actions">
                        <a href="{{ route('admin.gallery.edit', $documentation) }}" class="admin-btn admin-btn--primary">
                            <x-admin.icon name="plus" />
                            Tambah foto
                        </a>
                    </div>
                </div>
            @endif
        </section>

        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Informasi acara</h3>
                    <p class="admin-card__desc">Detail dokumentasi yang tersimpan.</p>
                </div>
            </div>

            <dl class="admin-detail-list">
                <dt>Judul</dt>
                <dd>{{ $documentation->title }}</dd>

                <dt>Tanggal acara</dt>
                <dd>{{ $documentation->event_date?->format('d/m/Y') ?? '—' }}</dd>

                <dt>Lokasi</dt>
                <dd>{{ $documentation->location ?: '—' }}</dd>

                <dt>Deskripsi</dt>
                <dd>{{ $documentation->description ?: '—' }}</dd>

                <dt>Jumlah foto</dt>
                <dd>{{ $documentation->photos->count() }} foto</dd>

                <dt>Ditambahkan</dt>
                <dd>{{ $documentation->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
            </dl>

            <div class="admin-form-actions">
                <a href="{{ route('galeri.acara', $documentation) }}" target="_blank" rel="noopener noreferrer" class="admin-btn">
                    <x-admin.icon name="external" />
                    Lihat di website
                </a>
            </div>
        </section>
    </div>
@endsection
