<?php

// there are 4 loops in php
// for 
// while
// do while
// for each


// for loop - usage - basically any thing that has a someting to do with numbers

for ($i = 0; $i <= 10; $i++) {
    echo "This is iteration number: " . $i . "<br>";
}

$test = 5;
for ($i = 0; $i <= $test; $i++) {
    echo "iteration number: " . $i . "<br>";
}

// while loop - usage - check condition like if condition
$boolean = true;
while ($boolean) {
    echo "While loop result: " . $boolean . "<br>";
    $boolean = false;
}

$test = 5;
while ($test < 10) {
    echo $test . "<br>";
    $test++;
}


// do while loop - no matter what happens it will loop one time
$test = 10;
do {
    echo "Do while loop result: " . $test . "<br>";
    $test++;
} while ($test < 10);

// for each loop -- indexed array
$fruits = array("Apple", "Banana", "Orange");

// don't do these
// echo $fruits[0] . "<br>";
// echo $fruits[1] . "<br>";
// echo $fruits[2] . "<br>";

foreach ($fruits as $fruit) {
    echo "This is a " . $fruit . "<br>";
}


// for each loop -- associative array
$fruits1 = array("Apple" => "Red", "Banana" => "Yellow", "Orange" => "Orange");

foreach ($fruits1 as $fruit => $color) {
    echo "This is a " . $fruit . ",that has a color of " . $color . "<br>";
}
