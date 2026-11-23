<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventDocumentation;
use App\Models\EventDocumentationPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventDocumentationController extends Controller
{
    public function index(Request $request): View
    {
        $documentations = EventDocumentation::query()
            ->with('photos')
            ->withCount('photos')
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = '%'.trim((string) $request->input('q')).'%';

                $query->where(function ($query) use ($term): void {
                    $query->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhere('location', 'like', $term);
                });
            })
            ->when($request->filled('year'), function ($query) use ($request): void {
                $query->whereYear('event_date', $request->input('year'));
            })
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $stats = [
            'total' => EventDocumentation::query()->count(),
            'photos' => EventDocumentationPhoto::query()->count(),
            'this_year' => EventDocumentation::query()->whereYear('event_date', now()->year)->count(),
            'with_photos' => EventDocumentation::query()->has('photos')->count(),
        ];

        $years = EventDocumentation::query()
            ->whereNotNull('event_date')
            ->pluck('event_date')
            ->map(fn ($date): int => (int) $date->year)
            ->unique()
            ->sortDesc()
            ->values();

        return view('admincakraaji.gallery.index', compact('documentations', 'stats', 'years'));
    }

    public function create(): View
    {
        return view('admincakraaji.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDocumentation($request, true);

        $documentation = DB::transaction(function () use ($request, $validated): EventDocumentation {
            $documentation = EventDocumentation::create(
                Arr::only($validated, ['title', 'description', 'event_date', 'location'])
            );

            $this->storePhotos($documentation, $request->file('photos', []));

            return $documentation;
        });

        return redirect()
            ->route('admin.gallery.show', $documentation)
            ->with('success', 'Dokumentasi acara berhasil ditambahkan.');
    }

    public function show(EventDocumentation $documentation): View
    {
        $documentation->load('photos');

        return view('admincakraaji.gallery.show', compact('documentation'));
    }

    public function edit(EventDocumentation $documentation): View
    {
        $documentation->load('photos');

        return view('admincakraaji.gallery.edit', compact('documentation'));
    }

    public function update(Request $request, EventDocumentation $documentation): RedirectResponse
    {
        $validated = $this->validateDocumentation($request, false);

        DB::transaction(function () use ($request, $documentation, $validated): void {
            $documentation->update(
                Arr::only($validated, ['title', 'description', 'event_date', 'location'])
            );

            foreach ($request->input('captions', []) as $photoId => $caption) {
                $photo = $documentation->photos()->whereKey($photoId)->first();

                if ($photo !== null) {
                    $caption = is_string($caption) ? trim($caption) : '';
                    $photo->update(['caption' => $caption === '' ? null : $caption]);
                }
            }

            $removeIds = collect($request->input('remove_photos', []))
                ->map(fn ($id): int => (int) $id)
                ->filter()
                ->all();

            if ($removeIds !== []) {
                $removedPhotos = $documentation->photos()->whereIn('id', $removeIds)->get();

                foreach ($removedPhotos as $photo) {
                    Storage::disk('public')->delete($photo->photo);
                    $photo->delete();
                }
            }

            $this->storePhotos($documentation, $request->file('photos', []));
        });

        return redirect()
            ->route('admin.gallery.show', $documentation)
            ->with('success', 'Dokumentasi acara berhasil diperbarui.');
    }

    public function destroy(EventDocumentation $documentation): RedirectResponse
    {
        $paths = $documentation->photos()->pluck('photo')->all();

        $documentation->delete();

        Storage::disk('public')->delete($paths);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Dokumentasi acara berhasil dihapus.');
    }

    public function destroyPhoto(EventDocumentationPhoto $photo): RedirectResponse
    {
        Storage::disk('public')->delete($photo->photo);

        $photo->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateDocumentation(Request $request, bool $requirePhotos): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'photos' => [$requirePhotos ? 'required' : 'nullable', 'array', 'max:20'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => ['integer'],
        ]);
    }

    /**
     * @param  array<int, \Illuminate\Http\UploadedFile>  $photos
     */
    private function storePhotos(EventDocumentation $documentation, array $photos): void
    {
        foreach ($photos as $photo) {
            $path = $photo->store('event-documentation', 'public');

            $documentation->photos()->create([
                'photo' => $path,
            ]);
        }
    }
}
