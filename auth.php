<?php
$required_elements = ['username', 'password'];
foreach($required_elements as $element){
    if( (!isset($_POST[$element])) || empty($_POST[$element]) ) {
        http_response_code(404);
            // copied response body from another 404 page on the server
            print '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">' ;
            print '<html><head>' ;
            print '<title>404 Not Found</title>' ;
            print '</head><body>' ;
            print '<h1>Not Found</h1>' ;
            print '<p>The requested URL was not found on this server.</p>' ;
            print '<hr>' ;
            print '<address>Apache/2.4.41 (Ubuntu) Server at cnmtsrv2.uwsp.edu Port 443</address>' ;
            print '</body></html>' ;
        die();
    }
}


// disable warnings
error_reporting(E_ALL ^ E_WARNING);

// secret hardcoded credentials
$expected_username = 'admin';
$secret = "pbkdf2.2000.sha512.ZCoCEVgb54sb4xFGqJO/rA==.254371ea0925b3a67d4d7bb81c85b0b793ccbe1195b4f513b29e90e8efb23da7d044201a10c69d8e4f539d4b40521f743e0829d00956e002b4534d50a10bceb0";


function do_die() {
    die(header("Location: ./login.php"));
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


$username_good = hash_equals('admin', $_POST['username']);
$password_good = pbkdf2_verify_password($secret, $_POST['password']);

if($username_good && $password_good) {
    session_start();
    $_SESSION["user_is_logged_in"] = true;
    $_SESSION["user_actual_name"] = 'Brittni Drakes';
    $_SESSION["user_auth_date"] = date(DATE_RFC2822);
    die(header("Location: ./home.php"));
} else {
    do_die();
}
?>
