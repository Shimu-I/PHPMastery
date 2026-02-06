<?php

declare(strict_types=1);



// inside of function return is recommended instead of eco

// normal function
function sayHello()
{
    return "Hello World!";
}

$test = sayHello();
echo "Return value for sayHello function: " . $test . "<br>";

// with parameter
function userName($firstName, $lastName)
{
    return "Hello! " . $firstName . " " . $lastName;
}

$name = userName("Jasmin", "Sultana");
echo "Print user first and last name: " . $name . "<br>";


// with parameter but not using one
function userName2($firstName, $middleName, $lastName)
{
    return "Hello! " . $firstName . " " . $middleName;
}

$name2 = userName2("Jasmin", "Sultana", "");
echo "Print user first and last name: " . $name2 . "<br>";


// with default value
function functionNo2($name = "value1")
{
    return "Hello " . $name . "!";
}

$test = functionNo2();
echo "Function no 2 with default: " . $test . "<br>";
$test = functionNo2("Shimu");
echo "Function no 2 without default: " . $test . "<br>";


// with type declaration
function functionNo3(string $name)
{
    return "Hello " . $name . "!";
}

// $test = functionNo3(123); -- after adding the declare statement the argument is showng error
$test = functionNo3("123");
echo "Return value for Function no 3: " . $test . "<br>";
// it ensure right data has inserted inside right function

// calculator function
function calculator($num1, $num2)
{
    $result = $num1 + $num2;
    return $result;
}

$test2 = calculator(4, 8);
echo "Return value form calculator function: " . $test2 . "<br>";


// function with global variable -- scopes
$global_value = "GLOBAL";
function globalVariable($test3)
{
    global $global_value;
    return $global_value;
}

$test4 = globalVariable("ggg");
echo "Return value form globalVariable function: " . $test4 . "<br>";
