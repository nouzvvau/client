<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index(Request $request)
    {
        $query = Murid::query();

        // Pencarian murid
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter program
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        // Filter tahun masuk
        if ($request->filled('tahun')) {
            $query->where('tahun_masuk', $request->tahun);
        }

        $murids = $query
            ->orderBy('nama', 'asc')
            ->paginate(12)
            ->withQueryString();

        $totalMurid = Murid::count();

        $totalProgram = Murid::distinct('program')
            ->count('program');

        $tahunMasuk = Murid::select('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'desc')
            ->pluck('tahun_masuk');

        return view('murid.index', compact(
            'murids',
            'totalMurid',
            'totalProgram',
            'tahunMasuk'
        ));
    }
}