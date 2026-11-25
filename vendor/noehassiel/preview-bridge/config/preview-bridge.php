<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | Like APP_DEBUG: off by default and off in production. Turn it on only on
    | the preview server. While false the package does nothing at all: no
    | script, no headers, nothing in the HTML.
    |
    */

    'enabled' => (bool) env('PREVIEW_BRIDGE', false),

    /*
    |--------------------------------------------------------------------------
    | Portal origin
    |--------------------------------------------------------------------------
    |
    | The only site allowed to show this one in an iframe and to receive the
    | page the client is on. Scheme and host, no path or trailing slash.
    |
    */

    'portal_origin' => env('PREVIEW_BRIDGE_PORTAL', 'https://noehassiel.com'),

];
