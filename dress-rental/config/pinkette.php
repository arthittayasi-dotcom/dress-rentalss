<?php

return [
    'bank_name' => env('WANWAN_BANK_NAME', env('PINKETTE_BANK_NAME')),
    'account_name' => env('WANWAN_ACCOUNT_NAME', env('PINKETTE_ACCOUNT_NAME')),
    'account_number' => env('WANWAN_ACCOUNT_NUMBER', env('PINKETTE_ACCOUNT_NUMBER')),
    'address' => env('WANWAN_ADDRESS', env('PINKETTE_ADDRESS')),
    'contact' => env('WANWAN_CONTACT', env('PINKETTE_CONTACT')),
    'slip_api_key' => env('EASYSLIP_API_KEY'),
];
