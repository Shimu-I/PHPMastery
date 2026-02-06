<?php

// to check what method the form is using
// var_dump($_SERVER["REQUEST_METHOD"]);

//alternative of if condition (not recommended)
// if (isset($_POST["submit"])) {
// }

// htmlsecialchars(convert special character to html entity) == htmlentities(convert every thing to html entity)

// recommended
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = htmlspecialchars($_POST["firstname"]);
    $lastName = htmlspecialchars($_POST["lastname"]);
    $favouritePets = htmlspecialchars($_POST["favouritepet"]);

    if (empty($firstNam)) {
        exit();
        header("Location: form.php");
    }
    echo "These are the data, that the user submitted: \r\n";
    echo "<br>";
    echo $firstName;
    echo "<br>";
    echo $lastName;
    echo "<br>";
    echo $favouritePets;

    header("Location: form.php");
} else {
    header("Location: form.php");
    // if the folder is in root header("Location: ../folder/fileName.php)
}
