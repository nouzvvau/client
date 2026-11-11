<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Booking::latest()->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatedData($request, true);
        $validated['status'] = $validated['status'] ?? 'pending';

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking berhasil ditambahkan.',
            'data' => $booking,
        ], 201);
    }

    public function show(Booking $booking): JsonResponse
    {
        return response()->json($booking);
    }

    public function update(Request $request, Booking $booking): JsonResponse
    {
        $booking->update($this->validatedData($request, false));

        return response()->json([
            'message' => 'Booking berhasil diperbarui.',
            'data' => $booking,
        ]);
    }

    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();

        return response()->json([
            'message' => 'Booking berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     name?: string,
     *     phone?: string,
     *     institution_name?: string|null,
     *     service_type?: string,
     *     event_name?: string,
     *     event_date?: string,
     *     start_time?: string|null,
     *     event_location?: string,
     *     estimated_audience?: int|string|null,
     *     additional_notes?: string|null,
     *     status?: string
     * }
     */
    private function validatedData(Request $request, bool $isCreating): array
    {
        $required = $isCreating ? ['required'] : ['sometimes', 'required'];

        $validated = $request->validate([
            'name' => [...$required, 'string', 'max:255'],
            'phone' => [...$required, 'string', 'max:255'],
            'institution_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'service_type' => [...$required, 'string', 'max:255'],
            'event_name' => [...$required, 'string', 'max:255'],
            'event_date' => [...$required, 'date'],
            'start_time' => ['sometimes', 'nullable', 'date_format:H:i'],
            'event_location' => [...$required, 'string'],
            'estimated_audience' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'additional_notes' => ['sometimes', 'nullable', 'string'],
            'status' => ['sometimes', Rule::in(['pending', 'accepted', 'rejected'])],
        ]);

        if (! $isCreating && $validated === []) {
            throw ValidationException::withMessages([
                'booking' => 'Minimal satu data booking harus dikirim.',
            ]);
        }

        return $validated;
    }
}
