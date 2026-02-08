<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        require_once "../../20-connect-db/includes/dbh.inc.php";

        $query = "INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);";
        // FOR NAME PARAMETERS
        // VALUES (:username, :pwd, :email);

        $stmt = $pdo->prepare($query);

        // $stmt->bindParam(":username", $username);
        // $stmt->bindParam(":pwd", $pwd);
        // $stmt->bindParam(":email", $email);

        $stmt->execute([$username, $pwd, $email]);

        // $stmt->execute();

        $pdo = null;

        $stmt = null;

        header("Location: ../form.php");
        die();
        // exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../form.php");
}
