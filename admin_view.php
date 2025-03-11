<?php
include "config.php"; // Include the database connection

// Fetch attendance records
$query = "SELECT a.id, u.name, a.date, a.ip_address, a.status FROM attendance a JOIN users u ON a.user_id = u.id";
$result = $conn->query($query);

$attendance_records = [];
while ($row = $result->fetch_assoc()) {
    $attendance_records[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($attendance_records);
?>