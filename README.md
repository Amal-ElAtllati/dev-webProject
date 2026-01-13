# Resource Reservation System

A Laravel-based resource reservation system with role-based access control, notifications, and statistics.

## Features

- 🔐 User authentication with roles (Admin, Responsable, User)
- 📅 Resource reservation system
- ✅ Approval workflow for reservations
- 🔔 Real-time notifications
- 📊 Statistics dashboard
- 🎨 Modern, responsive UI with Tailwind CSS

## Quick Setup

See [SETUP.md](SETUP.md) for detailed instructions, or use [QUICK_START.txt](QUICK_START.txt) for copy-paste commands.

### Prerequisites
- PHP 8.1+
- Composer
- Node.js & npm
- MySQL
- Git

### Installation Steps

```bash
# 1. Clone repository
git clone <repository-url>
cd dev-webProject

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
copy .env.example .env
php artisan key:generate

# 4. Create MySQL database
# Using MySQL command line or phpMyAdmin:
# CREATE DATABASE laravel_reservation;

# 5. Configure database in .env file
# Update: DB_CONNECTION=mysql, DB_DATABASE=laravel_reservation
# Update: DB_USERNAME=root, DB_PASSWORD=your_password

# 6. Run migrations and seed
php artisan migrate
php artisan db:seed

# 7. Build assets
npm run build

# 8. Start server
php artisan serve
```

Visit: http://127.0.0.1:8000

## Test Accounts

- **Admin**: `admin@example.com` / `password`
- **Responsable**: `responsable@example.com` / `password`
- **User**: `user@example.com` / `password`

## Project Structure

- `app/Http/Controllers/` - Application controllers
- `resources/views/` - Blade templates
- `database/migrations/` - Database migrations
- `database/seeders/` - Database seeders
- `routes/web.php` - Application routes

## Technologies

- Laravel 10
- MySQL
- Tailwind CSS
- Alpine.js

## License

This project is for educational purposes.
