<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PendaftaranMuridController extends Controller
{
    public function index(): View
    {
        return view('pendaftaran');
    }
}
