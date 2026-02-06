<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- when we want to send the form data to the same page the form is on--(not recommended) -->
    <!-- <form action="<?php // echo $_SERVER["PHP_SELF"] 
                        ?>" method="post"> -->

    <form action="formhandler.php" method="post">
        <label>Firstname?</label>
        <input id="firstname" type="text" name="firstname" placeholder="first name...">
        <br>
        <label for="lastname">Lastname?</label>
        <input id="lastname" type="text" name="lastname" placeholder="Last name...">
        <br>
        <select id="favouritepet" name="favouritepet">
            <option value="none">None</option>
            <option value="dog">Dog</option>
            <option value="cat">Car</option>
            <option value="bird">Bird</option>
        </select>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>







</body>

</html>