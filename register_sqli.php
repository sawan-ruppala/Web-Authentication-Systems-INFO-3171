<?php
    session_start();
    require_once 'db_sqli.php';

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Santize Inputs
        $username = trim(htmlspecialchars($_POST['username']));
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim(htmlspecialchars($_POST["password"]));
        $confirm_password = trim(htmlspecialchars($_POST["confirm_password"]));
        // $password = $_POST['password'];
        // $confirm_password = $_POST['confirm_password'];

        // Validate Inputs
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $error = "All fields are require.";
        } elseif ($password != $confirm_password) {
            $error = "Passwords do not match.";
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $password)) { // Password policy on length
            $error = "Weak password. Password must contain: 8+ chars, 1 uppercase, 1 number, 1 special char.";
        } else { // check if username and email already exist
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) { // will give rows if user already exists
                $error = "Username or email already taken.";
            } else {
                // Hash Password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert new user record
                $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);

                if ($stmt->execute()) {
                    header("Location: login_sqli.php");
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Registration</title>
    <style>
    </style>
</head>
<body>
    <h2>Secure Registration</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="register_sqli.php">
        <input type="text" name="username" placeholder="Username" id="username" required>
        <input type="email" name="email" placeholder="Email" id="email" required>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>

        <button type="submit">Register</button>
    </form>
    <a href="login_sqli.php">Already have an account? Login</a>
</body>
</html>