<?php
require_once __DIR__ . '/../db_connection.php';
    $pageTitle = "Trips";
    include 'header.php'; 
?>

<div class="section" style="padding-top: 40px;">
    <div class="section-subtitle">EXPLORE EXPEDITIONS</div>
    <h2 class="section-title">All Available Trips</h2>
    <p style="color: #666; margin-top: 16px;">Browse our full catalog of historical expeditions across Egypt.</p>
</div>

<div class="journeys">
    <?php
        // Fetch all active trips from the database
        $sql = "SELECT title, description, image, base_price, logistics_price FROM trips WHERE status = 'active'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($trip = $result->fetch_assoc()) {
                $title = $trip['title'];
                $image = $trip['image'];
                $tag = 'ACTIVE'; // Placeholder, you might want to derive this from database
                $price = $trip['base_price'] + $trip['logistics_price']; // Calculate total price
                $description = $trip['description'];
                include 'components/journey-card.php';
            }
        } else {
            echo "<p>No trips found at the moment.</p>";
        }
    ?>
</div>

<?php include 'footer.php'; ?>
