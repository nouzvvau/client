<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Registration::with('program')->latest()->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatedData($request, true);
        $validated['status'] = $validated['status'] ?? 'pending';

        $registration = Registration::create($validated);

        return response()->json([
            'message' => 'Pendaftaran berhasil ditambahkan.',
            'data' => $registration->load('program'),
        ], 201);
    }

    public function show(Registration $registration): JsonResponse
    {
        return response()->json($registration->load('program'));
    }

    public function update(Request $request, Registration $registration): JsonResponse
    {
        $registration->update($this->validatedData($request, false));

        return response()->json([
            'message' => 'Pendaftaran berhasil diperbarui.',
            'data' => $registration->load('program'),
        ]);
    }

    public function destroy(Registration $registration): JsonResponse
    {
        $registration->delete();

        return response()->json([
            'message' => 'Pendaftaran berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     full_name?: string,
     *     birth_date?: string,
     *     guardian_name?: string,
     *     contact_phone?: string,
     *     address?: string|null,
     *     program_id?: int|string,
     *     music_experience?: string|null,
     *     notes?: string|null,
     *     status?: string
     * }
     */
    private function validatedData(Request $request, bool $isCreating): array
    {
        $required = $isCreating ? ['required'] : ['sometimes', 'required'];

        $validated = $request->validate([
            'full_name' => [...$required, 'string', 'max:255'],
            'birth_date' => [...$required, 'date', 'before_or_equal:today'],
            'guardian_name' => [...$required, 'string', 'max:255'],
            'contact_phone' => [...$required, 'string', 'max:20'],
            'address' => ['sometimes', 'nullable', 'string'],
            'program_id' => [...$required, 'integer', 'exists:programs,id'],
            'music_experience' => ['sometimes', 'nullable', 'string'],
            'notes' => ['sometimes', 'nullable', 'string'],
            'status' => ['sometimes', Rule::in(['pending', 'completed', 'rejected'])],
        ]);

        if (! $isCreating && $validated === []) {
            throw ValidationException::withMessages([
                'registration' => 'Minimal satu data pendaftaran harus dikirim.',
            ]);
        }

        return $validated;
    }
}
