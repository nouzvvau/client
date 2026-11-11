<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    // Menampilkan daftar murid
    public function index()
    {
        $students = Student::with('programs')
            ->orderBy('full_name')
            ->get();

        return response()->json($students);
    }

    // Menambahkan murid
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'joined_at' => ['nullable', 'date'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ]);

        $validated['status'] = $validated['status'] ?? 'active';

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Murid berhasil ditambahkan.',
            'data' => $student,
        ], 201);
    }

    // Menampilkan detail murid
    public function show(Student $student)
    {
        $student->load('programs');

        return response()->json($student);
    }

    // Mengubah data murid
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_name' => ['sometimes', 'required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'joined_at' => ['nullable', 'date'],
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Data murid berhasil diperbarui.',
            'data' => $student,
        ]);
    }

    // Menghapus murid
    public function destroy(Student $student)
    {
        if ($student->programs()->exists()) {
            return response()->json([
                'message' => 'Murid masih memiliki hubungan dengan program. Lepaskan dari program terlebih dahulu.',
            ], 422);
        }

        $student->delete();

        return response()->json([
            'message' => 'Murid berhasil dihapus.',
        ]);
    }
}
