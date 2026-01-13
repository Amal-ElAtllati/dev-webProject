# 🚀 Project Setup Guide (For Students)

This is a simple step-by-step guide to set up this Laravel project on a new computer.

## 📋 Prerequisites

Before starting, make sure you have installed:
- **PHP 8.1 or higher** ([Download PHP](https://www.php.net/downloads))
- **Composer** ([Download Composer](https://getcomposer.org/download/))
- **Node.js and npm** ([Download Node.js](https://nodejs.org/))
- **MySQL** ([Download MySQL](https://dev.mysql.com/downloads/))
- **Git** ([Download Git](https://git-scm.com/downloads))

## 🎯 Step-by-Step Setup

### Step 1: Clone the Project
```bash
git clone <your-repository-url>
cd dev-webProject
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install JavaScript Dependencies
```bash
npm install
```

### Step 4: Copy Environment File
```bash
copy .env.example .env
```
*(On Linux/Mac, use: `cp .env.example .env`)*

### Step 5: Generate Application Key
```bash
php artisan key:generate
```

### Step 6: Setup MySQL Database
Before proceeding, make sure you have MySQL installed and running.

1. **Create a MySQL database** (using phpMyAdmin, MySQL Workbench, or command line):
   ```sql
   CREATE DATABASE laravel_reservation;
   ```

2. **Configure Database in .env file**
   Open the `.env` file and update these lines:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_reservation
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```
   
   **Important**: Replace `your_password` with your MySQL root password (or create a new MySQL user).

### Step 7: Run Migrations
```bash
php artisan migrate
```

### Step 8: Seed Database (Create Test Users)
```bash
php artisan db:seed
```

This creates 3 test users:
- **Admin**: `admin@example.com` / `password`
- **Responsable**: `responsable@example.com` / `password`
- **User**: `user@example.com` / `password`

### Step 9: Build Frontend Assets
```bash
npm run build
```

### Step 10: Start the Server
```bash
php artisan serve
```

The application will be available at: **http://127.0.0.1:8000**

## ✅ Quick Test

1. Open your browser and go to: `http://127.0.0.1:8000`
2. Login with: `user@example.com` / `password`
3. You should see the dashboard!

## 🔧 Common Issues

### Issue: "Class not found" errors
**Solution**: Run `composer install` again

### Issue: "Access denied for user" or "SQLSTATE[HY000] [1045]"
**Solution**: 
- Check your MySQL username and password in `.env` file
- Make sure MySQL is running
- Verify the database exists: `CREATE DATABASE laravel_reservation;`

### Issue: "Unknown database"
**Solution**: Create the database first: `CREATE DATABASE laravel_reservation;`

### Issue: "npm command not found"
**Solution**: Install Node.js from [nodejs.org](https://nodejs.org/)

### Issue: "Composer command not found"
**Solution**: Install Composer from [getcomposer.org](https://getcomposer.org/)

## 📝 Important Notes

- **MySQL is required** - Make sure MySQL is installed and running
- All test users have password: `password`
- The server runs on port 8000 by default
- To change port: `php artisan serve --port=8001`
- Default database name: `laravel_reservation` (you can change it in `.env`)

## 🎓 For Students

If you get stuck:
1. Check that all prerequisites are installed
2. Make sure you're in the `dev-webProject` folder
3. Try running commands one by one
4. Check error messages - they usually tell you what's wrong!

## 🚀 You're Ready!

Once you see the login page, you're all set! Happy coding! 🎉

