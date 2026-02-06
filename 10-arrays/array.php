<?php

// two ways to write array
// 1st way
// $fruits = array('apple', 'banana', 'cherry');
// 2nd way
// $flowers = ['lily', 'rose', 'lotus'];


$flowers = [
    'lily', //0
    'rose', //1
    'lotus' //2
];

echo "01--Flower array[0]: " . $flowers[0] . "<br>";

echo "02--(print_r) with index array: ";
print_r($flowers); // print with index number pointing

echo "<br>";

echo "03--(array_push) adding value: ";
array_push($flowers, "Daisy"); // same as adding value -- only works for index array
print_r($flowers);

echo "<br>";

$flowers[] = 'lavender'; // to add at the end of the array
$flowers[1] = 'sun flower'; // to replace the specific index

unset($flowers[2]); // to delete the value of that index leaves a hole
echo "04--(unset(flower[2])): ";
print_r($flowers);

echo "<br>";

// Removing element - remove the very first element - the element which was at 1 now at 0 index - reindexed
array_splice($flowers, 0, 1);
echo "05--(array_splice(flower, 0, 1)): ";
print_r($flowers);

echo "<br>";

$fruits = array(
    'apple',
    'orange',
    'banana',
    'watermelon'
);

$tests = array(
    'test1',
    'test2'
);

// Inserting Element (with out removing) - insert mango in the 2nd position
array_splice($fruits, 1, 0, "Mango");
echo "06--(array_splice(fruits, 1, 0, mango): ";
print_r($fruits);

echo "<br>";

array_splice($fruits, 3, 0, $tests); // merge new array
echo "07--(array_splice(fruits, 1, 0, tests) merging new array: ";
print_r($fruits);

echo "<br>";

//....... associate array using keys instade of numbers....... 
// create string and pointing towards a value in order to create key key => value
$tasks = [
    "laundry" => "Daniel",
    "trush" => "Frida",
    "vacuum" => "Basse",
    "dishes" => "Bella",
];

echo "08--Tasks associate array: " . $tasks['laundry'];

echo "<br>";

echo "09--Tasks array with key and value: ";
print_r($tasks);

echo "<br>";

// array functions

echo "10--How many element in the array: " . count($tasks);
$tasks["dusting"] = "Tara"; // adding element at the end in assciate array

echo "11--Adding new key with value: ";
print_r($tasks);

echo "<br>";

sort($tasks);
echo "12--Sort alpha order tasks array: ";
print_r($tasks); // after sorting gives index array not associat array

echo "<br>";


//....... multidimentional array....... 

$foods = [
    array("apple", "mango"),
    "banaan",
    "cherry"
];

echo "13--foods[0][0] result: " . $foods[0][0];

echo "<br>";

$foods1 = [
    "fruits" => array("apple", "banana", "cherry"),
    "meat" => array("chicken", "fish"),
    "vegetables" => array("cucumber", "carrot")
];

echo "14--foods1['vegetables'][0] result: " . $foods1["vegetables"][0];
