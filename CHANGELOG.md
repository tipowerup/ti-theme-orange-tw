# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.3] - 2026-04-28

### Changed

- **Toolkit constraint** bumped to `^0.5.0` — picks up
  [`tipowerup/ti-theme-toolkit:0.5.0`](https://github.com/tipowerup/ti-theme-toolkit/releases/tag/v0.5.0),
  which auto-wires the theme's `errors/` views into Laravel's exception
  handler. Removes ~30 lines of boilerplate from the theme's
  `ServiceProvider` (view-path injection + `errors.layout` brand-style
  composer now live in the toolkit, gated on non-admin requests).

### Removed

- **Duplicated error-view wiring in `ServiceProvider::boot()`** — moved
  upstream into `AbstractThemeServiceProvider::registerStorefrontErrorViews()`.
  No behaviour change for consumers; the theme's friendly 404 / 500 / 503
  templates still render on the storefront and the admin error UI is
  unaffected.

## [1.0.2] - 2026-04-28

### Added

- **Explicit `php: ^8.2` constraint** in `composer.json` — enforces the
  PHP version the theme already required at runtime. Composer now refuses
  to install on PHP < 8.2 (was silently allowed before, would fail at
  runtime). Also makes the PHP Version badge render on Packagist.

### Removed

- **`spatie/laravel-google-fonts`** dependency — never used by the theme.
  Google Fonts are loaded via a direct `<link>` in `head.blade.php`, not
  via the Spatie integration. Drops one dev install.
- **Redundant TastyIgniter extension requires** — `ti-ext-cart`,
  `ti-ext-local`, `ti-ext-payregister`, `ti-ext-reservation`, and
  `ti-ext-user` are pulled in transitively by `tastyigniter/core`.
  Listing them again in our `require` was noise, not enforcement.
  Theme activation requirements (`extra.tastyigniter-theme.require`) are
  unchanged.

### Changed

- **README jargon strip.** Dropped implementation-detail leakage from
  the "What's New" bullets, removed the contributor-facing "Frontend
  Source Layout" section (better suited to `CONTRIBUTING.md` if/when one
  is added), tightened the Tests paragraph, dropped the "Migration from
  Orange Theme" stub (already covered in Introduction), removed the
  toolkit row + non-existent View Transitions API row from the Tech
  Stack table, rewrote Reporting Issues / Contributing / Security
  sections with general best-practice text, softened the Credits
  attribution from "Based on" → "Inspired by", and dropped the
  redundant Monthly Downloads badge.
- **License badge** now links to `LICENSE.md` instead of the Packagist
  page (clicking actually opens the licence text).

## [1.0.1] - 2026-04-28

### Changed

- **Toolkit constraint** bumped to `^0.4.0` — picks up
  [`tipowerup/ti-theme-toolkit:0.4.0`](https://github.com/tipowerup/ti-theme-toolkit/releases/tag/v0.4.0),
  which adds an auto-publish hook on `main.theme.activated`. Theme
  assets now copy into `public/vendor/<theme-code>/` automatically when
  an admin activates the theme — no manual
  `php artisan igniter:theme-vendor-publish --force` needed in the
  standard install flow.

## [1.0.0] - 2026-04-28

First public release. Modern, mobile-first TastyIgniter theme — drop-in
replacement for the original Orange theme with full feature parity, built
on Tailwind v4, Livewire 3, and the shared
[`@tipowerup/ti-theme-toolkit`](https://github.com/tipowerup/ti-theme-toolkit).

### Added

#### Design system

- **Tailwind CSS v4** — CSS-first configuration via `@theme`, no
  `tailwind.config.js`, no PostCSS pipeline; styled through the official
  `@tailwindcss/vite` plugin.
- **CSS-variable theming** — runtime-customisable colours from the admin
  panel without rebuilding assets; brand colours injected on `<html>`
  (survives morph), neutrals scoped to light mode via `:root:not(.dark)`.
- **15+ customisable theme colours** — Primary, Secondary, Accent;
  Success / Warning / Danger / Info; Text, Text-muted, Body, Surface,
  Border (separate light/dark sets).
- **Google Fonts integration** with preconnect + font preloading.

#### Mobile-first UX

- **Bottom tab bar navigation** (Uber Eats / DoorDash style) — Home,
  Menu, Cart, Reservation.
- **Cart drawer** — slide-in from the right with sticky header (close X),
  scrollable item list with overscroll containment, and sticky footer
  carrying coupon entry + subtotal + checkout button.
- **Mobile account dropdown** in the header — Alpine dropdown matching
  the desktop pattern; auth-state aware (Login / Register when signed
  out; My Account / Orders / Address / Reservations / Logout when signed
  in).
- **Body-scroll lock** when any drawer or sheet is open.
- **Smart sticky header** — hides on scroll down, reveals on scroll up.

#### Performance & navigation

- **SPA-like transitions** — native View Transitions API + Livewire
  `wire:navigate`.
- **Active-route store** — global Alpine `$store.nav` listens to
  `livewire:navigated` + `popstate` so the active tab indicator follows
  the URL across SPA transitions.
- **Vite 5 build pipeline** with code splitting, content hashing, and a
  hashed-bundle JS strategy that plays nicely with `wire:navigate`.
- **Pre-built CSS / JS shipped in the package** — `composer require` +
  activate "just works"; no `npm install && npm run build` required by
  consumers.
- **Auto-publish on activation** — toolkit's `main.theme.activated`
  listener copies theme assets to `public/vendor/...` automatically.

#### Dark mode

- System preference detection with manual toggle in the header (desktop)
  and More sheet (mobile).
- Persists across `wire:navigate` DOM swaps via the toolkit's Alpine
  `$store.darkMode`.
- Light/dark palettes scoped via `:root:not(.dark)` so theme tokens stay
  valid in either mode.

#### Frontend stack

- **TypeScript** — frontend source under `strict: true`; modern Alpine
  components typed via a shared `AlpineComponent<TState, TWire>` helper.
  Legacy jQuery-plugin code is isolated and `@ts-nocheck`-flagged.
- **Theme Toolkit** integration — shared infrastructure for the Vite
  preset, Tailwind v4 theme tokens, dark-mode store, and auth Livewire
  components (Login, Register, ResetPassword, Socialite, Contact,
  NewsletterSubscribeForm). Toolkit ships `.d.ts` declarations for
  consumer IntelliSense.

### Pages

- Home — multi-slide hero banner with autoplay / hover-to-pause / keyboard
  navigation, featured items, location search.
- Menu (`/local/menus`) — searchable menu with categories, cart sidebar,
  add-to-cart modal.
- Cart, Checkout (single + multi-step), Reservation, Locations,
  Login / Register / Reset / Socialite, Address Book, Orders, Reservation
  history, Contact (with captcha support), error pages (404 / 500 / minimal).

### Components

- Theme-local: `LocalSearch`, `MenuItemList`, `CartBox`, `CartItemModal`,
  `FulfillmentModal`, `Checkout`, `AddressBook`, `ReservationList`,
  `Booking`, `ReviewList`, `LeaveReview`, `Captcha`, `FlashMessage`,
  `Modal`, `OrderPreview`, `ReservationPreview`.
- Toolkit-shipped (registered under the theme's namespace): `Login`,
  `Register`, `ResetPassword`, `Socialite`, `Contact`,
  `NewsletterSubscribeForm`. The theme provides only the corresponding
  blade views.

### Documentation

- README with hero screenshot, badge row (CI / version / downloads /
  stars / PHP version / license), feature pitch, installation guide.
- `docs/index.md` — TI marketplace-style documentation (features,
  quick start, settings table, mobile UX, troubleshooting, FAQ).
- `docs/screenshots/` — UI captures used by the README and marketplace.

### Credits

- Based on [TastyIgniter Orange Theme](https://github.com/tastyigniter/ti-theme-orange)
  by the TastyIgniter Dev Team.
- Built by [TiPowerUp](https://github.com/tipowerup) on
  [`@tipowerup/ti-theme-toolkit`](https://github.com/tipowerup/ti-theme-toolkit).
