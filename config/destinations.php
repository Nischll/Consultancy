<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supported destination countries
    |--------------------------------------------------------------------------
    | Use these for target_country (student) and country (university).
    | Add or remove countries as needed for your consultancy.
    */
    'countries' => [
        'Japan',
        'Canada',
        'USA',
        'Australia',
        'UK',
        'New Zealand',
        'Ireland',
        'Germany',
        'France',
        'Netherlands',
        'Singapore',
        'Malaysia',
        'South Korea',
        'Italy',
        'Spain',
        'Other',
    ],

    /*
    |--------------------------------------------------------------------------
    | Common language / proficiency tests by region
    |--------------------------------------------------------------------------
    | Japan: JLPT, JFT, NAT. English-speaking: IELTS, TOEFL, PTE, Duolingo.
    */
    'language_tests' => [
        'english' => ['IELTS', 'TOEFL', 'PTE', 'Duolingo', 'Other'],
        'japanese' => ['JLPT', 'JFT', 'NAT'],
    ],

];
