<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProgramPageController extends Controller
{
    public function index(): View
    {
        return view('program', [
            'activities' => collect(),
        ]);
    }

    public function detail(string $slug): RedirectResponse
    {
        return redirect()->route('program');
    }
}
