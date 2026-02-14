<?php
session_start();
// unset($_SESSION["username"]);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    echo "This is example page" . "<br>";
    echo $_SESSION["username"];

    ?>
</body>

</html>