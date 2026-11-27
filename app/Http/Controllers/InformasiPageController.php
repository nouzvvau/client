<?php

namespace App\Http\Controllers;

use App\Support\WhatsApp;
use Illuminate\View\View;

class InformasiPageController extends Controller
{
    public function kontak(): View
    {
        return view('kontak', [
            'contactPersons' => collect(),
            'whatsappLink' => WhatsApp::link(),
            'whatsappCtaLabel' => WhatsApp::ctaLabel(),
        ]);
    }

    public function faq(): View
    {
        return view('tanya-jawab', [
            'whatsappLink' => WhatsApp::link(),
        ]);
    }

    public function booking(): View
    {
        return view('booking');
    }
}
