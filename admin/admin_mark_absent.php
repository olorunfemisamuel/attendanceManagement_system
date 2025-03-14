<?php
include "../connection/config.php"; // Include the database connection

// $id = $_GET['id'];

// // Mark attendance as absent
// $stmt = $conn->prepare("UPDATE attendance SET status = 'absent' WHERE id = ?");
// $stmt->bind_param("ii", $id, $user_id);
// if ($stmt->execute()) {
//     echo "Attendance record marked as absent.";
// } else {
//     echo "Error marking attendance record as absent.";
// }
// $stmt->close();
// $conn->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id = intval($_POST['student_id']); // Ensure it's an integer

    $stmt = $conn->prepare("UPDATE attendance SET status = 'absent' WHERE id = ?");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $student_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Student marked as absent successfully.";
    } else {
        echo "No changes made.";
    }

    $stmt->close();
    $conn->close();
}
?>
