<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Str;

class ProgramPageController extends Controller
{
    public function index()
    {
        $activities = Activity::query()
            ->with('photos')
            ->orderByDesc('date')
            ->get();

        return view('program', [
            'activities' => $activities,
        ]);
    }

    public function detail(string $slug)
    {
        $activity = Activity::query()
            ->with('photos')
            ->orderByDesc('date')
            ->get()
            ->first(fn (Activity $activity): bool => Str::slug($activity->title) === $slug);

        abort_unless($activity !== null, 404);

        $others = Activity::query()
            ->where('id', '!=', $activity->id)
            ->orderByDesc('date')
            ->limit(4)
            ->get()
            ->map(fn (Activity $activity): array => [
                'title' => $activity->title,
                'slug' => Str::slug($activity->title),
            ]);

        return view('detail-kegiatan', [
            'activity' => $activity,
            'others' => $others,
        ]);
    }
}
