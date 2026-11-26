<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Support\WhatsApp;
use Illuminate\View\View;

class InformasiPageController extends Controller
{
    public function kontak(): View
    {
        $number = Setting::get(
            'whatsapp_number',
            config('whatsapp.number')
        );

        $message = Setting::get(
            'whatsapp_message',
            config('whatsapp.message')
        );

        $whatsappLink = filled($number)
            ? WhatsApp::link($message, $number)
            : null;

        return view('kontak', [
            'locations' => collect(),
            'contactPersons' => collect(),
            'whatsappLink' => $whatsappLink,
        ]);
    }

    public function faq(): View
    {
        return view('tanya-jawab');
    }

    public function booking(): View
    {
        return view('booking');
    }
}
