<?php
    session_start();
    if(!isset($_SESSION["user_id"])) {
        header("Location: login_vulnerable.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vulnerable Dashboard</title>
        <style></style>
    </head>
    <body>
        <h1>Welcome to Your Vulnerable Account Dashboard!</h1>
        <a href="../logout.php">Logout</a>
    </body>
</html>