@extends('layouts.admin')

@section('title', 'Program & Kegiatan')
@section('admin_eyebrow', 'Program & Kegiatan')
@section('admin_title', 'Program & Kegiatan')

@section('content')
    <div class="admin-page-head">
        <div>
            <h2 class="admin-page-head__title">Program &amp; kegiatan</h2>
            <p class="admin-page-head__desc">
                Kelola program yang tampil di halaman program website. Program tidak
                aktif tetap tersimpan, tetapi disembunyikan dari halaman publik.
            </p>
        </div>

        <div class="admin-page-head__actions">
            <a href="{{ route('program') }}" target="_blank" rel="noopener noreferrer" class="admin-btn">
                <x-admin.icon name="external" />
                Lihat halaman program
            </a>
        </div>
    </div>

    <section class="admin-card">
        <div class="admin-card__head">
            <div>
                <h3 class="admin-card__title">Tambah program</h3>
                <p class="admin-card__desc">Isi data program dalam bahasa Indonesia dan Inggris.</p>
            </div>
        </div>

        <form action="{{ route('admin.program.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="name">Nama program (ID)</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="admin-input">
                </div>

                <div class="admin-field">
                    <label for="name_en">Nama program (EN)</label>
                    <input id="name_en" type="text" name="name_en" value="{{ old('name_en') }}" class="admin-input">
                </div>

                <div class="admin-field">
                    <label for="description">Deskripsi (ID)</label>
                    <textarea id="description" name="description" rows="4" class="admin-textarea">{{ old('description') }}</textarea>
                </div>

                <div class="admin-field">
                    <label for="description_en">Deskripsi (EN)</label>
                    <textarea id="description_en" name="description_en" rows="4" class="admin-textarea">{{ old('description_en') }}</textarea>
                </div>


                <div class="admin-field">
                    <label for="year">Tahun program</label>
                    <input id="year" type="number" name="year" value="{{ old('year') }}" min="1900" max="2100" placeholder="Contoh: 2026" class="admin-input">
                </div>

                <div class="admin-field" style="justify-content:flex-end;">
                    <input type="hidden" name="is_active" value="0">
                    <label class="admin-check">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                        <span>Tampilkan di halaman publik</span>
                    </label>
                </div>

                <div class="admin-field admin-field--full">
                    <label for="photos">Foto dokumentasi</label>
                    <input
                        id="photos"
                        type="file"
                        name="photos[]"
                        accept="image/jpeg,image/png,image/webp"
                        multiple
                        class="admin-file-input"
                        data-preview-input="#photo-preview"
                    >
                    <small style="font-size:11px;color:var(--admin-muted);">
                        Opsional. Maksimal 6 foto dokumentasi, format JPG, JPEG, PNG, atau WEBP,
                        masing-masing maksimal 2 MB. Tampil pada halaman detail program.
                    </small>
                    <div id="photo-preview" class="admin-preview"></div>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <x-admin.icon name="plus" />
                    Tambah program
                </button>
            </div>
        </form>
    </section>

    <section class="admin-card" style="margin-top: 20px;">
        <form method="GET" action="{{ route('admin.program.index') }}" class="admin-filter">
            <div class="admin-field">
                <label for="cari">Cari program</label>
                <input id="cari" type="search" name="cari" value="{{ request('cari') }}" placeholder="Nama program" class="admin-input">
            </div>

            <div class="admin-filter__actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <x-admin.icon name="search" />
                    Cari
                </button>
                @if (request()->filled('cari'))
                    <a href="{{ route('admin.program.index') }}" class="admin-btn">Reset</a>
                @endif
            </div>
        </form>

        @if ($programs->isNotEmpty())
            <div class="admin-table-wrap" style="margin-top: 18px;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr>
                                <td>
                                    <span class="admin-table__primary">{{ $program->name }}</span>
                                    @if ($program->name_en)
                                        <span class="admin-table__secondary">{{ $program->name_en }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $program->year ?: '—' }}
                                </td>
                                
                                <td>
                                    <span class="admin-badge admin-badge--{{ $program->is_active ? 'accepted' : 'rejected' }}">
                                        {{ $program->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="admin-table__actions">
                                        <a href="{{ route('admin.program.edit', $program) }}" class="admin-btn admin-btn--sm">
                                            <x-admin.icon name="pencil" />
                                            Ubah
                                        </a>
                                        <form action="{{ route('admin.program.destroy', $program) }}" method="POST" data-confirm="Hapus program {{ $program->name }}?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">
                                                <x-admin.icon name="trash" />
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-admin.pagination :paginator="$programs" />
        @else
            <div class="admin-empty">
                <span class="admin-empty__title">
                    @if (request()->filled('cari'))
                        Program tidak ditemukan
                    @else
                        Belum ada program
                    @endif
                </span>
                @if (request()->filled('cari'))
                    Coba ubah kata kunci pencarian.
                @else
                    Tambahkan program pertama melalui formulir di atas.
                @endif
            </div>
        @endif
    </section>
@endsection
