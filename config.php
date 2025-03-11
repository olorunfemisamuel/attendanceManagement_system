<?php
$host = "localhost"; // Change if your database is on a different server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "attendance_db"; // Your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
