<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WhatsApp contact defaults
    |--------------------------------------------------------------------------
    |
    | Nilai ini dipakai sebagai cadangan ketika pengaturan WhatsApp belum
    | diisi melalui panel admin. Pengaturan yang disimpan di database akan
    | selalu diprioritaskan.
    |
    */

    'number' => env('WHATSAPP_NUMBER'),

    'message' => env('WHATSAPP_DEFAULT_MESSAGE', 'Halo Sanggar Cakra Aji, saya ingin bertanya.'),

    'cta_label' => env('WHATSAPP_CTA_LABEL', 'Hubungi via WhatsApp'),

];
