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
</head>
<body>
    <form class="form-group" action="authenticate.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <button type="submit" class="btn btn-primary">Sign In</button>
    </form> 
</body>
</html>
