<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranMurid;
use Illuminate\Http\Request;

class PendaftaranMuridController extends Controller
{
    public function index()
    {
        return view('pendaftaran.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_murid' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'nama_wali' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'program' => 'required|string|max:255',
            'pengalaman' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        PendaftaranMurid::create([
            'nama_murid' => $request->nama_murid,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama_wali' => $request->nama_wali,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'program' => $request->program,
            'pengalaman' => $request->pengalaman,
            'catatan' => $request->catatan,
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }
}