<?php
// admin.php - Admin Panel (Vanilla PHP + JavaScript)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Attendance View</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function fetchAttendance() {
            fetch('admin_view.php')
                .then(response => response.json())
                .then(data => {
                    let table = '<table border="1"><tr><th>Student</th><th>Date</th><th>IP Address</th><th>Status</th><th>Actions</th></tr>';
                    data.forEach(record => {
                        let status = record.status === 'absent' ? '<span style="color: red;">&#10060; Absent</span>' : '<span style="color: green;">&#10004; Present</span>';
                        table += `<tr>
                            <td>${record.name}</td>
                            <td>${record.date}</td>
                            <td>${record.ip_address}</td>
                            <td>${status}</td>
                            <td>
                                <button onclick="editAttendance(${record.id})">Edit</button>
                                <button onclick="deleteAttendance(${record.id})">Delete</button>
                                <button onclick="markAbsent(${record.id})">Mark Absent</button>
                                <button onclick="markPresent(${record.id})">Mark Present</button>
                            </td>
                        </tr>`;
                    });
                    table += '</table>';
                    document.getElementById('attendanceTable').innerHTML = table;
                })
                .catch(error => console.error('Error fetching attendance records:', error));
        }

        function editAttendance(id) {
            const newDate = prompt("Enter new date (YYYY-MM-DD HH:MM:SS):");
            if (newDate) {
                fetch(`admin_edit.php?id=${id}&date=${newDate}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchAttendance();
                    })
                    .catch(error => console.error('Error editing attendance record:', error));
            }
        }

        function deleteAttendance(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                fetch(`admin_delete.php?id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchAttendance();
                    })
                    .catch(error => console.error('Error deleting attendance record:', error));
            }
        }

        function markAbsent(studentId) {
            if (confirm("Are you sure you want to mark this student absent?")) {
                fetch(`admin_mark_absent.php?id=${studentId}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchAttendance();
                    })
                    .catch(error => console.error('Error marking attendance record as absent:', error));
            }
        }

        function markPresent(id) {
            if (confirm("Are you sure you want to mark this student present?")) {
                fetch(`admin_mark_present.php?id=${id}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        fetchAttendance();
                    })
                    .catch(error => console.error('Error marking attendance record as present:', error));
            }
        }

        function printAttendance() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add title
            doc.setFontSize(18);
            doc.text("Attendance Records", 20, 20);

            // Add attendance records
            const attendanceRecords = document.querySelectorAll('#attendanceTable table tr');
            let yPosition = 30;
            attendanceRecords.forEach((record, index) => {
                if (index === 0) {
                    doc.setFontSize(14);
                } else {
                    doc.setFontSize(12);
                }
                doc.text(record.innerText, 20, yPosition);
                yPosition += 10;
            });

            // Save the PDF
            doc.save("attendance.pdf");
        }

        window.onload = fetchAttendance;
    </script>
</head>
<body>
    <h2>Attendance Records</h2>
    <div id="attendanceTable"></div>
    <button onclick="printAttendance()">Print Attendance</button>
    <button onclick="window.location.href='../admin/admin_registered_students.php'">Registered Students</button>
</body>
</html>