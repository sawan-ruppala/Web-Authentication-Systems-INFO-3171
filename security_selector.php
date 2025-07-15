<?php?>

<!DOCTYPE html>
<html>
    <head>
        <title>Security Selector</title>
    </head>
    <body>
        <h1>Choose Login System</h1>
        
        <!-- Vulnerable -->
        <form action="vulnerable/login_vulnerable.php">
            <button type="submit">Vulnerable Login</button>
        </form>
        
        <!-- SQL -->
        <form action="login_sqli.php">
            <button type="submit">Secured (SQL Injection Protected)</button>
        </form>

        <!-- Encrypted -->
         <form action="login_encrypted.php">
            <button type="submit">Encrypted DB Login</button>
        </form>

        <!-- Multi Factor Authentication -->
        <form action="login_mfa.php">
            <button type="submit">MFA Login</button>
        </form>

        <!-- AI -->
         <form action="">
            <button type="submit">AI Login (Not yet implemented)</button>
        </form>
    </body>
</html>