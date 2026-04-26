<?php
require_once 'db_connection.php';

// Check if booking_date column exists
$result = $conn->query("SHOW COLUMNS FROM bookings LIKE 'booking_date'");
if ($result->num_rows == 0) {
    // Add the column
    $conn->query("ALTER TABLE bookings ADD COLUMN booking_date DATE AFTER total_price");
    echo "Added booking_date column to bookings table.\n";
} else {
    echo "booking_date column already exists.\n";
}
?>
