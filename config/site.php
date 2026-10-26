<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WhatsApp
    |--------------------------------------------------------------------------
    |
    | Every call to action on the public site opens this WhatsApp number.
    |
    */

    'whatsapp' => env('SITE_WHATSAPP', '525585808041'),

    'whatsapp_display' => '+52 55 8580 8041',

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | Languages the public site can be toggled to, keyed by locale code.
    |
    */

    'locales' => [
        'es' => 'ES',
        'zh_TW' => '繁中',
    ],

];
