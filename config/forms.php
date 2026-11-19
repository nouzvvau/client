<?php

return [

    /*
    |--------------------------------------------------------------------------
    | External registration & booking forms
    |--------------------------------------------------------------------------
    |
    | Isi dengan URL Google Forms yang sudah dipublikasikan. Selama nilainya
    | kosong, tombol akan kembali ke halaman internal agar situs tetap utuh.
    |
    */

    'registration_url' => env('GOOGLE_FORM_PENDAFTARAN_URL'),

    'booking_url' => env('GOOGLE_FORM_BOOKING_URL'),

];
