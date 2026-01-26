# TiPowerUp Orange TW Theme - Project Memory

## Project Overview

Minimal TastyIgniter theme template using Tailwind CSS and Vite for building custom themes.

## Theme Configuration

- **Theme Code**: `tipowerup-orange-tw`
- **Namespace**: `TiPowerUp\OrangeTw`
- **View Namespace**: `tipowerup-orange-tw`
- **Translation Key**: `tipowerup.orange-tw`
- **Package Name**: `tipowerup/ti-theme-orange-tw`

## Technology Stack

- **Backend**: TastyIgniter v4.0+
- **Build System**: Vite 5.x
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **PHP Version**: 8.1+
- **Dev Tools**: Laravel Boost (for AI development)

## Directory Structure

```
.
├── src/                          # PHP source files
│   └── ServiceProvider.php       # Main service provider
├── resources/
│   ├── meta/                     # Theme metadata
│   │   ├── assets.json          # Asset definitions
│   │   └── fields.php           # Theme settings form
│   ├── lang/                     # Translations
│   │   └── en/default.php
│   ├── views/                    # Blade templates
│   │   ├── _layouts/            # Layout templates
│   │   ├── _pages/              # Page templates
│   │   └── includes/            # Partial templates
│   └── src/                      # Frontend source
│       ├── css/app.css          # Tailwind entry
│       └── js/app.js            # JavaScript entry
├── public/                       # Compiled assets (gitignored)
│   ├── css/
│   └── js/
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
├── vite.config.js               # Vite configuration
└── tailwind.config.js           # Tailwind configuration
```

## Key Features

1. **Modern Build System**: Vite for fast asset compilation
2. **Tailwind CSS**: Utility-first CSS framework with custom theme
3. **Minimal Codebase**: Clean starting point for customization
4. **Proper Namespacing**: PSR-4 autoloading with `TiPowerUp\OrangeTw`
5. **Alpine.js**: Lightweight JavaScript framework
6. **Laravel Boost**: AI development assistance (dev dependency)

## Development Commands

```bash
# Install dependencies
composer install
npm install

# Development mode (watch for changes)
npm run dev

# Build for production
npm run build

# Watch mode
npm run watch
```

## Theme Structure

### Service Provider (`src/ServiceProvider.php`)
- Loads views from `resources/views` with namespace `tipowerup-orange-tw`
- Loads translations from `resources/lang` with key `tipowerup.orange-tw`
- Makes `$theme` and `$page` available to all views

### Asset Management
- **Entry Points**: `resources/src/css/app.css` and `resources/src/js/app.js`
- **Output**: Compiled to `public/css/` and `public/js/`
- **Vite Manifest**: Auto-generated for asset versioning

### Views
- **Layouts**: `resources/views/_layouts/default.blade.php`
- **Pages**: `resources/views/_pages/home.blade.php`
- **Includes**: Header, footer, head, scripts

### Styling
- Tailwind utility classes
- Custom primary color: Orange (50-900 shades)
- Responsive design patterns
- Custom components layer for reusable styles

## Customization Points

### Colors
Edit `tailwind.config.js` to modify color scheme:
```javascript
colors: {
  primary: { ... }
}
```

### Fonts
Default: Inter font family from Google Fonts
Configure in `resources/meta/fields.php` under `font[url]`

### Custom CSS/JS
Theme settings allow custom CSS and JavaScript injection via admin panel

## Extension Points

This minimal theme is designed to be extended with:
- Additional page layouts
- Custom Livewire components
- Blade components
- TastyIgniter extension integrations
- Custom navigation menus
- Footer widgets

## Reference Theme

Based on structure from: `/home/obinnaelviso/projects/tasty4/vendor/tastyigniter/ti-theme-orange/`

## Git Workflow

- Main development branch: `claude-session`
- Files excluded from commits: `node_modules/`, `vendor/`, compiled assets
- Project memory tracked in `.claude/CLAUDE.md`

## Next Steps

1. Run `npm install` to install Node dependencies
2. Run `npm run build` to compile assets
3. Configure theme settings in TastyIgniter admin
4. Extend with additional pages and components as needed

## Notes

- This is a **template theme** - meant to be customized
- Keep codebase minimal and focused
- Follow TastyIgniter theme conventions
- Use Tailwind utilities over custom CSS when possible
- Leverage Alpine.js for simple interactions
