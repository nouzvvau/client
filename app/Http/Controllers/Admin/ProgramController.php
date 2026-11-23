<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(Request $request): View
    {
        $programs = Program::query()
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->cari.'%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admincakraaji.program', compact('programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProgram($request);

        Program::create($validated);

        return back()->with('success', 'Program & kegiatan berhasil ditambahkan.');
    }

    public function edit(Program $program): View
    {
        return view('admincakraaji.program-edit', compact('program'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $validated = $this->validateProgram($request);

        $program->update($validated);

        return redirect()
            ->route('admin.program.index')
            ->with('success', 'Program & kegiatan berhasil diperbarui.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return back()->with('success', 'Program & kegiatan berhasil dihapus.');
    }

    /**
     * @return array{name: string, name_en: ?string, schedule: ?string, schedule_en: ?string, description: ?string, description_en: ?string, image: ?string, is_active: bool}
     */
    private function validateProgram(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'schedule_en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
