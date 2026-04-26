<?php
require_once __DIR__ . '/../db_connection.php';
    $pageTitle = "Home";
    include 'header.php'; 
?>

<div class="hero">
    <div class="hero-content">
        <div class="subtitle">A GUIDED PASSAGE THROUGH ANTIQUITY</div>
        <h1>Experience the Timeless<br>Splendor of Egypt</h1>
    </div>
    <?php include 'components/search-bar.php'; ?>
</div>

<div class="section">
    <div class="section-header">
        <div class="section-title-group">
            <div class="section-subtitle">CURATOR'S SELECTION</div>
            <h2 class="section-title">Iconic Journeys</h2>
        </div>
        <a class="view-all" href="trips.php">VIEW ALL EXPEDITIONS &rarr;</a>
    </div>

    <div class="journeys">
        <?php
            // Fetch trips with location names and IDs
            $sql = "SELECT t.id, t.title, t.description, t.image, t.base_price, t.logistics_price, l.name as location_name 
                    FROM trips t 
                    LEFT JOIN locations l ON t.location_id = l.id
                    WHERE t.status = 'active' 
                    LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($trip = $result->fetch_assoc()) {
                    $id = $trip['id'];
                    $title = $trip['title'];
                    $image = $trip['image'];
                    $tag = 'FEATURED'; 
                    $price = $trip['base_price'] + $trip['logistics_price'];
                    $description = $trip['description'];
                    $location = $trip['location_name'];
                    include 'components/home-card.php';
                }
            } else {
                echo "<p>No iconic journeys found at the moment.</p>";
            }
        ?>
    </div>
</div>

<div class="curation-section">
    <div class="curation-img">
        <img src="https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=800&q=80" alt="Egyptian Museum Artifact">
    </div>
    <div class="curation-content">
        <div class="section-subtitle" style="margin-bottom: 8px;">THE GUID ME STANDARD</div>
        <div class="curation-title">Curating History with Precision</div>
        <div class="curation-desc">Unlike standard tourism, GUID ME connects you with verified historians and archeologists. We don't just show you ruins; we translate the whispers of the ancient world into a modern luxury experience.</div>
        <div class="curation-badges">
            <div class="curation-badge"><span class="curation-badge-icon">&#10003;</span> CERTIFIED EGYPTOLOGISTS ONLY</div>
            <div class="curation-badge"><span class="curation-badge-icon">&#9733;</span> BESPOKE PRIVATE ITINERARIES</div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>