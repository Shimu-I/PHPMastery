<?php
session_start();
$_SESSION["username"] = "Shimu";
// unset($_SESSION["username"]); // deleting one session data
// session_unset(); // deleteing all session data
session_destroy(); // stoping the session running again, // can't see the effect until i visit another page

// commently used together
// session_unset();
// session_distroy();

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

    // First visit this page then the example page
    echo "This is index page" . "<br>";
    echo $_SESSION["username"];

    ?>

</body>

</html>