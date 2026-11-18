<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class DaftarMuridController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('programs')->where('status', 'active');

        // Pencarian murid
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%'.$request->search.'%');
        }

        // Filter program
        if ($request->filled('program')) {
            $query->whereHas('programs', function ($programQuery) use ($request) {
                $programQuery->where('programs.id', $request->program);
            });
        }

        // Filter tahun masuk
        if ($request->filled('tahun')) {
            $query->whereYear('joined_at', $request->tahun);
        }

        $murids = $query
            ->orderBy('full_name', 'asc')
            ->paginate(12)
            ->withQueryString();

        $totalMurid = Student::where('status', 'active')->count();

        $totalProgram = Student::where('status', 'active')
            ->with('programs')
            ->get()
            ->pluck('programs')
            ->flatten()
            ->unique('id')
            ->count();

        $tahunMasuk = Student::where('status', 'active')
            ->whereNotNull('joined_at')
            ->get()
            ->map(fn (Student $student) => $student->joined_at?->year)
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        return view('murid', compact(
            'murids',
            'totalMurid',
            'totalProgram',
            'tahunMasuk'
        ));
    }
}
