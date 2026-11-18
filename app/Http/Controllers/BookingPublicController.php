<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingPublicController extends Controller
{
    /**
     * Menyimpan permintaan booking acara dari pengunjung website (tanpa login).
     *
     * Field `status` tidak pernah diterima dari input pengunjung dan selalu
     * dipaksa menjadi 'pending' oleh server.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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

        Booking::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'institution_name' => $validated['institution_name'] ?? null,
            'service_type' => $validated['service_type'],
            'event_name' => $validated['event_name'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'event_location' => $validated['event_location'],
            'estimated_audience' => $validated['estimated_audience'] ?? null,
            'additional_notes' => $validated['additional_notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('booking')
            ->with('success', 'Permintaan booking berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp.');
    }
}
