<p align="center">
    <a href="https://packagist.org/packages/tipowerup/ti-theme-orange-tw"><img src="https://img.shields.io/packagist/dt/tipowerup/ti-theme-orange-tw" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/tipowerup/ti-theme-orange-tw"><img src="https://img.shields.io/packagist/v/tipowerup/ti-theme-orange-tw" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/tipowerup/ti-theme-orange-tw"><img src="https://img.shields.io/packagist/l/tipowerup/ti-theme-orange-tw" alt="License"></a>
</p>

## Introduction

Orange TW (also known as **Orange Theme with Tailwind CSS**) is a modernized version of the popular [TastyIgniter Orange Theme](https://github.com/tastyigniter/ti-theme-orange), rebuilt from the ground up with **Tailwind CSS** and enhanced with modern features like dark mode, mobile-first navigation, and SPA-like page transitions. It retains full feature parity with the original Orange theme while delivering a faster, more customizable, and visually refined experience.

Built with Laravel Livewire and Alpine.js, Orange TW is designed for restaurant online ordering on the TastyIgniter platform. It's perfect for restaurants, cafes, bars, bistros, pizza shops, bakeries, food delivery services, or any food-related business looking for a modern, professional storefront.

## What's New in Orange TW

Orange TW takes the solid foundation of the original Orange theme and elevates it with:

- **Tailwind CSS** - Utility-first CSS framework replacing Bootstrap for smaller bundle sizes and easier customization
- **Dark Mode** - System preference detection with manual toggle, persisted via localStorage
- **Mobile App-Like Navigation** - Bottom tab bar navigation for mobile devices (Uber Eats/DoorDash style)
- **Smart Sticky Header** - Hides on scroll down, reveals on scroll up for maximum content visibility
- **SPA-Like Transitions** - Native View Transitions API with Livewire navigate for instant page transitions
- **CSS Variable Theming** - Runtime customizable colors from the admin panel without rebuilding assets
- **Performance Optimized** - Code splitting, responsive images, debounced inputs, and content hashing

## Features

- Modern and clean design with Tailwind CSS
- Full dark mode support with system preference detection
- Responsive design with mobile-first approach
- Bottom tab bar navigation for mobile devices
- Smart sticky header with scroll behavior
- SPA-like page transitions using View Transitions API
- Effortlessly manage and showcase your menu items
- AJAX add-to-cart with real-time updates
- Multiple checkout flow with single or two-page checkout
- 15+ customizable theme colors from the admin panel
- Lightweight and optimized for speed with Vite
- Google Fonts integration with font preloading
- Supports static pages and navigation menus
- GDPR-compliant cookie consent banner
- Social login integration (Google, Facebook, Twitter)
- Newsletter subscription form
- Contact form with captcha support
- Review and rating system
- Reservation booking system
- Compatible with all TastyIgniter extensions

## Requirements

- TastyIgniter v4.0+
- PHP 8.1+
- Node.js 18+ (for asset compilation)

## Installation

Install the theme via Composer:

```bash
composer require tipowerup/ti-theme-orange-tw
```

Then compile the assets:

```bash
cd vendor/tipowerup/ti-theme-orange-tw
npm install
npm run build
```

Activate the theme from **Design > Themes** in your TastyIgniter admin panel.

## Development

For development with hot reloading:

```bash
npm run dev
```

To build for production:

```bash
npm run build
```

## Customization

### Theme Colors

All theme colors can be customized from **Design > Themes > Orange TW > Customize**. The theme supports 15 customizable colors including:

- Primary, Secondary, Accent colors
- Success, Warning, Danger, Info states
- Text, Background, Surface, Border colors
- Light and dark mode variants

Colors are applied via CSS variables, so changes take effect immediately without rebuilding assets.

### Dark Mode

Dark mode can be configured to:
- Follow system preference (default)
- Default to light mode
- Default to dark mode

Users can toggle dark mode using the switch in the header, and their preference is saved to localStorage.

### Fonts

Configure Google Fonts from the theme settings. The theme uses Inter as the default font family with optimized font loading.

## Tech Stack

| Technology | Purpose |
|------------|---------|
| Tailwind CSS 3.x | Utility-first styling |
| Livewire 3.x | Dynamic components |
| Alpine.js 3.x | JavaScript interactions |
| Vite 5.x | Asset bundling |
| View Transitions API | Page transitions |

## Migration from Orange Theme

Orange TW is designed as a drop-in replacement for the original Orange theme. All TastyIgniter extensions are fully supported. Simply install, activate, and customize your colors.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Reporting Issues

If you encounter a bug in this theme, please report it using the [Issue Tracker](https://github.com/tipowerup/ti-theme-orange-tw/issues) on GitHub.

## Contributing

Contributions are welcome! Please read [TastyIgniter's contributing guide](https://tastyigniter.com/docs/resources/contribution-guide).

## Security Vulnerabilities

For reporting security vulnerabilities, please see our security policy.

## Credits

- Based on [TastyIgniter Orange Theme](https://github.com/tastyigniter/ti-theme-orange) by TastyIgniter Dev Team
- Built by [TiPowerUp](https://github.com/tipowerup)

## License

Orange TW Theme is open-source software licensed under the [MIT license](LICENSE.md).
