<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Schedule;

class GaleriPageController extends Controller
{
    public function index()
    {
        $activities = Activity::query()
            ->with('photos')
            ->orderByDesc('date')
            ->get();

        $schedules = Schedule::query()
            ->with(['program', 'location'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return view('galeri', compact('activities', 'schedules'));
    }
}
