<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
                    '%' . $request->cari . '%'
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
}