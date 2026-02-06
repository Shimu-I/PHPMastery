<?php

//if (!$bool) -> checks the condition is true or not not the value
//if $bool = ture ,  !$bool == False are same
// else if == elseif
//


$bool = true;
$a = 1;
$b = 4;

// If , else if conditions

if ($a < $b && !$bool) {
    echo "First condition is true!";
} else if ($a < $b && !$bool) {
    echo "Second condition is true!";
} else if ($a < $b && !$bool) {
    echo "Second condition is true!";
} else if ($a < $b && !$bool) {
    echo "Second condition is true!";
} else if ($a < $b && !$bool) {
    echo "Second condition is true!";
} else {
    echo "None of the conditions were true!";
}
