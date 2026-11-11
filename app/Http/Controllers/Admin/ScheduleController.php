<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Schedule::with(['program', 'location'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatedData($request, true);
        $this->ensureEndTimeAfterStartTime($validated['start_time'], $validated['end_time']);

        $schedule = Schedule::create($validated);

        return response()->json([
            'message' => 'Jadwal berhasil ditambahkan.',
            'data' => $schedule->load(['program', 'location']),
        ], 201);
    }

    public function show(Schedule $schedule): JsonResponse
    {
        return response()->json($schedule->load(['program', 'location']));
    }

    public function update(Request $request, Schedule $schedule): JsonResponse
    {
        $validated = $this->validatedData($request, false);
        $this->ensureEndTimeAfterStartTime(
            $validated['start_time'] ?? $schedule->start_time,
            $validated['end_time'] ?? $schedule->end_time
        );

        $schedule->update($validated);

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui.',
            'data' => $schedule->load(['program', 'location']),
        ]);
    }

    public function destroy(Schedule $schedule): JsonResponse
    {
        $schedule->delete();

        return response()->json([
            'message' => 'Jadwal berhasil dihapus.',
        ]);
    }

    /**
     * @return array{
     *     program_id?: int|string,
     *     location_id?: int|string,
     *     day_of_week?: string,
     *     start_time?: string,
     *     end_time?: string
     * }
     */
    private function validatedData(Request $request, bool $isCreating): array
    {
        $required = $isCreating ? ['required'] : ['sometimes', 'required'];

        $validated = $request->validate([
            'program_id' => [...$required, 'integer', 'exists:programs,id'],
            'location_id' => [...$required, 'integer', 'exists:locations,id'],
            'day_of_week' => [...$required, 'string', Rule::in([
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu',
            ])],
            'start_time' => [...$required, 'date_format:H:i'],
            'end_time' => [...$required, 'date_format:H:i'],
        ]);

        if (! $isCreating && $validated === []) {
            throw ValidationException::withMessages([
                'schedule' => 'Minimal satu data jadwal harus dikirim.',
            ]);
        }

        return $validated;
    }

    private function ensureEndTimeAfterStartTime(?string $startTime, ?string $endTime): void
    {
        if ($startTime === null || $endTime === null) {
            return;
        }

        if (strtotime($endTime) <= strtotime($startTime)) {
            throw ValidationException::withMessages([
                'end_time' => 'Jam selesai harus lebih lambat dari jam mulai.',
            ]);
        }
    }
}
