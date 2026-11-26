<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventDocumentation;
use App\Models\EventDocumentationPhoto;
use App\Models\Program;
use App\Support\PhotoThumbnail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProgramController extends Controller
{
    private const MAX_PHOTOS = 5;
    private const MAX_PHOTO_SIZE = 2048;

    public function index(Request $request): View
    {
        $programs = Program::query()
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->cari.'%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admincakraaji.program', compact('programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProgram($request);
        $photos = $this->validateDocumentationPhotos($request, null);

        $newFiles = [];

        try {
            DB::transaction(function () use ($validated, $photos, &$newFiles): void {
                $program = Program::create($validated);

                $this->syncDocumentationPhotos(
                    $program,
                    $photos,
                    $newFiles
                );
            });
        } catch (\Throwable $exception) {
            $this->cleanupNewFiles($newFiles);

            throw $exception;
        }

        return back()->with(
            'success',
            'Program & kegiatan berhasil ditambahkan.'
        );
    }

    public function edit(Program $program): View
    {
        $program->load('documentations.photos');

        $documentationPhotos = $program->documentations
            ->flatMap(fn (EventDocumentation $documentation) => $documentation->photos)
            ->values();

        return view(
            'admincakraaji.program-edit',
            compact('program', 'documentationPhotos')
        );
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $validated = $this->validateProgram($request);

        $program->update($validated);

        return redirect()
            ->route('admin.program.index')
            ->with('success', 'Program & kegiatan berhasil diperbarui.');
    }

    public function documentationPhotos(
        Request $request,
        Program $program
    ): RedirectResponse {
        $photos = $this->validateDocumentationPhotos($request, $program);

        $newFiles = [];

        try {
            DB::transaction(function () use ($program, $photos, &$newFiles): void {
                $this->syncDocumentationPhotos(
                    $program,
                    $photos,
                    $newFiles
                );
            });
        } catch (\Throwable $exception) {
            $this->cleanupNewFiles($newFiles);

            throw $exception;
        }

        return redirect()
            ->route('admin.program.edit', $program)
            ->with('success', 'Foto dokumentasi program berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $documentationIds = $program->documentations()->pluck('id');

        $photos = EventDocumentationPhoto::query()
            ->whereIn('event_documentation_id', $documentationIds)
            ->get(['photo', 'thumbnail']);

        $paths = $photos
            ->flatMap(fn (EventDocumentationPhoto $photo) => [
                $photo->photo,
                $photo->thumbnail,
            ])
            ->filter()
            ->unique()
            ->values()
            ->all();

        DB::transaction(function () use ($program): void {
            $program->documentations()->delete();
            $program->delete();
        });

        if ($paths !== []) {
            Storage::disk('public')->delete($paths);
        }

        return back()->with(
            'success',
            'Program & kegiatan berhasil dihapus.'
        );
    }

    /**
     * Validasi data program.
     *
     * @return array<string, mixed>
     */
    private function validateProgram(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'schedule_en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    /**
     * Validasi foto dokumentasi program.
     *
     * @return array{
     *     photos: array<int, UploadedFile>,
     *     remove_photos: array<int>,
     *     thumbnail_photo_id: ?int
     * }
     */
    private function validateDocumentationPhotos(
        Request $request,
        ?Program $program
    ): array {
        $validated = $request->validate([
            'photos' => ['nullable', 'array', 'max:'.self::MAX_PHOTOS],
            'photos.*' => [
                'bail',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:'.self::MAX_PHOTO_SIZE,
            ],
            'remove_photos' => ['nullable', 'array'],
            'remove_photos.*' => ['integer'],
            'thumbnail_photo_id' => ['nullable', 'integer'],
        ], [
            'photos.max' => 'Maksimal '.self::MAX_PHOTOS.' foto dokumentasi untuk satu program.',
            'photos.*.image' => 'File :attribute bukan gambar yang valid.',
            'photos.*.mimes' => 'Format :attribute harus JPG, JPEG, PNG, atau WEBP.',
            'photos.*.max' => 'Upload gagal! Ukuran foto :attribute melebihi batas maksimal 2 MB. Silakan pilih foto yang ukurannya tidak lebih dari 2 MB.',
        ], [
            'photos.*' => 'foto dokumentasi',
        ]);

        $removeIds = collect($request->input('remove_photos', []))
            ->map(fn ($id): int => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $thumbnailPhotoId = isset($validated['thumbnail_photo_id'])
            ? (int) $validated['thumbnail_photo_id']
            : null;

        $existingCount = 0;
        $removedCount = 0;

        if ($program !== null) {
            $documentationIds = $program->documentations()->pluck('id');

            $programPhotos = EventDocumentationPhoto::query()
                ->whereIn('event_documentation_id', $documentationIds);

            $existingCount = (clone $programPhotos)->count();

            $removedCount = (clone $programPhotos)
                ->whereIn('id', $removeIds)
                ->count();

            if ($thumbnailPhotoId !== null) {
                $thumbnailExists = (clone $programPhotos)
                    ->where('id', $thumbnailPhotoId)
                    ->exists();

                if (! $thumbnailExists) {
                    throw ValidationException::withMessages([
                        'thumbnail_photo_id' => 'Foto thumbnail tidak valid.',
                    ]);
                }

                if (in_array($thumbnailPhotoId, $removeIds, true)) {
                    throw ValidationException::withMessages([
                        'thumbnail_photo_id' => 'Foto yang dipilih sebagai thumbnail tidak boleh dihapus.',
                    ]);
                }
            }
        }

        $remainingSlots = self::MAX_PHOTOS - ($existingCount - $removedCount);
        $newPhotoCount = count($request->file('photos', []));

        if ($newPhotoCount > $remainingSlots) {
            throw ValidationException::withMessages([
                'photos' => $remainingSlots <= 0
                    ? 'Foto dokumentasi sudah mencapai batas maksimal '.self::MAX_PHOTOS.' foto. Hapus salah satu foto terlebih dahulu.'
                    : 'Total foto dokumentasi melebihi batas maksimal '.self::MAX_PHOTOS.' foto. Sisa slot tersedia: '.$remainingSlots.'.',
            ]);
        }

        return [
            'photos' => $request->file('photos', []),
            'remove_photos' => $removeIds,
            'thumbnail_photo_id' => $thumbnailPhotoId,
        ];
    }

    /**
     * Sinkronisasi foto dokumentasi dan thumbnail program.
     *
     * @param array{
     *     photos: array<int, UploadedFile>,
     *     remove_photos: array<int>,
     *     thumbnail_photo_id: ?int
     * } $payload
     * @param array<int, string> $newFiles
     */
    private function syncDocumentationPhotos(
        Program $program,
        array $payload,
        array &$newFiles
    ): void {
        $disk = Storage::disk('public');
        $pathsToDelete = [];

        // Hapus foto yang dipilih untuk dihapus.
        if ($payload['remove_photos'] !== []) {
            $documentationIds = $program->documentations()->pluck('id');

            $removedPhotos = EventDocumentationPhoto::query()
                ->whereIn('event_documentation_id', $documentationIds)
                ->whereIn('id', $payload['remove_photos'])
                ->get();

            foreach ($removedPhotos as $photo) {
                $pathsToDelete[] = $photo->photo;

                if ($photo->thumbnail) {
                    $pathsToDelete[] = $photo->thumbnail;
                }

                $photo->delete();
            }
        }

        // Simpan foto baru sebagai foto asli tanpa kompresi.
        if ($payload['photos'] !== []) {
            $documentation = $program->documentations()
                ->orderBy('id')
                ->first()
                ?? $program->documentations()->create([
                    'title' => $program->name,
                ]);

            foreach ($payload['photos'] as $photo) {
                $photoPath = $photo->store(
                    'event-documentation',
                    'public'
                );

                if (! $photoPath) {
                    throw new \RuntimeException(
                        'Gagal menyimpan foto dokumentasi.'
                    );
                }

                // Catat file baru agar bisa dibersihkan jika transaksi gagal.
                $newFiles[] = $photoPath;

                $documentation->photos()->create([
                    'photo' => $photoPath,
                    'thumbnail' => null,
                    'is_thumbnail' => false,
                ]);
            }
        }

        // Ambil seluruh foto milik program.
        $documentationIds = $program->documentations()->pluck('id');

        $programPhotos = EventDocumentationPhoto::query()
            ->whereIn('event_documentation_id', $documentationIds)
            ->orderBy('id')
            ->get();

        if ($programPhotos->isEmpty()) {
            $this->deleteFilesAfterCommit($pathsToDelete);

            return;
        }

        // Tentukan foto yang menjadi thumbnail.
        $thumbnailPhotoId = $payload['thumbnail_photo_id'];

        if ($thumbnailPhotoId === null) {
            $thumbnailPhotoId = $programPhotos
                ->firstWhere('is_thumbnail', true)?->id;
        }

        if ($thumbnailPhotoId === null) {
            $thumbnailPhotoId = $programPhotos->first()->id;
        }

        // Buat atau pertahankan thumbnail foto terpilih.
        foreach ($programPhotos as $photo) {
            if ((int) $photo->id === $thumbnailPhotoId) {
                if (
                    ! $photo->thumbnail ||
                    ! $disk->exists($photo->thumbnail)
                ) {
                    $newThumbnail = PhotoThumbnail::create($photo->photo);

                    // Catat thumbnail baru untuk pembersihan jika transaksi gagal.
                    $newFiles[] = $newThumbnail;

                    if ($photo->thumbnail) {
                        $pathsToDelete[] = $photo->thumbnail;
                    }

                    $photo->thumbnail = $newThumbnail;
                }

                $photo->is_thumbnail = true;
            } else {
                if ($photo->thumbnail) {
                    $pathsToDelete[] = $photo->thumbnail;
                }

                $photo->thumbnail = null;
                $photo->is_thumbnail = false;
            }

            $photo->save();
        }

        // Hapus file lama hanya setelah transaksi berhasil.
        $this->deleteFilesAfterCommit($pathsToDelete);
    }

    /**
     * Bersihkan file baru jika transaksi database gagal.
     *
     * @param array<int, string> $paths
     */
    private function cleanupNewFiles(array $paths): void
    {
        $paths = array_values(array_unique(array_filter($paths)));

        if ($paths !== []) {
            Storage::disk('public')->delete($paths);
        }
    }

    /**
     * Hapus file fisik setelah transaksi database berhasil.
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