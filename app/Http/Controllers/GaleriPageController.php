<?php

namespace App\Http\Controllers;

use App\Models\GalleryPhoto;
use Illuminate\View\View;

class GaleriPageController extends Controller
{
    public function index(): View
    {
        return view('galeri', [
            'photos' => GalleryPhoto::query()
                ->latest()
                ->get(),
        ]);
    }
}
