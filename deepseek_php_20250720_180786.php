<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Change if you have different MySQL credentials
define('DB_PASS', ''); // Change if you have a MySQL password
define('DB_NAME', 'hr_management');

// Create database connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Set timezone
date_default_timezone_set('Africa/Nairobi'); // Change to your timezone

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Base URL
define('BASE_URL', 'http://localhost/hr_management'); // Change if your project is in a subfolder
?>