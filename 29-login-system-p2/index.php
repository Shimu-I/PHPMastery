<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h3>

        <?php
        output_username();
        ?>
    </h3>


    <?php
    if (!isset($_SESSION["user_id"])) { ?>
        <h3>Login</h3>

        <form action="includes/login.inc.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="pwd" placeholder="Password">
            <button>Login</button>
        </form>

    <?php } ?>




    <?php
    check_login_errors();
    ?>

    <h3>Signup</h3>

    <form action="includes/signup.inc.php" method="post">
        <?php
        signup_inputs()
        ?>
        <button>Signup</button>


    </form>

    <?php

    check_signup_errors();
    ?>


    <h3>Logout</h3>

    <form action="includes/logout.inc.php" method="post">

        <button>Logout</button>
    </form>

</body>

</html>