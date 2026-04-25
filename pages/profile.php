<?php
require_once __DIR__ . '/../db_connection.php';
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

    .profile-header { margin-bottom: 30px; }

    .avatar-wrapper { position: relative; display: inline-block; }

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
        border: none;
    }

    .btn-primary { background-color: var(--accent-yellow); color: var(--text-dark); }
    .btn-outline { background: transparent; border: 1px solid var(--accent-yellow); color: var(--text-dark); }

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

    /* --- Modal CSS --- */
    .modal-overlay {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(26, 26, 26, 0.6);
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal-content {
        background-color: var(--white);
        padding: 35px;
        border-radius: 24px;
        width: 90%;
        max-width: 420px;
        position: relative;
        text-align: left;
    }

    .close-btn {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 20px;
        cursor: pointer;
        color: var(--text-muted);
    }

    .modal-title { font-family: 'Playfair Display', serif; font-size: 26px; margin: 0; }
    .modal-subtitle { font-size: 10px; color: var(--text-muted); letter-spacing: 1px; margin-bottom: 25px; }

    .input-group { margin-bottom: 20px; }
    .input-group label { display: block; font-size: 10px; font-weight: 700; color: #B5A895; margin-bottom: 8px; }
    .input-group input {
        width: 100%;
        padding: 14px;
        border: none;
        background-color: var(--card-bg);
        border-radius: 12px;
        box-sizing: border-box;
        font-family: inherit;
        font-weight: 500;
    }

    .btn-full { width: 100%; justify-content: center; margin-top: 10px; }
    .btn-cancel { background: transparent; border: 1px solid #eee; color: var(--text-muted); margin-top: 5px; }
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
        <button class="btn btn-primary" onclick="openEditModal()">✎ Edit Profile</button>
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

<<<<<<< HEAD
<div class="profile-details">
    <?php
        // Assuming a logged-in user with ID 1 for demonstration purposes
        // In a real application, this would come from a session or authentication system
        $user_id = 1; 

        $sql = "SELECT name, email, role, phone, created_at FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo '<h3>User Information</h3>';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($user['name']) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($user['email']) . '</p>';
            echo '<p><strong>Role:</strong> ' . htmlspecialchars(ucfirst($user['role'])) . '</p>';
            echo '<p><strong>Phone:</strong> ' . htmlspecialchars($user['phone']) . '</p>';
            echo '<p><strong>Member Since:</strong> ' . date('M d, Y', strtotime($user['created_at'])) . '</p>';
        } else {
            echo '<p style="color: #666; margin-top: 16px;">User not found.</p>';
        }
        $stmt->close();
    ?>
</div>

<?php include 'footer.php'; ?>

<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">✕</span>
        <h2 class="modal-title">Edit Profile</h2>
        <p class="modal-subtitle">UPDATE YOUR PERSONAL DETAILS</p>

        <form action="" method="POST">
            <div class="input-group">
                <label>FULL NAME</label>
                <input type="text" value="Amir Ibrahim">
            </div>

            <div class="input-group">
                <label>EMAIL ADDRESS</label>
                <input type="email" value="amir.ibrahim@history.com">
            </div>

            <div class="input-group">
                <label>PHONE NUMBER</label>
                <input type="text" value="+20 123 456 7890">
            </div>

            <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
            <button type="button" class="btn btn-cancel btn-full" onclick="closeEditModal()">Cancel</button>
        </form>
    </div>
</div>

<script>
    function openEditModal() {
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(event) {
        let modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>

<?php include 'footer.php'; ?>

