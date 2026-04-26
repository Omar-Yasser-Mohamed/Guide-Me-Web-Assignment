<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = 1; 
    
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $check_email = "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
        die("خطأ: الإيميل ده مستخدم قبل كدة من يوزر تاني، جربي إيميل تاني يا هندسة.");
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$user_id'";

        if (mysqli_query($conn, $sql)) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>