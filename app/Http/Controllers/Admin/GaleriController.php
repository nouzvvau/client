<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GaleriController extends Controller
{
    /**
     * Menampilkan daftar kegiatan.
     */
    public function index(Request $request): View
    {
        $activities = Activity::query()
            ->withCount('photos')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(
                    'title',
                    'like',
                    '%'.$request->cari.'%'
                );
            })
            ->orderByDesc('date')
            ->paginate(10)
            ->withQueryString();

        return view('admincakraaji.galeri', compact('activities'));
    }

    /**
     * Menampilkan form tambah kegiatan.
     */
    public function create(): View
    {
        return view('admincakraaji.galeri-tambah');
    }

    /**
     * Menyimpan kegiatan baru beserta foto.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        $activity = Activity::create([
            'title' => $validated['title'],
            'date' => $validated['date'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('activities', 'public');

                $activity->photos()->create([
                    'photo' => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.galeri')
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kegiatan.
     */
    public function edit(Activity $activity): View
    {
        $activity->load('photos');

        return view('admincakraaji.edit_galeri', compact('activity'));
    }

    /**
     * Menyimpan perubahan informasi kegiatan.
     */
    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $activity->update($validated);

        return redirect()
            ->route('admin.galeri.edit', $activity)
            ->with('success', 'Acara berhasil diperbarui.');
    }

    /**
     * Menghapus kegiatan beserta seluruh filenya.
     */
    public function destroy(Activity $activity): RedirectResponse
    {
        foreach ($activity->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        $activity->photos()->delete();
        $activity->delete();

        return redirect()
            ->route('admin.galeri')
            ->with('success', 'Acara berhasil dihapus.');
    }

    /**
     * Mengunggah foto tambahan untuk kegiatan.
     */
    public function storePhoto(Request $request, Activity $activity): RedirectResponse
    {
        $request->validate([
            'photos' => ['required', 'array'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('activities', 'public');

            $activity->photos()->create([
                'photo' => $path,
            ]);
        }

        return back()->with('success', 'Foto berhasil ditambahkan.');
    }

    /**
     * Menghapus satu foto dokumentasi.
     */
    public function destroyPhoto(ActivityPhoto $photo): RedirectResponse
    {
        Storage::disk('public')->delete($photo->photo);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
