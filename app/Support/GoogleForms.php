<?php

namespace App\Support;

final class GoogleForms
{
    private const FORMS = [
        'registration' => [
            'config' => 'forms.registration_url',
            'fallback' => 'pendaftaran.index',
        ],
        'booking' => [
            'config' => 'forms.booking_url',
            'fallback' => 'booking',
        ],
    ];

    public static function url(string $form): string
    {
        $definition = self::definition($form);
        $url = self::configuredUrl($definition['config']);

        return $url ?? route($definition['fallback']);
    }

    public static function isExternal(string $form): bool
    {
        return self::configuredUrl(self::definition($form)['config']) !== null;
    }

    private static function configuredUrl(string $configKey): ?string
    {
        $url = config($configKey);

        if (! is_string($url)) {
            return null;
        }

        $url = trim($url);
        $scheme = parse_url($url, PHP_URL_SCHEME);

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        return in_array($scheme, ['http', 'https'], true) ? $url : null;
    }

    /**
     * @return array{config: string, fallback: string}
     */
    private static function definition(string $form): array
    {
        if (! isset(self::FORMS[$form])) {
            throw new \InvalidArgumentException("Form [{$form}] tidak dikenali.");
        }

        return self::FORMS[$form];
    }
}
