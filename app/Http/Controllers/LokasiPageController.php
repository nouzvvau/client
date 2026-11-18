<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LokasiPageController extends Controller
{
    public function index()
    {
        $locations = Location::query()
            ->where('is_active', true)
            ->with(['schedules' => fn ($query) => $query->with('program')->orderBy('start_time')])
            ->orderBy('id')
            ->get();

        return view('lokasi', compact('locations'));
    }
}
