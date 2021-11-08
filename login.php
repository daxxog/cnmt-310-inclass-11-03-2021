<?php
// disable warnings
error_reporting(E_ALL ^ E_WARNING);
header('Content-Type: text/plain; charset=utf-8');
$secret = "pbkdf2.2000.sha512.ZCoCEVgb54sb4xFGqJO/rA==.254371ea0925b3a67d4d7bb81c85b0b793ccbe1195b4f513b29e90e8efb23da7d044201a10c69d8e4f539d4b40521f743e0829d00956e002b4534d50a10bceb0";

function do_die() {
    die('{"error": 100}');
}

function pbkdf2_verify_password($secret, $password_plain) {
    $secrets = explode('.', $secret);
    if($secrets[0] !== "pbkdf2") {
        do_die();
    }
    $salt = base64_decode($secrets[3], $strict = true);
    if($salt === false) {
        do_die();
    }
    $iterations = intval($secrets[1]);
    if($iterations < 1) {
        do_die();
    }
    $algorithm = $secrets[2];
    $actual_hash = $secrets[4];
    $check_hash = hash_pbkdf2("sha512", $password_plain, $salt, $iterations, $length = 0, $binary = false);

    return hash_equals($actual_hash, $check_hash);
}

var_dump(pbkdf2_verify_password($secret, "solarwinds123"))
?>
