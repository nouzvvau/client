<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function pendaftar(): RedirectResponse
    {
        return redirect()->route('admin.nama-murid');
    }

    public function booking(Request $request): View
    {
        $bookings = new LengthAwarePaginator(
            collect(),
            0,
            10,
            LengthAwarePaginator::resolveCurrentPage(),
            ['path' => route('admin.booking')]
        );

        $jumlahBaru = 0;
        $jumlahDikonfirmasi = 0;
        $jumlahDitolak = 0;

        return view('admincakraaji.bookingAcara', compact(
            'bookings',
            'jumlahBaru',
            'jumlahDikonfirmasi',
            'jumlahDitolak',
        ));
    }

    public function namaMurid(Request $request): View
    {
        $murids = Student::query()
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->cari.'%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $programs = Student::classOptions();

        return view('admincakraaji.namaMurid', compact('murids', 'programs'));
    }

    public function storeMurid(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_murid' => ['required', 'string', 'max:255'],
            'program_id' => ['nullable', 'string', Rule::in(Student::CLASSES)],
        ]);

        Student::create([
            'name' => $validated['nama_murid'],
            'class' => $validated['program_id'] ?? null,
        ]);

        return back()->with('success', 'Murid berhasil ditambahkan.');
    }

    public function updateMurid(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'nama_murid' => ['required', 'string', 'max:255'],
            'program_id' => ['nullable', 'string', Rule::in(Student::CLASSES)],
        ]);

        $student->name = $validated['nama_murid'];

        if (array_key_exists('program_id', $validated)) {
            $student->class = $validated['program_id'];
        }

        $student->save();

        return back()->with('success', 'Nama murid berhasil diperbarui.');
    }

    public function destroyMurid(Student $student): RedirectResponse
    {
        $student->delete();

        return back()->with('success', 'Murid berhasil dihapus.');
    }
}
