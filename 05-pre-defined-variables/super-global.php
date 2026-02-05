<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- Pre defined variable == Build-in variable-->

    <?php
    // This is super global variable can access this from any where
    echo $_SERVER["DOCUMENT_ROOT"];
    echo "<br>";
    echo $_SERVER["PHP_SELF"];
    echo "<br>";
    echo $_SERVER["SERVER_NAME"];
    echo "<br>";
    echo $_SERVER["REQUEST_METHOD"];
    ?>

    <!----------------------------------------------->

    <?php
    echo $_GET["name"];
    echo $_GET["eyecolor"];
    // http://localhost/phpmastery/index.php?name=shimu

    // http://localhost/phpmastery/index.php?name=shimu&eyecolor=black
    /*
        because name = shimu 
        we are accessing a piece of data inside of URL which could have been submitted by a get method

        (get method -- 
        -submit data
        -visible in the url
        -get data form the database or want to show the user use GET method)
    */
    ?>

    <!----------------------------------------------->

    <?php
    // echo $_POST["name"];

    /*
        (post method -- 
        -submit data
        -not visible in the url
        -more useful in term of sending sensitive data
        -submit data to the website or database in the website use POST method)
    */
    ?>

    <!----------------------------------------------->

    <?php
    echo $_REQUEST["name"];
    /*
        ( request method -- 
        -get
        -post
        -cookies
        -when comes to looking data 
    */
    ?>

    <!----------------------------------------------->

    <?php
    // echo $_FILES["name"];
    /*
        ( file method -- 
        -get data about a file that has been uploaded into my server
    */
    ?>

    <!----------------------------------------------->

    <?php
    // echo $_COOKIE["name"];
    /*
        ( cookie method -- 
        Cookie logic:
      - Small file stored in the browser.
      - Sent back to the server with every request.
      - Great for "Remember Me" or user preferences.
    */
    ?>

    <!----------------------------------------------->

    <?php
    echo $_SESSION["username"] = "Jasmin";
    echo $_SESSION["username"];
    /*
        ( session method -- 
    - Stored on the SERVER (secure).
    - Temporary (usually ends when browser closes).
    - Used for sensitive info like "is the user logged in?".
    */
    ?>

    <!----------------------------------------------->

    <?php
    $_ENV[""];
    /*
    $_ENV (Environment Variables)
        - Used for server-side configurations.
        - Keeps sensitive "secrets" out of your main code.
        - Data comes from the operating system or a .env file.
    */
    ?>

    <!----------------------------------------------->

    <?php
    //summary of super global

    $_SERVER[""];
    $_GET[""];
    $_POST[""];
    $_REQUEST[""];
    $_FILES[""];
    $_COOKIES[""];
    $_SESSION[""];
    $_ENV[""];
    ?>


</body>

</html>