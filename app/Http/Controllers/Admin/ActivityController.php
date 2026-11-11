<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Activity::with('photos')->latest()->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $activity = Activity::create($this->validatedData($request, true));

        return response()->json([
            'message' => 'Aktivitas berhasil ditambahkan.',
            'data' => $activity->load('photos'),
        ], 201);
    }

    public function show(Activity $activity): JsonResponse
    {
        return response()->json($activity->load('photos'));
    }

    public function update(Request $request, Activity $activity): JsonResponse
    {
        $activity->update($this->validatedData($request, false));

        return response()->json([
            'message' => 'Aktivitas berhasil diperbarui.',
            'data' => $activity->load('photos'),
        ]);
    }

    public function destroy(Activity $activity): JsonResponse
    {
        foreach ($activity->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        $activity->delete();

        return response()->json([
            'message' => 'Aktivitas berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     title?: string,
     *     description?: string|null,
     *     date?: string|null
     * }
     */
    private function validatedData(Request $request, bool $isCreating): array
    {
        $required = $isCreating ? ['required'] : ['sometimes', 'required'];

        $validated = $request->validate([
            'title' => [...$required, 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'date' => ['sometimes', 'nullable', 'date'],
        ]);

        if (! $isCreating && $validated === []) {
            throw ValidationException::withMessages([
                'activity' => 'Minimal satu data aktivitas harus dikirim.',
            ]);
        }

        return $validated;
    }
}
