@echo off
:: Durga Temple Management System - Windows Setup Script

echo 🕉️ Starting Durga Temple Project Setup...

:: 1. Check for PHP
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP could not be found. Please install PHP 8.2+ and add it to your PATH.
    pause
    exit /b
)

:: 2. Check for Composer
composer -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Composer could not be found. Please install it.
    pause
    exit /b
)

:: 3. Check for Node & NPM
npm -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ NPM could not be found. Please install Node.js.
    pause
    exit /b
)

echo 📦 Installing PHP dependencies...
call composer install

echo 📦 Installing JS dependencies...
call npm install

if not exist .env (
    echo 📄 Creating .env from .env.example...
    copy .env.example .env
    echo 🔑 Generating Application Key...
    call php artisan key:generate
)

echo 🗄️ Running migrations and seeding...
call php artisan migrate --force
call php artisan db:seed --class=DonationSeeder
call php artisan db:seed --class=PurohitSeeder

echo 🚀 Building frontend assets...
call npm run build

echo ✅ Setup Complete! Run 'php artisan serve' and 'npm run dev' to start.
pause
