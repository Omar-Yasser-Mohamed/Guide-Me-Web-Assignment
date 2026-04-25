<?php 
    $pageTitle = "Profile";
    include 'header.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    :root {
        --bg-color: #FDF8F0;
        --card-bg: #FFF4E0;
        --text-dark: #1A1A1A;
        --text-muted: #666;
        --accent-yellow: #E9C46A;
        --white: #FFFFFF;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Plus Jakarta Sans', sans-serif;
        margin: 0;
        color: var(--text-dark);
    }

    .profile-container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        padding: 40px 20px;
    }

    .profile-header {
        margin-bottom: 30px;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .avatar-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--text-dark);
    }

    .edit-icon {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: var(--accent-yellow);
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: 1px solid #000;
    }

    .member-since {
        font-size: 12px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 15px;
    }

    .user-name {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        margin: 5px 0 30px;
    }

    
    .info-card {
        background-color: var(--card-bg);
        border-radius: 15px;
        padding: 25px;
        text-align: left;
        margin-bottom: 25px;
    }

    .info-group {
        margin-bottom: 20px;
        position: relative;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 10px;
    }

    .info-group:last-child { border: none; }

    .info-label {
        font-size: 10px;
        color: #B5A895;
        text-transform: uppercase;
        font-weight: 700;
    }

    .info-value {
        font-size: 16px;
        font-weight: 500;
        margin-top: 5px;
        display: block;
    }

    .info-icon {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        color: #A0A0A0;
    }

    
    .actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 40px;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--accent-yellow);
        border: none;
        color: var(--text-dark);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--accent-yellow);
        color: var(--text-dark);
    }

    
    .secondary-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .small-card {
        background: var(--white);
        padding: 15px;
        border-radius: 12px;
        display: flex;
        gap: 12px;
        text-align: left;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    .icon-box {
        background: var(--card-bg);
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-content h4 {
        margin: 0;
        font-size: 14px;
    }

    .card-content p {
        margin: 5px 0 0;
        font-size: 11px;
        color: var(--text-muted);
        line-height: 1.4;
    }
</style>

<div class="profile-container">
    
    <div class="profile-header">
        <div class="avatar-wrapper">
            <img src="../assets/images/Amir.png" alt="Amir Ibrahim" class="avatar-img">
            <div class="edit-icon">✎</div>
        </div>
        <div class="member-since">MEMBER SINCE 2022</div>
        <h1 class="user-name">Amir Ibrahim</h1>
    </div>

    <div class="info-card">
        <div class="info-group">
            <span class="info-label">Email Address</span>
            <span class="info-value">amir.ibrahim@history.com</span>
            <span class="info-icon">✉</span>
        </div>
        
        <div class="info-group">
            <span class="info-label">Phone Number</span>
            <span class="info-value">+20 123 456 7890</span>
            <span class="info-icon">📞</span>
        </div>

        <div class="info-group">
            <span class="info-label">Preferred Language</span>
            <span class="info-value">English (UK) & Arabic</span>
            <span class="info-icon">🌐</span>
        </div>
    </div>

    <div class="actions">
        <button class="btn btn-primary">✎ Edit Profile</button>
        <button class="btn btn-outline">🔄 Change Password</button>
    </div>

    <div class="secondary-cards">
        <div class="small-card">
            <div class="icon-box">🕒</div>
            <div class="card-content">
                <h4>Trip History</h4>
                <p>Review your past explorations of the Nile.</p>
            </div>
        </div>
        <div class="small-card">
            <div class="icon-box">🔔</div>
            <div class="card-content">
                <h4>Notifications</h4>
                <p>Manage alerts for new curated tours.</p>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
