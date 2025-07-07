<?php
    session_start();
    session_destroy();
    header("Location: security_selector.php");
    exit();
?>