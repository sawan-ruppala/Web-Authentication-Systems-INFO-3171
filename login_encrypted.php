<?php
    session_start();
    require_once 'db_sqli.php'; // Ensure the database connection file is set up
    $error = "";

    // 32-byte encryption key genereated by AI
    define('ENCRYPTION_KEY', '7b2c5f9e1d4a8c3f6e0b7d2a5c8f1e3d6b4a9f0c7e2d5b8a3f6e1c9d4b7a2');
    define('ENCRYPTION_METHOD', 'aes-256-cbc');

    function encryptData($data) {
        if (empty($data)) return null;
        // Generate an initial vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(ENCRYPTION_METHOD));
        // encrypts
        $encrypted = openssl_encrypt(
            $data,                      // The plaintext data
            ENCRYPTION_METHOD,          // The encryption algorithm
            hex2bin(ENCRYPTION_KEY),    // Converts hex key to binary
            0,                          // No options
            $iv                         // unique random vector from earlier
        );
        // Combines the vector with the ciphertext
        return base64_encode($iv . $encrypted);
    }

    function decryptData($data) {
        if (empty($data)) return null;
        $data = base64_decode($data);

        // Gets vector length for AES
        $iv_length = openssl_cipher_iv_length(ENCRYPTION_METHOD);
        // Extracts vector
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length); // Get ciphertext
        return openssl_decrypt( // decrypts similarly to above
            $encrypted,
            ENCRYPTION_METHOD,
            hex2bin(ENCRYPTION_KEY),
            0,
            $iv
        );
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Sanitizes Inputs
        $username = trim(htmlspecialchars($_POST["username"])); // grab from form and sanitize
        $password = trim(htmlspecialchars($_POST["password"]));
        
        // PDO Prepared Statements
        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT id, username, password_hash, email FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the user record
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Verify the password
            if (password_verify($password, $user['password_hash'])) {
                // Decrypt email
                $user['email'] = decryptData($user['email']);
                if ($user['email'] === false) die("Decryption failed!");

                $_SESSION["user_id"] = $user['id'];
                $_SESSION["user_email"] = $user["email"]; // saves decrypted email
                header("Location: dashboard.php"); // Redirect
                exit();
            }
        }
        $error = "Invalid credentials";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encrypted SQL Login</title>
    <style>
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Encrypted SQL Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="login_encrypted.php">
            <input type="text" name="username" placeholder="Username" id="username" required>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register_encrypted.php">Don't have an account? Register</a>
    </div>
</body>
</html>