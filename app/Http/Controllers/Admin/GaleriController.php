<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class GaleriController extends Controller
{
    public function index(Request $request): View
    {
        $activities = new LengthAwarePaginator(
            collect(),
            0,
            10,
            LengthAwarePaginator::resolveCurrentPage(),
            ['path' => route('admin.galeri')]
        );

        return view('admincakraaji.galeri', compact('activities'));
    }

    public function create(): View
    {
        return view('admincakraaji.galeri-tambah');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        return back()->withErrors([
            'galeri' => 'Data galeri belum dapat disimpan karena penyimpanan data galeri tidak lagi tersedia.',
        ]);
    }
}
