<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingPublicController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:255'],
            'event_name' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'event_location' => ['required', 'string'],
            'estimated_audience' => ['nullable', 'integer', 'min:0'],
            'additional_notes' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama pemesan wajib diisi.',
            'name.max' => 'Nama pemesan maksimal 255 karakter.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.max' => 'Nomor WhatsApp maksimal 255 karakter.',
            'institution_name.max' => 'Nama instansi maksimal 255 karakter.',
            'service_type.required' => 'Jenis layanan wajib diisi.',
            'service_type.max' => 'Jenis layanan maksimal 255 karakter.',
            'event_name.required' => 'Nama acara wajib diisi.',
            'event_name.max' => 'Nama acara maksimal 255 karakter.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_date.date' => 'Tanggal acara harus berupa tanggal yang valid.',
            'start_time.date_format' => 'Jam mulai harus berformat jam:menit, contoh 09:00.',
            'event_location.required' => 'Lokasi acara wajib diisi.',
            'estimated_audience.integer' => 'Estimasi jumlah peserta harus berupa angka.',
            'estimated_audience.min' => 'Estimasi jumlah peserta tidak boleh negatif.',
        ]);

        return redirect()
            ->route('booking')
            ->withErrors([
                'booking' => 'Formulir booking belum dapat disimpan karena penyimpanan data booking tidak lagi tersedia.',
            ]);
    }
}
