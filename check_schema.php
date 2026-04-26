<?php
require_once 'db_connection.php';
$result = $conn->query("DESCRIBE bookings");
while($row = $result->fetch_assoc()) {
    print_r($row);
}
?>
