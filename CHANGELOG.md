# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2025-01-27

### Added

- Initial release of Orange TW (Orange Theme with Tailwind CSS)
- Based on TastyIgniter Orange Theme
- Tailwind CSS 3.x replacing Bootstrap for styling
- Dark mode support with system preference detection and manual toggle
- Mobile bottom tab bar navigation (Uber Eats/DoorDash style)
- Smart sticky header (hides on scroll down, shows on scroll up)
- SPA-like page transitions using native View Transitions API
- CSS variable theming for runtime color customization
- 15 customizable theme colors from admin panel
- Vite 5.x build system with code splitting and content hashing
- Responsive images with srcset for retina displays
- Debounced inputs for improved performance
- Google Fonts integration with font preloading
- Livewire 3.x components for all interactive features
- Alpine.js 3.x for JavaScript interactions

### Pages

- Home page with slider, featured items, and location search
- Locations listing with search and filters
- Menu page with category navigation and cart sidebar
- Cart page with quantity controls and order summary
- Checkout page with multi-step flow
- Account dashboard with order history
- Address book management
- Reservation booking and management
- Contact page with captcha support
- Login, register, and password reset pages
- Social login integration (Google, Facebook, Twitter)

### Components

- LocalSearch - Restaurant location search with autocomplete
- MenuItemList - Menu items with filtering and infinite scroll
- CartBox - Shopping cart with real-time updates
- CartItemModal - Menu item customization modal
- FulfillmentModal - Delivery/collection and time selection
- Checkout - Multi-step checkout process
- AddressBook - Customer address management
- ReservationList - Customer reservation history
- Booking - Reservation booking form
- ReviewList - Location reviews display
- LeaveReview - Review submission form
- Contact - Contact form with validation
- Captcha - reCAPTCHA and math captcha support
- FlashMessage - Toast notifications
- Modal - Reusable modal component
- NewsletterSubscribeForm - Newsletter subscription

### Credits

- Based on [TastyIgniter Orange Theme](https://github.com/tastyigniter/ti-theme-orange)
- Built with Tailwind CSS, Livewire, and Alpine.js
