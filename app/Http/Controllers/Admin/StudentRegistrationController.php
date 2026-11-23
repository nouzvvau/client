<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Student;
use App\Models\StudentRegistration;
use App\Support\WhatsApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = StudentRegistration::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = '%'.trim((string) $request->input('q')).'%';

                $query->where(function ($query) use ($term): void {
                    $query->where('name', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhere('guardian_name', 'like', $term)
                        ->orWhere('program', 'like', $term);
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->input('status'));
            })
            ->when($request->filled('program'), function ($query) use ($request): void {
                $query->where('program', $request->input('program'));
            })
            ->latest('created_at')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => StudentRegistration::query()->count(),
            'pending' => StudentRegistration::query()->where('status', StudentRegistration::STATUS_PENDING)->count(),
            'accepted' => StudentRegistration::query()->where('status', StudentRegistration::STATUS_ACCEPTED)->count(),
            'rejected' => StudentRegistration::query()->where('status', StudentRegistration::STATUS_REJECTED)->count(),
        ];

        $programs = Program::query()
            ->orderBy('name')
            ->pluck('name')
            ->merge(
                StudentRegistration::query()
                    ->whereNotNull('program')
                    ->where('program', '!=', '')
                    ->distinct()
                    ->orderBy('program')
                    ->pluck('program')
            )
            ->unique()
            ->values();

        return view('admincakraaji.registrations.index', compact('registrations', 'stats', 'programs'));
    }

    public function create(): View
    {
        return view('admincakraaji.registrations.create', [
            'programs' => $this->programOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRegistration($request);

        $registration = StudentRegistration::create($validated);

        return redirect()
            ->route('admin.registrations.show', $registration)
            ->with('success', 'Data pendaftar berhasil ditambahkan.');
    }

    public function show(StudentRegistration $registration): View
    {
        $registration->load('student');

        return view('admincakraaji.registrations.show', [
            'registration' => $registration,
            'whatsappLink' => WhatsApp::link(
                'Halo '.$registration->name.', kami dari Sanggar Cakra Aji ingin menindaklanjuti pendaftaran Anda.',
                $registration->phone
            ),
        ]);
    }

    public function edit(StudentRegistration $registration): View
    {
        return view('admincakraaji.registrations.edit', [
            'registration' => $registration,
            'programs' => $this->programOptions($registration->program),
        ]);
    }

    public function update(Request $request, StudentRegistration $registration): RedirectResponse
    {
        $validated = $this->validateRegistration($request);

        $registration->update($validated);

        return redirect()
            ->route('admin.registrations.show', $registration)
            ->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    public function updateStatus(Request $request, StudentRegistration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(StudentRegistration::STATUSES)],
        ]);

        $registration->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    public function convert(StudentRegistration $registration): RedirectResponse
    {
        if ($registration->student_id !== null) {
            return back()->with('error', 'Pendaftar ini sudah dikonversi menjadi murid.');
        }

        $student = DB::transaction(function () use ($registration): Student {
            $name = trim($registration->name);
            $program = $registration->program === null ? null : trim($registration->program);

            $student = Student::query()
                ->whereRaw('LOWER(name) = ?', [Str::lower($name)])
                ->get()
                ->first(fn (Student $candidate): bool => trim((string) $candidate->class) === (string) $program);

            if ($student === null) {
                $student = Student::create([
                    'name' => $name,
                    'class' => $program !== '' ? $program : null,
                    'status' => Student::STATUS_ACTIVE,
                    'joined_at' => now()->toDateString(),
                ]);
            }

            $registration->update([
                'student_id' => $student->getKey(),
                'status' => StudentRegistration::STATUS_ACCEPTED,
            ]);

            return $student;
        });

        return back()->with('success', "Pendaftar berhasil dijadikan murid: {$student->name}.");
    }

    public function destroy(StudentRegistration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateRegistration(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'address' => ['nullable', 'string', 'max:1000'],
            'program' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', Rule::in(StudentRegistration::STATUSES)],
        ]);

        $validated['status'] = $validated['status'] ?? StudentRegistration::STATUS_PENDING;

        return $validated;
    }

    /**
     * @return \Illuminate\Support\Collection<int, string>
     */
    private function programOptions(?string $current = null): \Illuminate\Support\Collection
    {
        $options = Program::query()->orderBy('name')->pluck('name');

        if ($current !== null && $current !== '' && ! $options->contains($current)) {
            $options->push($current);
        }

        return $options->unique()->values();
    }
}
