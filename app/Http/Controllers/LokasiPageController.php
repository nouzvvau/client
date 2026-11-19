<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LokasiPageController extends Controller
{
    public function index(): View
    {
        return view('lokasi', [
            'locations' => collect(),
        ]);
    }
}
