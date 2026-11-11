<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentProgramController extends Controller
{
    // Menambahkan murid ke program
    public function store(Request $request, Student $student): JsonResponse
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
            'joined_at' => ['nullable', 'date'],
        ]);

        $program = Program::findOrFail($validated['program_id']);

        if ($student->programs()->where('program_id', $program->id)->exists()) {
            return response()->json([
                'message' => 'Murid sudah terdaftar pada program ini.',
            ], 422);
        }

        $student->programs()->attach($program->id, [
            'status' => $validated['status'] ?? 'active',
            'joined_at' => $validated['joined_at'] ?? null,
        ]);

        return response()->json([
            'message' => 'Murid berhasil ditambahkan ke program.',
            'data' => $student->load('programs'),
        ], 201);
    }

    // Mengubah status keanggotaan murid pada program
    public function update(Request $request, Student $student, Program $program): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['sometimes', 'required', Rule::in(['active', 'inactive'])],
            'joined_at' => ['sometimes', 'nullable', 'date'],
        ]);

        if ($validated === []) {
            return response()->json([
                'message' => 'Minimal satu data keanggotaan harus dikirim.',
            ], 422);
        }

        if (! $student->programs()->where('program_id', $program->id)->exists()) {
            return response()->json([
                'message' => 'Murid tidak terdaftar pada program ini.',
            ], 404);
        }

        $student->programs()->updateExistingPivot(
            $program->id,
            $validated
        );

        return response()->json([
            'message' => 'Keanggotaan program berhasil diperbarui.',
            'data' => $student->load('programs'),
        ]);
    }

    // Mengeluarkan murid dari program
    public function destroy(Student $student, Program $program): JsonResponse
    {
        $detached = $student->programs()->detach($program->id);

        if (! $detached) {
            return response()->json([
                'message' => 'Murid tidak terdaftar pada program ini.',
            ], 404);
        }

        return response()->json([
            'message' => 'Murid berhasil dikeluarkan dari program.',
        ]);
    }
}
