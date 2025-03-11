<?php
include "config.php"; // Include the database connection

$id = $_GET['id'];

// Delete attendance record
$stmt = $conn->prepare("DELETE FROM attendance WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "Attendance record deleted successfully.";
} else {
    echo "Error deleting attendance record.";
}
$stmt->close();
$conn->close();
?>