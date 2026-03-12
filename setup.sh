#!/bin/bash

# Durga Temple Management System - Linux/Mac Setup Script

echo "🕉️ Starting Durga Temple Project Setup..."

# 1. Check for PHP
if ! command -v php &> /dev/null
then
    echo "❌ PHP could not be found. Please install PHP 8.2+"
    exit
fi

# 2. Check for Composer
if ! command -v composer &> /dev/null
then
    echo "❌ Composer could not be found. Please install it."
    exit
fi

# 3. Check for Node & NPM
if ! command -v npm &> /dev/null
then
    echo "❌ NPM could not be found. Please install Node.js."
    exit
fi

echo "📦 Installing PHP dependencies..."
composer install

echo "📦 Installing JS dependencies..."
npm install

if [ ! -f .env ]; then
    echo "📄 Creating .env from .env.example..."
    cp .env.example .env
    echo "🔑 Generating Application Key..."
    php artisan key:generate
fi

echo "🗄️ Running migrations and seeding..."
php artisan migrate --force
php artisan db:seed --class=DonationSeeder
php artisan db:seed --class=PurohitSeeder

echo "🚀 Building frontend assets..."
npm run build

echo "✅ Setup Complete! Run 'php artisan serve' and 'npm run dev' to start."
