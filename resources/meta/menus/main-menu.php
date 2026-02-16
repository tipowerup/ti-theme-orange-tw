<?php

declare(strict_types=1);

return [
    'name' => 'Main menu',
    'items' => [
        [
            'title' => 'tipowerup.orange-tw::default.nav.menu',
            'code' => 'view-menu',
            'type' => 'theme-page',
            'reference' => 'local.menus',
        ],
        [
            'title' => 'tipowerup.orange-tw::default.nav.reservation',
            'code' => 'reservation',
            'type' => 'theme-page',
            'reference' => 'reservation.reservation',
        ],
        [
            'title' => 'tipowerup.orange-tw::default.nav.login',
            'code' => 'login',
            'type' => 'theme-page',
            'reference' => 'account.login',
        ],
        [
            'title' => 'tipowerup.orange-tw::default.nav.register',
            'code' => 'register',
            'type' => 'theme-page',
            'reference' => 'account.register',
        ],
        [
            'title' => 'tipowerup.orange-tw::default.nav.account',
            'code' => 'account',
            'type' => 'theme-page',
            'reference' => 'account.account',
            'items' => [
                [
                    'title' => 'tipowerup.orange-tw::default.nav.recent_orders',
                    'code' => 'recent-orders',
                    'type' => 'theme-page',
                    'reference' => 'account.orders',
                ],
                [
                    'title' => 'tipowerup.orange-tw::default.nav.my_account',
                    'code' => 'my-account',
                    'type' => 'theme-page',
                    'reference' => 'account.account',
                ],
                [
                    'title' => 'tipowerup.orange-tw::default.nav.address_book',
                    'code' => 'address-book',
                    'type' => 'theme-page',
                    'reference' => 'account.address',
                ],
                [
                    'title' => 'tipowerup.orange-tw::default.nav.reservations',
                    'code' => 'reservations',
                    'type' => 'theme-page',
                    'reference' => 'account.reservations',
                ],
                [
                    'title' => 'tipowerup.orange-tw::default.nav.logout',
                    'code' => 'logout',
                    'type' => 'url',
                    'url' => 'logout',
                ],
            ],
        ],
    ],
];
