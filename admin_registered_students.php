<?php
include "config.php"; // Database connection

// Fetch all registered students
$query = "SELECT id, name, email, status FROM users WHERE role = 'student'";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h2>Registered Students</h2>
    <div id="studentsTable">
        <table border="1">
            <tr>
                <th>Student</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
                <td>
                    <span id="status-<?php echo $student['id']; ?>">
                        <?php if ($student['status'] == 'present'): ?>
                            <span style="color: green;">&#10004; Present</span>
                        <?php elseif ($student['status'] == 'absent'): ?>
                            <span style="color: red;">&#10060; Absent</span>
                        <?php endif; ?>
                    </span>
                </td>
                <td>
                    <button onclick="markAttendance(<?php echo $student['id']; ?>, 'present')">Mark Present</button>
                    <button onclick="markAttendance(<?php echo $student['id']; ?>, 'absent')">Mark Absent</button>
                    <button onclick="markAttendance(<?php echo $student['id']; ?>, 'not marked')">Not marked</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function markAttendance(studentId, status) {
            fetch(`update_attendance.php?id=${studentId}&status=${status}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(`status-${studentId}`).innerHTML =
                        status === 'present'
                        ? '<span style="color: green;">✔ Present</span>'
                        : '<span style="color: red;">✘ Absent</span>';
                })
                .catch(error => console.error('Error updating attendance:', error));
        }
    </script>
</body>
</html>
