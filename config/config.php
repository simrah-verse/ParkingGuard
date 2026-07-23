<?php
declare(strict_types=1);

const APP_NAME = 'ParkingGuard';
const APP_TAGLINE = 'Visitor Vehicle and Parking Control System';
const BASE_URL = '/ParkingGuard';
const DB_HOST = 'localhost';
const DB_NAME = 'parkingguard';
const DB_USER = 'root';
const DB_PASS = '';
const HOURLY_RATE = 3.50;

date_default_timezone_set('UTC');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
