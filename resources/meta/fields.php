<?php

declare(strict_types=1);

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:igniter::admin.button_icon_back',
                    'class' => 'btn btn-outline-default',
                    'href' => 'settings',
                ],
                'save' => [
                    'label' => 'lang:igniter::admin.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                ],
            ],
        ],
        'fields' => [
            'logo_image' => [
                'label' => 'Logo Image',
                'type' => 'mediafinder',
                'span' => 'left',
                'comment' => 'Upload a logo image for your theme',
            ],
            'logo_text' => [
                'label' => 'Logo Text',
                'type' => 'text',
                'span' => 'right',
                'comment' => 'Alternatively, enter text to display as logo',
            ],
            'favicon' => [
                'label' => 'Favicon',
                'type' => 'mediafinder',
                'span' => 'left',
                'comment' => 'Upload a favicon for your theme (recommended: 32x32 or 16x16 .ico file)',
            ],
            'font[url]' => [
                'label' => 'Google Font URL',
                'type' => 'text',
                'default' => 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap',
                'comment' => 'Enter Google Fonts URL',
            ],
            'custom_css' => [
                'label' => 'Custom CSS',
                'type' => 'codeeditor',
                'mode' => 'css',
                'comment' => 'Add custom CSS styles',
            ],
            'custom_js' => [
                'label' => 'Custom JavaScript',
                'type' => 'codeeditor',
                'mode' => 'javascript',
                'comment' => 'Add custom JavaScript code',
            ],
        ],
    ],
];
