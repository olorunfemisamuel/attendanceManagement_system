<?php 
session_start();
include "../connection/config.php"; // Include the database connection

date_default_timezone_set('Africa/Lagos'); // Set your timezone

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_attendance'])) {
    $student_id = $_SESSION['id']; // Assuming the student ID is stored in the session
    $current_time = new DateTime();
    $start_time = new DateTime('16:00'); // 4 PM
    $end_time = new DateTime('19:00'); // 7 PM
    $current_day = $current_time->format('N'); // 1 (for Monday) through 7 (for Sunday)

    // Check if the current time is between 4 PM and 7 PM and the day is Saturday
    if ($current_time >= $start_time && $current_time <= $end_time && $current_day == 6) {
        // Check if the student has already marked attendance today
        $stmt = $conn->prepare("SELECT COUNT(*) FROM attendance WHERE user_id = ? AND DATE(date) = CURDATE()");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            // Record attendance
            $stmt = $conn->prepare("INSERT INTO attendance (user_id, date) VALUES (?, NOW())");
            $stmt->bind_param("i", $student_id);
            if ($stmt->execute()) {
                $message = "Attendance marked successfully!";
            } else {
                $message = "Error marking attendance.";
            }
            $stmt->close();
        } else {
            $message = "You have already marked attendance today.";
        }
    } else {
        $message = "You can only mark attendance on Saturdays between 4 PM and 7 PM.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System</title>
    <link rel="stylesheet" href="../css/student_mark_attendance.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function enableSubmitButton() {
            document.getElementById('submit-attendance').disabled = !document.getElementById('mark-attendance').checked;
        }

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
    <h2>Mark Your Attendance</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="post" action="student_mark_attendance.php">
        <div class="checkbox-container">
            <input type="checkbox" id="mark-attendance" name="mark_attendance" onclick="enableSubmitButton()">
            <label for="mark-attendance">Click to mark attendance</label>
        </div>
        <div class="button-container">
            <button type="button" class="btn btn-primary" onclick="window.location.href='view_attendance.php'">View Attendance</button>
            <button type="submit" id="submit-attendance" class="btn btn-primary" disabled>Submit Attendance</button>
        </div>
    </form>
</div>
<p id="status"></p>
</body>
</html>