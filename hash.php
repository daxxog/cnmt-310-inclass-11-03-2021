<?php

// the constants are considered good against an "NSA sized" attacker
$PBKDF2_SALT_LENGTH = 16;
$PBKDF2_ITERATIONS = 2000;
$PBKDF2_HASH_FUNCTION = "sha512"; // FIPS-compatible

$password_plain = "solarwinds123";
$salt = openssl_random_pseudo_bytes($PBKDF2_SALT_LENGTH);
$password_hash = hash_pbkdf2("sha512", $password_plain, $salt, $PBKDF2_ITERATIONS, $length = 0, $binary = false);
$password_fmt = "pbkdf2.".$PBKDF2_ITERATIONS.".".$PBKDF2_HASH_FUNCTION.".".base64_encode($salt).".".$password_hash;
header('Content-Type: application/json; charset=utf-8');
print('{"pbkdf2_hash_function": "'.$PBKDF2_HASH_FUNCTION.
    '", "pbkdf2_iterations": '.$PBKDF2_ITERATIONS.
     ', "salt_base64":"'.base64_encode($salt).
    '", "password_plain_base64": "'.base64_encode($password_plain).
    '", "password_hash": "'.$password_hash.
    '", "password_fmt":  "'.$password_fmt.'"}');
?>
