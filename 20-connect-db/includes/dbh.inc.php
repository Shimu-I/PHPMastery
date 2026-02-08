<?php

$dsn = "mysql:host=localhost;port=55000;dbname=database";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "DB connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
