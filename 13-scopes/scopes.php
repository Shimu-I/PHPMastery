<?php

// there are 4 different type of scopes

// global -- outside of funciton or class
// local -- inside of function
// static -- get when create a static function
// class -- inside of class

// global variable can be access form local function not recommended unless you really have a reson for this

$test = "Shimu";

function myFunction()
{
    global $test;

    // Define a local variable
    $localVar = "Hello, world!";

    // Use the local variable
    return $test;
}

echo "This is the return value for myFunction: " . myFunction() . "<br>";


// with super global
$test2 = "Shimu";

function myFunction2()
{
    // Define a local variable
    $localVar = "Hello, world!";

    // Use the local variable
    return $GLOBALS["test2"];
}

echo "This is the return value for myFunction2: " . myFunction2() . "<br>";



// with out static variable 

function myFunction3()
{
    // Declare a static variable
    $staticVar = 0;

    // Increment the static variable
    $staticVar++;

    // Use the static variable
    return $staticVar;
}

echo "First time without static: " . myFunction3() . "<br>"; // 1
echo "Second time without static: " . myFunction3() . "<br>"; // 1
echo "Third time without static: " . myFunction3() . "<br>"; // 1


// with static variable 

function myFunction4()
{
    // Declare a static variable
    static $staticVar = 0;

    // Increment the static variable
    $staticVar++;

    // Use the static variable
    return $staticVar;
}

echo "First time with static: " . myFunction4() . "<br>"; // 1
echo "Second time with static: " . myFunction4() . "<br>"; // 2
echo "Third time with static: " . myFunction4() . "<br>"; // 3


// class scope (for now skip this, we will study this later)

class MyClass
{
    // Define a class variable
    static public $classVar = "Hello, world!";

    // Define a class method
    public function myMethod()
    {
        // Use the class variable
        echo $this->classVar; // Output: Hello, world!
    }
}

echo "MyClass output: " .  MyClass::$classVar;
