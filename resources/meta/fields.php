<?php

declare(strict_types=1);

use TiPowerUp\ThemeToolkit\Fields\BaseSchema;

return [
    'form' => BaseSchema::merge(
        ['tabs' => BaseSchema::tabs()],
        ['tabs' => [
            'colors' => [
                'fields' => [
                    'color[primary]' => ['default' => '#f97316'],
                    'color[secondary]' => ['default' => '#6c757d'],
                    'color[success]' => ['default' => '#22c55e'],
                    'color[danger]' => ['default' => '#ef4444'],
                    'color[warning]' => ['default' => '#eab308'],
                    'color[info]' => ['default' => '#3b82f6'],
                    'color[text]' => ['default' => '#111827'],
                    'color[text_muted]' => ['default' => '#6b7280'],
                    'color[body]' => ['default' => '#ffffff'],
                    'color[surface]' => ['default' => '#f9fafb'],
                    'color[border]' => ['default' => '#e5e7eb'],
                ],
            ],
        ]]
    )['tabs'],
];
