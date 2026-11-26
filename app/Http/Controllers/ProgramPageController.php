<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\View\View;

class ProgramPageController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()
            ->active()
            ->with('thumbnailPhotos')
            ->orderBy('name')
            ->get();

        return view('program', compact('programs'));
    }

    public function detail(string $slug): View
    {
        $program = Program::query()
            ->active()
            ->with('documentations.photos')
            ->get()
            ->first(
                fn (Program $program): bool => $program->slug === $slug
            );

        abort_if($program === null, 404);

        $others = Program::query()
            ->active()
            ->whereKeyNot($program->getKey())
            ->orderBy('name')
            ->get();

        return view('detail-kegiatan', compact('program', 'others'));
    }
}