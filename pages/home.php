<?php 
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
            $trips = [
                [
                    'title' => 'Valley of the Kings Private Tour',
                    'image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=600&q=80',
                    'tag' => 'PRIVATE',
                    'price' => '150',
                    'description' => 'Uncover the hidden chambers and secrets of the 18th to 20th dynasties with an expert Egyptologist.'
                ],
                [
                    'title' => 'Karnak & Luxor Temple Twilight',
                    'image' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
                    'tag' => 'SUNSET',
                    'price' => '120',
                    'description' => 'Witness the grandeur of Thebes under the stars, exploring the world\'s largest religious complex.'
                ],
                [
                    'title' => 'Aswan Felucca Private Expedition',
                    'image' => 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=600&q=80',
                    'tag' => 'EXCLUSIVE',
                    'price' => '185',
                    'description' => 'A serene passage through Elephantine Island aboard a traditional wooden sailboat.'
                ]
            ];

            foreach ($trips as $trip) {
                $title = $trip['title'];
                $image = $trip['image'];
                $tag = $trip['tag'];
                $price = $trip['price'];
                $description = $trip['description'];
                include 'components/journey-card.php';
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