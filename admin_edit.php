<?php
include "config.php"; // Include the database connection

$id = $_GET['id'];
$date = $_GET['date'];

// Update attendance record
$stmt = $conn->prepare("UPDATE attendance SET date = ? WHERE id = ?");
$stmt->bind_param("si", $date, $id);
if ($stmt->execute()) {
    echo "Attendance record updated successfully.";
} else {
    echo "Error updating attendance record.";
}
$stmt->close();
$conn->close();
?>