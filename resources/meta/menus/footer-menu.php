<?php

declare(strict_types=1);

return [
    'name' => 'Footer menu',
    'items' => [
        [
            'title' => 'tipowerup.orange-tw::default.text_restaurant',
            'code' => '',
            'type' => 'header',
            'items' => [
                [
                    'title' => 'tipowerup.orange-tw::default.nav.menu',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'local.menus',
                ],
                [
                    'title' => 'tipowerup.orange-tw::default.nav.reservation',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'reservation.reservation',
                ],
                [
                    'title' => 'tipowerup.orange-tw::default.nav.locations',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'locations',
                ],
            ],
        ],
        [
            'title' => 'tipowerup.orange-tw::default.text_information',
            'code' => '',
            'type' => 'header',
            'items' => [
                [
                    'title' => 'tipowerup.orange-tw::default.menu_contact',
                    'code' => '',
                    'type' => 'theme-page',
                    'reference' => 'contact',
                ],
                [
                    'title' => 'About Us',
                    'code' => '',
                    'type' => 'static-page',
                    'reference' => 'about-us',
                ],
                [
                    'title' => 'Privacy Policy',
                    'code' => '',
                    'type' => 'static-page',
                    'reference' => 'policy',
                ],
            ],
        ],
    ],
];
