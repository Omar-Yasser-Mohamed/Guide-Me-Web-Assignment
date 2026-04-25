<?php
require_once __DIR__ . '/../../db_connection.php';
?>
<div class="journey-card">
    <div style="position:relative;">
        <?php
        $displayImage = '';
        if (!empty($image)) {
            if (filter_var($image, FILTER_VALIDATE_URL)) { // Check if it's a URL
                $displayImage = $image;
            } else { // Assume it's a local path
                $imagePath = PROJECT_ROOT . $image;
                if (file_exists($imagePath)) {
                    $displayImage = $image;
                }
            }
        }
        // If $displayImage is still empty, use the placeholder
        if (empty($displayImage)) {
            $displayImage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkYpYnuUyzt8VtrMTXhsdsu9CEKDLhk0CfnA&s'; // Your network placeholder
        }
        ?>
        <img src="<?php echo $displayImage; ?>" alt="<?php echo $title; ?>">
        <span class="tag"><?php echo $tag; ?></span>
    </div>
    <div class="journey-card-content">
        <div class="journey-card-title"><?php echo $title; ?></div>
        <div class="journey-card-desc"><?php echo $description; ?></div>
        <div class="journey-card-footer">
            <span class="journey-card-price">$<?php echo $price; ?></span>
            <span class="journey-card-per">PER CURATOR</span>
        </div>
    </div>
</div>