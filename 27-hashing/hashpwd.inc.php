<?php

// this is general password hashing
$sensitiveData = "Violet";
$salt = bin2hex(random_bytes(16)); // Generate random salt
$pepper = "ASecretPepperString";

echo "<br>" . $salt;

$dataToHash = $sensitiveData . $salt . $pepper;
$hash = hash("sha256", $dataToHash);

echo "<br>" . $hash;


/*------*/

$sensitiveData = "Violet";
$storeSalt = $salt;
$storedHash = $hash;
$pepper = "ASecretPepperString";

$dataToHash = $sensitiveData . $storeSalt . $pepper;

$verificationHash = hash("sha256", $dataToHash);

if ($storedHash === $verificationHash) {
    echo "<br> The data are the same <br>";
    echo $storedHash;
    echo "<br>";
    echo $verificationHash;
} else {
    echo "<br> The data are not the same! <br>";
}
