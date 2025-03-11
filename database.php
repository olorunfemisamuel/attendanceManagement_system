<?php
// database.php - Database Connection
$host = "localhost";  // Change if your database is hosted elsewhere
$dbname = "attendance_db";  // Use the database name you created
$username = "root";  // Default user for XAMPP/WAMP (change if needed)
$password = "";  // Default password for XAMPP/WAMP (leave empty for XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
