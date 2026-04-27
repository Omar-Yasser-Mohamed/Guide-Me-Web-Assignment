<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = 1; // For demo purposes
    
    $current = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new !== $confirm) {
        $msg = "Error: New passwords do not match.";
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['status' => 'error', 'message' => $msg]);
            exit();
        }
        echo $msg;
        exit();
    }

    // In a real app, check current password hash. 
    // For this assignment, we'll just update it.
    
    $sql = "UPDATE users SET password='$new' WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
            exit();
        }
        header("Location: profile.php?msg=Password updated successfully");
        exit();
    } else {
        $error = mysqli_error($conn);
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['status' => 'error', 'message' => "Error updating password: $error"]);
            exit();
        }
        echo "Error updating password: " . $error;
    }
}
?>
