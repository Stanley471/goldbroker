# Gold Broker

A Laravel-based web application for buying, selling, and managing precious metals (gold and silver) investments. The platform supports physical bullion purchases, with individual product tracking for each user's vault.

## Features

### Core Functionality
- **Live Gold Price Tracking** – Real-time gold and silver prices fetched from external APIs
- **Product Catalog** – Browse gold and silver products (coins, bars) with dynamic pricing based on market rates
- **Individual Product Holdings** – Each purchased product is tracked individually in your vault with purchase history
- **Portfolio Tracking** – View your holdings by product type, track profit/loss on each position
- **User Wallet** – Manage USD balance for purchases
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
- `Wallet` – User USD balance
- `Order` – Purchase and sale orders
- `UserHolding` – Individual product holdings tracking each purchase
- `Transaction` – Financial transaction records
- `Cart/CartItem` – Shopping cart functionality
- `IraAccount` – Gold IRA retirement accounts
- `Vault` – Secure storage locations
- `Referral` – Referral relationships
- `AdminLog` – Administrative activity logging

### Routes
- `/` – Landing page with live gold price
- `/products` – Product catalog
- `/dashboard` – User dashboard with portfolio overview
- `/wallet` – Vault with product holdings, deposit, and transaction history
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
- **User**: Default role for all registered users – can purchase products, manage vault holdings, and use IRA features
- **Admin**: Full access to admin dashboard and user management

### How Product Holdings Work

Unlike simple gold gram tracking, this platform tracks each product purchase individually:

1. **Purchase Products** – Add gold/silver products to your cart and checkout
2. **Individual Tracking** – Each product is tracked separately in your vault
3. **Portfolio View** – See your holdings grouped by product type
4. **Profit/Loss Tracking** – View unrealized gains/losses based on current market prices
5. **Detailed History** – Each holding maintains its purchase price, date, and storage location

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

## Recent Changes

### Individual Product Holdings
The system has been updated to track individual product holdings instead of just total gold grams. This provides:
- Better portfolio visibility
- Product-specific profit/loss tracking
- Detailed purchase history
- Support for multiple product types (coins, bars, different weights)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
