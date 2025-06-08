<?php
    $host = 'localhost';
    $dbname = 'Banking';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname, $username, $password");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOExcception $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
?>