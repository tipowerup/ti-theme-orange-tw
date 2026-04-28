<?php

declare(strict_types=1);

return [
    'name' => 'Mobile menu',
    'items' => [
        [
            'title' => 'tipowerup.orange-tw::default.nav.locations',
            'code' => 'locations',
            'type' => 'theme-page',
            'reference' => 'locations',
        ],
        [
            'title' => 'tipowerup.orange-tw::default.menu_contact',
            'code' => 'contact',
            'type' => 'theme-page',
            'reference' => 'contact',
        ],
        [
            'title' => 'About Us',
            'code' => 'about',
            'type' => 'static-page',
            'reference' => 'about-us',
        ],
        [
            'title' => 'Privacy Policy',
            'code' => 'privacy',
            'type' => 'static-page',
            'reference' => 'policy',
        ],
        [
            'title' => 'Terms & Conditions',
            'code' => 'terms',
            'type' => 'static-page',
            'reference' => 'terms-and-conditions',
        ],
    ],
];
