<?php

// include 'config.php';

// $input_password = $_POST['password'];

// $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
// $stmt->bind_param("s", $email);
// $stmt->execute();
// $stmt->bind_result($hashed_password);
// $stmt->fetch();
// $stmt->close();

// if (password_verify($input_password, $hashed_password)) {
//     echo "Password is correct!";
// } else {
//     echo "Invalid password.";
// }

//



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/sign_in.css">
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
    <form class="form-group" action="authenticate.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
        <label for="password">Password</label>
        <div class="password-container">
            <input type="password" name="password" id="password" class="form-control" required>
            <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
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
