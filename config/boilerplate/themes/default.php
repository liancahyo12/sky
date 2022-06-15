<?php

/**
 * BG : blue, indigo, purple, pink, red, orange, yellow, green, teal, cyan, gray, gray-dark, black
 * Type : dark, light
 * Shadow : 0-4.
 */
return [
    'navbar'  => [
        'bg'     => 'white',
        'type'   => 'light',
        'border' => true,
        'user'   => [
            'visible' => false,
            'shadow'  => 0,
        ],
    ],
    'sidebar' => [
        'type'    => 'dark',
        'shadow'  => 4,
        'border'  => false,
        'compact' => false,
        'links'   => [
            'bg'     => 'blue',
            'shadow' => 1,
        ],
        'brand'   => [
            'bg'   => 'gray-dark',
            'logo' => [
                'bg'     => 'white',
                'icon'   => '<img src="/favicon.png" alt="sky" width="30" />',
                'text'   => '<strong>Sky</strong>Team',
                'shadow' => 2,
            ],
        ],
        'user'    => [
            'visible' => true,
            'shadow'  => 2,
        ],
    ],
    'footer'  => [
        'visible'    => true,
        'vendorname' => 'Sky Team',
        'vendorlink' => '',
    ],
    'card'    => [
        'outline'       => true,
        'default_color' => 'info',
    ],
];
