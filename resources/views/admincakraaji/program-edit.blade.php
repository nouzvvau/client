@extends('layouts.admin')

@section('title', 'Ubah Program')
@section('admin_eyebrow', 'Program & Kegiatan')
@section('admin_title', 'Ubah Program')

@section('content')
    <div class="admin-page-head">
        <div>
            <a href="{{ route('admin.program.index') }}" class="admin-btn admin-btn--sm" style="margin-bottom:10px;">
                <x-admin.icon name="arrow-left" />
                Kembali
            </a>
            <h2 class="admin-page-head__title">Ubah program</h2>
            <p class="admin-page-head__desc">{{ $program->name }}</p>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <form action="{{ route('admin.program.update', $program) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <div class="admin-field">
                        <label for="name">Nama program (ID)</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $program->name) }}" required class="admin-input">
                    </div>

                    <div class="admin-field">
                        <label for="name_en">Nama program (EN)</label>
                        <input id="name_en" type="text" name="name_en" value="{{ old('name_en', $program->name_en) }}" class="admin-input">
                    </div>

                    <div class="admin-field">
                        <label for="description">Deskripsi (ID)</label>
                        <textarea id="description" name="description" rows="5" class="admin-textarea">{{ old('description', $program->description) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label for="description_en">Deskripsi (EN)</label>
                        <textarea id="description_en" name="description_en" rows="5" class="admin-textarea">{{ old('description_en', $program->description_en) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label for="image">Gambar</label>
                        <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="admin-input">
                    </div>

                    <div class="admin-field">
                        <label for="year">Tahun program</label>
                        <input id="year" type="number" name="year" value="{{ old('year', $program->year) }}" min="1900" max="2100" placeholder="Contoh: 2026" class="admin-input">
                    </div>

                    <div class="admin-field" style="justify-content:flex-end;">
                        <input type="hidden" name="is_active" value="0">
                        <label class="admin-check">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $program->is_active))>
                            <span>Tampilkan di halaman publik</span>
                        </label>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <x-admin.icon name="check" />
                        Simpan perubahan
                    </button>
                    <a href="{{ route('admin.program.index') }}" class="admin-btn">Batal</a>
                </div>
            </form>
        </section>

        <div>
            <section class="admin-card">
                <div class="admin-card__head">
                    <div>
                        <h3 class="admin-card__title">Pratinjau gambar</h3>
                        <p class="admin-card__desc">Gambar yang dipakai di halaman publik.</p>
                    </div>
                </div>

                <div style="border:1px solid var(--admin-line);border-radius:var(--admin-radius);overflow:hidden;background:var(--admin-cream-deep);">
                    <img src="{{ $program->image_url }}" alt="{{ $program->name }}" style="display:block;width:100%;height:auto;">
                </div>
            </section>

            <section class="admin-card" style="border-color:#e3b1b3;">
                <div class="admin-card__head">
                    <div>
                        <h3 class="admin-card__title" style="color:var(--admin-red);">Hapus program</h3>
                        <p class="admin-card__desc">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>

                <form action="{{ route('admin.program.destroy', $program) }}" method="POST" data-confirm="Hapus program {{ $program->name }}?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--danger admin-btn--block">
                        <x-admin.icon name="trash" />
                        Hapus program
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection
