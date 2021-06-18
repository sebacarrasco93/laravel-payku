<?php

return [
    

    /*
    |--------------------------------------------------------------------------
    | API data
    |--------------------------------------------------------------------------
    |
    | Copy the keys and place their values in your .env file
    | You can get it from https://app.payku.cl/usuarios/tokenintegracion
    |
    */

    'base_url' => env('PAYKU_BASE_URL'),
    'public_token' => env('PAYKU_PUBLIC_TOKEN'),
    'private_token' => env('PAYKU_PRIVATE_TOKEN'),

    
    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | You can change the "prefix" from the URL route, by default is: "payku"
    | So, the full "url" will be: https://yourdomain.com/payku
    |
    |
    */

    'route_prefix' => 'payku',


    /*
    |--------------------------------------------------------------------------
    | Finished Route name
    |--------------------------------------------------------------------------
    |
    | You can set a custom name for showing the final result of transaction
    |
    |
    */

    'route_finish_name' => env('PAYKU_ROUTE_FINISH_NAME', 'payku.result'),

];
