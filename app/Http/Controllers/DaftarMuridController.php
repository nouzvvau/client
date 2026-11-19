<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarMuridController extends Controller
{
    public function index(Request $request): View
    {
        $murids = Student::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('murid', compact('murids'));
    }
}
