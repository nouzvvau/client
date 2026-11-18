<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Staff;
use Illuminate\View\View;

class InformasiPageController extends Controller
{
    public function kontak(): View
    {
        $locations = Location::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->with('schedules')
            ->get();

        $contactPersons = Staff::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('kontak', compact('locations', 'contactPersons'));
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
