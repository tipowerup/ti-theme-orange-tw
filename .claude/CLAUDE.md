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

## Implemented Features

### Phase 3B: Password Reset and Social Login (Completed)

#### Pages Created
1. **Password Reset Page** (`resources/views/_pages/account/reset.blade.php`)
   - Email input for reset request
   - Reset form (when token provided)
   - Success message display
   - Back to login link
   - Dark mode compatible

2. **Socialite Page** (`resources/views/_pages/account/socialite.blade.php`)
   - Social login buttons display
   - Email confirmation form
   - Dark mode compatible

#### Livewire Components (SFC Format)
1. **ResetPassword Component** (`resources/views/livewire/reset-password.blade.php`)
   - Two modes: request reset and actual reset
   - Email input for reset request
   - Password inputs with confirmation
   - Success messages
   - Loading states
   - Form validation

2. **Socialite Component** (`resources/views/livewire/socialite.blade.php`)
   - Lists enabled social providers
   - OAuth redirect buttons with provider icons (Google, Facebook, Twitter)
   - Email confirmation form
   - Error handling

#### Controllers
1. **Logout Controller** (`src/Http/Controllers/Logout.php`)
   - Single action controller
   - Logs out user and clears session
   - Preserves cart session
   - Redirects to home page

#### Auth Partials
1. **Social Buttons** (`resources/views/includes/auth/social-buttons.blade.php`)
   - Reusable social login button group
   - Dynamic provider detection
   - SVG icons for popular providers

2. **Divider** (`resources/views/includes/auth/divider.blade.php`)
   - "Or continue with" separator
   - Dark mode compatible

#### Translations Added
- `account_reset_title`: Reset Password
- `account_socialite_title`: Confirm your email address
- `text_forgot`: Forgot password?
- `text_or_continue_with`: Or continue with
- `text_back_to_login`: Back to login

### Phase 4A: Account Dashboard and Orders (Completed)

#### Pages Created
1. **Account Dashboard Page** (`resources/views/_pages/account/account.blade.php`)
   - Welcome message with user name
   - Quick stats display
   - Account navigation sidebar
   - Account settings form
   - Dark mode compatible

2. **Orders Page** (`resources/views/_pages/account/orders.blade.php`)
   - Orders list with pagination
   - Status display
   - Order details link
   - Empty state
   - Dark mode compatible

3. **Single Order Page** (`resources/views/_pages/account/order.blade.php`)
   - Order details with status timeline
   - Order items list
   - Restaurant information
   - Delivery/payment details
   - Reorder and cancel buttons
   - Dark mode compatible

#### Livewire Components
1. **AccountSettings Component** (`src/Livewire/AccountSettings.php` + view)
   - Profile information form (name, email, phone)
   - Newsletter subscription toggle
   - Password change section
   - Loading states
   - Form validation
   - Auto-logout on email/password change

2. **OrderPreview Component** (`src/Livewire/OrderPreview.php` + view)
   - Order status display with progress bars
   - Reorder functionality
   - Cancel order functionality
   - Order polling (120s)
   - Guest/authenticated views
   - Error handling

#### View Components
1. **AccountDashboard Component** (`src/View/Components/AccountDashboard.php` + view)
   - Welcome card
   - Default address display
   - Cart summary card
   - Quick action links

2. **OrderList Component** (`src/View/Components/OrderList.php` + view)
   - Paginated orders table
   - Order status badges
   - Responsive design
   - Empty state

#### Forms
1. **SettingsForm** (`src/Livewire/Forms/SettingsForm.php`)
   - User profile fields
   - Password fields
   - Validation rules
   - Newsletter toggle

#### Order Partials (`resources/views/includes/order/`)
1. **status.blade.php** - Order status display with progress bars
2. **items.blade.php** - Order items with options and totals
3. **details.blade.php** - Delivery address, comment, payment method
4. **restaurant.blade.php** - Restaurant location information

#### Features
- Dark mode support throughout
- Responsive design (mobile-first)
- Loading states with wire:loading
- Empty states
- wire:navigate for SPA-like navigation
- Accessible components
- Status color coding
- Real-time order polling
- Reorder functionality
- Cancel order functionality

### Phase 5C: Newsletter, GDPR, Error Pages, and Pagination (Completed)

#### Livewire Components
1. **Newsletter Subscribe Form** (`resources/views/livewire/newsletter-subscribe-form.blade.php`)
   - Email input with validation
   - Success message display
   - Loading state with spinner
   - Send icon
   - Dark mode compatible
   - Accessible (ARIA labels)
   - Livewire v4 SFC format

#### Includes
1. **EU Cookie Banner** (`resources/views/includes/eucookiebanner.blade.php`)
   - Cookie consent banner with Alpine.js
   - Accept/Decline buttons
   - Privacy policy link
   - Stores consent in localStorage
   - Auto-hides after consent
   - Configurable via theme settings
   - Dark mode compatible
   - Accessible (ARIA labels)

#### Error Pages (`resources/views/errors/`)
1. **Error Layout** (`layout.blade.php`)
   - Minimal layout for error pages
   - Logo display
   - Dark mode support
   - Back to home link
   - Vite assets integration

2. **404 Error Page** (`404.blade.php`)
   - "Page Not Found" message
   - Search icon illustration
   - Quick links to Home, Locations, Menu
   - Contact suggestion
   - Dark mode compatible
   - Accessible

3. **500 Error Page** (`500.blade.php`)
   - "Server Error" message
   - Alert icon illustration
   - Try again button
   - Contact support link
   - Debug mode details (when enabled)
   - Dark mode compatible
   - Accessible

4. **Minimal Error Page** (`minimal.blade.php`)
   - Generic error template
   - Go back button
   - Go home button
   - Dark mode compatible

#### Pagination Views (`resources/views/pagination/`)
1. **Default Pagination** (`default.blade.php`)
   - Full pagination with page numbers
   - Previous/Next buttons with icons
   - Current page highlighting
   - Result count display
   - Mobile-responsive (simplified on mobile)
   - "Three dots" separator for large page counts
   - Dark mode compatible
   - Accessible (ARIA labels)

2. **Simple Pagination** (`simple_default.blade.php`)
   - Previous/Next only navigation
   - Page number indicator
   - Minimal design
   - Mobile-responsive
   - Dark mode compatible
   - Accessible

#### Features
- All components fully dark mode compatible
- Cookie banner respects user choice via localStorage
- Error pages provide helpful actions and links
- Pagination matches theme design system
- Newsletter shows clear success/error feedback
- All components responsive and mobile-friendly
- Accessible with proper ARIA labels
- Smooth transitions and loading states

## Notes

- This is a **template theme** - meant to be customized
- Keep codebase minimal and focused
- Follow TastyIgniter theme conventions
- Use Tailwind utilities over custom CSS when possible
- Leverage Alpine.js for simple interactions
- Dark mode is supported throughout all components
- Account and order components follow reference theme patterns
- Error pages, pagination, and GDPR components are production-ready
