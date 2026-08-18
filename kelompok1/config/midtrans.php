<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    | Gunakan SANDBOX Server Key selama testing.
    | Format sandbox: SB-Mid-server-xxxxxxxxxxxx
    */
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    | Gunakan SANDBOX Client Key selama testing.
    | Format sandbox: SB-Mid-client-xxxxxxxxxxxx
    */
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Environment: Sandbox / Production
    |--------------------------------------------------------------------------
    | Selama testing, pastikan ini bernilai FALSE (Sandbox).
    | Set ke TRUE hanya jika sudah siap production.
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitize Input
    |--------------------------------------------------------------------------
    */
    'is_sanitized' => true,

    /*
    |--------------------------------------------------------------------------
    | 3D Secure
    |--------------------------------------------------------------------------
    */
    'is_3ds' => true,

    /*
    |--------------------------------------------------------------------------
    | Snap JS URL
    |--------------------------------------------------------------------------
    | URL diambil dinamis berdasarkan environment.
    | Sandbox  : https://app.sandbox.midtrans.com/snap/snap.js
    | Production: https://app.midtrans.com/snap/snap.js
    */
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

];
