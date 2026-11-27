<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventDocumentation;
use App\Models\EventDocumentationPhoto;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function dashboard(): View
    {
        return view('admincakraaji.dashboard', [
            'jumlahMurid' => Student::query()->count(),
            'jumlahProgramAktif' => Program::query()->active()->count(),
            'jumlahProgramNonaktif' => Program::query()->where('is_active', false)->count(),
            'jumlahDokumentasi' => EventDocumentation::query()->count(),
            'jumlahFoto' => EventDocumentationPhoto::query()->count(),
            'dokumentasiTerbaru' => EventDocumentation::query()
                ->with('photos')
                ->orderByDesc('event_date')
                ->orderByDesc('id')
                ->limit(3)
                ->get(),
        ]);
    }

    public function namaMurid(Request $request): View
    {
        $murids = Student::query()
            ->when($request->filled('cari'), function ($query) use ($request): void {
                $query->where('name', 'like', '%'.trim((string) $request->input('cari')).'%');
            })
            ->when($request->filled('kelas'), function ($query) use ($request): void {
                $query->where('class', $request->input('kelas'));
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Student::query()->count(),
            'active' => Student::query()->where('status', Student::STATUS_ACTIVE)->count(),
            'inactive' => Student::query()->where('status', Student::STATUS_INACTIVE)->count(),
            'with_class' => Student::query()->whereNotNull('class')->where('class', '!=', '')->count(),
        ];

        return view('admincakraaji.namaMurid', [
            'murids' => $murids,
            'programs' => Student::classOptions(),
            'classes' => Student::CLASSES,
            'statuses' => Student::statusOptions(),
            'stats' => $stats,
        ]);
    }

    public function storeMurid(Request $request): RedirectResponse
    {
        $validated = $this->validateMurid($request);

        Student::create([
            'name' => $validated['nama_murid'],
            'class' => $validated['program_id'] ?? null,
            'status' => $validated['status'] ?? Student::STATUS_ACTIVE,
            'joined_at' => $validated['joined_at'] ?? null,
        ]);

        return back()->with('success', 'Murid berhasil ditambahkan.');
    }

    public function editMurid(Student $student): View
    {
        return view('admincakraaji.murid-edit', [
            'student' => $student,
            'programs' => Student::classOptions(),
            'statuses' => Student::statusOptions(),
        ]);
    }

    public function updateMurid(Request $request, Student $student): RedirectResponse
    {
        $validated = $this->validateMurid($request);

        $student->name = $validated['nama_murid'];

        if (array_key_exists('program_id', $validated)) {
            $student->class = $validated['program_id'];
        }

        if (array_key_exists('status', $validated)) {
            $student->status = $validated['status'] ?? Student::STATUS_ACTIVE;
        }

        if (array_key_exists('joined_at', $validated)) {
            $student->joined_at = $validated['joined_at'];
        }

        $student->save();

        return redirect()
            ->route('admin.nama-murid')
            ->with('success', 'Data murid berhasil diperbarui.');
    }

    public function destroyMurid(Student $student): RedirectResponse
    {
        $student->delete();

        return back()->with('success', 'Murid berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateMurid(Request $request): array
    {
        return $request->validate([
            'nama_murid' => ['required', 'string', 'max:255'],
            'program_id' => ['nullable', 'string', Rule::in(Student::CLASSES)],
            'status' => ['nullable', Rule::in(Student::STATUSES)],
            'joined_at' => ['nullable', 'date'],
        ]);
    }
}
