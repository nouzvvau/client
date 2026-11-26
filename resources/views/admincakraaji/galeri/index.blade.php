@extends('layouts.admin')

@section('title', 'Galeri')
@section('admin_eyebrow', 'Konten Website')
@section('admin_title', 'Galeri')

@section('content')
    <div class="admin-gallery-page">
        <div class="admin-page-head">
            <div>
                <h2 class="admin-page-head__title">Kelola Galeri</h2>
                <p class="admin-page-head__desc">
                    Tambahkan foto dan caption yang akan ditampilkan pada halaman Galeri website.
                    Galeri ini terpisah dari dokumentasi Program &amp; Kegiatan.
                </p>
            </div>
            <div class="admin-page-head__actions">
                <span class="admin-btn admin-btn--gold">{{ $stats['total'] }} foto tersimpan</span>
            </div>
        </div>

        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Tambah Foto</h3>
                    <p class="admin-card__desc">Pilih satu atau beberapa foto sekaligus. Maksimal 2 MB per foto.</p>
                </div>
            </div>

            <form action="{{ route('admin.public-gallery.store') }}" method="POST" enctype="multipart/form-data" class="admin-gallery-upload-form">
                @csrf
                <div class="admin-form-group">
                    <label for="photos">Pilih foto</label>
                    <input type="file" id="photos" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple required>
                    @error('photos')
                        <small class="admin-form-error">{{ $message }}</small>
                    @enderror
                    @foreach ($errors->get('photos.*') as $messages)
                        @foreach ($messages as $message)
                            <small class="admin-form-error">{{ $message }}</small>
                        @endforeach
                    @endforeach
                </div>

                <div id="gallery-caption-fields"></div>

                <button type="submit" class="admin-btn admin-btn--gold">
                    <x-admin.icon name="plus" />
                    Simpan Foto
                </button>
            </form>
        </section>

        <section class="admin-card">
            <div class="admin-card__head">
                <div>
                    <h3 class="admin-card__title">Daftar Foto Galeri</h3>
                    <p class="admin-card__desc">Kelola foto dan ubah caption kapan saja.</p>
                </div>
            </div>

            @if ($photos->isNotEmpty())
                <div class="admin-gallery-grid">
                    @foreach ($photos as $photo)
                        <article class="admin-gallery-card">
                            <div class="admin-gallery-card__media">
                                <img src="{{ $photo->url }}" alt="{{ $photo->caption ?: 'Foto galeri' }}" loading="lazy">
                            </div>
                            <div class="admin-gallery-card__body">
                                <form action="{{ route('admin.public-gallery.update', $photo) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="admin-form-group">
                                        <label for="caption-{{ $photo->id }}">Caption</label>
                                        <input type="text" id="caption-{{ $photo->id }}" name="caption" value="{{ $photo->caption }}" maxlength="255" placeholder="Tambahkan caption foto...">
                                    </div>
                                    <div class="admin-inline-actions">
                                        <button type="submit" class="admin-btn admin-btn--sm admin-btn--gold">Simpan caption</button>
                                    </div>
                                </form>

                                <form action="{{ route('admin.public-gallery.destroy', $photo) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--sm">Hapus foto</button>
                                </form>

                                <div class="admin-card__desc">Diunggah {{ $photo->created_at->format('d/m/Y') }}</div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="admin-pagination">{{ $photos->links() }}</div>
            @else
                <div class="admin-empty">
                    <span class="admin-empty__title">Belum ada foto galeri</span>
                    Foto yang kamu unggah akan muncul di sini.
                </div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('photos');
    const container = document.getElementById('gallery-caption-fields');
    if (!input || !container) return;

    input.addEventListener('change', function () {
        container.innerHTML = '';
        Array.from(input.files).forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'admin-form-group';
            const label = document.createElement('label');
            label.textContent = 'Caption foto ' + (index + 1) + ' — ' + file.name;
            const caption = document.createElement('input');
            caption.type = 'text';
            caption.name = 'captions[' + index + ']';
            caption.maxLength = 255;
            caption.placeholder = 'Opsional';
            wrapper.append(label, caption);
            container.appendChild(wrapper);
        });
    });
});
</script>
@endpush