# 🔋 Solar & Power Inventory Management System

A high-performance Laravel 11 application designed to track solar energy components, including Inverters, Batteries, Panels, and UPS systems. Featuring a real-time dashboard, automated stock alerts, and professional Excel reporting.

## 🚀 Features
- **Centralized Dashboard:** Real-time metrics for all inventory categories.
- **Automated Stock Alerts:** Visual indicators for items falling below threshold (5 units).
- **Audit Logs:** Complete transaction history (Additions/Removals).
- **Pro Exports:** Generate professional Excel reports using PhpSpreadsheet.
- **Modern UI:** Responsive design built with Tailwind CSS.

---

## 🛠️ Installation Guide

Follow these steps to set up the project locally:

### 1. Clone the Repository
```bash
git clone [https://github.com/codeking-mike/inventory.git](https://github.com/codeking-mike/inventory.git)
cd inventory

## Install Dependencies
composer install
npm install && npm run build

### Environment Config
cp .env.example .env
php artisan key:generate

4. Database Setup
Create a database named inventory_db in your local MySQL server (XAMPP/Wamp).

Update your .env file with your database credentials:

Plaintext
DB_DATABASE=inventory_db
DB_USERNAME=root
DB_PASSWORD=

5. Run the migrations:

Bash
php artisan migrate

6.Enable PHP Extensions
Ensure the GD Library is enabled in your php.ini to support Excel exports:

Find ;extension=gd and change it to extension=gd.

Restart your Apache server.

7. Running the Application
Start the local development server:

Bash
php artisan serve


Exporting Reports
The system uses PhpSpreadsheet for data exports. To generate a report, navigate to the Transactions page and click "Export to Excel".