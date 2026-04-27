<?php
require_once __DIR__ . '/../db_connection.php'; 
    $pageTitle = "My Bookings";
    include 'header.php'; 
?>
<link rel="stylesheet" href="../styles/bookings.css">

<div class="bookings-page">
    <div class="bookings-container">
        <span class="travel-journal-label">TRAVEL JOURNAL</span>
        <h1 class="bookings-title">My Bookings</h1>
        <div class="title-underline"></div>
        
        <div class="bookings-list">
     
            <?php
                $tourist_id = 1; 
                $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

                $sql = "SELECT 
                            b.id AS booking_id, 
                            b.trip_id,
                            b.people_count, 
                            b.total_price, 
                            b.status AS booking_status,
                            t.title AS trip_title, 
                            t.image AS trip_image,
                            COALESCE(b.created_at, t.date) AS trip_date,
                            l.name AS location_name
                        FROM bookings b
                        JOIN trips t ON b.trip_id = t.id
                        JOIN locations l ON t.location_id = l.id
                        WHERE b.tourist_id = ?";
                
                if ($statusFilter !== 'all') {
                    $sql .= " AND b.status = ?";
                }
                
                $sql .= " ORDER BY trip_date DESC, b.created_at DESC";
                
                $stmt = $conn->prepare($sql);
                if ($statusFilter !== 'all') {
                    $stmt->bind_param("is", $tourist_id, $statusFilter);
                } else {
                    $stmt->bind_param("i", $tourist_id);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($booking = $result->fetch_assoc()) {
                        include 'components/booking-card.php';
                    }
                } else {
                    echo '<p style="color: #666; margin-top: 16px;">You have no active bookings at the moment. Start exploring to book your next adventure.</p>';
                }
                $stmt->close();
            ?>
        </div>

        <div class="curator-note">
            <div class="curator-icon-circle">i</div>
            <div class="curator-content">
                <h4>Curator's Note</h4>
                <p>Every journey we curate is a collaboration between historian and traveler. Please allow up to 24 hours for our local experts to review and confirm your booking requests. For immediate assistance with any accepted booking, use the "Contact Curator" link in the footer.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

