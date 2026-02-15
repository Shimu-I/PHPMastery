<?php

$pwdSignup = "Violet";

// two common hashing method or hashing algorithm
// PASSWORD_DEFAULT --  automaticaly gets updated in the future
// PASSWORD_BCRYPT -- used under PASSWORD_DEFAULT

$options = [
    'cost' => 12
];

$hashedPwd = password_hash($pwdSignup, PASSWORD_BCRYPT, $options);


$pwdLogin = "Violet";

if (password_verify($pwdLogin, $hashedPwd)) {
    echo "They are the same!";
} else {
    echo "They are no the same!";
}
