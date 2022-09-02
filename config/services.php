<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'smspoh' => [
        'endpoint' => env('SMSPOH_ENDPOINT', 'https://smspoh.com/api/v2/send'),
        'token' => env('SMSPOH_TOKEN', 'l0y8puv5LHZWwYcs4yuKa0AIf1SJifz4Hg5plGvdeNOUlnuj3g123ogxUAa9ZYo4'),
        'sender' => env('SMSPOH_SENDER', 'SMSPoh')
    ],

];
