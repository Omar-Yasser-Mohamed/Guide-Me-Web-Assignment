<?php
require_once __DIR__ . '/../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_id = isset($_POST['trip_id']) ? (int)$_POST['trip_id'] : 0;
    $tourist_id = 1; // Assuming user ID 1 for this assignment
    $people_count = isset($_POST['people_count']) ? (int)$_POST['people_count'] : 1;
    
    // Fetch trip details to get prices and ensure it exists
    $sql = "SELECT base_price, logistics_price, max_people FROM trips WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trip_id);
    $stmt->execute();
    $trip = $stmt->get_result()->fetch_assoc();
    
    if ($trip) {
        // Validate people count
        if ($people_count < 1 || $people_count > $trip['max_people']) {
            header("Location: trip-details.php?id=$trip_id&error=invalid_guests");
            exit;
        }

        // Calculate total price
        $total_price = ($trip['base_price'] + $trip['logistics_price']) * $people_count;
        
        $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : date('Y-m-d');
        
        // Insert booking
        $insertSql = "INSERT INTO bookings (trip_id, tourist_id, people_count, total_price, status, created_at) VALUES (?, ?, ?, ?, 'pending', ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iiids", $trip_id, $tourist_id, $people_count, $total_price, $booking_date);
        
        if ($insertStmt->execute()) {
            // Success - redirect back to trip details with success flag
            header("Location: trip-details.php?id=$trip_id&success=1");
            exit;
        } else {
            // Error
            header("Location: trip-details.php?id=$trip_id&error=db_error");
            exit;
        }
    } else {
        header("Location: trips.php");
        exit;
    }
} else {
    header("Location: trips.php");
    exit;
}
?>
