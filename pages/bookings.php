<?php
require_once __DIR__ . '/../db_connection.php'; 
    $pageTitle = "My Bookings";
    include 'header.php'; 
?>

<div class="section" style="padding-top: 40px;">
    <div class="section-subtitle">YOUR JOURNEYS</div>
    <h2 class="section-title">My Bookings</h2>
    <p style="color: #666; margin-top: 16px;">You have no active bookings at the moment. Start exploring to book your next adventure.</p>
</div>

<div class="bookings-list">
    <?php
        // Assuming a logged-in user with ID 1 for demonstration purposes
        // In a real application, this would come from a session or authentication system
        $tourist_id = 1; 

        $sql = "SELECT 
                    b.id AS booking_id, 
                    b.people_count, 
                    b.total_price, 
                    b.status AS booking_status,
                    t.title AS trip_title, 
                    t.image AS trip_image,
                    t.date AS trip_date,
                    l.name AS location_name
                FROM bookings b
                JOIN trips t ON b.trip_id = t.id
                JOIN locations l ON t.location_id = l.id
                WHERE b.tourist_id = ?
                ORDER BY b.created_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tourist_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($booking = $result->fetch_assoc()) {
                // Display booking details
                echo '<div class="booking-card">';
                $displayImage = '';
                if (!empty($booking['trip_image'])) {
                    if (filter_var($booking['trip_image'], FILTER_VALIDATE_URL)) { // Check if it's a URL
                        $displayImage = $booking['trip_image'];
                    } else { // Assume it's a local path
                        $imagePath = PROJECT_ROOT . $booking['trip_image'];
                        if (file_exists($imagePath)) {
                            $displayImage = $booking['trip_image'];
                        }
                    }
                }
                // If $displayImage is still empty, use the placeholder
                if (empty($displayImage)) {
                    $displayImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkYpYnuUyzt8VtrMTXhsdsu9CEKDLhk0CfnA&s'; // Your network placeholder
                }
                echo '    <img src="' . htmlspecialchars($displayImage) . '" alt="' . htmlspecialchars($booking['trip_title']) . '" onerror="this.onerror=null;this.src=\'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkYpYnuUyzt8VtrMTXhsdsu9CEKDLhk0CfnA&s\';">';
                echo '    <div class="booking-details">';
                echo '        <h3>' . htmlspecialchars($booking['trip_title']) . '</h3>';
                echo '        <p><strong>Location:</strong> ' . htmlspecialchars($booking['location_name']) . '</p>';
                echo '        <p><strong>Date:</strong> ' . date('M d, Y H:i', strtotime($booking['trip_date'])) . '</p>';
                echo '        <p><strong>People:</strong> ' . htmlspecialchars($booking['people_count']) . '</p>';
                echo '        <p><strong>Total Price:</strong> $' . htmlspecialchars(number_format($booking['total_price'], 2)) . '</p>';
                echo '        <p><strong>Status:</strong> <span class="status-' . htmlspecialchars($booking['booking_status']) . '">' . htmlspecialchars(ucfirst($booking['booking_status'])) . '</span></p>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo '<p style="color: #666; margin-top: 16px;">You have no active bookings at the moment. Start exploring to book your next adventure.</p>';
        }
        $stmt->close();
    ?>
</div>

<?php include 'footer.php'; ?>
