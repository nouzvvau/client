<?php

namespace App\Http\Controllers;

use App\Models\EventDocumentation;
use Illuminate\View\View;

class GaleriPageController extends Controller
{
    public function index(): View
    {
        return view('galeri', [
            'activities' => EventDocumentation::query()
                ->with('photos')
                ->orderByDesc('event_date')
                ->orderByDesc('id')
                ->get(),
            'schedules' => collect(),
        ]);
    }

    public function show(EventDocumentation $eventDocumentation): View
    {
        $eventDocumentation->load('photos');

        return view('galeri-acara', compact('eventDocumentation'));
    }
}
