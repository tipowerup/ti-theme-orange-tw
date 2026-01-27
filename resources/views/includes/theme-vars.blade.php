@php
    use TiPowerUp\OrangeTw\Support\ColorHelper;

    $colors = $theme->color ?? [];
@endphp

<style>
    :root {
        @if(isset($colors['primary']))
        --color-primary: {{ ColorHelper::hexToRgb($colors['primary']) }};
        @endif
        @if(isset($colors['primary_light']))
        --color-primary-light: {{ ColorHelper::hexToRgb($colors['primary_light']) }};
        @endif
        @if(isset($colors['primary_dark']))
        --color-primary-dark: {{ ColorHelper::hexToRgb($colors['primary_dark']) }};
        @endif

        @if(isset($colors['secondary']))
        --color-secondary: {{ ColorHelper::hexToRgb($colors['secondary']) }};
        @endif
        @if(isset($colors['secondary_light']))
        --color-secondary-light: {{ ColorHelper::hexToRgb($colors['secondary_light']) }};
        @endif
        @if(isset($colors['secondary_dark']))
        --color-secondary-dark: {{ ColorHelper::hexToRgb($colors['secondary_dark']) }};
        @endif

        @if(isset($colors['success']))
        --color-success: {{ ColorHelper::hexToRgb($colors['success']) }};
        @endif
        @if(isset($colors['danger']))
        --color-danger: {{ ColorHelper::hexToRgb($colors['danger']) }};
        @endif
        @if(isset($colors['warning']))
        --color-warning: {{ ColorHelper::hexToRgb($colors['warning']) }};
        @endif
        @if(isset($colors['info']))
        --color-info: {{ ColorHelper::hexToRgb($colors['info']) }};
        @endif

        @if(isset($colors['text']))
        --color-text: {{ ColorHelper::hexToRgb($colors['text']) }};
        @endif
        @if(isset($colors['text_muted']))
        --color-text-muted: {{ ColorHelper::hexToRgb($colors['text_muted']) }};
        @endif

        @if(isset($colors['body']))
        --color-body: {{ ColorHelper::hexToRgb($colors['body']) }};
        @endif
        @if(isset($colors['surface']))
        --color-surface: {{ ColorHelper::hexToRgb($colors['surface']) }};
        @endif
        @if(isset($colors['border']))
        --color-border: {{ ColorHelper::hexToRgb($colors['border']) }};
        @endif
    }
</style>
