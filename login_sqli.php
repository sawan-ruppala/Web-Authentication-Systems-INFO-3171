<?php
    session_start();
    require_once 'db_sqli.php'; // Ensure the database connection file is set up
    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Sanitizes Inputs
        $username = trim(htmlspecialchars($_POST["username"])); // grab from form and sanitize
        $password = trim(htmlspecialchars($_POST["password"]));
        // $password = $_POST['password'];

        // PDO Prepared Statements
        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the user record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (password_verify($password, $user['password_hash'])) {
            // echo json_encode(["success" => true, "message" => "Incorrect password."]);
            // Start the session and store the user ID
            $_SESSION["user_id"] = $user['id'];
            header("Location: dashboard.php"); // Redirect
            exit();
        } else {
            $error = "Invalid credentials";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure SQL Login</title>
    <style>
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Secure SQL Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="login_sqli.php">
            <input type="text" name="username" placeholder="Username" id="username" required>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register_sqli.php">Don't have an account? Register</a>
    </div>
</body>
</html>