<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Login</title>
    <style>
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Bank Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" id="username" required>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register</a>
    </div>
</body>
</html>

<?php
    session_start();
    require_once 'db.php'; // Ensure the database connection file is set up
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($username) || empty($password)) {
            echo json_encode(["success" => false, "message" => "Both email and password are required."]);
            exit();
        }
        
        // Sanitizes Inputs
        $username = trim(htmlspecialchars($_POST["username"])); // grab from form and sanitize
        $password = trim(htmlspecialchars($_POST["password"]));

        // PDO Prepared Statements
        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
        echo json_encode(["success" => false, "message" => "No user found with that email address."]);
        exit();
        }

        // Fetch the user record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (!password_verify($password, $user['password_hash'])) {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
            // Start the session and store the user ID
            $_SESSION["user_id"] = $user['id'];
            header("Location: dashboard.php"); // Redirect
            exit();
        }
    }
?>