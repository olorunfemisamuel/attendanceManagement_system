<?php
include "../connection/config.php"; // Include your database connection

if (isset($_GET['id']) && isset($_GET['status'])) {
    $studentId = $_GET['id'];
    $status = $_GET['status'];

    $query = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $studentId);
    
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Failed to update attendance";
    }

    $stmt->close();
    $conn->close();
}
?>
