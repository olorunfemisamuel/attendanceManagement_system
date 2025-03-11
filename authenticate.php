<?php

include "config.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ? AND role = 'student'");
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                session_regenerate_id(true); // Prevent session fixation
                $_SESSION["id"] = $id;
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email;

                header("Location: student_mark_attendance.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
    } else {
        $error = "Database error. Please try again later.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="stylesheet" href="css/authenticate.css">
</head>

<body>
    <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <button type="submit" onclick="window.location.href='students.php'">Register</button>

</html>
