<?php
include "../connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (!$hashed_password) {
        die("Error hashing password");
    }

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email is already registered
        echo "<script>alert('This email is already registered. Please use a different email.');</script>";
    } else {
        // Check if the password is already in use
        $stmt = $conn->prepare("SELECT id FROM users WHERE password = ?");
        $stmt->bind_param("s", $hashed_password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Password is already in use
            echo "<script>alert('This password is already in use. Please use a different password.');</script>";
        } else {
            $role = "student"; // Default role

            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                // Display alert and redirect to sign-in page after successful registration
                echo "<script>alert('You have been successfully registered.'); window.location.href='../students/sign_in.php';</script>";
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>