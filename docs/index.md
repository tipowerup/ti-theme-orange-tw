---
title: Orange TW Theme Documentation
---

# Orange TW Theme

A modern, mobile-first TastyIgniter storefront theme — Tailwind v4, dark mode, instant page transitions, and full brand customization. Built on the [Orange theme](https://github.com/tastyigniter/ti-theme-orange) foundation with feature parity, faster rendering, and a more polished customer experience.

---

## Features

- **Mobile-first design** — bottom tab bar, swipe-friendly cart drawer, native-feeling sheets
- **Dark mode** — system-preference detection, manual toggle, persists across navigations
- **Tailwind CSS v4** — CSS-first design tokens via `@theme`, no `tailwind.config.js`
- **SPA-like transitions** — Livewire `wire:navigate` + View Transitions API
- **Smart sticky header** — hides on scroll-down, reveals on scroll-up
- **Runtime brand customization** — admin-configured colours apply via CSS variables, no rebuild needed
- **Multi-banner hero** — autoplay slider with hover-to-pause and keyboard navigation
- **Auth flow ready** — Login, Register, Reset Password, Socialite, Newsletter, Contact components ship pre-wired
- **Drop-in Orange replacement** — same admin settings, same TI extension support, no migration

---

## Quick Start

### Installation

```bash
composer require tipowerup/ti-theme-orange-tw
php artisan igniter:theme-vendor-publish --force
```

### Activate

1. Go to **Design > Themes**
2. Find **Orange TW Theme**
3. Click **Activate**

### Customize

1. From the theme list, click **Customize** on Orange TW Theme
2. Adjust your brand colours, logo, banners, and fonts
3. Save — changes take effect immediately

---

## Theme Settings

All settings live under **Design > Themes > Orange TW > Customize**.

| Tab | Purpose |
|-----|---------|
| General | Logo, favicon, site title, Google Font URL |
| Colors | Brand palette (primary, secondary, accent, status colours) and neutrals |
| Banners | Multi-slide hero on the home page (text, CTA, background image, link) |
| Footer | Footer layout, social links, copyright |
| Dark Mode | Default mode (system / light / dark), toggle visibility |
| Custom CSS / JS | Admin-injected overrides without touching theme files |

Brand colours apply via CSS variables — no rebuild needed when an admin tweaks the palette. Neutral overrides are scoped to light mode; dark mode keeps its own palette.

---

## Pages

The theme ships these front-end pages out of the box:

| Page | Permalink | Component |
|------|-----------|-----------|
| Home | `/` | Multi-slide banner + featured items + locations grid |
| Menu | `/local/menus` | Searchable menu with categories, cart sidebar |
| Cart | `/cart` | Cart summary + checkout CTA |
| Checkout | `/checkout` | Address book + fulfillment + payment |
| Reservations | `/reservation` | Date/time picker + table reservation flow |
| Locations | `/locations` | Location finder + delivery-area map |
| Account | `/account/*` | Login, Register, Reset, Address Book, Orders, Reservations |
| Contact | `/contact` | Contact form + opening hours |

---

## Mobile Experience

The mobile UI was redesigned around how customers actually order on phones:

- **Bottom tab bar** — Home, Menu, Cart, Reservations (Uber Eats / DoorDash style)
- **Cart drawer** — slide-in from the right; sticky checkout button at the bottom; scrollable item list with overscroll containment
- **More sheet** — bottom sheet for secondary navigation (admin-configured `mobile-menu`)
- **Body-scroll lock** — prevents the page underneath from scrolling while a drawer/sheet is open
- **Active tab indicator** — follows the current URL even across `wire:navigate` transitions

---

## Dark Mode

Dark mode is built-in:

- **System preference detection** on first load
- **Manual toggle** in the header (desktop) and More sheet (mobile)
- **Persists** across `wire:navigate` DOM swaps via the toolkit's Alpine `$store.darkMode`
- **CSS-variable scoped** — light/dark palettes don't interfere; theme tokens stay valid in either mode

To make a custom component dark-mode aware, use Tailwind's `dark:` modifier:

```html
<div class="bg-body dark:bg-surface text-text">
    Hello
</div>
```

The `bg-body`, `bg-surface`, and `text-text` utilities resolve to admin-configured colours, so they automatically pick up overrides.

---

## Customization

### Theme Colors

15+ brand and neutral colours, configurable from the admin without rebuilding assets:

- Primary, Secondary, Accent
- Status: Success, Warning, Danger, Info
- Neutrals: Text, Text-muted, Body, Surface, Border (separate light/dark sets)

### Fonts

Set any Google Fonts URL under **General > Google Font URL**. The theme uses **Inter** by default with optimized font loading (preconnect + preload).

### Banners

Add up to several hero slides under **Banners**. Each slide carries a heading, sub-heading, CTA label + URL, background image, and an optional alignment. Autoplay, hover-to-pause, and keyboard navigation work out of the box.

### Custom CSS / JS

For one-off overrides without forking the theme, paste CSS or JS into the **Custom CSS** / **Custom JS** fields under theme customize. They're rendered after the bundled theme assets, so they reliably override built-in styles.

---

## Technical Details

### Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel + TastyIgniter v4 + Livewire 3 |
| Frontend | Tailwind CSS v4 + Alpine.js 3 + TypeScript (strict) |
| Build | Vite 5 (`@tailwindcss/vite`) |
| Toolkit | [`@tipowerup/ti-theme-toolkit`](https://github.com/tipowerup/ti-theme-toolkit) |

### How Theming Works

- **Compile-time defaults** live in the toolkit's `theme.css` (`@theme` block).
- **Runtime overrides** are injected as inline CSS variables on `<html>` (brand colours) and a scoped `<style>` block (neutrals) — driven by admin settings.
- **Result**: admins can re-brand without rebuilding assets. The toolkit's `ThemePayloadResolver` handles all of this.

### File Layout

```
resources/
├── css/app.css           # Tailwind v4 entry — imports toolkit's theme.css
├── js/app.ts             # Entry — Alpine factories + helpers
├── js/components/        # Typed Alpine x-data factories
└── views/                # Blade templates (layouts, pages, includes)
```

---

## Troubleshooting

### Assets Not Loading After Install

**Symptom**: Theme renders unstyled, no JS, broken images.

**Solution**: run the publish command from your project root:

```bash
php artisan igniter:theme-vendor-publish --force
```

This copies `vendor/tipowerup/ti-theme-orange-tw/public/*` to your project's `public/vendor/tipowerup-orange-tw/`. Required after first install on most setups.

### Dark Mode Flicker on Page Load

**Symptom**: brief light flash before the page renders in dark mode.

**Solution**: ensure the `<head>` block runs the dark-mode pre-flight script that the theme ships. It's auto-included via the default layout — verify your layout extends `default` rather than rolling its own `<head>`.

### Custom Colors Not Showing

**Symptom**: changed brand colour in admin, theme still shows old colour.

**Solution**:
1. Hard-refresh the browser (Ctrl/Cmd + Shift + R) — CSS variables apply on next request, but cached HTML may still hold old values.
2. Run `php artisan view:clear` if a CDN or full-page cache is in front of the site.

---

## Browser Support

- All modern evergreen browsers (Chrome, Firefox, Safari, Edge — last two major versions)
- Mobile: iOS Safari 16+, Chrome Android 110+
- Graceful degradation: View Transitions API is feature-detected; older browsers fall back to standard navigation

---

## FAQ

**Q: Can I use this alongside the original Orange theme?**

A: Yes — they're separate themes. Activate one or the other in Design > Themes. Migrating from Orange is a drop-in swap.

**Q: Will customising colours require me to rebuild assets?**

A: No. Brand and neutral colours apply via CSS variables at runtime. Only structural CSS changes need a rebuild.

**Q: Does it work with TastyIgniter extensions?**

A: Yes — full compatibility with the standard extension set (cart, coupons, payments, reservations, socialite, etc.) inherited from Orange.

**Q: How do I customise the mobile bottom tab bar?**

A: The "Browse" section in the More sheet pulls from the `mobile-menu` defined in **Design > Menus**. Edit items, add static pages, or hide entries from there.

**Q: Can I override a specific Livewire component?**

A: Yes. Drop a class with the same name in your project's theme `src/Livewire/` directory — the toolkit's auto-loader runs theme classes after toolkit defaults, last-writer-wins.

---

## Support

- **Issues & Contributions**: [GitHub Repository](https://github.com/tipowerup/ti-theme-orange-tw)
- **Contact**: [tipowerup.com/contact](https://tipowerup.com/contact)
- **Discord Community**: [tipowerup.com/social/discord](https://tipowerup.com/social/discord)
