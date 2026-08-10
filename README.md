LedgerFinance

LedgerFinance is a simple personal finance management application built with Vue 3 and Laravel. It helps users manage their income and expenses, view their financial summary, and track transaction history.

Features

- User registration and login
- Secure authentication
- Financial dashboard
- Add, edit, and delete transactions
- Track income and expenses
- View current balance
- Search transactions
- Filter by type, category, and date
- View recent transactions

Tech Stack

- Frontend: Vue 3, TypeScript, Tailwind CSS
- Backend: Laravel, PHP
- Database: MySQL
- API: REST API
- HTTP Client: Axios
- Build Tool: Vite

Installation

Clone the repository:

git clone <repository-url>
cd LedgerFinance

Install Laravel dependencies:

composer install

Install frontend dependencies:

npm install

Create the environment file:

cp .env.example .env

Generate the application key:

php artisan key:generate

Configure your MySQL database in ".env", then run:

php artisan migrate

Run the Application

Start Laravel:

php artisan serve

Start Vue:

npm run dev

Balance Calculation

Current Balance = Total Income - Total Expenses
