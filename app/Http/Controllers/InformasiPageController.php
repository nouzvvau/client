<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class InformasiPageController extends Controller
{
    public function kontak(): View
    {
        return view('kontak', [
            'locations' => collect(),
            'contactPersons' => collect(),
        ]);
    }

    public function faq(): View
    {
        return view('tanya-jawab');
    }

    public function booking(): View
    {
        return view('booking');
    }
}
