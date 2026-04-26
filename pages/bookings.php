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
                        $statusClass = 'status-' . strtolower($booking['booking_status']);
                        $displayImage = !empty($booking['trip_image']) ? $booking['trip_image'] : 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&q=80&w=300';
                        ?>
                        <div class="booking-card">
                            <div class="booking-card-image">
                                <img src="<?php echo htmlspecialchars($displayImage); ?>" alt="<?php echo htmlspecialchars($booking['trip_title']); ?>" onerror="this.src='https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&q=80&w=300'">
                            </div>
                            <div class="booking-card-content">
                                <div class="booking-header">
                                    <h3 class="booking-card-title"><?php echo htmlspecialchars($booking['trip_title']); ?></h3>
                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars(strtoupper($booking['booking_status'])); ?></span>
                                </div>
                                
                                <div class="booking-info-row">
                                    <div class="info-item">
                                        <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        <span><?php echo date('M d, Y', strtotime($booking['trip_date'])); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <svg class="info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        <span><?php echo htmlspecialchars($booking['people_count']); ?> Persons</span>
                                    </div>
                                </div>
                                
                                <div class="investment-section">
                                    <div>
                                        <div class="investment-label">Total Investment</div>
                                        <div class="investment-amount">$<?php echo number_format($booking['total_price'], 2); ?></div>
                                    </div>
                                    
                                    <?php if ($booking['booking_status'] == 'pending'): ?>
                                        <a href="booking-details.php?id=<?php echo $booking['booking_id']; ?>" class="view-details-link">
                                            View Details 
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                        </a>
                                    <?php elseif ($booking['booking_status'] == 'confirmed' || $booking['booking_status'] == 'accepted'): ?>
                                        <a href="#" class="get-ticket-link">
                                            Get Ticket 
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"></path><line x1="13" y1="5" x2="13" y2="19"></line></svg>
                                        </a>
                                    <?php elseif ($booking['booking_status'] == 'cancelled' || $booking['booking_status'] == 'rejected'): ?>
                                        <span class="unavailable-text">Guide unavailable for selected dates</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
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

