<?php
require_once __DIR__ . '/../db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GUID ME - <?php echo $pageTitle ?? 'Home'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/base.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/hero.css">
    <link rel="stylesheet" href="../styles/search-bar.css">
    <link rel="stylesheet" href="../styles/cards.css">
    <link rel="stylesheet" href="../styles/sections.css">
    <link rel="stylesheet" href="../styles/footer.css">
</head>
<body>
    <div class="main-bg">
        <?php 
            $currentFile = basename($_SERVER['PHP_SELF']); 
        ?>
        <div class="navbar">
            <div class="logo">GUID ME</div>
            <nav id="main-nav">
                <a href="home.php" class="nav-link <?php echo $currentFile == 'home.php' ? 'active' : ''; ?>" data-link>Home</a>
                <a href="trips.php" class="nav-link <?php echo $currentFile == 'trips.php' ? 'active' : ''; ?>" data-link>Trips</a>
                <a href="bookings.php" class="nav-link <?php echo $currentFile == 'bookings.php' ? 'active' : ''; ?>" data-link>My Bookings</a>
                <a href="profile.php" class="nav-link <?php echo $currentFile == 'profile.php' ? 'active' : ''; ?>" data-link>Profile</a>
            </nav>
            <div class="profile">JD</div>
        </div>

        <div id="page-container">
            <main id="main-content" class="fade-in">