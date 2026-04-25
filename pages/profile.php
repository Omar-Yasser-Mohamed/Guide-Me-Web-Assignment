<?php
require_once __DIR__ . '/../db_connection.php';
    $pageTitle = "Profile";
    include 'header.php'; 
?>

<div class="section" style="padding-top: 40px;">
    <div class="section-subtitle">ACCOUNT SETTINGS</div>
    <h2 class="section-title">User Profile</h2>
    <p style="color: #666; margin-top: 16px;">Manage your personal information and preferences.</p>
</div>

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
