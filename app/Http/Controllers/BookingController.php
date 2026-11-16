<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(): View
    {
        return view('booking.acara');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:20', 'regex:/^[0-9+() -]{8,20}$/'],
            'organization' => ['nullable', 'string', 'max:160'],
            'event_type' => ['required', 'string', 'in:Pentas / pengisi acara,Pertunjukan seni,Workshop / pelatihan,Kolaborasi acara,Lainnya'],
            'event_name' => ['required', 'string', 'max:160'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'event_location' => ['required', 'string', 'max:200'],
            'audience_estimate' => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ], [
            'customer_name.required' => 'Nama pemesan wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Format nomor WhatsApp belum valid.',
            'event_type.required' => 'Pilih kebutuhan acara terlebih dahulu.',
            'event_name.required' => 'Nama acara wajib diisi.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_date.after_or_equal' => 'Tanggal acara tidak boleh berada di masa lalu.',
            'event_location.required' => 'Lokasi acara wajib diisi.',
        ]);

        BookingRequest::create($validated);

        return redirect()->route('booking.create')
            ->with('success', 'Permintaan booking berhasil dikirim dan tersimpan. Admin akan menghubungi kamu melalui WhatsApp.');
    }
}
