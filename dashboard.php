<?php
    session_start();

    // Validate session
    $valid_session = isset($_SESSION["user_id"]) && $_SESSION['ip'] === $_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'];
    
    if(!$valid_session) {
        session_destroy();
        header("Location: login_sqli.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bank Dashboard</title>
        <style></style>
    </head>
    <body>
        <h1>Welcome to Your Secure Account!</h1>
        <a href="logout.php">Logout</a>
    </body>
</html>