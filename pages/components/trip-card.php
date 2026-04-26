<?php
require_once __DIR__ . '/../../db_connection.php';
?>
<a href="trip-details.php?id=<?php echo $id; ?>" class="trip-card" style="text-decoration: none; color: inherit; display: block;">
    <div style="position:relative;">
        <?php
        $displayImage = '';
        if (!empty($image)) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $displayImage = $image;
            } else {
                $imagePath = PROJECT_ROOT . $image;
                if (file_exists($imagePath)) {
                    $displayImage = $image;
                }
            }
        }
        if (empty($displayImage)) {
            $displayImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:AMd9GcTkYpYnuUyzt8VtrMTXhsdsu9CEKDLhk0CfnA&s';
        }
        ?>
        <img src="<?php echo $displayImage; ?>" alt="<?php echo $title; ?>">
        <span class="rating-tag"><?php echo $rating ?? '4.9'; ?></span>
    </div>
    <div class="trip-card-content">
        <div class="trip-location">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <?php echo $location ?? 'GIZA PLATEAU'; ?>
        </div>
        <div class="trip-card-title"><?php echo $title; ?></div>
        <div class="trip-card-desc"><?php echo $description; ?></div>
        <div class="trip-card-footer">
            <span class="trip-card-price">$<?php echo number_format($price); ?></span>
            <span class="explore-link">Explore</span>
        </div>
    </div>
</a>
