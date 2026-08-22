# LedgerFinance

LedgerFinance is a personal finance management application built with Vue 3 and Laravel. It allows users to manage income and expenses, track transactions, and view their financial summary.

## Production

[LedgerFinance](https://ledgerfinance.wuaze.com)

## Tech Stack

- Vue 3
- TypeScript
- Tailwind CSS
- Laravel
- PHP
- MySQL
- Axios
- Vite

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- npm
- MySQL

### Installation

Clone the repository:

```bash
git clone <repository-url>
cd LedgerFinance
```

Install dependencies:

```bash
composer install
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database in `.env`, then run:

```bash
php artisan migrate --seed
```

## Development

Start the Laravel backend:

```bash
php artisan serve
```

Start the frontend in a separate terminal:

```bash
npm run dev
```

## Features

- User authentication
- Financial dashboard
- Income and expense management
- Transaction management
- Category management
- Transaction search and filtering
- Current balance and financial summary
- Responsive interface

## Project Structure

```text
LedgerFinance/
├── app/            # Laravel application
├── database/       # Migrations and seeders
├── routes/         # API routes
├── resources/      # Frontend resources
├── public/         # Public assets
├── src/            # Frontend source code
├── composer.json   # PHP dependencies
├── package.json    # Frontend dependencies
└── README.md       # Project documentation
```
