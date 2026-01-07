# 📋 Exact Commands for Setup (Copy & Paste)

Copy and paste these commands **one by one** in your terminal:

## Windows (PowerShell or CMD)

```powershell
# 1. Clone the project
git clone https://github.com/Amal-ElAtllati/dev-webProject.git
cd dev-webProject

# 2. Install PHP packages
composer install

# 3. Install JavaScript packages
npm install

# 4. Copy environment file
copy .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Create MySQL database (using MySQL command line or phpMyAdmin)
mysql -u root -p
CREATE DATABASE laravel_reservation;
EXIT;

# 7. Configure database in .env file
# Edit .env file and update these lines:
# DB_CONNECTION=mysql
# DB_DATABASE=laravel_reservation
# DB_USERNAME=root
# DB_PASSWORD=your_mysql_password

# 8. Run migrations (create tables)
php artisan migrate

# 9. Seed database (create test users)
php artisan db:seed

# 10. Build frontend assets
npm run build

# 11. Start the server
php artisan serve
```

## Linux/Mac (Terminal)

```bash
# 1. Clone the project
git clone https://github.com/Amal-ElAtllati/dev-webProject.git
cd dev-webProject

# 2. Install PHP packages
composer install

# 3. Install JavaScript packages
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Create MySQL database (using MySQL command line or phpMyAdmin)
mysql -u root -p
CREATE DATABASE laravel_reservation;
EXIT;

# 7. Configure database in .env file
# Edit .env file and update these lines:
# DB_CONNECTION=mysql
# DB_DATABASE=laravel_reservation
# DB_USERNAME=root
# DB_PASSWORD=your_mysql_password

# 8. Run migrations (create tables)
php artisan migrate

# 9. Seed database (create test users)
php artisan db:seed

# 10. Build frontend assets
npm run build

# 11. Start the server
php artisan serve
```

## ✅ After Setup

1. Open browser: **http://127.0.0.1:8000**
2. Login with: `user@example.com` / `password`

## 🎯 Test Accounts

- Admin: `admin@example.com` / `password`
- Responsable: `responsable@example.com` / `password`
- User: `user@example.com` / `password`

## ⚠️ Troubleshooting

**Error: "composer command not found"**
- Install Composer: https://getcomposer.org/download/

**Error: "npm command not found"**
- Install Node.js: https://nodejs.org/

**Error: "php command not found"**
- Install PHP: https://www.php.net/downloads

**Error: "Access denied for user" or "SQLSTATE[HY000] [1045]"**
- Check your MySQL username and password in `.env` file
- Make sure MySQL is running
- Verify the database exists: `CREATE DATABASE laravel_reservation;`

**Error: "Unknown database"**
- Create the database first: `CREATE DATABASE laravel_reservation;`

**Error: "MySQL not running"**
- Start MySQL service (Windows: Services → MySQL, Linux: `sudo systemctl start mysql`)

**Error: "Class not found"**
- Run: `composer install` again

