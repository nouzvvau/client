<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\WhatsApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WhatsAppSettingController extends Controller
{
    public function edit(): View
    {
        $number = Setting::get('whatsapp_number', config('whatsapp.number'));
        $message = Setting::get('whatsapp_message', config('whatsapp.message'));
        $ctaLabel = Setting::get('whatsapp_cta_label', config('whatsapp.cta_label'));

        return view('admincakraaji.kontak', [
            'number' => $number,
            'message' => $message,
            'ctaLabel' => $ctaLabel,
            'previewLink' => WhatsApp::link($message, $number),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_number' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]*$/'],
            'whatsapp_message' => ['nullable', 'string', 'max:1000'],
            'whatsapp_cta_label' => ['nullable', 'string', 'max:50'],
        ]);

        $rawNumber = trim((string) ($validated['whatsapp_number'] ?? ''));
        $normalizedNumber = $rawNumber === '' ? null : WhatsApp::normalize($rawNumber);

        if ($rawNumber !== '' && $normalizedNumber === null) {
            throw ValidationException::withMessages([
                'whatsapp_number' => 'Nomor WhatsApp tidak valid. Gunakan format seperti 0812-3456-7890 atau 6281234567890.',
            ]);
        }

        $message = trim((string) ($validated['whatsapp_message'] ?? ''));
        $ctaLabel = trim((string) ($validated['whatsapp_cta_label'] ?? ''));

        Setting::setMany([
            'whatsapp_number' => $normalizedNumber,
            'whatsapp_message' => $message === '' ? null : $message,
            'whatsapp_cta_label' => $ctaLabel === '' ? null : $ctaLabel,
        ]);

        return back()->with('success', 'Pengaturan WhatsApp berhasil disimpan.');
    }
}
