<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayMaya Keys
    |--------------------------------------------------------------------------
    |
    | The PayMaya API keys used to consume PayMaya API
    | The public_key is usually used to send data, while secret_key is used to
    | access private endpoints
    |
    */
    'public_key' => env('PAYMAYA_PUBLIC_KEY'),

    'secret_key' => env('PAYMAYA_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | PayMaya Path
    |--------------------------------------------------------------------------
    |
    | This is the base URI where the PayMaya boiler plate's resources, 
    | will be available such as the webhook route.
    |
    */
    'path' => env('PAYMAYA_PATH', 'paymaya'),

    /*
    |--------------------------------------------------------------------------
    | Sandbox Mode
    |--------------------------------------------------------------------------
    |
    | Set to true to use sandbox mode
    | Set to false to use production mode
    |
    */
    'sandbox' => env('PAYMAYA_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Default currency to use
    |
    */
    'currency' => env('PAYMAYA_CURRENCY', 'PHP'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Routes
    |--------------------------------------------------------------------------
    |
    | The routes that will be accessed by PayMaya endpoint
    |
    */
    'webhook_routes' => [
        'CHECKOUT_SUCCESS' => 'paymaya.webhook.checkout.success',
        'CHECKOUT_FAILURE' => 'paymaya.webhook.checkout.failure',
        'CHECKOUT_DROPOUT' => 'paymaya.webhook.checkout.expiry',
    ],
];
