<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- for putting data to the same page we can do 
- action="" or action = "<php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" -->

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <input type="number" name="num01" placeholder="number 1">
        <br>
        <select name="operator">
            <option value="add">+</option>
            <option value="subtract">-</option>
            <option value="multiply">*</option>
            <option value="divide">/</option>
        </select>
        <br>
        <input type="number" name="num02" placeholder="number 2">
        <br>
        <button name="calculate">Calculate</button>
    </form>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // secure way -- $num01 = filter_input(INPUT_POST, "num01", FILTER_SANITIZE_NUMBER_FLOAT);
        // not secure way -- $num1 = $_POST["num01"];


        // Grap data form the inputs
        $num01 = filter_input(INPUT_POST, "num01", FILTER_SANITIZE_NUMBER_FLOAT);
        $num02 = filter_input(INPUT_POST, "num02", FILTER_SANITIZE_NUMBER_FLOAT);
        $operator = htmlspecialchars($_POST["operator"]);

        // Error handlers
        $errors = false;
        if (empty($num01)  || empty($num02) || empty($operator)) {
            echo "Fill in all fields!";
            $errors = true;
        }
        if (!is_numeric($num01) || !is_numeric($num02)) {
            echo "Only write numbers!";
            $errors = true;
        }

        // Calculate the number if no errors
        // the case string need to be same as the form option value
        if (!$errors) {
            $value = 0;
            switch ($operator) {
                case 'add':
                    $value = $num01 + $num02;
                    break;
                case 'subtract':
                    $value = $num01 - $num02;
                    break;
                case 'multiply':
                    $value = $num01 * $num02;
                    break;
                case 'divide':
                    $value = $num01 / $num02;
                    break;
                default:
                    echo "Something went HORRIBLY wrong!";
            }

            echo "Result = " . $value;
        }
    }



    ?>
</body>

</html>