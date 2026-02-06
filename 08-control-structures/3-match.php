<?php


// match

// if $u = "5" we can get the default error uncaught unhandled match error
// 1, 3, 5 ==> either equal to 1 or 3 or 5
// if else vs switch vs match -> depends on the purpose of the code

$u = 6;

$result = match ($u) {
    1, 3, 5 => "Variable a is equal to the value!",
    2 => "Variable is not equal to one!",
    default => "NONE WERE A MATCH"
};

echo $result;
