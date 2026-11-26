<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $photos = GalleryPhoto::query()
            ->latest()
            ->paginate(12);

        $stats = [
            'total' => GalleryPhoto::count(),
        ];

        return view('admincakraaji.galeri.index', compact('photos', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
        ], [
            'photos.required' => 'Pilih minimal satu foto untuk diunggah.',
            'photos.min' => 'Pilih minimal satu foto untuk diunggah.',
            'photos.*.image' => 'File yang dipilih harus berupa gambar.',
            'photos.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 2 MB.',
            'captions.*.max' => 'Caption maksimal 255 karakter.',
        ]);

        foreach ($request->file('photos', []) as $index => $photo) {
            $path = $photo->store('gallery', 'public');

            GalleryPhoto::create([
                'photo' => $path,
                'caption' => filled($validated['captions'][$index] ?? null)
                    ? trim($validated['captions'][$index])
                    : null,
            ]);
        }

        return redirect()
            ->route('admin.public-gallery.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function update(Request $request, GalleryPhoto $photo): RedirectResponse
    {
        $validated = $request->validate([
            'caption' => ['nullable', 'string', 'max:255'],
        ], [
            'caption.max' => 'Caption maksimal 255 karakter.',
        ]);

        $caption = trim($validated['caption'] ?? '');

        $photo->update([
            'caption' => $caption !== '' ? $caption : null,
        ]);

        return back()->with('success', 'Caption foto berhasil diperbarui.');
    }

    public function destroy(GalleryPhoto $photo): RedirectResponse
    {
        Storage::disk('public')->delete($photo->photo);

        $photo->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}