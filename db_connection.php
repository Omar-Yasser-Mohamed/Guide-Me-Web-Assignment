<?php

// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Default username for phpMyAdmin
define('DB_PASSWORD', '');     // Default password for phpMyAdmin (often empty)
define('DB_NAME', 'guid_me');  // Database name from your SQL file

// Define project root for absolute path resolution
define('PROJECT_ROOT', __DIR__ . '/');

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to utf8mb4
$conn->set_charset("utf8mb4");

?>