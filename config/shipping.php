<?php

return [
    // Client-supplied package presets, keyed by nominal piece size. Used to prefill the
    // admin product form and as the fallback when a product has no shipping info set yet.
    'presets' => [
        '24' => ['label' => '24 inch piece', 'weight_lbs' => 16, 'length_in' => 28, 'width_in' => 28, 'height_in' => 5],
        '30' => ['label' => '30 inch piece', 'weight_lbs' => 23, 'length_in' => 34, 'width_in' => 34, 'height_in' => 5],
        '36' => ['label' => '36 inch piece', 'weight_lbs' => 32, 'length_in' => 40, 'width_in' => 40, 'height_in' => 6],
        '46' => ['label' => '46 inch piece', 'weight_lbs' => 50, 'length_in' => 48, 'width_in' => 48, 'height_in' => 8],
    ],

    // Used for any product that has no weight/dimensions set. The client asked to estimate
    // high rather than undercharge, so this defaults to the largest preset.
    'fallback_preset' => '46',

    // Ship-from address for rate quotes and label purchases.
    'from_address' => [
        'name' => env('SHIP_FROM_NAME', 'JDM Custom Creations'),
        'street1' => env('SHIP_FROM_STREET1'),
        'city' => env('SHIP_FROM_CITY'),
        'state' => env('SHIP_FROM_STATE'),
        'zip' => env('SHIP_FROM_ZIP'),
        'country' => env('SHIP_FROM_COUNTRY', 'US'),
        'phone' => env('SHIP_FROM_PHONE'),
        'email' => env('SHIP_FROM_EMAIL'),
    ],

    // Service-level tokens (per carrier) treated as "standard/ground" for auto rate
    // selection, so we never accidentally pick an overnight/express rate as the "best" one.
    'standard_service_tokens' => [
        'usps_priority', 'usps_priority_mail', 'usps_ground_advantage', 'usps_parcel_select',
        'ups_ground', 'ups_surepost',
        'fedex_ground', 'fedex_home_delivery',
    ],
];
