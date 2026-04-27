<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 require_once __DIR__ . '/../db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = 1; 
    
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $check_email = "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
        $msg = "خطأ: الإيميل ده مستخدم قبل كدة من يوزر تاني، جرب إيميل تاني يا هندسة.";
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['status' => 'error', 'message' => $msg]);
            exit();
        }
        echo $msg;
               
    } else {
        $sql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$user_id'";

        if (mysqli_query($conn, $sql)) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
                exit();
            }
            header("Location: profile.php?msg=Profile updated successfully");
            exit();
        } else {
            $error = mysqli_error($conn);
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                echo json_encode(['status' => 'error', 'message' => "Error updating record: $error"]);
                exit();
            }
            echo "Error updating record: " . $error;
        }
    }
}
?>