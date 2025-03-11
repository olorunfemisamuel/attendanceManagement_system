<?php
include "config.php"; // Include the database connection

$id = $_GET['id'];

// Mark attendance as present
$stmt = $conn->prepare("UPDATE attendance SET status = 'present' WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "Attendance record marked as present.";
} else {
    echo "Error marking attendance record as present.";
}
$stmt->close();
$conn->close();
?>