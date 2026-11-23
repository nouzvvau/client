<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['id', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        // Ambil bahasa dari session, default ke 'id'
        $locale = $request->session()->get('locale', 'id');

        if (! is_string($locale) || ! in_array($locale, self::SUPPORTED, true)) {
            $locale = 'id';
        }

        App::setLocale($locale);

        // PENTING: teks Indonesia dipakai sebagai kunci terjemahan (lang/en.json).
        // Fallback harus 'id' supaya saat bahasa Indonesia aktif, teks tidak
        // "jatuh" ke en.json dan tampil Inggris.
        App::setFallbackLocale('id');

        // Supaya nama bulan dari Carbon (translatedFormat) ikut berganti bahasa
        Carbon::setLocale($locale);

        return $next($request);
    }
}