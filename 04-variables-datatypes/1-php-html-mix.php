<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!--How php and HTML can be mix together-->

    <p>This is a paragraph.</p>

    <p>This is a <?php echo "awesome"; ?> paragraph.</p>

    <?php echo "This is ALSO a paragraph." ?>

    <br>

    <?php
    $user_name = "Jasmin Sultana Shimu";
    $test = $user_name;
    ?>
    <p>Hi! My name is <?php echo $test; ?>, and I'm learning PHP!</p>








</body>

</html>