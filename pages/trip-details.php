<?php
require_once __DIR__ . '/../db_connection.php';

// Get trip ID from URL
$trip_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($trip_id <= 0) {
    header("Location: trips.php");
    exit;
}

// Fetch trip details with location and guide info
$sql = "SELECT t.*, l.name as location_name, l.country, u.name as guide_name,
               (SELECT AVG(rating) FROM reviews r 
                JOIN bookings b ON r.booking_id = b.id 
                WHERE b.trip_id = t.id) as avg_rating
        FROM trips t
        LEFT JOIN locations l ON t.location_id = l.id
        LEFT JOIN users u ON t.guide_id = u.id
        WHERE t.id = ? AND t.status = 'active'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $trip_id);
$stmt->execute();
$trip = $stmt->get_result()->fetch_assoc();

if (!$trip) {
    header("Location: trips.php");
    exit;
}

// Fetch additional images
$imagesSql = "SELECT image_url FROM trip_images WHERE trip_id = ?";
$imgStmt = $conn->prepare($imagesSql);
$imgStmt->bind_param("i", $trip_id);
$imgStmt->execute();
$imagesResult = $imgStmt->get_result();
$additionalImages = [];
while ($img = $imagesResult->fetch_assoc()) {
    $additionalImages[] = $img['image_url'];
}

$pageTitle = $trip['title'];
include 'header.php';
?>

<link rel="stylesheet" href="../styles/trip-details.css">

<div class="trip-details-container">
    <!-- Hero Section -->
    <div class="trip-hero">
        <img src="<?php echo htmlspecialchars($trip['image']); ?>" alt="<?php echo htmlspecialchars($trip['title']); ?>" class="trip-hero-img">
        <div class="trip-hero-overlay"></div>
        <div class="trip-hero-content">
            <div class="trip-hero-subtitle">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; vertical-align: middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <?php echo htmlspecialchars($trip['location_name']); ?>, <?php echo htmlspecialchars($trip['country']); ?>
            </div>
            <h1 class="trip-hero-title"><?php echo htmlspecialchars($trip['title']); ?></h1>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="trip-content-grid">
        <!-- Left Column: Info -->
        <div class="trip-main-info">
            <h2>Journey Overview</h2>
            <div class="trip-description">
                <?php echo nl2br(htmlspecialchars($trip['description'])); ?>
            </div>

            <!-- Experience Blueprint -->
            <div class="blueprint-section">
                <span class="blueprint-header">THE EXPERIENCE BLUEPRINT</span>
                <div class="blueprint-grid">
                    <div class="blueprint-item">
                        <div class="blueprint-icon">📜</div>
                        <div>
                            <h4>Expert Narration</h4>
                            <p>Access to curated knowledge from <?php echo htmlspecialchars($trip['guide_name']); ?> throughout the expedition.</p>
                        </div>
                    </div>
                    <div class="blueprint-item">
                        <div class="blueprint-icon">🚐</div>
                        <div>
                            <h4>Premium Transit</h4>
                            <p>Climate-controlled luxury transport from your assembly point to the site.</p>
                        </div>
                    </div>
                    <div class="blueprint-item">
                        <div class="blueprint-icon">🎫</div>
                        <div>
                            <h4>Priority Entry</h4>
                            <p>Fast-track admission to the site and exclusive access areas included.</p>
                        </div>
                    </div>
                    <div class="blueprint-item">
                        <div class="blueprint-icon">📍</div>
                        <div>
                            <h4>Sacred Site</h4>
                            <p>Located in <?php echo htmlspecialchars($trip['location_name']); ?>, <?php echo htmlspecialchars($trip['country']); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Booking Sidebar -->
        <aside class="booking-sidebar">
            <div class="booking-card">
                <h3>Secure Passage</h3>
                <p>Reserve your curated expedition now.</p>
                
                <form action="process_booking.php" method="POST">
                    <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>">
                    
                    <div class="form-group">
                        <label>GUESTS</label>
                        <input type="number" name="people_count" class="form-control" value="2" min="1" max="<?php echo $trip['max_people']; ?>">
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_guests'): ?>
                            <span style="color: #d9534f; font-size: 0.8rem; margin-top: 5px; display: block;">Capacity: max <?php echo $trip['max_people']; ?> guests</span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>EXPEDITION DATE</label>
                        <input type="date" name="booking_date" class="form-control" value="<?php echo date('Y-m-d', strtotime($trip['date'])); ?>">
                    </div>

                    <div class="form-group">
                        <label>CURATOR NOTES</label>
                        <textarea name="notes" class="form-control" style="height: 100px; resize: none;" placeholder="Special requirements, dietary needs..."></textarea>
                    </div>

                    <div class="price-summary">
                        <span class="price-label">Total Investment</span>
                        <span class="price-amount">$<?php echo number_format($trip['base_price'] + $trip['logistics_price']); ?></span>
                    </div>

                    <button type="submit" class="btn-book">Book Now</button>
                    <span class="cancellation-note">Free cancellation 48h prior to departure</span>
                </form>
            </div>
        </aside>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
<!-- Success Modal -->
<div class="modal-overlay" id="success-modal">
    <div class="modal-card">
        <div class="modal-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h2 class="modal-title">Booking Confirmed!</h2>
        <p class="modal-text">Your request has been sent successfully.<br>Please wait for guide approval.</p>
        
        <div class="modal-actions">
            <a href="bookings.php" class="btn-modal-primary">View My Bookings</a>
            <button onclick="closeModal()" class="btn-modal-secondary">Close</button>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        const modal = document.getElementById('success-modal');
        modal.style.display = 'none';
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/[?&]success=1/, ''));
    }
</script>
<?php endif; ?>

<?php include 'footer.php'; ?>
