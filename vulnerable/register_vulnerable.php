<?php
    // NO SESSION SECURITY
    session_start();
    require_once 'db_vulnerable.php';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // NO INPUT SANITIZATION
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // PLAIN TEXT PASSWORD STORAGE
        $sql = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: login_vulnerable.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable Registration</title>
    <style>
    </style>
</head>
<body>
    <h2>Vulnerable Registration</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" id="username" required>
        <input type="email" name="email" placeholder="Email" id="email" required>
        <input type="password" name="password" placeholder="Password" id="password" required>

        <button type="submit">Register</button>
    </form>
    <a href="login_vulnerable.php">Already have an account? Login</a>
</body>
</html>