<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PendaftaranMuridController extends Controller
{
    public function index(): View
    {
        return view('pendaftaran');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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

        Student::create([
            'name' => $validated['nama_murid'],
            'class' => $validated['program'],
        ]);

        return redirect()
            ->route('pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
