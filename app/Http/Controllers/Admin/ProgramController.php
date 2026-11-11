<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index()
    {
        return response()->json(
            Program::withCount(['students', 'schedules', 'registrations'])
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('programs', 'public');
        }

        $validated['is_active'] = $validated['is_active'] ?? true;

        $program = Program::create($validated);

        return response()->json([
            'message' => 'Program berhasil ditambahkan.',
            'data' => $program,
        ], 201);
    }

    public function show(Program $program)
    {
        return response()->json(
            $program->load(['students', 'schedules.location', 'registrations'])
        );
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }

            $validated['image'] = $request->file('image')
                ->store('programs', 'public');
        }

        $program->update($validated);

        return response()->json([
            'message' => 'Program berhasil diperbarui.',
            'data' => $program,
        ]);
    }

    public function destroy(Program $program)
    {
        if (
            $program->schedules()->exists() ||
            $program->registrations()->exists() ||
            $program->students()->exists()
        ) {
            return response()->json([
                'message' => 'Program memiliki relasi atau riwayat. Nonaktifkan program daripada menghapus permanen.',
            ], 422);
        }

        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        return response()->json([
            'message' => 'Program berhasil dihapus.',
        ]);
    }
}
