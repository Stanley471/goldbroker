# Gold Broker

A Laravel-based web application for buying, selling, and managing precious metals (gold and silver) investments. The platform supports physical bullion purchases, digital gold trading, and Gold IRA accounts.

## Features

### Core Functionality
- **Live Gold Price Tracking** – Real-time gold and silver prices fetched from external APIs
- **Buy & Sell Gold** – Purchase and sell digital gold by weight or physical bullion products
- **Product Catalog** – Browse gold and silver products (coins, bars) with dynamic pricing based on market rates
- **User Wallet** – Manage USD balance and gold holdings (in grams)
- **Shopping Cart** – Add products to cart and checkout seamlessly
- **Secure Vault Storage** – Physical bullion stored in secure vaults across multiple locations

### Investment Features
- **Gold IRA Accounts** – Create and manage Individual Retirement Accounts backed by physical gold
- **Referral System** – Invite friends and earn rewards through referral codes

### User Management
- **KYC Verification** – Know Your Customer verification process for secure trading
- **Transaction History** – Complete audit trail of all purchases, sales, and transfers
- **Role-Based Access** – Separate interfaces for customers and administrators

### Admin Dashboard
- Manage products (CRUD operations)
- View and manage user accounts
- Process KYC verifications
- Monitor orders and transactions
- View system logs and activity

## Tech Stack

- **Framework**: Laravel 12 (PHP 8.2+)
- **Authentication**: Laravel Breeze with email verification
- **Authorization**: Spatie Laravel Permission (role-based access control)
- **Frontend**: Tailwind CSS + Alpine.js
- **Build Tool**: Vite
- **Database**: SQLite (default), supports MySQL/PostgreSQL

## Project Structure

### Key Models
- `User` – Customer accounts with referral codes and KYC status
- `Product` – Bullion products (coins, bars) with dynamic pricing
- `GoldPrice` – Cached market prices for gold/silver
- `Wallet` – User balances (USD + gold grams)
- `Order` – Purchase and sale orders
- `Transaction` – Financial transaction records
- `Cart/CartItem` – Shopping cart functionality
- `IraAccount` – Gold IRA retirement accounts
- `Vault` – Secure storage locations
- `Referral` – Referral relationships
- `AdminLog` – Administrative activity logging

### Routes
- `/` – Landing page with live gold price
- `/products` – Product catalog
- `/dashboard` – User dashboard
- `/wallet` – Wallet management (deposit, view balance)
- `/orders` – Buy/sell gold (rate limited)
- `/cart` – Shopping cart
- `/checkout` – Checkout process
- `/ira` – IRA account management
- `/referrals` – Referral program
- `/admin` – Admin dashboard (admin only)

## Installation

```bash
# Clone the repository
git clone <repository-url>
cd goldbrokers

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate

# Build assets
npm run build

# Or run in development mode
composer run dev
```

## Usage

### Default User Roles
- **User**: Default role for all registered users – can trade gold, manage wallet, and use IRA features
- **Admin**: Full access to admin dashboard and user management

### Gold Pricing
- Gold prices are fetched from external APIs and cached
- Product prices include a 1.5% markup over spot price
- Silver pricing uses a gold-to-silver ratio approximation

### Rate Limiting
- Buy/sell endpoints are rate-limited to 10 requests per minute to prevent abuse

## Security Features

- Throttling on critical trading endpoints
- KYC verification required for trading
- Role-based access control
- Admin activity logging
- CSRF protection on all forms
- Password hashing with bcrypt

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
