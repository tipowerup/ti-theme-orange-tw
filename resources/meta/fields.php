<?php

declare(strict_types=1);

use Igniter\Pages\Models\Page;

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
        'tabs' => [
            'fields' => [
                'general' => [
                    'label' => 'General',
                    'type' => 'section',
                    'fields' => [
                        'logo_image' => [
                            'label' => 'Logo Image',
                            'type' => 'mediafinder',
                            'span' => 'left',
                            'comment' => 'Upload a logo image for your theme',
                            'rules' => 'nullable|string',
                        ],
                        'logo_text' => [
                            'label' => 'Logo Text',
                            'type' => 'text',
                            'span' => 'right',
                            'comment' => 'Alternatively, enter text to display as logo',
                            'rules' => 'nullable|string',
                        ],
                        'favicon' => [
                            'label' => 'Favicon',
                            'type' => 'mediafinder',
                            'span' => 'left',
                            'comment' => 'Upload a favicon for your theme (recommended: 32x32 or 16x16 .ico file)',
                            'rules' => 'nullable|string',
                        ],
                        'font[url]' => [
                            'label' => 'Google Font URL',
                            'type' => 'text',
                            'span' => 'right',
                            'default' => 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap',
                            'comment' => 'Grab your CSS URL from <a href="https://fonts.google.com/" target="_blank">Google Fonts</a> and paste it here.',
                            'rules' => 'required|startsWith:https://fonts.googleapis.com/',
                        ],
                    ],
                ],
                'colors' => [
                    'label' => 'Colors',
                    'type' => 'section',
                    'fields' => [
                        'color[primary]' => [
                            'label' => 'Primary Color',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#f97316',
                            'rules' => 'required',
                            'comment' => 'Main brand color',
                        ],
                        'color[primary_light]' => [
                            'label' => 'Primary Light',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#fb923c',
                            'rules' => 'required',
                        ],
                        'color[primary_dark]' => [
                            'label' => 'Primary Dark',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#ea580c',
                            'rules' => 'required',
                        ],
                        'color[secondary]' => [
                            'label' => 'Secondary Color',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#6c757d',
                            'rules' => 'required',
                        ],
                        'color[secondary_light]' => [
                            'label' => 'Secondary Light',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#9ca3af',
                            'rules' => 'required',
                        ],
                        'color[secondary_dark]' => [
                            'label' => 'Secondary Dark',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#4b5563',
                            'rules' => 'required',
                        ],
                        'color[success]' => [
                            'label' => 'Success Color',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#22c55e',
                            'rules' => 'required',
                        ],
                        'color[danger]' => [
                            'label' => 'Danger Color',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#ef4444',
                            'rules' => 'required',
                        ],
                        'color[warning]' => [
                            'label' => 'Warning Color',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#eab308',
                            'rules' => 'required',
                        ],
                        'color[info]' => [
                            'label' => 'Info Color',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#3b82f6',
                            'rules' => 'required',
                        ],
                        'color[text]' => [
                            'label' => 'Text Color',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#111827',
                            'rules' => 'required',
                            'comment' => 'Main text color',
                        ],
                        'color[text_muted]' => [
                            'label' => 'Text Muted',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#6b7280',
                            'rules' => 'required',
                            'comment' => 'Secondary text color',
                        ],
                        'color[body]' => [
                            'label' => 'Body Background',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#ffffff',
                            'rules' => 'required',
                        ],
                        'color[surface]' => [
                            'label' => 'Surface Background',
                            'type' => 'colorpicker',
                            'span' => 'right',
                            'default' => '#f9fafb',
                            'rules' => 'required',
                            'comment' => 'Cards, panels background',
                        ],
                        'color[border]' => [
                            'label' => 'Border Color',
                            'type' => 'colorpicker',
                            'span' => 'left',
                            'default' => '#e5e7eb',
                            'rules' => 'required',
                        ],
                    ],
                ],
                'dark_mode' => [
                    'label' => 'Dark Mode',
                    'type' => 'section',
                    'fields' => [
                        'dark_mode[enabled]' => [
                            'label' => 'Enable Dark Mode',
                            'type' => 'switch',
                            'default' => true,
                            'rules' => 'boolean',
                            'comment' => 'Allow users to toggle dark mode',
                        ],
                        'dark_mode[default]' => [
                            'label' => 'Default Mode',
                            'type' => 'select',
                            'default' => 'system',
                            'options' => [
                                'system' => 'System Preference',
                                'light' => 'Light',
                                'dark' => 'Dark',
                            ],
                            'rules' => 'required|in:system,light,dark',
                        ],
                    ],
                ],
                'social' => [
                    'label' => 'Social Links',
                    'type' => 'section',
                    'fields' => [
                        'social[facebook]' => [
                            'label' => 'Facebook URL',
                            'type' => 'text',
                            'span' => 'left',
                            'rules' => 'nullable|url',
                        ],
                        'social[twitter]' => [
                            'label' => 'Twitter URL',
                            'type' => 'text',
                            'span' => 'right',
                            'rules' => 'nullable|url',
                        ],
                        'social[instagram]' => [
                            'label' => 'Instagram URL',
                            'type' => 'text',
                            'span' => 'left',
                            'rules' => 'nullable|url',
                        ],
                        'social[youtube]' => [
                            'label' => 'YouTube URL',
                            'type' => 'text',
                            'span' => 'right',
                            'rules' => 'nullable|url',
                        ],
                    ],
                ],
                'advanced' => [
                    'label' => 'Advanced',
                    'type' => 'section',
                    'fields' => [
                        'ga_tracking_code' => [
                            'label' => 'Google Analytics Tracking Code',
                            'type' => 'codeeditor',
                            'size' => 'small',
                            'mode' => 'js',
                            'comment' => 'Paste your Google Analytics Tracking Code here.',
                            'rules' => 'nullable|string',
                        ],
                        'custom_css' => [
                            'label' => 'Custom CSS',
                            'type' => 'codeeditor',
                            'mode' => 'css',
                            'span' => 'left',
                            'size' => 'small',
                            'comment' => 'Add custom CSS styles',
                            'rules' => 'nullable|string',
                        ],
                        'custom_js' => [
                            'label' => 'Custom JavaScript',
                            'type' => 'codeeditor',
                            'mode' => 'javascript',
                            'span' => 'right',
                            'size' => 'small',
                            'comment' => 'Add custom JavaScript code',
                            'rules' => 'nullable|string',
                        ],
                    ],
                ],
                'gdpr' => [
                    'label' => 'GDPR (EU Cookie Settings)',
                    'type' => 'section',
                    'fields' => [
                        'gdpr[enabled]' => [
                            'label' => 'Enable Cookie Banner',
                            'type' => 'switch',
                            'default' => true,
                            'rules' => 'boolean',
                        ],
                        'gdpr[message]' => [
                            'label' => 'Cookie Message',
                            'type' => 'textarea',
                            'default' => 'We use cookies to improve our services. If you continue to browse, consider accepting its use.',
                            'rules' => 'required|string',
                            'attributes' => [
                                'rows' => '4',
                            ],
                        ],
                        'gdpr[accept_text]' => [
                            'label' => 'Accept Button Text',
                            'type' => 'text',
                            'default' => 'Accept',
                            'rules' => 'required|max:128',
                        ],
                        'gdpr[more_info_text]' => [
                            'label' => 'More Info Text',
                            'type' => 'text',
                            'default' => 'More Information',
                            'rules' => 'required|max:128',
                        ],
                        'gdpr[more_info_link]' => [
                            'label' => 'More Info Link',
                            'type' => 'select',
                            'options' => Page::getDropdownOptions(...),
                            'rules' => 'nullable|string',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
