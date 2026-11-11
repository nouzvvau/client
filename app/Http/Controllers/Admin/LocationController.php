<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Location::latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatedData($request, true);
        $validated['is_active'] = $validated['is_active'] ?? true;

        $location = Location::create($validated);

        return response()->json([
            'message' => 'Lokasi berhasil ditambahkan.',
            'data' => $location,
        ], 201);
    }

    public function show(Location $location): JsonResponse
    {
        return response()->json($location);
    }

    public function update(Request $request, Location $location): JsonResponse
    {
        $location->update($this->validatedData($request, false));

        return response()->json([
            'message' => 'Lokasi berhasil diperbarui.',
            'data' => $location,
        ]);
    }

    public function destroy(Location $location): JsonResponse
    {
        if ($location->schedules()->exists()) {
            return response()->json([
                'message' => 'Lokasi masih digunakan oleh jadwal. Hapus atau pindahkan jadwal terlebih dahulu.',
            ], 422);
        }

        $location->delete();

        return response()->json([
            'message' => 'Lokasi berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     name?: string,
     *     address?: string,
     *     description?: string|null,
     *     google_maps_url?: string,
     *     is_active?: bool|int|string
     * }
     */
    private function validatedData(Request $request, bool $isCreating): array
    {
        $required = $isCreating ? ['required'] : ['sometimes', 'required'];

        $validated = $request->validate([
            'name' => [...$required, 'string', 'max:255'],
            'address' => [...$required, 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
            'google_maps_url' => [...$required, 'url'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if (! $isCreating && $validated === []) {
            throw ValidationException::withMessages([
                'location' => 'Minimal satu data lokasi harus dikirim.',
            ]);
        }

        return $validated;
    }
}
