# 🛕 Durga Temple Management System

A professional management portal for temple administration, handling donations, events, and purohit coordination with a modern, glassmorphic UI.

---

## 🚀 Quick Start (Automated)

We have provided automated scripts to set up the project for you.

### For Linux or macOS:
1. Open terminal in the project root.
2. Run: `chmod +x setup.sh && ./setup.sh`

### For Windows:
1. Open Command Prompt in the project root.
2. Run: `setup.bat`

---

## 🛠 Prerequisites

Ensure you have the following installed on your system:
- **PHP 8.2+**
- **Composer** (PHP Package Manager)
- **Node.js & NPM**
- **MySQL/MariaDB**

---

## 📖 Manual Installation Steps

If you prefer to set up manually or the scripts encounter environment issues, follow these steps:

### 1. Clone the Repository
```bash
git clone https://github.com/ManojKshetrapalam/Durga_temple.git
cd Durga_temple
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
Create your `.env` file and generate the app key:
```bash
cp .env.example .env
php artisan key:generate
```
> [!IMPORTANT]
> Edit `.env` and set your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.

### 4. Database Setup
Run migrations and seed the initial data (Purohits and Donations):
```bash
php artisan migrate
php artisan db:seed --class=DonationSeeder
php artisan db:seed --class=PurohitSeeder
```

### 5. Build Frontend
```bash
npm run build
```

---

## 🚦 How to Run

To start the development environment, you need two terminals:

**Terminal 1 (Backend):**
```bash
php artisan serve
```

**Terminal 2 (Frontend Watcher):**
```bash
npm run dev
```

---

## 📝 Project Features
- **Modern Dashboard**: Real-time stats and recent activity.
- **Donation Management**: Record and filter donations with persistent database storage.
- **Purohit Directory**: Manage temple priests and their specializations.
- **Event Scheduling**: Assign Purohits to festivals and daily rituals.
- **Adaptive UI**: High-end design with full Dark Mode support.

---

## 📅 Roadmap
Check [TODO.md](TODO.md) for planned features and technical tasks.
