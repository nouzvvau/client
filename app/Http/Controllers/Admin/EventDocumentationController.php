<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventDocumentation;
use App\Models\EventDocumentationPhoto;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EventDocumentationController extends Controller
{
    private const MAX_PHOTOS = 5;

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
            'this_year' => EventDocumentation::query()
                ->whereYear('event_date', now()->year)
                ->count(),
            'with_photos' => EventDocumentation::query()->has('photos')->count(),
        ];

        $years = EventDocumentation::query()
            ->whereNotNull('event_date')
            ->pluck('event_date')
            ->map(fn ($date): int => (int) $date->year)
            ->unique()
            ->sortDesc()
            ->values();

        return view('admincakraaji.galeri.index', compact(
            'documentations',
            'stats',
            'years'
        ));
    }

    public function create(): View
    {
        return view('admincakraaji.gallery.create', [
            'programs' => $this->programOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDocumentation($request, true);

        $documentation = DB::transaction(function () use ($request, $validated): EventDocumentation {
            $documentation = EventDocumentation::create(
                Arr::only($validated, [
                    'title',
                    'description',
                    'event_date',
                    'location',
                    'program_id',
                ])
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

        return view('admincakraaji.gallery.edit', [
            'documentation' => $documentation,
            'programs' => $this->programOptions(),
        ]);
    }

    public function update(
        Request $request,
        EventDocumentation $documentation
    ): RedirectResponse {
        $validated = $this->validateDocumentation($request, false);

        $documentation->load('photos');

        $removeIds = collect($request->input('remove_photos', []))
            ->map(fn ($id): int => (int) $id)
            ->filter()
            ->all();

        $remainingSlots = self::MAX_PHOTOS - $documentation->photos
            ->reject(fn (EventDocumentationPhoto $photo): bool => in_array(
                $photo->id,
                $removeIds,
                false
            ))
            ->count();

        $newPhotoCount = count($request->file('photos', []));

        if ($newPhotoCount > $remainingSlots) {
            throw ValidationException::withMessages([
                'photos' => $remainingSlots <= 0
                    ? 'Foto sudah mencapai batas maksimal '.self::MAX_PHOTOS.' foto. Hapus salah satu foto lama terlebih dahulu.'
                    : 'Total foto melebihi batas maksimal '.self::MAX_PHOTOS.' foto. Sisa slot tersedia: '.$remainingSlots.'.',
            ]);
        }

        DB::transaction(function () use (
            $request,
            $documentation,
            $validated,
            $removeIds
        ): void {
            $documentation->update(
                Arr::only($validated, [
                    'title',
                    'description',
                    'event_date',
                    'location',
                    'program_id',
                ])
            );

            foreach ($request->input('captions', []) as $photoId => $caption) {
                $photo = $documentation->photos()
                    ->whereKey($photoId)
                    ->first();

                if ($photo !== null) {
                    $caption = is_string($caption) ? trim($caption) : '';

                    $photo->update([
                        'caption' => $caption === '' ? null : $caption,
                    ]);
                }
            }

            if ($removeIds !== []) {
                $removedPhotos = $documentation->photos()
                    ->whereIn('id', $removeIds)
                    ->get();

                $pathsToDelete = [];

                foreach ($removedPhotos as $photo) {
                    $pathsToDelete[] = $photo->photo;

                    if ($photo->thumbnail) {
                        $pathsToDelete[] = $photo->thumbnail;
                    }

                    $photo->delete();
                }

                $this->deleteFilesAfterCommit($pathsToDelete);
            }

            $this->storePhotos(
                $documentation,
                $request->file('photos', [])
            );
        });

        return redirect()
            ->route('admin.gallery.show', $documentation)
            ->with('success', 'Dokumentasi acara berhasil diperbarui.');
    }

    public function destroy(EventDocumentation $documentation): RedirectResponse
    {
        DB::transaction(function () use ($documentation): void {
            $paths = $documentation->photos()
                ->get(['photo', 'thumbnail'])
                ->flatMap(fn ($photo) => [
                    $photo->photo,
                    $photo->thumbnail,
                ])
                ->filter()
                ->unique()
                ->values()
                ->all();

            $documentation->delete();

            $this->deleteFilesAfterCommit($paths);
        });

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Dokumentasi acara berhasil dihapus.');
    }

    public function destroyPhoto(EventDocumentationPhoto $photo): RedirectResponse
    {
        DB::transaction(function () use ($photo): void {
            $paths = array_filter([
                $photo->photo,
                $photo->thumbnail,
            ]);

            $photo->delete();

            $this->deleteFilesAfterCommit($paths);
        });

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateDocumentation(
        Request $request,
        bool $requirePhotos
    ): array {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'photos' => [
                $requirePhotos ? 'required' : 'nullable',
                'array',
                'max:'.self::MAX_PHOTOS,
            ],
            'photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'captions' => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => ['integer'],
        ], [
            'photos.required' => 'Unggah minimal satu foto dokumentasi.',
            'photos.max' => 'Maksimal '.self::MAX_PHOTOS.' foto untuk satu dokumentasi.',
            'photos.*.image' => 'Setiap file yang dipilih harus berupa gambar.',
            'photos.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 2 MB.',
            'program_id.exists' => 'Program yang dipilih tidak ditemukan.',
        ]);
    }

    /**
     * @return Collection<int, Program>
     */
    private function programOptions(): Collection
    {
        return Program::query()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @param array<int, UploadedFile> $photos
     */
    private function storePhotos(
        EventDocumentation $documentation,
        array $photos
    ): void {
        foreach ($photos as $photo) {
            $path = $photo->store('event-documentation', 'public');

            $documentation->photos()->create([
                'photo' => $path,
                'thumbnail' => null,
                'is_thumbnail' => false,
            ]);
        }
    }

    /**
     * Hapus file setelah transaksi database berhasil.
     *
     * @param array<int, string|null> $paths
     */
    private function deleteFilesAfterCommit(array $paths): void
    {
        $paths = array_values(array_unique(array_filter($paths)));

        if ($paths === []) {
            return;
        }

        DB::afterCommit(function () use ($paths): void {
            Storage::disk('public')->delete($paths);
        });
    }
}