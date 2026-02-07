<?php

$dsn = "mysql:host=localhost:55000, dbname=database";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXception $e) {
    echo "Connection failed: " . $e->getMessage();
}
