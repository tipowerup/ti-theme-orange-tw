# TastyIgniter Theming Guide

A comprehensive reference for creating themes in TastyIgniter v4, including SCSS compilation, Tailwind CSS integration, child themes, standalone themes, and frontend framework integration.

---

## Table of Contents

1. [Theme Architecture Overview](#theme-architecture-overview)
2. [Theme Directory Structure](#theme-directory-structure)
3. [Core Configuration Files](#core-configuration-files)
4. [Asset Compilation System](#asset-compilation-system)
5. [Theme Customization Fields](#theme-customization-fields)
6. [Child Theme Development](#child-theme-development)
7. [Standalone Theme Development](#standalone-theme-development)
8. [Using Tailwind CSS](#using-tailwind-css)
9. [Dark Mode Implementation](#dark-mode-implementation)
10. [Livewire Integration](#livewire-integration)
11. [Vue.js Integration](#vuejs-integration)
12. [React Integration](#react-integration)
13. [Theme Registration Methods](#theme-registration-methods)
14. [Debugging and Troubleshooting](#debugging-and-troubleshooting)

---

## Theme Architecture Overview

### How TastyIgniter Discovers Themes

TastyIgniter's `ThemeManager` class scans registered directories for `theme.json` files. By default, it scans:

- `themes/` directory in the project root
- Any directory registered via `ThemeManager::addDirectory()`

**Core classes involved:**

| Class | Location | Purpose |
|-------|----------|---------|
| `ThemeManager` | `vendor/tastyigniter/core/src/Main/Classes/ThemeManager.php` | Discovers, loads, and manages themes |
| `Theme` | `vendor/tastyigniter/core/src/Main/Classes/Theme.php` | Represents a theme instance, handles config merging |
| `Theme` (Model) | `vendor/tastyigniter/core/src/Main/Models/Theme.php` | Database model for theme settings |
| `Assets` | `vendor/tastyigniter/core/src/System/Libraries/Assets.php` | Asset compilation and bundling |

### Theme Lifecycle

```
1. ThemeManager scans directories for theme.json
              ↓
2. Theme instances created from discovered themes
              ↓
3. Active theme determined from database setting
              ↓
4. Theme config merged (parent + child if applicable)
              ↓
5. Assets loaded via assets.json
              ↓
6. Views resolved (child overrides → parent fallback)
```

---

## Theme Directory Structure

### Standard Theme Structure

```
theme-name/
├── theme.json                    # Theme definition (required)
├── _meta/
│   ├── assets.json              # Asset configuration
│   └── fields.php               # Admin customization fields
├── _layouts/
│   └── default.blade.php        # Base layout templates
├── _pages/
│   ├── home.blade.php           # Page templates
│   └── local/
│       └── menus.blade.php
├── _partials/                   # Reusable partial templates
├── _content/                    # Static content blocks
├── components/                  # Livewire component views
├── includes/                    # Include partials (header, footer, etc.)
├── livewire/                    # Livewire component view overrides
└── public/
    ├── css/
    │   └── app.css              # Compiled CSS
    ├── js/
    │   └── app.js               # Compiled JavaScript
    └── images/
```

### View Resolution Order

When TastyIgniter looks for a view, it checks in this order:

1. **Child theme** `_layouts/`, `_pages/`, `_partials/`
2. **Parent theme** `_layouts/`, `_pages/`, `_partials/`
3. **Extension views** (if using namespaced views)

For Livewire components specifically:
1. Child theme `livewire/` or `components/`
2. Parent theme `livewire/` or `components/`
3. Original component view location

---

## Core Configuration Files

### theme.json

The theme definition file. Required fields:

```json
{
    "code": "theme-code",
    "name": "Theme Display Name",
    "description": "Theme description",
    "author": "Author Name",
    "homepage": "https://example.com",
    "locked": false,
    "parent": null,
    "require": {
        "igniter.cart": "*",
        "igniter.local": "*",
        "igniter.user": "*"
    }
}
```

**Key fields:**

| Field | Type | Description |
|-------|------|-------------|
| `code` | string | Unique theme identifier (used in paths) |
| `name` | string | Display name in admin |
| `parent` | string\|null | Parent theme code for child themes |
| `locked` | boolean | If true, prevents editing in admin |
| `require` | object | Required extensions |

### _meta/assets.json

Controls which assets are loaded and how they're compiled:

```json
{
    "doctype": "html5",
    "favicon": "$/theme-code/images/favicon.ico",
    "meta": [
        {
            "name": "viewport",
            "content": "width=device-width, initial-scale=1",
            "type": "name"
        }
    ],
    "style": [
        {
            "path": "$/theme-code/css/app.css",
            "name": "app-css",
            "data-navigate-track": "true"
        }
    ],
    "script": [
        {
            "path": "$/theme-code/js/app.js",
            "name": "app-js",
            "data-navigate-once": "true"
        }
    ],
    "bundles": [
        {
            "type": "scss",
            "files": "theme-code::src/scss/app.scss",
            "destination": "$/theme-code/css/app.css"
        }
    ]
}
```

**Path symbols:**

| Symbol | Meaning |
|--------|---------|
| `$/` | Theme's public directory |
| `theme-code::` | Theme's resource path (for source files) |

**Asset attributes:**

| Attribute | Purpose |
|-----------|---------|
| `data-navigate-track` | Re-evaluate on Livewire navigation |
| `data-navigate-once` | Load only once, persist across navigation |

### _meta/fields.php

Defines admin customization fields:

```php
<?php

return [
    'form' => [
        [
            'title' => 'Colors',
            'description' => 'Customize theme colors',
            'icon' => 'fa fa-paint-brush',
            'priority' => 1,
            'fields' => [
                'color-primary' => [
                    'label' => 'Primary color',
                    'type' => 'colorpicker',
                    'default' => '#ff4900',
                    'rules' => 'required',
                    'assetVar' => 'primary',  // Maps to SCSS $primary
                ],
                'color-secondary' => [
                    'label' => 'Secondary color',
                    'type' => 'colorpicker',
                    'default' => '#6c757d',
                    'rules' => 'required',
                    'assetVar' => 'secondary',
                ],
            ],
        ],
        [
            'title' => 'Typography',
            'fields' => [
                'font' => [
                    'label' => 'Font family',
                    'type' => 'select',
                    'default' => 'Inter',
                    'options' => [
                        'Inter' => 'Inter',
                        'Roboto' => 'Roboto',
                        'Open Sans' => 'Open Sans',
                    ],
                ],
            ],
        ],
    ],
];
```

**The `assetVar` property:**

This is critical for SCSS compilation. It maps the admin field value to an SCSS variable:

```php
'color-primary' => [
    'assetVar' => 'primary',  // Becomes $primary in SCSS
]
```

When the theme is saved, TastyIgniter:
1. Reads all fields with `assetVar`
2. Passes them to the SCSS compiler
3. Compiles SCSS with these values injected
4. Outputs to the bundle destination

---

## Asset Compilation System

### How SCSS Compilation Works

**Trigger:** Saving theme settings in Admin > Design

**Code flow:**

```
Admin saves theme
       ↓
Themes::formAfterSave() called
       ↓
Assets::buildBundles($theme) called
       ↓
addAssetsFromThemeManifest() - loads bundles from assets.json
       ↓
getAssetVariables() - gets assetVar values from fields.php
       ↓
SCSS filter receives variables
       ↓
combineBundles() - compiles SCSS to CSS
       ↓
Output written to destination path
```

**Key code locations:**

| File | Method | Purpose |
|------|--------|---------|
| `Themes.php` | `formAfterSave()` | Triggers compilation after save |
| `CombinesAssets.php` | `buildBundles()` | Orchestrates compilation |
| `Assets.php` | `addAssetsFromThemeManifest()` | Loads bundle config |
| `Theme.php` | `getAssetVariables()` | Extracts assetVar values |

### Important: Child Theme Bundles

**Critical:** If a child theme has its own `assets.json`, it **overrides** the parent's entirely. The child's `assets.json` must include bundles if SCSS compilation is needed:

```json
{
    "bundles": [
        {
            "type": "scss",
            "files": "parent-theme::src/scss/app.scss",
            "destination": "$/parent-theme/css/app.css"
        }
    ]
}
```

Without this, saving child theme settings won't trigger any compilation.

### Manual Compilation

```bash
php artisan igniter:util compile scss
```

---

## Theme Customization Fields

### Available Field Types

| Type | Description |
|------|-------------|
| `text` | Single line text input |
| `textarea` | Multi-line text input |
| `number` | Numeric input |
| `select` | Dropdown selection |
| `checkbox` | Boolean toggle |
| `colorpicker` | Color selection with preview |
| `mediafinder` | Media library file picker |
| `repeater` | Repeatable field groups |
| `codeeditor` | Code editor with syntax highlighting |

### Accessing Field Values in Templates

```blade
{{-- Direct access --}}
{{ $theme->{'color-primary'} }}

{{-- With default fallback --}}
{{ $theme->{'font-size'} ?? '16px' }}

{{-- In conditionals --}}
@if($theme->{'show-banner'})
    @include('includes.banner')
@endif
```

### Field Configuration Options

```php
'field-name' => [
    'label' => 'Field Label',
    'type' => 'text',
    'default' => 'default value',
    'placeholder' => 'Enter value...',
    'comment' => 'Help text shown below field',
    'commentAbove' => 'Help text shown above field',
    'span' => 'left',        // left, right, full
    'cssClass' => 'flex-width',
    'rules' => 'required|max:255',
    'trigger' => [
        'action' => 'show',
        'field' => 'other-field',
        'condition' => 'checked',
    ],
    'assetVar' => 'scss-variable-name',
],
```

---

## Child Theme Development

### When to Use a Child Theme

- Customizing an existing theme without modifying it
- Adding features while maintaining upstream updates
- Creating variations of a base theme

### Creating a Child Theme

**Method 1: Admin Panel**

1. Go to Admin > Design > Themes
2. Click on parent theme
3. Click "Create Child Theme" button
4. TastyIgniter creates the child automatically

**Method 2: Manual Creation**

1. Create theme directory:

```
themes/my-child-theme/
├── theme.json
└── _meta/
    ├── assets.json
    └── fields.php
```

2. Configure `theme.json`:

```json
{
    "code": "my-child-theme",
    "name": "My Child Theme",
    "description": "Child theme extending Parent Theme",
    "parent": "parent-theme-code",
    "locked": false
}
```

3. Configure `assets.json` (critical for SCSS):

```json
{
    "style": [
        {"path": "$/parent-theme/css/app.css", "name": "app-css"},
        {"path": "$/my-child-theme/css/custom.css", "name": "custom-css"}
    ],
    "script": [
        {"path": "$/parent-theme/js/app.js", "name": "app-js"}
    ],
    "bundles": [
        {
            "type": "scss",
            "files": "parent-theme::src/scss/app.scss",
            "destination": "$/parent-theme/css/app.css"
        }
    ]
}
```

4. `fields.php` can be empty (inherits from parent):

```php
<?php

return [];
```

### Method 3: Extension-Based Child Theme

For distributable child themes via Composer:

**composer.json:**

```json
{
    "name": "vendor/theme-package",
    "type": "tastyigniter-extension",
    "require": {
        "tastyigniter/ti-theme-orange": "^3.0"
    },
    "extra": {
        "tastyigniter-extension": {
            "code": "vendor.themepackage"
        }
    }
}
```

**Extension.php:**

```php
<?php

namespace Vendor\ThemePackage;

use Igniter\Main\Classes\ThemeManager;
use Igniter\System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function register(): void
    {
        $this->app->afterResolving(ThemeManager::class, function (ThemeManager $themeManager) {
            $themeManager->addDirectory(dirname(__DIR__).'/resources/theme');
        });
    }
}
```

**Directory structure:**

```
ti-ext-themepackage/
├── composer.json
├── src/
│   └── Extension.php
└── resources/
    └── theme/
        └── vendor-childtheme/
            ├── theme.json
            ├── _meta/
            └── ...
```

### Overriding Parent Views

Simply create a file at the same relative path:

**To override parent's `_layouts/default.blade.php`:**
```
my-child-theme/_layouts/default.blade.php
```

**To override parent's `includes/header.blade.php`:**
```
my-child-theme/includes/header.blade.php
```

**To override parent's Livewire component:**
```
my-child-theme/livewire/cart-box.blade.php
```

### Overriding Namespaced Views

For views loaded via namespace (e.g., `igniter-orange::includes.header`), register a namespace override in your extension:

```php
use Illuminate\Support\Facades\View;

public function boot(): void
{
    $activeTheme = resolve(ThemeManager::class)->getActiveThemeCode();

    if ($activeTheme !== 'my-child-theme') {
        return;
    }

    View::prependNamespace('igniter-orange',
        dirname(__DIR__).'/resources/theme/my-child-theme'
    );
}
```

---

## Standalone Theme Development

### Creating a Theme from Scratch

1. **Create directory structure:**

```
themes/my-theme/
├── theme.json
├── _meta/
│   ├── assets.json
│   └── fields.php
├── _layouts/
│   ├── default.blade.php
│   └── static.blade.php
├── _pages/
│   ├── home.blade.php
│   ├── account/
│   ├── checkout/
│   └── local/
├── _partials/
├── components/
├── includes/
│   ├── head.blade.php
│   ├── header.blade.php
│   ├── footer.blade.php
│   └── scripts.blade.php
├── livewire/
└── public/
    ├── css/
    ├── js/
    └── images/
```

2. **Configure theme.json:**

```json
{
    "code": "my-theme",
    "name": "My Custom Theme",
    "description": "A custom TastyIgniter theme",
    "author": "Your Name",
    "locked": false,
    "require": {
        "igniter.cart": "*",
        "igniter.local": "*",
        "igniter.user": "*",
        "igniter.pages": "*",
        "igniter.reservation": "*"
    }
}
```

3. **Create base layout (`_layouts/default.blade.php`):**

```blade
---
description: Default layout
---
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    @include('my-theme::includes.head')
    @livewireStyles
</head>
<body class="{{ $this->page->bodyClass ?? '' }}">

<header>
    @include('my-theme::includes.header')
</header>

<main>
    @themePage
</main>

<footer>
    @include('my-theme::includes.footer')
</footer>

<livewire:my-theme::utils.modal />
<livewire:my-theme::utils.flash-message />

@livewireScripts
@include('my-theme::includes.scripts')
</body>
</html>
```

4. **Create includes/head.blade.php:**

```blade
{!! get_metas() !!}
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

@if ($favicon = $theme->favicon)
    <link href="{{ media_url($favicon) }}" rel="shortcut icon" type="image/ico">
@else
    {!! get_favicon() !!}
@endif

<title>{{ lang(get_title()).setting('site_name') }}</title>

@themeStyles

@if (!empty($theme->custom_css))
    <style>{!! $theme->custom_css !!}</style>
@endif
```

5. **Create includes/scripts.blade.php:**

```blade
{!! Assets::getJsVars() !!}
@themeScripts
@stack('scripts')

@if (!empty($theme->custom_js))
    <script>{!! $theme->custom_js !!}</script>
@endif
```

### SCSS Setup for Standalone Theme

**Directory structure:**

```
my-theme/
├── resources/
│   └── src/
│       └── scss/
│           ├── app.scss
│           ├── _variables.scss
│           ├── _buttons.scss
│           ├── _cards.scss
│           └── _utilities.scss
└── public/
    └── css/
        └── app.css
```

**_meta/assets.json:**

```json
{
    "style": [
        {"path": "$/my-theme/css/app.css", "name": "app-css"}
    ],
    "bundles": [
        {
            "type": "scss",
            "files": "my-theme::src/scss/app.scss",
            "destination": "$/my-theme/css/app.css"
        }
    ]
}
```

**resources/src/scss/app.scss:**

```scss
// Variables (use !default for assetVar override)
$primary: #ff4900 !default;
$secondary: #6c757d !default;
$body-bg: #ffffff !default;
$body-color: #212529 !default;

// Import Bootstrap
@import "bootstrap/scss/bootstrap";

// Custom styles
@import "buttons";
@import "cards";
@import "utilities";
```

**_meta/fields.php:**

```php
<?php

return [
    'form' => [
        [
            'title' => 'Colors',
            'fields' => [
                'color-primary' => [
                    'label' => 'Primary color',
                    'type' => 'colorpicker',
                    'default' => '#ff4900',
                    'assetVar' => 'primary',
                ],
                'color-secondary' => [
                    'label' => 'Secondary color',
                    'type' => 'colorpicker',
                    'default' => '#6c757d',
                    'assetVar' => 'secondary',
                ],
            ],
        ],
    ],
];
```

---

## Using Tailwind CSS

TastyIgniter does not have built-in Tailwind/PostCSS support. Tailwind themes require local build or CI/CD.

### Setup

**Directory structure:**

```
my-tailwind-theme/
├── theme.json
├── _meta/
│   ├── assets.json           # No bundles (pre-compiled)
│   └── fields.php
├── _layouts/
├── _pages/
├── includes/
│   └── theme-vars.blade.php  # Runtime CSS variable injection
├── src/                      # Build source (not served)
│   ├── css/
│   │   └── app.css
│   ├── tailwind.config.js
│   └── postcss.config.js
├── public/
│   └── css/
│       └── app.css           # Compiled output (committed)
├── package.json
└── .github/
    └── workflows/
        └── build-css.yml     # Auto-build on push
```

### package.json

```json
{
    "name": "my-tailwind-theme",
    "scripts": {
        "dev": "tailwindcss -i ./src/css/app.css -o ./public/css/app.css --watch",
        "build": "tailwindcss -i ./src/css/app.css -o ./public/css/app.css --minify"
    },
    "devDependencies": {
        "tailwindcss": "^3.4"
    }
}
```

### tailwind.config.js

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './_layouts/**/*.blade.php',
        './_pages/**/*.blade.php',
        './_partials/**/*.blade.php',
        './includes/**/*.blade.php',
        './livewire/**/*.blade.php',
        './components/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: 'rgb(var(--color-primary) / <alpha-value>)',
                secondary: 'rgb(var(--color-secondary) / <alpha-value>)',
            },
        },
    },
    plugins: [],
}
```

### src/css/app.css

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
    :root {
        --color-primary: 255 73 0;
        --color-secondary: 108 117 125;
        --color-bg: 255 255 255;
        --color-text: 33 37 41;
    }

    .dark {
        --color-bg: 17 24 39;
        --color-text: 243 244 246;
    }
}

@layer components {
    .btn-primary {
        @apply bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition;
    }
}
```

### _meta/assets.json (No bundles)

```json
{
    "style": [
        {
            "path": "$/my-tailwind-theme/css/app.css",
            "name": "app-css",
            "data-navigate-track": "true"
        }
    ],
    "script": [
        {
            "path": "$/my-tailwind-theme/js/app.js",
            "name": "app-js"
        }
    ]
}
```

### Runtime CSS Variable Injection

Since Tailwind is pre-compiled, admin color changes need runtime injection.

**includes/theme-vars.blade.php:**

```blade
@php
    $hexToRgb = function($hex) {
        $hex = ltrim($hex, '#');
        return implode(' ', array_map('hexdec', str_split($hex, 2)));
    };

    $primary = $theme->{'color-primary'} ?? '#ff4900';
    $secondary = $theme->{'color-secondary'} ?? '#6c757d';
@endphp
<style>
:root {
    --color-primary: {{ $hexToRgb($primary) }};
    --color-secondary: {{ $hexToRgb($secondary) }};
}
</style>
```

**Include in layout:**

```blade
<head>
    @include('my-tailwind-theme::includes.head')
    @include('my-tailwind-theme::includes.theme-vars')
    @livewireStyles
</head>
```

### GitHub Actions Auto-Build

**.github/workflows/build-css.yml:**

```yaml
name: Build Tailwind CSS

on:
    push:
        branches: [main]
        paths:
            - 'src/**'
            - '_layouts/**'
            - '_pages/**'
            - '_partials/**'
            - 'includes/**'
            - 'livewire/**'
            - 'components/**'
            - 'tailwind.config.js'
            - 'package.json'

jobs:
    build:
        runs-on: ubuntu-latest

        steps:
            - uses: actions/checkout@v4

            - name: Setup Node.js
              uses: actions/setup-node@v4
              with:
                  node-version: '20'
                  cache: 'npm'

            - name: Install dependencies
              run: npm ci

            - name: Build CSS
              run: npm run build

            - name: Commit compiled CSS
              uses: stefanzweifel/git-auto-commit-action@v5
              with:
                  commit_message: "Build: Compile Tailwind CSS"
                  file_pattern: 'public/css/app.css'
```

### SCSS vs Tailwind Comparison

| Aspect | SCSS (Built-in) | Tailwind CSS |
|--------|-----------------|--------------|
| Build tool | TastyIgniter auto-compiles | npm (local/CI) |
| Admin color changes | Instant (recompiles on save) | Requires CSS variables |
| Dark mode | Manual implementation | Built-in `dark:` prefix |
| File size | ~200KB+ | ~30KB (purged) |
| Learning curve | Traditional CSS knowledge | Utility-first paradigm |
| Integration | Native | Custom setup required |

---

## Dark Mode Implementation

### Tailwind CSS Approach

**tailwind.config.js:**

```js
module.exports = {
    darkMode: 'class',  // Toggle via .dark class on <html>
    // ...
}
```

**Layout with Alpine.js toggle:**

```blade
<html
    x-data="{
        dark: localStorage.getItem('darkMode') === 'true',
        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('darkMode', this.dark);
        }
    }"
    :class="{ 'dark': dark }"
>
<head>...</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Toggle button -->
    <button @click="toggle()" class="p-2">
        <span x-show="!dark">🌙</span>
        <span x-show="dark">☀️</span>
    </button>

    <!-- Content uses dark: prefix -->
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded">
        <h1 class="text-gray-900 dark:text-white">Hello</h1>
    </div>

</body>
</html>
```

### CSS Variables Approach (SCSS or Pure CSS)

**CSS:**

```css
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f3f4f6;
    --text-primary: #111827;
    --text-secondary: #6b7280;
}

[data-theme="dark"] {
    --bg-primary: #111827;
    --bg-secondary: #1f2937;
    --text-primary: #f9fafb;
    --text-secondary: #9ca3af;
}

body {
    background-color: var(--bg-primary);
    color: var(--text-primary);
}
```

**JavaScript toggle:**

```js
const toggle = document.getElementById('theme-toggle');
const html = document.documentElement;

// Check saved preference or system preference
const savedTheme = localStorage.getItem('theme');
const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
    html.setAttribute('data-theme', 'dark');
}

toggle.addEventListener('click', () => {
    const isDark = html.getAttribute('data-theme') === 'dark';
    html.setAttribute('data-theme', isDark ? 'light' : 'dark');
    localStorage.setItem('theme', isDark ? 'light' : 'dark');
});
```

### Admin Setting for Default Mode

**_meta/fields.php:**

```php
'default-theme-mode' => [
    'label' => 'Default theme mode',
    'type' => 'select',
    'default' => 'light',
    'options' => [
        'light' => 'Light',
        'dark' => 'Dark',
        'system' => 'System preference',
    ],
],
```

**Layout implementation:**

```blade
<html
    x-data="themeMode('{{ $theme->{'default-theme-mode'} ?? 'light' }}')"
    :class="{ 'dark': isDark }"
>
<script>
function themeMode(defaultMode) {
    return {
        isDark: false,
        init() {
            const saved = localStorage.getItem('theme');
            if (saved) {
                this.isDark = saved === 'dark';
            } else if (defaultMode === 'system') {
                this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            } else {
                this.isDark = defaultMode === 'dark';
            }
        },
        toggle() {
            this.isDark = !this.isDark;
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
        }
    }
}
</script>
```

---

## Livewire Integration

TastyIgniter v4 uses Livewire 3 for reactive components.

### Understanding Livewire in TastyIgniter

**Core Livewire components are in extensions:**

- `igniter.cart` → CartBox, CartItemModal
- `igniter.local` → LocalBox, MenuList
- `igniter.user` → Session, Account components
- `igniter.reservation` → Reservations component

**Component view resolution:**

```
1. Theme's livewire/ directory
2. Theme's components/ directory
3. Extension's default view
```

### Overriding Livewire Component Views

**To override CartBox view:**

```
my-theme/livewire/cart-box.blade.php
```

**To override with different structure:**

```blade
{{-- livewire/cart-box.blade.php --}}
<div>
    @if($cart->count())
        <div class="cart-widget">
            <h3>Your Cart ({{ $cart->count() }})</h3>

            @foreach($cart->content() as $cartItem)
                <div class="cart-item" wire:key="cart-item-{{ $cartItem->rowId }}">
                    <span>{{ $cartItem->name }}</span>
                    <span>{{ currency_format($cartItem->subtotal) }}</span>

                    <button wire:click="updateItemQty('{{ $cartItem->rowId }}', '{{ $cartItem->qty - 1 }}')">
                        -
                    </button>
                    <span>{{ $cartItem->qty }}</span>
                    <button wire:click="updateItemQty('{{ $cartItem->rowId }}', '{{ $cartItem->qty + 1 }}')">
                        +
                    </button>
                </div>
            @endforeach

            <div class="cart-total">
                Total: {{ $this->cartTotal }}
            </div>

            <button wire:click="onProceedToCheckout({{ $this->getLocationId() }})">
                Checkout
            </button>
        </div>
    @else
        <p>Your cart is empty</p>
    @endif
</div>
```

### Key Livewire Directives

| Directive | Purpose |
|-----------|---------|
| `wire:click` | Handle click events |
| `wire:model` | Two-way data binding |
| `wire:loading` | Show during AJAX requests |
| `wire:key` | Unique identifier for list items |
| `wire:navigate` | SPA-style navigation |
| `$dispatch()` | Emit events to other components |

### Dispatching Events Between Components

**Trigger cart update from menu item:**

```blade
<button wire:click="$dispatch('cart-box:add-item', {menuId: {{ $item->id }}, quantity: 1})">
    Add to Cart
</button>
```

**Open modal for item with options:**

```blade
<div
    data-toggle="orange-modal"
    data-component="igniter-orange::cart-item-modal"
    data-arguments='{"menuId": {{ $item->id }}}'
>
    {{ $item->name }}
</div>
```

### Wire:navigate Considerations

Livewire 3's `wire:navigate` provides SPA-like navigation but can cause issues with:

- Bootstrap JavaScript components (dropdowns, collapses)
- Third-party JavaScript that needs reinitialization

**Solution - Reinitialize on navigation:**

```js
document.addEventListener('livewire:navigated', () => {
    // Reinitialize Bootstrap dropdowns
    document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => {
        new bootstrap.Dropdown(el);
    });

    // Reinitialize other JS components
    initializeMyComponents();
});
```

**Or disable wire:navigate for specific links:**

```blade
<a href="{{ page_url('home') }}" wire:navigate.hover="false">
    Home (full page load)
</a>
```

---

## Vue.js Integration

### Approach 1: Vue Components within Blade

**Setup:**

```json
// package.json
{
    "dependencies": {
        "vue": "^3.4"
    },
    "devDependencies": {
        "@vitejs/plugin-vue": "^5.0",
        "vite": "^5.0"
    }
}
```

**vite.config.js:**

```js
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: 'public/js',
        rollupOptions: {
            input: 'src/js/app.js',
            output: {
                entryFileNames: 'app.js',
            },
        },
    },
});
```

**src/js/app.js:**

```js
import { createApp } from 'vue';
import MenuFilter from './components/MenuFilter.vue';
import CartWidget from './components/CartWidget.vue';

// Mount Vue components to elements
document.querySelectorAll('[data-vue-component]').forEach(el => {
    const componentName = el.dataset.vueComponent;
    const props = JSON.parse(el.dataset.props || '{}');

    const components = { MenuFilter, CartWidget };

    if (components[componentName]) {
        createApp(components[componentName], props).mount(el);
    }
});
```

**Usage in Blade:**

```blade
<div
    data-vue-component="MenuFilter"
    data-props='{"categories": @json($categories)}'
></div>
```

### Approach 2: Full Vue SPA with TastyIgniter API

For a fully Vue-based frontend consuming TastyIgniter's API:

**Theme layout (minimal):**

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['src/js/app.js', 'src/css/app.css'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
```

**Vue app with API calls:**

```js
// src/js/app.js
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Home from './pages/Home.vue';
import Menu from './pages/Menu.vue';
import Cart from './pages/Cart.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: Home },
        { path: '/menu', component: Menu },
        { path: '/cart', component: Cart },
    ],
});

createApp(App)
    .use(router)
    .mount('#app');
```

**API service:**

```js
// src/js/services/api.js
const API_BASE = '/api';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

export async function fetchMenu(locationId) {
    const response = await fetch(`${API_BASE}/menu/${locationId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    });
    return response.json();
}

export async function addToCart(menuId, quantity, options = []) {
    const response = await fetch(`${API_BASE}/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ menuId, quantity, options }),
    });
    return response.json();
}
```

### Vue + Livewire Coexistence

You can use Vue for complex interactive components while keeping Livewire for simpler reactivity:

```blade
<div class="menu-page">
    {{-- Vue handles complex filtering --}}
    <div data-vue-component="MenuFilter" data-props='...'></div>

    {{-- Livewire handles cart --}}
    <livewire:igniter-cart::cart-box />
</div>
```

**Communication between Vue and Livewire:**

```js
// Vue component emitting to Livewire
methods: {
    addToCart(itemId) {
        Livewire.dispatch('cart-box:add-item', {
            menuId: itemId,
            quantity: 1
        });
    }
}
```

---

## React Integration

### Setup

**package.json:**

```json
{
    "dependencies": {
        "react": "^18.2",
        "react-dom": "^18.2"
    },
    "devDependencies": {
        "@vitejs/plugin-react": "^4.0",
        "vite": "^5.0"
    }
}
```

**vite.config.js:**

```js
import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [react()],
    build: {
        outDir: 'public/js',
        rollupOptions: {
            input: 'src/js/app.jsx',
            output: {
                entryFileNames: 'app.js',
            },
        },
    },
});
```

### React Components in Blade

**src/js/app.jsx:**

```jsx
import React from 'react';
import { createRoot } from 'react-dom/client';
import MenuGrid from './components/MenuGrid';
import CartSidebar from './components/CartSidebar';

// Mount React components
document.querySelectorAll('[data-react-component]').forEach(el => {
    const componentName = el.dataset.reactComponent;
    const props = JSON.parse(el.dataset.props || '{}');

    const components = { MenuGrid, CartSidebar };
    const Component = components[componentName];

    if (Component) {
        createRoot(el).render(<Component {...props} />);
    }
});
```

**src/js/components/MenuGrid.jsx:**

```jsx
import React, { useState, useEffect } from 'react';

export default function MenuGrid({ locationId, categories }) {
    const [items, setItems] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch(`/api/menu/${locationId}`)
            .then(res => res.json())
            .then(data => {
                setItems(data.items);
                setLoading(false);
            });
    }, [locationId]);

    const addToCart = (itemId) => {
        // Communicate with Livewire
        Livewire.dispatch('cart-box:add-item', {
            menuId: itemId,
            quantity: 1
        });
    };

    if (loading) return <div>Loading...</div>;

    return (
        <div className="grid grid-cols-3 gap-4">
            {items.map(item => (
                <div key={item.id} className="menu-item-card">
                    <img src={item.thumb} alt={item.name} />
                    <h3>{item.name}</h3>
                    <p>{item.price}</p>
                    <button onClick={() => addToCart(item.id)}>
                        Add to Cart
                    </button>
                </div>
            ))}
        </div>
    );
}
```

**Usage in Blade:**

```blade
<div
    data-react-component="MenuGrid"
    data-props='@json(["locationId" => $location->id, "categories" => $categories])'
></div>
```

### Full React SPA

Similar to Vue SPA approach - create a minimal Blade layout that mounts the React app:

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site_name') }}</title>
    @vite(['src/js/app.jsx', 'src/css/app.css'])
</head>
<body>
    <div id="root"></div>
</body>
</html>
```

---

## Theme Registration Methods

### Method 1: themes/ Directory (Simplest)

Place theme directly in `themes/` folder:

```
project-root/
└── themes/
    └── my-theme/
        ├── theme.json
        └── ...
```

No additional configuration needed. TastyIgniter auto-discovers it.

### Method 2: Composer Package (Distributable)

**composer.json:**

```json
{
    "name": "vendor/my-theme",
    "type": "tastyigniter-theme",
    "require": {
        "tastyigniter/core": "^4.0"
    },
    "extra": {
        "tastyigniter-theme": {
            "code": "my-theme",
            "source-path": "/"
        }
    }
}
```

Install via: `composer require vendor/my-theme`

### Method 3: Extension with Theme (Most Flexible)

Best for child themes or themes bundled with functionality.

**composer.json:**

```json
{
    "name": "vendor/my-extension",
    "type": "tastyigniter-extension",
    "extra": {
        "tastyigniter-extension": {
            "code": "vendor.myextension"
        }
    }
}
```

**Extension.php:**

```php
<?php

namespace Vendor\MyExtension;

use Igniter\Main\Classes\ThemeManager;
use Igniter\System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function register(): void
    {
        $this->app->afterResolving(ThemeManager::class, function (ThemeManager $manager) {
            $manager->addDirectory(__DIR__.'/../resources/theme');
        });
    }
}
```

---

## Debugging and Troubleshooting

### Common Issues

#### Theme Not Appearing in Admin

1. Check `theme.json` exists and is valid JSON
2. Run `php artisan package:discover`
3. Clear cache: `php artisan cache:clear`

#### SCSS Not Compiling

1. Verify `bundles` section in `assets.json`
2. Check file paths use correct symbols (`$/`, `theme::`)
3. Check `assetVar` mappings in `fields.php`
4. Clear cache and resave theme settings

#### Child Theme Not Inheriting Parent Colors

1. Ensure `bundles` section exists in child's `assets.json`
2. Bundle must point to parent's SCSS files
3. Child's `fields.php` can be empty (inherits from parent)

#### Livewire Components Not Working After Navigation

Add reinitialization script:

```js
document.addEventListener('livewire:navigated', () => {
    // Reinitialize JS components
});
```

#### Views Not Overriding

1. Check file path matches exactly
2. For namespaced views, use `View::prependNamespace()`
3. Clear view cache: `php artisan view:clear`

### Useful Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# Rediscover packages
php artisan package:discover

# Compile SCSS manually
php artisan igniter:util compile scss

# List registered themes
php artisan tinker
>>> resolve(\Igniter\Main\Classes\ThemeManager::class)->listThemes()
```

### Debug Theme Configuration

```php
// In a controller or tinker
$theme = resolve(\Igniter\Main\Classes\ThemeManager::class)->findTheme('theme-code');

// Check config
dd($theme->getConfig());

// Check asset variables
dd($theme->getAssetVariables());

// Check form fields
dd($theme->getFormConfig());
```

---

## Quick Reference

### File Locations

| Purpose | Path |
|---------|------|
| Theme definition | `theme.json` |
| Asset config | `_meta/assets.json` |
| Admin fields | `_meta/fields.php` |
| Layouts | `_layouts/*.blade.php` |
| Pages | `_pages/**/*.blade.php` |
| Partials | `_partials/*.blade.php` |
| Components | `components/*.blade.php` |
| Livewire views | `livewire/*.blade.php` |
| Includes | `includes/*.blade.php` |
| Public assets | `public/css/`, `public/js/` |
| SCSS source | `resources/src/scss/` |

### Blade Directives

| Directive | Purpose |
|-----------|---------|
| `@themePage` | Render current page content |
| `@themeStyles` | Output registered CSS |
| `@themeScripts` | Output registered JS |
| `@livewireStyles` | Livewire CSS |
| `@livewireScripts` | Livewire JS |
| `@stack('name')` | Output pushed content |
| `@push('name')` | Push content to stack |

### Theme Variables in Templates

```blade
{{ $theme->{'field-name'} }}           {{-- Field value --}}
{{ $this->page->title }}               {{-- Page title --}}
{{ $this->page->bodyClass }}           {{-- Page body class --}}
{{ setting('site_name') }}             {{-- Site setting --}}
{{ page_url('page-name') }}            {{-- Generate page URL --}}
{{ media_url($path) }}                 {{-- Media library URL --}}
```

---

*Last updated: January 2025*
*TastyIgniter Version: 4.x*
*Livewire Version: 3.x*
