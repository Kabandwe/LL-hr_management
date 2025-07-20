<?php
require_once 'config.php';

// Redirect if not logged in
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Simple login function (for demo purposes)
function login($username, $password) {
    // In a real application, you would verify against database with hashed passwords
    $valid_users = [
        'admin' => 'password123', // Change this to a secure password
        'hr' => 'hrpassword'
    ];
    
    if (isset($valid_users[$username]) {
        if ($valid_users[$username] === $password) {
            $_SESSION['user_id'] = $username;
            return true;
        }
    }
    return false;
}

// Logout function
function logout() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>