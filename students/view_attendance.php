<?php
session_start();
include "../connection/config.php"; // Include the database connection

// Check if the student is logged in
if (!isset($_SESSION['id'])) {
    header("Location: students/sign_in.php");
    exit();
}

$student_id = $_SESSION['id']; // Get the student ID from the session

// Retrieve attendance records for the student
$stmt = $conn->prepare("SELECT date FROM attendance WHERE user_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($date);

$attendance_records = [];
while ($stmt->fetch()) {
    $attendance_records[] = $date;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="../css/view_attendance.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function printAttendance() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(18);
            doc.text("Attendance Records", 20, 20);

            // Add attendance records
            const attendanceRecords = document.querySelectorAll('.attendance-container ul li');
            let yPosition = 30;
            attendanceRecords.forEach(record => {
                doc.setFontSize(12);
                doc.text(record.textContent, 20, yPosition);
                yPosition += 10;
            });

            // Save the PDF
            doc.save("attendance.pdf");
        }
    </script>
</head>
<body>
<div class="attendance-container">
    <h2>Your Attendance Records</h2>
    <?php if (empty($attendance_records)) { ?>
        <p>No attendance records found.</p>
    <?php } else { ?>
        <ul>
            <?php foreach ($attendance_records as $record) { ?>
                <li><?php echo htmlspecialchars($record); ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <button type="button" class="btn btn-primary" onclick="window.location.href='student_mark_attendance.php'">Back</button>
    <button type="button" class="btn btn-primary" onclick="printAttendance()">Print Attendance</button>
</div>
</body>
</html>