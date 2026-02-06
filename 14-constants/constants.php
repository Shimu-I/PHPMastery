<?php

// can be write with small letters but capital letters are recommended

// define constant at the top of your script

define("PI", 3.14);
echo "Constant value: " . PI . "<br>";

define("NAME", "shimu");
echo "Constant value: " . NAME . "<br>";

define("IS_ADMIN", true);
echo "Constant value: " . IS_ADMIN . "<br>";

function test()
{
    echo PI;
}

test();
