<?php

// Comparison operator

echo "<br>";
$a = 2;
$b = "2";
$c = 4;
// 2 == "2"
// 2 === "2" is this true and do they have the same data type.
// 2 !=== 2 check not the same data type or number
// != is same as <>
// <, >, <=, >=
if ($a != $c) {
    echo "This statement is true!";
} else {
    echo "This statement is false";
}
