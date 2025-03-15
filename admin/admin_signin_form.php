<?php
include "../connection/config.php";
session_start();

$name = $email = $password = "";
$login_err = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Ensure email exists
    $stmt = $conn->prepare("SELECT id, name, email, password FROM admins WHERE email = ? AND name = ?");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $admin_name, $admin_email, $hashed_password);
        $stmt->fetch();

        // Check if password matches
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_email'] = $admin_email;

            header("Location: ../admin/admin.php");
            exit();
        } else {
            $login_err = "Invalid password.";
        }
    } else {
        $login_err = "No account found with that name and email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="stylesheet" href="../css/admin_signin_form.css">
    <style>
        .password-container {
            position: relative;
        }
        .password-container input {
            width: calc(100% - 40px);
        }
        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Sign In</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='../index.php'">Back</button>
        </div>
        <span class="error"><?php echo $login_err; ?></span>
    </form>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }
    </script>
</body>
</html>