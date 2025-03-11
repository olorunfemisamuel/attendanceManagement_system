<?php 



?>

<!DOCTYPE html>
<html lang="en">
<head>

<?php include 'database.php'; ?>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="css/students_form.css">
</head>
<body>
    <form class="form-group" action="student_register.php" method="post">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <label for="password">Confirm Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <button type="submit" class="btn btn-primary">Register</button>
        <button type="submit" class="btn btn-primary" onclick="window.location.href='sign_in.php'">Sign In</button>
        
    </form> 
</body>
</html>