# TiPowerUp Orange TW Theme

A minimal TastyIgniter theme template with Tailwind CSS and Vite for building custom themes.

## Introduction

This is a minimal starter template for TastyIgniter themes that uses modern frontend tooling:

- **Tailwind CSS** for utility-first styling
- **Vite** for fast asset compilation
- **Alpine.js** for lightweight JavaScript interactions
- **Laravel Boost** for AI-assisted development

## Features

- Modern build system with Vite
- Tailwind CSS with custom design tokens
- Minimal, clean codebase for easy customization
- Proper namespace structure (`TiPowerUp\OrangeTw`)
- MIT licensed
- Ready for AI-assisted development

## Installation

1. Install dependencies:
```bash
composer install
npm install
```

2. Build assets:
```bash
# Development
npm run dev

# Production
npm run build

# Watch mode
npm run watch
```

## Structure

```
.
├── composer.json           # PHP dependencies
├── package.json           # Node dependencies
├── vite.config.js         # Vite configuration
├── tailwind.config.js     # Tailwind configuration
├── src/
│   └── ServiceProvider.php
├── resources/
│   ├── meta/
│   │   ├── assets.json
│   │   └── fields.php
│   ├── lang/
│   │   └── en/
│   │       └── default.php
│   ├── views/
│   │   ├── _layouts/
│   │   │   └── default.blade.php
│   │   ├── _pages/
│   │   │   └── home.blade.php
│   │   └── includes/
│   │       ├── head.blade.php
│   │       ├── header.blade.php
│   │       ├── footer.blade.php
│   │       └── scripts.blade.php
│   └── src/
│       ├── css/
│       │   └── app.css
│       └── js/
│           └── app.js
└── public/
    ├── css/
    └── js/
```

## Configuration

- **Theme Code**: `tipowerup-orange-tw`
- **Namespace**: `TiPowerUp\OrangeTw`
- **View Namespace**: `tipowerup-orange-tw`
- **Translation Key**: `tipowerup.orange-tw`

## Customization

This template is designed to be extended. Start by:

1. Customizing Tailwind colors in `tailwind.config.js`
2. Adding components to `resources/views/`
3. Modifying layouts in `resources/views/_layouts/`
4. Adding custom CSS/JS in `resources/src/`

## Development with Laravel Boost

This theme includes Laravel Boost as a dev dependency for AI-assisted development workflows.

## License

MIT License - see [LICENSE](LICENSE) for details

## Credits

Built with [TastyIgniter](https://tastyigniter.com)
