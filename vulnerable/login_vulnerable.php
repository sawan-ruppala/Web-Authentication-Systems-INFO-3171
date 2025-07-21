<?php
    session_start();
    require_once 'db_vulnerable.php'; // Ensure the database connection file is set up

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username']; // No sanitization (trimming)
        $password = $_POST['password'];
        
        // Direct SQL injection vulnerability
        $sql = "SELECT * FROM users WHERE username = '$username' AND password_hash = '$password'";
        $result = mysqli_query($conn, $sql);

        // Fetch the user record
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['user_id'] = mysqli_fetch_assoc($result)['username']; // unsafe session storage
            header("Location: dashboard_vulnerable.php?xss=1");
            exit();
        } else {
            // $error = "Invalid credentials";
            die("Login failed. SQL: " . htmlspecialchars($sql) . "<br>Error: " . mysqli_error($conn));
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable Login</title>
    <style>
    </style>
</head>
<body>
    <h2>Vulnerable Login</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login_vulnerable.php">
        <input type="text" name="username" placeholder="Username" id="username" required>
        <input type="password" name="password" placeholder="Password" id="password">
        <button type="submit">Login</button>
    </form>
    <a href="register_vulnerable.php">Don't have an account? Register</a>
</body>
</html>