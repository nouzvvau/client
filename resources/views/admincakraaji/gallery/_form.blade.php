@php($isEdit = isset($documentation))

<form
    action="{{ $isEdit ? route('admin.gallery.update', $documentation) : route('admin.gallery.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="admin-form"
>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="admin-form-grid">
        <div class="admin-field admin-field--full">
            <label for="title">Judul dokumentasi</label>
            <input id="title" type="text" name="title" value="{{ old('title', $documentation->title ?? '') }}" required class="admin-input">
        </div>

        <div class="admin-field">
            <label for="event_date">Tanggal acara</label>
            <input id="event_date" type="date" name="event_date" value="{{ old('event_date', isset($documentation) && $documentation->event_date ? $documentation->event_date->format('Y-m-d') : '') }}" class="admin-input">
        </div>

        <div class="admin-field">
            <label for="location">Lokasi acara</label>
            <input id="location" type="text" name="location" value="{{ old('location', $documentation->location ?? '') }}" class="admin-input">
        </div>

        <div class="admin-field admin-field--full">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="4" class="admin-textarea">{{ old('description', $documentation->description ?? '') }}</textarea>
        </div>

        <div class="admin-field admin-field--full">
            <label for="photos">{{ $isEdit ? 'Tambah foto baru' : 'Foto dokumentasi' }}</label>
            <input
                id="photos"
                type="file"
                name="photos[]"
                accept="image/jpeg,image/png,image/webp"
                multiple
                class="admin-file-input"
                data-preview-input="#photo-preview"
                @if (! $isEdit) required @endif
            >
            <small style="font-size:11px;color:var(--admin-muted);">
                Format JPG, PNG, atau WEBP. Maksimal 20 foto, masing-masing 4 MB.
            </small>
            <div id="photo-preview" class="admin-preview"></div>
        </div>
    </div>

    @if ($isEdit && $documentation->photos->isNotEmpty())
        <div class="admin-divider"><span>Foto tersimpan</span></div>

        <div class="admin-form-grid">
            @foreach ($documentation->photos as $photo)
                <div class="admin-existing-photo">
                    <div class="admin-existing-photo__media">
                        <img src="{{ $photo->url }}" alt="{{ $photo->caption ?: $documentation->title }}">
                    </div>

                    <div class="admin-existing-photo__body">
                        <div class="admin-field">
                            <label for="caption-{{ $photo->id }}">Keterangan foto</label>
                            <input
                                id="caption-{{ $photo->id }}"
                                type="text"
                                name="captions[{{ $photo->id }}]"
                                value="{{ old('captions.'.$photo->id, $photo->caption) }}"
                                class="admin-input"
                            >
                        </div>

                        <label class="admin-existing-photo__remove">
                            <input
                                type="checkbox"
                                name="remove_photos[]"
                                value="{{ $photo->id }}"
                                @checked(collect(old('remove_photos', []))->contains($photo->id))
                            >
                            Hapus foto ini saat menyimpan
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="admin-form-actions">
        <button type="submit" class="admin-btn admin-btn--primary">
            <x-admin.icon name="check" />
            {{ $isEdit ? 'Simpan perubahan' : 'Unggah dokumentasi' }}
        </button>
        <a href="{{ $isEdit ? route('admin.gallery.show', $documentation) : route('admin.gallery.index') }}" class="admin-btn">
            Batal
        </a>
    </div>
</form>
