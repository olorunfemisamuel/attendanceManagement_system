<?php
session_start();
header('Content-Type: application/json'); // Ensure JSON response
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$date = date("Y-m-d");
$ip_address = $_SERVER['REMOTE_ADDR'];

// Check if attendance is already marked
$stmt = $pdo->prepare("SELECT * FROM attendance WHERE user_id = ? AND DATE(timestamp) = ?");
$stmt->execute([$user_id, $date]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["message" => "Already marked"]);
    exit;
}

// Insert attendance record
$stmt = $pdo->prepare("INSERT INTO attendance (user_id, timestamp, ip_address, status) VALUES (?, NOW(), ?, 'present')");
$stmt->execute([$user_id, $ip_address]);

echo json_encode(["message" => "Attendance marked"]);
?>
