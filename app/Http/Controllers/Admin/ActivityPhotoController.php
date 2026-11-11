<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ActivityPhotoController extends Controller
{
    public function store(Request $request, Activity $activity): JsonResponse
    {
        $validated = $request->validate([
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['required', 'image', 'max:2048'],
            'captions' => ['sometimes', 'nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
        ]);

        $photos = [];

        foreach ($request->file('photos') as $index => $file) {
            $photos[] = ActivityPhoto::create([
                'activity_id' => $activity->id,
                'photo' => $file->store('activities', 'public'),
                'caption' => $validated['captions'][$index] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Foto aktivitas berhasil ditambahkan.',
            'data' => $photos,
        ], 201);
    }

    public function update(Request $request, Activity $activity, ActivityPhoto $photo): JsonResponse
    {
        if ($photo->activity_id !== $activity->id) {
            return response()->json([
                'message' => 'Foto tidak ditemukan pada aktivitas ini.',
            ], 404);
        }

        $validated = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($photo->photo);
            $validated['photo'] = $request->file('photo')->store('activities', 'public');
        }

        $photo->update($validated);

        return response()->json([
            'message' => 'Foto aktivitas berhasil diperbarui.',
            'data' => $photo,
        ]);
    }

    public function destroy(Activity $activity, ActivityPhoto $photo): JsonResponse
    {
        if ($photo->activity_id !== $activity->id) {
            return response()->json([
                'message' => 'Foto tidak ditemukan pada aktivitas ini.',
            ], 404);
        }

        Storage::disk('public')->delete($photo->photo);
        $photo->delete();

        return response()->json([
            'message' => 'Foto aktivitas berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     caption?: string|null
     * }
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'caption' => ['sometimes', 'nullable', 'string', 'max:255'],
            'photo' => ['sometimes', 'image', 'max:2048'],
        ]);

        if ($validated === []) {
            throw ValidationException::withMessages([
                'activity_photo' => 'Minimal satu data foto aktivitas harus dikirim.',
            ]);
        }

        return $validated;
    }
}
