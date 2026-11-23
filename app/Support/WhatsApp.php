<?php

namespace App\Support;

use App\Models\Setting;

final class WhatsApp
{
    public static function number(): ?string
    {
        $number = Setting::get('whatsapp_number', config('whatsapp.number'));

        return self::normalize($number);
    }

    public static function displayNumber(): ?string
    {
        $number = self::number();

        return $number === null ? null : '+'.$number;
    }

    public static function message(): string
    {
        $message = trim((string) Setting::get('whatsapp_message', config('whatsapp.message')));

        return $message !== '' ? $message : (string) config('whatsapp.message');
    }

    public static function ctaLabel(): string
    {
        $label = trim((string) Setting::get('whatsapp_cta_label', config('whatsapp.cta_label')));

        return $label !== '' ? $label : (string) config('whatsapp.cta_label');
    }

    public static function isConfigured(): bool
    {
        return self::number() !== null;
    }

    public static function link(?string $message = null, ?string $number = null): ?string
    {
        $number = $number === null ? self::number() : self::normalize($number);

        if ($number === null) {
            return null;
        }

        $text = trim($message ?? self::message());

        return 'https://wa.me/'.$number.($text === '' ? '' : '?text='.rawurlencode($text));
    }

    public static function normalize(?string $number): ?string
    {
        if ($number === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $number);

        if (! is_string($digits) || $digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62'.$digits;
        }

        $length = strlen($digits);

        if ($length < 8 || $length > 15) {
            return null;
        }

        return $digits;
    }
}
