<?php

// Logical operator

echo "<br>";
$a = 4;
$b = 4;
$c = 2;
$d = 6;
// and, or, ||(or), &&(and)
if ($a == $b and $c == $d) {
    echo "This statement is TRUE!";
} else {
    echo "NOT TRUE!";
}
// $a == $b || $c == $d && $a == $c
// in term of precedence or is the last determiner
