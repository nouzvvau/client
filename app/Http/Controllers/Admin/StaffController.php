<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class StaffController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Staff::orderBy('sort_order')->latest()->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatedData($request, true);
        $validated['photo'] = $this->storePhoto($request);
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $staff = Staff::create($validated);

        return response()->json([
            'message' => 'Staf berhasil ditambahkan.',
            'data' => $staff,
        ], 201);
    }

    public function show(Staff $staff): JsonResponse
    {
        return response()->json($staff);
    }

    public function update(Request $request, Staff $staff): JsonResponse
    {
        $validated = $this->validatedData($request, false);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($staff);
            $validated['photo'] = $this->storePhoto($request);
        } elseif (array_key_exists('photo', $validated) && $validated['photo'] === null) {
            $this->deletePhoto($staff);
        }

        $staff->update($validated);

        return response()->json([
            'message' => 'Staf berhasil diperbarui.',
            'data' => $staff,
        ]);
    }

    public function destroy(Staff $staff): JsonResponse
    {
        $this->deletePhoto($staff);
        $staff->delete();

        return response()->json([
            'message' => 'Staf berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     name?: string,
     *     position?: string,
     *     photo?: UploadedFile|null,
     *     description?: string|null,
     *     is_active?: bool|int|string,
     *     sort_order?: int|string
     * }
     */
    private function validatedData(Request $request, bool $isCreating): array
    {
        $required = $isCreating ? ['required'] : ['sometimes', 'required'];

        $validated = $request->validate([
            'name' => [...$required, 'string', 'max:255'],
            'position' => [...$required, 'string', 'max:255'],
            'photo' => ['sometimes', 'nullable', 'image', 'max:2048'],
            'description' => ['sometimes', 'nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer'],
        ]);

        if (! $isCreating && $validated === []) {
            throw ValidationException::withMessages([
                'staff' => 'Minimal satu data staf harus dikirim.',
            ]);
        }

        return $validated;
    }

    private function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        return $request->file('photo')->store('staff', 'public');
    }

    private function deletePhoto(Staff $staff): void
    {
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }
    }
}
