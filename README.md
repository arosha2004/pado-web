# JSB SecureHub

A secure internal awareness and compliance portal for JSB Oil Mart, built with Laravel 12 and MySQL.

## Requirements

- PHP 8.2+
- Composer
- MySQL / MariaDB
- Node.js + npm

## Setup

1. Copy `.env.example` to `.env`.
2. Configure the MySQL database settings in `.env`.
3. Create the database if needed:
   ```bash
   mysql -u root -e "CREATE DATABASE jsb_securehub;"
   ```
4. Install dependencies:
   ```bash
   composer install
   npm install
   ```
5. Run the database migrations and seed data:
   ```bash
   php artisan migrate --seed
   ```
6. Start the app:
   ```bash
   php artisan serve
   ```
7. Open `http://127.0.0.1:8000/login` and sign in with the seeded accounts:
   - Admin: `admin@jsb.local` / `password123`
   - Manager: `manager@jsb.local` / `password123`
   - Employee: `employee@jsb.local` / `password123`

## Notes

- This app includes role-based access control, policy tracking, training assignments, incident reporting, notifications, and audit visibility.
- The default Laravel welcome screen remains available for guest users at the root URL, while authenticated users are redirected to the dashboard.
