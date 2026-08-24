<?php

return [
    'payglocal' => [
        'enabled' => env('PAYGLOCAL_ENABLED', false),
        'mode' => env('PAYGLOCAL_MODE', 'sandbox'),
        'merchant_id' => env('PAYGLOCAL_MERCHANT_ID', ''),
        'public_key_id' => env('PAYGLOCAL_PUBLIC_KEY_ID', ''),
        'private_key_id' => env('PAYGLOCAL_PRIVATE_KEY_ID', ''),
        'public_key_path' => env('PAYGLOCAL_PUBLIC_KEY_PATH', 'payments/payglocal/public.pem'),
        'private_key_path' => env('PAYGLOCAL_PRIVATE_KEY_PATH', 'payments/payglocal/private.pem'),
        'base_url' => env('PAYGLOCAL_BASE_URL', 'https://sandbox.payglocal.in'),
    ],

    'stripe' => [
        'enabled' => env('STRIPE_ENABLED', false),
        'mode' => env('STRIPE_MODE', 'sandbox'),
        'public_key' => env('STRIPE_PUBLIC_KEY', ''),
        'secret_key' => env('STRIPE_SECRET_KEY', ''),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
    ],

    'razorpay' => [
        'enabled' => env('RAZORPAY_ENABLED', false),
        'mode' => env('RAZORPAY_MODE', 'sandbox'),
        'key_id' => env('RAZORPAY_KEY_ID', ''),
        'key_secret' => env('RAZORPAY_KEY_SECRET', ''),
    ],
];
