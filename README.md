# LedgerFinance

A modern full-stack personal finance management application for securely tracking income, expenses, and financial activity.

LedgerFinance is a web-based expense tracking application built with **Vue 3 and Laravel**. It provides authenticated users with a centralized platform to manage transactions, monitor their financial position, and quickly search or filter their transaction history.

## Overview

LedgerFinance is designed around a simple financial workflow:

**Authenticate → View Dashboard → Manage Transactions → Analyze Financial Activity**

The application separates frontend presentation and interaction from backend business logic and data persistence through a RESTful API architecture.

## Key Features

### Authentication & User Management

- User registration with name, email, and password
- Unique email validation
- Secure password hashing
- User authentication
- Protected application functionality
- Secure logout

### Financial Dashboard

Provides a quick overview of the user's financial activity:

- Total income
- Total expenses
- Current balance
- Recent transactions

The current balance is calculated using:

text
Current Balance = Total Income - Total Expenses
Transaction Management

Users can manage their financial transactions through a complete CRUD workflow.

Each transaction contains:

Title
Amount
Type
Category
Date

Supported operations:

Create transactions
View transactions
Update transactions
Delete transactions
Review transaction history
Search & Filtering

The transaction history can be refined using:

Transaction type
Category
Date range
Title-based search

Transactions are displayed in latest-first order to provide quick access to recent financial activity.

Technology Stack
Layer	Technology
Frontend	Vue 3
Language	TypeScript
Build Tool	Vite
UI Styling	Tailwind CSS
UI Components	Nuxt UI
HTTP Client	Axios
Routing	Vue Router
Backend	Laravel
Backend Language	PHP
ORM	Eloquent
API	RESTful API
Database	MySQL
Architecture
┌─────────────────────────────────────────────┐
│                  User                       │
└──────────────────────┬──────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────┐
│              Vue 3 Frontend                 │
│                                             │
│  Views → Components → Composables →         │
│                  Services                   │
└──────────────────────┬──────────────────────┘
                       │
                       │ REST API
                       ▼
┌─────────────────────────────────────────────┐
│             Laravel Backend                 │
│                                             │
│  Routes → Controllers → Requests →          │
│              Services → Models              │
└──────────────────────┬──────────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────┐
│                  MySQL                      │
└─────────────────────────────────────────────┘
Project Structure
LedgerFinance/
│
├── database/
│   ├── factories/             # Model factories
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
│
├── public/                    # Public application assets
│
├── resources/
│   ├── css/                   # Tailwind CSS and application styles
│   │
│   └── js/                    # Vue frontend application
│       ├── components/        # Reusable UI components
│       ├── composables/       # Reusable Vue composables
│       ├── configs/           # Frontend configuration
│       ├── enums/             # Frontend enums
│       ├── interfaces/        # TypeScript interfaces
│       ├── models/            # Frontend models
│       ├── router/            # Vue Router configuration
│       ├── services/          # API communication layer
│       ├── store/             # Application state management
│       └── views/             # Application pages
│
├── routes/                    # Laravel API routes
│
├── src/
│   ├── Contracts/             # Service contracts
│   │
│   ├── Http/
│   │   ├── Controllers/       # API controllers
│   │   ├── Requests/          # Request validation
│   │   └── Resources/         # API response resources
│   │
│   ├── Models/                # Eloquent models
│   ├── Providers/             # Laravel service providers
│   └── Services/              # Business logic
│
├── storage/                   # Application storage and logs
├── tests/                     # Automated tests
│
├── artisan                    # Laravel CLI
├── composer.json              # PHP dependencies
├── package.json               # Frontend dependencies
└── README.md
Getting Started
Prerequisites

Ensure the following are installed:

PHP 8.x
Composer
Node.js
npm
MySQL

Git
1. Clone the Repository
git clone git@github-personal:KoushikReddyVummalareddy/LedgerFinance.git
cd LedgerFinance
2. Install Backend Dependencies
composer install
3. Install Frontend Dependencies
npm install
4. Configure Environment

Create the Laravel environment file:

cp .env.example .env

Generate the application key:

php artisan key:generate
5. Configure Database

Update the database configuration in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ledger_finance
DB_USERNAME=root
DB_PASSWORD=

Create the ledger_finance database in MySQL and run:

php artisan migrate
6. Configure Frontend API

Configure the backend API URL according to your local environment:

VITE_API_BASE_URL=http://127.0.0.1:8000
7. Start the Application

Start the Laravel backend:

php artisan serve

In a separate terminal, start the Vue development server:

npm run dev
API Responsibilities

The backend provides RESTful endpoints for the application's core functionality.

Area	Operations
Authentication	Register, Login, Logout
Dashboard	Financial summary, Recent transactions
Transactions	Create, Read, Update, Delete
Filtering	Type, Category, Date range
Search	Transaction title

The frontend communicates with these APIs through the dedicated service layer.

Security

Security considerations implemented within the application include:

Password hashing before persistence
Authentication for protected functionality
Unique email validation
Server-side request validation
User-specific transaction access
Protected transaction operations
Secure logout handling

Sensitive environment configuration such as database credentials should be maintained in .env and should not be committed to version control.

Run the Laravel test suite using:

php artisan test

Build the frontend for production:

npm run build
Future Enhancements

This project is developed as a personal finance management application for learning, development, and portfolio purposes.
