@extends('layouts.admin')

@section('title', 'Ubah Program')
@section('admin_eyebrow', 'Program & Kegiatan')
@section('admin_title', 'Ubah Program')

@section('content')
    <div class="admin-page-head">
        <div>
            <a href="{{ route('admin.program.index') }}" class="admin-btn admin-btn--sm" style="margin-bottom:10px;">
                <x-admin.icon name="arrow-left" /> Kembali
            </a>

            <h2 class="admin-page-head__title">Ubah program</h2>
            <p class="admin-page-head__desc">{{ $program->name }}</p>
        </div>
    </div>

    <div class="admin-detail-grid">
        <section class="admin-card">
            <form action="{{ route('admin.program.update', $program) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <div class="admin-field">
                        <label for="name">Nama program (ID)</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $program->name) }}"
                            required
                            class="admin-input"
                        >
                    </div>

                    <div class="admin-field">
                        <label for="name_en">Nama program (EN)</label>
                        <input
                            id="name_en"
                            type="text"
                            name="name_en"
                            value="{{ old('name_en', $program->name_en) }}"
                            class="admin-input"
                        >
                    </div>

                    <div class="admin-field">
                        <label for="description">Deskripsi (ID)</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="admin-textarea"
                        >{{ old('description', $program->description) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label for="description_en">Deskripsi (EN)</label>
                        <textarea
                            id="description_en"
                            name="description_en"
                            rows="5"
                            class="admin-textarea"
                        >{{ old('description_en', $program->description_en) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label for="year">Tahun program</label>
                        <input
                            id="year"
                            type="number"
                            name="year"
                            value="{{ old('year', $program->year) }}"
                            min="1900"
                            max="2100"
                            placeholder="Contoh: 2026"
                            class="admin-input"
                        >
                    </div>

                    <div class="admin-field" style="justify-content:flex-end;">
                        <input type="hidden" name="is_active" value="0">

                        <label class="admin-check">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked(old('is_active', $program->is_active))
                            >
                            <span>Tampilkan di halaman publik</span>
                        </label>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <x-admin.icon name="check" /> Simpan perubahan
                    </button>

                    <a href="{{ route('admin.program.index') }}" class="admin-btn">
                        Batal
                    </a>
                </div>
            </form>
        </section>

        <div>
            <section class="admin-card" style="border-color:#e3b1b3;">
                <div class="admin-card__head">
                    <div>
                        <h3 class="admin-card__title" style="color:var(--admin-red);">
                            Hapus program
                        </h3>

                        <p class="admin-card__desc">
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <form
                    action="{{ route('admin.program.destroy', $program) }}"
                    method="POST"
                    data-confirm="Hapus program {{ $program->name }}?"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="admin-btn admin-btn--danger admin-btn--block">
                        <x-admin.icon name="trash" /> Hapus program
                    </button>
                </form>
            </section>
        </div>
    </div>

    @php
        $maxPhotos = 6;
        $photoCount = $documentationPhotos->count();
        $remainingSlots = max($maxPhotos - $photoCount, 0);

        $selectedThumbnailId = old(
            'thumbnail_photo_id',
            $documentationPhotos->firstWhere('is_thumbnail', true)?->id
                ?? $documentationPhotos->first()?->id
        );

        $removedPhotoIds = collect(old('remove_photos', []))
            ->map(fn ($id) => (int) $id);
    @endphp

    <section class="admin-card" style="margin-top:20px;">
        <div class="admin-card__head">
            <div>
                <h3 class="admin-card__title">Foto dokumentasi</h3>

                <p class="admin-card__desc">
                    Terpakai <strong>{{ $photoCount }}/{{ $maxPhotos }}</strong> foto ·
                    sisa slot <strong>{{ $remainingSlots }}</strong>.
                    Pilih satu foto sebagai thumbnail program.
                </p>
            </div>
        </div>

        <form
            action="{{ route('admin.program.documentation-photos', $program) }}"
            method="POST"
            enctype="multipart/form-data"
            class="admin-form"
        >
            @csrf

            @if ($photoCount > 0)
                <div class="admin-form-grid">
                    @foreach ($documentationPhotos as $photo)
                        @php
                            $isSelectedThumbnail = (int) $selectedThumbnailId === (int) $photo->id;
                            $isMarkedForRemoval = $removedPhotoIds->contains((int) $photo->id);

                            $previewUrl = $isSelectedThumbnail && $photo->thumbnail_url
                                ? $photo->thumbnail_url
                                : $photo->url;
                        @endphp

                        <div class="admin-existing-photo">
                            <div class="admin-existing-photo__media">
                                <img
                                    src="{{ $previewUrl }}"
                                    alt="{{ $photo->caption ?: $program->name }}"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </div>

                            <div class="admin-existing-photo__body">
                                @if ($isSelectedThumbnail)
                                    <span style="display:inline-block;margin-bottom:8px;padding:4px 9px;background:#e5f4e8;color:#24733a;border-radius:20px;font-size:11px;font-weight:700;">
                                        Thumbnail aktif
                                    </span>
                                @endif

                                <label style="display:flex;align-items:center;gap:7px;margin-bottom:10px;cursor:pointer;">
                                    <input
                                        type="radio"
                                        name="thumbnail_photo_id"
                                        value="{{ $photo->id }}"
                                        @checked($isSelectedThumbnail)
                                    >

                                    <span>Jadikan thumbnail</span>
                                </label>

                                <p style="margin:0 0 6px;">
                                    {{ $photo->caption ?: 'Tanpa keterangan' }}
                                </p>

                                <label class="admin-existing-photo__remove">
                                    <input
                                        type="checkbox"
                                        name="remove_photos[]"
                                        value="{{ $photo->id }}"
                                        @checked($isMarkedForRemoval)
                                    >

                                    Hapus foto ini saat menyimpan
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="admin-card__desc">
                    Belum ada foto dokumentasi untuk program ini.
                </p>
            @endif

            @error('thumbnail_photo_id')
                <p style="color:var(--admin-red);font-size:12px;margin-top:10px;">
                    {{ $message }}
                </p>
            @enderror

            <div class="admin-field admin-field--full" style="margin-top:16px;">
                <label for="photos">Tambah foto baru</label>

                <input
                    id="photos"
                    type="file"
                    name="photos[]"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    multiple
                    class="admin-file-input"
                    data-preview-input="#photo-preview"
                    @disabled($remainingSlots === 0)
                >

                <small style="font-size:11px;color:var(--admin-muted);">
                    Format JPG, JPEG, PNG, atau WEBP.
                    Maksimal 6 foto per program.
                    Ukuran foto asli maksimal 10 MB per foto dan akan otomatis
                    dikompres menjadi WebP maksimal 2 MB per foto.
                    Pilih seluruh foto sekaligus.

                    @if ($remainingSlots === 0)
                        Semua slot foto penuh — hapus salah satu foto untuk menambah foto baru.
                    @endif
                </small>

                <div id="photo-preview" class="admin-preview"></div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <x-admin.icon name="check" /> Simpan foto dokumentasi
                </button>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('photos');

    if (!input) return;

    const MAX_ORIGINAL = 10 * 1024 * 1024;
    const MAX_OUTPUT = 2 * 1024 * 1024;
    const MAX_DIMENSION = 2400;

    const canvasToBlob = (canvas, quality) => {
        return new Promise((resolve, reject) => {
            canvas.toBlob(blob => {
                if (!blob) {
                    reject(new Error('Browser gagal mengompres gambar.'));
                    return;
                }

                resolve(blob);
            }, 'image/webp', quality);
        });
    };

    const compressImage = async (file) => {
        if (file.size > MAX_ORIGINAL) {
            throw new Error('Ukuran foto asli melebihi 10 MB.');
        }

        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            throw new Error('Format foto harus JPG, PNG, atau WEBP.');
        }

        const bitmap = await createImageBitmap(file);

        try {
            let width = bitmap.width;
            let height = bitmap.height;

            const initialScale = Math.min(
                1,
                MAX_DIMENSION / Math.max(width, height)
            );

            width = Math.max(1, Math.round(width * initialScale));
            height = Math.max(1, Math.round(height * initialScale));

            for (let dimensionAttempt = 0; dimensionAttempt < 12; dimensionAttempt++) {
                const canvas = document.createElement('canvas');

                canvas.width = width;
                canvas.height = height;

                const context = canvas.getContext('2d');

                if (!context) {
                    throw new Error('Browser tidak mendukung pemrosesan gambar.');
                }

                context.drawImage(bitmap, 0, 0, width, height);

                for (let quality = 0.85; quality >= 0.40; quality -= 0.05) {
                    const blob = await canvasToBlob(canvas, quality);

                    if (blob.type !== 'image/webp') {
                        throw new Error('Browser tidak mendukung ekspor WebP.');
                    }

                    if (blob.size <= MAX_OUTPUT) {
                        const filename = file.name.replace(/\.[^.]+$/, '') + '.webp';

                        return new File([blob], filename, {
                            type: 'image/webp',
                            lastModified: Date.now()
                        });
                    }
                }

                width = Math.max(1, Math.round(width * 0.85));
                height = Math.max(1, Math.round(height * 0.85));
            }

            throw new Error('Foto tidak berhasil dikompres hingga maksimal 2 MB.');
        } finally {
            bitmap.close();
        }
    };

    input.addEventListener('change', async () => {
        const files = Array.from(input.files);

        if (!files.length) return;

        if (files.length > 6) {
            alert('Maksimal pilih 6 foto sekaligus.');
            input.value = '';
            return;
        }

        input.disabled = true;

        const compressedFiles = [];

        try {
            for (const file of files) {
                const compressed = await compressImage(file);

                compressedFiles.push(compressed);

                console.log(
                    `${file.name}: ${(file.size / 1024 / 1024).toFixed(2)} MB → ${(compressed.size / 1024 / 1024).toFixed(2)} MB`
                );
            }

            const dataTransfer = new DataTransfer();

            compressedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;

            alert(
                `${compressedFiles.length} foto berhasil dikompres dan siap diunggah.`
            );
        } catch (error) {
            console.error(error);

            input.value = '';

            alert(`Gagal mengompres foto: ${error.message}`);
        } finally {
            input.disabled = false;
        }
    });
});
</script>
@endpush
