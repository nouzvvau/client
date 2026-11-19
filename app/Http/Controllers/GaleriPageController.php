<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GaleriPageController extends Controller
{
    public function index(): View
    {
        return view('galeri', [
            'activities' => collect(),
            'schedules' => collect(),
        ]);
    }
}
