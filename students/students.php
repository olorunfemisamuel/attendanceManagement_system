<?php 
// Include database connection if needed
// include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="css/students_form.css">
    <style>
        .form-group {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: calc(100% - 30px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group .password-container {
            position: relative;
        }
        .form-group .password-container input {
            width: calc(100% - 40px);
        }
        .form-group .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .form-group button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <form class="form-group" action="/students/student_register.php" method="post" onsubmit="return validateForm()">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
        <label for="password">Password</label>
        <div class="password-container">
            <input type="password" name="password" id="password" class="form-control" required>
            <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
        </div>
        <label for="confirm_password">Confirm Password</label>
        <div class="password-container">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            <span class="toggle-password" onclick="togglePassword('confirm_password')">👁️</span>
        </div>
        <span class="error" id="password_error"></span>
        <button type="submit" class="btn btn-primary">Register</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='sign_in.php'">Sign In</button>
    </form> 

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorElement = document.getElementById('password_error');

            if (password !== confirmPassword) {
                errorElement.textContent = "Passwords do not match.";
                return false;
            }

            errorElement.textContent = "";
            return true;
        }
    </script>
</body>
</html>