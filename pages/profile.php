<?php 
    session_start();
    include 'db_connection.php'; 

    $user_id = 1; 
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);

    if (!$user_data) {
        die("User not found in database.");
    }

    $pageTitle = "Profile";
    include 'header.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../styles/profile.css">

<div class="profile-container">
    <div class="profile-header">
        <div class="avatar-wrapper">
            <img src="../assets/images/Amir.png" alt="User Image" class="avatar-img">
            <div class="edit-badge">✎</div>
        </div>
        <div class="member-since">
            📅 MEMBER SINCE <?php echo date('Y', strtotime($user_data['created_at'])); ?>
        </div>
        <h1 class="user-name"> <?php echo $user_data['name']; ?></h1>
    </div>

    <div class="info-card">
        <div class="info-group">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span class="info-label">Email Address</span>
                    <span class="info-value"><?php echo $user_data['email']; ?></span>
                </div>
                <span style="font-size: 20px;">✉️</span>
            </div>
        </div>

        <div class="info-group">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span class="info-label">Phone Number</span>
                    <span class="info-value"><?php echo $user_data['phone']; ?></span>
                </div>
                <span style="font-size: 20px;">📞</span>
            </div>
        </div>

        <div class="info-group">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span class="info-label">Account Status</span>
                    <div class="info-value" style="margin-top: 8px;">
                        <?php 
                            $status = strtolower($user_data['status']); 
                            $statusClass = '';
                            if ($status == 'active') { $statusClass = 'status-active'; }
                            elseif ($status == 'pending') { $statusClass = 'status-pending'; }
                            else { $statusClass = 'status-blocked'; }
                        ?>
                        <span class="status-badge <?php echo $statusClass; ?>">
                            <?php echo strtoupper($user_data['status']); ?>
                        </span>
                    </div>
                </div>
                <span style="font-size: 20px;">🌐</span>
            </div>
        </div>
    </div>

    <div class="actions">
        <button class="btn btn-primary" onclick="openEditModal()">⚙️ Edit Profile</button>
        <button class="btn btn-outline">🔒 Change Password</button>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 26px; margin: 0;">📝 Edit Profile</h2>
        <p style="font-size: 10px; color: #666; letter-spacing: 1px; margin-bottom: 25px;">UPDATE YOUR PERSONAL DETAILS</p>

        <form action="update_profile.php" method="POST">
            <div class="input-group">
                <label>👤 FULL NAME</label>
                <input type="text" name="name" value="<?php echo $user_data['name']; ?>" required>
            </div>

            <div class="input-group">
                <label>📧 EMAIL ADDRESS</label>
                <input type="email" name="email" value="<?php echo $user_data['email']; ?>" required>
            </div>

            <div class="input-group">
                <label>📞 PHONE NUMBER</label>
                <input type="text" name="phone" value="<?php echo $user_data['phone']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">💾 Save Changes</button>
            <button type="button" class="btn btn-outline btn-full" onclick="closeEditModal()">❌ Cancel</button>
        </form>
    </div>
</div>

<script>
    function openEditModal() { document.getElementById('editModal').style.display = 'flex'; }
    function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }
    window.onclick = function(event) {
        if (event.target == document.getElementById('editModal')) closeEditModal();
    }
</script>

<?php include 'footer.php'; ?>

