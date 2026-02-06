<?php

$string = "Hello World!";

echo "01--The length of the string is: " . strlen($string) . "<br>";

echo "02--Single letter position: " . strpos($string, "o") . "<br>";

echo "03--Single letter position: " . strpos($string, "Wo") . "<br>";

echo "04--Replaced word(old_word, new_word, string): " . str_replace("World!", "Shimu", $string) . "<br>";

echo "05--Transform into lowercase: " . strtolower($string) . "<br>";

echo "06--Transform into UPPERCASE: " . strtoupper($string) . "<br>";

echo "07--Extracting a portion of a string(string, start, length): " . substr($string, 2, 2) . "<br>";

echo "08--Extracting a portion of a string forward and backword(string, start, length): " . substr($string, 2, -2) . "<br>";

echo "09--Splits a string into an array based on delimiter: ";
print_r(explode(" ", $string));
echo "<br>";

$number = -5.5;
echo "10--Absolute value: " . abs($number) . "<br>";

echo "11--Round value: " . round($number) . "<br>";

echo "12--Exponential value: " . pow(2, 3) . "<br>";

echo "13--Square root value: " . sqrt(16) . "<br>";

echo "14--Random value(start, end): " . rand(1, 100) . "<br>";

$array1 = ["apple", "banana", "orange"];
$array2 = ["watermeton", "dragon fruit"];

echo "15--Number of data in an array: " . count($array1) . "<br>";

echo "16--Is this an array: " . is_array($array1) . "<br>";

echo "17--Add new data in the array(array, new_word): ";
array_push($array1, "kiwi");
print_r($array1);

echo "<br>";

echo "18--Remove last data form array:";
array_pop($array1);
print_r($array1);

echo "<br>";

echo "19--Reverse the arrary: ";
print_r(array_reverse($array1));

echo "<br>";

echo "20--Merge two array(old_array, new_array): ";
print_r(array_merge($array1, $array2));

echo "<br>";

$a = ["a", "b", "c", "d", "e"];
echo "21--Remove a portion of an array and can optionally replace it with new element(array, start, length-to-remove, replacement-word(optional) ):";
array_splice($a, 1, 2, "z");
print_r($a);

echo "<br>";

echo "22--Show date format: " . date("Y-m-d H:i:s") . "<br>";

echo "23--Show time - time function: " . time() . "<br>";

$date = "2026-04-11 12:00:00";
echo "24--Conver date to time: " . strtotime($date);
