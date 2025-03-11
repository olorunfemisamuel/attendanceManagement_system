<?php
include "config.php"; // Include the database connection

// Fetch all registered students
$query = "SELECT id, name, email FROM users WHERE role = 'student'";
$result = $conn->query($query);

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($students);
?>