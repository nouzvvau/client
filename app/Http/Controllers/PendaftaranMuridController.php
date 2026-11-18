<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranMurid;
use Illuminate\Http\Request;

class PendaftaranMuridController extends Controller
{
    public function index()
    {
        return view('pendaftaran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_murid' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'nama_wali' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'program' => 'required|string|max:255',
            'pengalaman' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ], [
            'nama_murid.required' => 'Nama lengkap calon murid wajib diisi.',
            'nama_murid.max' => 'Nama lengkap calon murid maksimal 255 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.',
            'nama_wali.required' => 'Nama orang tua / wali wajib diisi.',
            'nama_wali.max' => 'Nama orang tua / wali maksimal 255 karakter.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.max' => 'Nomor WhatsApp maksimal 20 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'program.required' => 'Program yang diminati wajib dipilih.',
            'pengalaman.required' => 'Pengalaman bermusik wajib diisi.',
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
