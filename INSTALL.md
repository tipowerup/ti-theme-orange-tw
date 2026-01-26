# Installation Guide

## Prerequisites

- TastyIgniter v4.0 or higher
- PHP 8.1 or higher
- Node.js 18+ and npm
- Composer

## Installation Steps

### 1. Install PHP Dependencies

```bash
composer install
```

This will install the required TastyIgniter core package.

### 2. Install Node Dependencies

```bash
npm install
```

This installs:
- Vite (build tool)
- Tailwind CSS and plugins
- Alpine.js
- PostCSS and Autoprefixer

### 3. Build Assets

For development (with hot reload):
```bash
npm run dev
```

For production:
```bash
npm run build
```

For watch mode:
```bash
npm run watch
```

### 4. Activate Theme

1. Log in to your TastyIgniter admin panel
2. Navigate to **Design > Themes**
3. Find "Orange TW Theme" in the list
4. Click **Activate**

### 5. Configure Theme

1. Go to **Design > Themes**
2. Click the **Customize** button for Orange TW Theme
3. Configure:
   - Logo Image or Logo Text
   - Google Font URL (default: Inter)
   - Custom CSS (optional)
   - Custom JavaScript (optional)

## Development Workflow

### Hot Reload Development

1. Start Vite dev server:
```bash
npm run dev
```

2. Make changes to:
   - `resources/src/css/app.css` (Tailwind CSS)
   - `resources/src/js/app.js` (JavaScript)
   - `resources/views/**/*.blade.php` (Templates)

3. Changes will auto-reload in browser

### Production Build

Before deploying:
```bash
npm run build
```

This creates optimized, minified assets in `public/css/` and `public/js/`.

## File Structure Overview

```
├── composer.json              # PHP dependencies
├── package.json              # Node dependencies
├── vite.config.js           # Vite build config
├── tailwind.config.js       # Tailwind CSS config
├── postcss.config.js        # PostCSS config
│
├── src/
│   └── ServiceProvider.php  # Theme service provider
│
├── resources/
│   ├── meta/
│   │   ├── assets.json      # Asset definitions
│   │   └── fields.php       # Theme settings
│   ├── lang/en/
│   │   └── default.php      # English translations
│   ├── views/
│   │   ├── _layouts/        # Layout templates
│   │   ├── _pages/          # Page templates
│   │   └── includes/        # Partial templates
│   └── src/
│       ├── css/app.css      # Main CSS (Tailwind)
│       └── js/app.js        # Main JavaScript
│
└── public/                   # Compiled assets (auto-generated)
    ├── css/
    └── js/
```

## Customization

### Adding Tailwind Classes

Edit `resources/src/css/app.css` to add custom styles:

```css
@layer components {
  .my-custom-class {
    @apply px-4 py-2 bg-primary-500 text-white rounded;
  }
}
```

### Adding JavaScript

Edit `resources/src/js/app.js`:

```javascript
import Alpine from 'alpinejs';

// Add your custom Alpine components
Alpine.data('myComponent', () => ({
  // component logic
}));

window.Alpine = Alpine;
Alpine.start();
```

### Modifying Colors

Edit `tailwind.config.js`:

```javascript
theme: {
  extend: {
    colors: {
      primary: {
        // your custom color palette
      },
    },
  },
},
```

## Troubleshooting

### Assets Not Loading

1. Ensure you ran `npm run build`
2. Check that `public/css/app.css` and `public/js/app.js` exist
3. Clear TastyIgniter cache: **Settings > System > Clear Cache**

### Styles Not Updating

1. Make sure Vite dev server is running (`npm run dev`)
2. Hard refresh browser (Ctrl+Shift+R or Cmd+Shift+R)
3. Check browser console for errors

### Build Errors

1. Delete `node_modules/` and run `npm install` again
2. Clear npm cache: `npm cache clean --force`
3. Ensure Node.js version is 18 or higher: `node -v`

## Support

For issues or questions:
- Check TastyIgniter documentation: https://tastyigniter.com/docs
- Review Tailwind CSS docs: https://tailwindcss.com
- Check Vite documentation: https://vitejs.dev

## License

MIT License - See [LICENSE](LICENSE) file for details
