# ParkingGuard – Visitor Vehicle and Parking Control System

ParkingGuard is a PHP + MySQL full-stack web app for managing visitor vehicles, parking slots, allocations, reports, CSV exports, and printable records. It is designed to run locally on XAMPP without extra build tooling.

## Requirements
- XAMPP with Apache, PHP 8+, and MySQL/MariaDB
- A modern browser

## Installation
1. Copy this project folder to `xampp/htdocs/ParkingGuard`.
2. Start Apache and MySQL in XAMPP.
3. Open `http://localhost/phpmyadmin` and import `database.sql`.
4. Visit `http://localhost/ParkingGuard/`.
5. Login with:
   - Email: `admin@parkingguard.local`
   - Password: `admin123`

## Features
- Session authentication
- Responsive Bootstrap 5 UI
- External custom CSS and vanilla JavaScript
- Font Awesome icons
- Chart.js dashboard charts
- Visitor, vehicle, parking slot, and parking record CRUD
- Automatic parking slot allocation
- Active parking check-out with fee calculation
- Reports with date filtering
- CSV export
- Print-friendly reports
- SEO metadata
