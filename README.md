**LedgerFinance – Expense Tracker**

LedgerFinance is a full-stack personal finance management application that allows users to securely track their income and expenses, view their financial summary, and manage their transaction history.

The application is built with Vue 3, TypeScript, Tailwind CSS, and Nuxt UI components on the frontend, with Laravel and MySQL powering the backend.

✨ Features
🔐 User Registration

Users can create an account to securely manage their financial data.

Register with name, email, and password.
Email must be unique.
Passwords are securely hashed.
Validation for registration data.
🔑 Login

Users can securely access their personal financial records.

Login with valid credentials.
Invalid credentials display an error.
Authentication is required to access protected features.

📊 Dashboard

The dashboard provides an overview of the user's financial status.

Total Income
Total Expenses
Current Balance
Recent Transactions

The current balance is calculated as:

Current Balance = Total Income - Total Expenses
💰 Add Transaction

Users can record both income and expense transactions.

Each transaction contains:

Title
Amount
Type
Category
Date

Supported transaction types:

Income
Expense
📋 View Transactions

Users can view their complete transaction history.

Each transaction displays:

Title
Amount
Category
Type
Date

Transactions are displayed with the latest transactions first.

✏️ Edit Transaction

Users can modify existing transactions.

Existing transaction data is pre-filled.
Users can update the transaction details.
Updated data is saved successfully.
🗑️ Delete Transaction

Users can remove transactions they no longer need.

Delete confirmation is displayed.
Transaction is permanently removed after confirmation.
🔎 Filter Transactions

Users can filter their transaction history based on:

Transaction type
Category
Date range
🔍 Search Transactions

Users can quickly find transactions by searching their title.

Search by transaction title.
Display matching transactions.
🚪 Logout

Users can securely end their session.

Ends the authenticated session.
Redirects the user to the login page.
🛠️ Tech Stack
Frontend
Vue 3
TypeScript
Vite
Tailwind CSS
Nuxt UI Components
Axios
Vue Router
HTML5
CSS
Backend
Laravel
PHP
RESTful APIs
Eloquent ORM
Laravel Request Validation
Database
MySQL
🏗️ Application Architecture
                         LedgerFinance
                              │
             ┌────────────────┴────────────────┐
             │                                 │
        Vue Frontend                     Laravel Backend
             │                                 │
     ┌───────┴────────┐                ┌───────┴────────┐
     │                │                │                │
   Views         Components        Controllers      Services
     │                │                │                │
     └────────┬───────┘                └────────┬───────┘
              │                                 │
           Axios ───────── REST API ────────────┘
                                                │
                                                │
                                             Eloquent
                                                │
                                                ▼
                                             MySQL
📁 Project Structure
LedgerFinance/
│
├── database/                       # Database migrations, seeders and factories
│
├── public/                         # Public assets
│
├── resources/
│   ├── css/                        # Tailwind CSS and application styles
│   │
│   └── js/                         # Vue frontend application
│       ├── components/             # Reusable Vue components
│       ├── composables/            # Reusable Vue composables
│       ├── configs/                # Frontend configuration
│       ├── enums/                  # Frontend enums
│       ├── interfaces/             # TypeScript interfaces
│       ├── models/                 # Frontend models
│       ├── router/                 # Vue Router configuration
│       ├── services/               # API service layer
│       ├── store/                  # Application state management
│       ├── views/                  # Application pages/views
│       ├── app.ts                  # Vue application entry point
│       └── vite-env.d.ts           # Vite TypeScript definitions
│
├── routes/                         # Laravel API routes
│
├── src/                            # Laravel backend application
│   ├── Contracts/
│   │   └── Services/               # Service contracts/interfaces
│   │
│   ├── Http/
│   │   ├── Controllers/            # API controllers
│   │   ├── Requests/               # Request validation
│   │   └── Resources/              # API resources
│   │
│   ├── Models/                     # Eloquent models
│   ├── Providers/                  # Laravel service providers
│   └── Services/                   # Business logic and services
│
├── storage/                        # Laravel storage and logs
│
├── tests/                          # Automated tests
│
├── vendor/                         # PHP dependencies
│
├── .env.example                    # Environment configuration example
├── .gitignore
├── artisan                         # Laravel Artisan CLI
├── composer.json                   # PHP dependencies
├── package.json                    # Node.js dependencies
└── README.md
🚀 Getting Started
Prerequisites

Make sure the following are installed:

PHP 8.x
Composer
Node.js
npm
MySQL
Git
📥 Installation
1. Clone the Repository
git clone git@github-personal:KoushikReddyVummalareddy/LedgerFinance.git
cd LedgerFinance
2. Install PHP Dependencies
composer install
3. Install Frontend Dependencies
npm install
4. Create Environment File
cp .env.example .env
5. Generate Laravel Application Key
php artisan key:generate
🗄️ Database Configuration

Create a MySQL database for the application.

For example:

ledger_finance

Configure your .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ledger_finance
DB_USERNAME=root
DB_PASSWORD=

Update the database credentials according to your local MySQL configuration.

Run Database Migrations
php artisan migrate

If seeders are available and you want to populate sample data:

php artisan db:seed

Or:

php artisan migrate --seed
⚙️ Frontend Configuration

Configure the frontend API URL in your environment file.

For example:

VITE_API_BASE_URL=http://127.0.0.1:8000

Make sure the URL matches the Laravel backend URL used in your local environment.

▶️ Running the Application

The frontend and backend should be started separately during development.

Start Laravel Backend
php artisan serve

The backend will typically be available at:

http://127.0.0.1:8000
Start Vue Frontend
npm run dev

Vite will display the frontend URL in the terminal, typically:

http://localhost:5173
🔌 API Overview

The Laravel backend exposes RESTful APIs for authentication, dashboard data, and transaction management.

Feature	Method	Purpose
Register	POST	Create a new user
Login	POST	Authenticate user
Logout	POST	End user session
Dashboard	GET	Retrieve financial summary
Transactions	GET	Retrieve transactions
Add Transaction	POST	Create a transaction
View Transaction	GET	Retrieve a transaction
Edit Transaction	PUT/PATCH	Update a transaction
Delete Transaction	DELETE	Delete a transaction
Filter Transactions	GET	Filter transactions
Search Transactions	GET	Search transactions by title

The exact API paths depend on the route definitions in the Laravel application.

💵 Transaction Types

LedgerFinance supports two transaction types.

Income

Represents money received by the user.

Examples:

Salary
Freelance income
Bonus
Other income
Expense

Represents money spent by the user.

Examples:

Food
Shopping
Transportation
Bills
Entertainment
🔐 Security

The application includes several security and validation measures:

Secure password hashing.
Unique email validation.
Authentication-protected routes.
User-specific financial data.
Backend request validation.
Authenticated logout.
Protected transaction operations.

Users can only access and manage their own financial records.

👤 User Stories

The following user stories have been implemented:

User Story	Status
User Registration	✅ Completed
Login	✅ Completed
Dashboard	✅ Completed
Add Transaction	✅ Completed
View Transactions	✅ Completed
Edit Transaction	✅ Completed
Delete Transaction	✅ Completed
Filter Transactions	✅ Completed
Search Transactions	✅ Completed
Logout	✅ Completed
📌 Acceptance Criteria
User Registration
 Register with name, email, and password.
 Email must be unique.
 Password is securely hashed.
Login
 Valid credentials allow login.
 Invalid credentials display an error.
Dashboard
 Display total income.
 Display total expenses.
 Display current balance.
 Display recent transactions.
Add Transaction
 Enter title.
 Enter amount.
 Select transaction type.
 Select category.
 Select date.
 Save transaction successfully.
View Transactions
 List all transactions.
 Display title, amount, category, type, and date.
 Display latest transactions first.
Edit Transaction
 Pre-fill existing transaction data.
 Save updated transaction.
Delete Transaction
 Display delete confirmation.
 Permanently delete the transaction.
Filter Transactions
 Filter by transaction type.
 Filter by category.
 Filter by date range.
Search Transactions
 Search transactions by title.
 Display matching results.
Logout
 End the user session.
 Redirect to the login page.
🧪 Testing

Run the Laravel test suite with:

php artisan test

You can also run a specific test:

php artisan test --filter=TestName
🔄 Development Workflow

A typical development workflow for the project is:

User Action
    ↓
Vue Component
    ↓
Composable / Service
    ↓
Axios API Request
    ↓
Laravel Route
    ↓
Controller
    ↓
Request Validation
    ↓
Service Layer
    ↓
Eloquent Model
    ↓
MySQL
    ↓
API Response
    ↓
Vue UI Update

This separation keeps the frontend presentation logic, API communication, backend business logic, and database operations organized.

📈 Future Improvements

Potential future enhancements include:

Monthly and yearly financial reports.
Expense and income charts.
Budget management.
Export transactions to CSV/Excel.
Recurring transactions.
Financial analytics.
Notifications and reminders.
Dark mode.
Improved mobile responsiveness.
Pagination for large transaction histories.
📄 License

This project was developed as a personal finance tracking application for learning, development, and demonstration purposes.
