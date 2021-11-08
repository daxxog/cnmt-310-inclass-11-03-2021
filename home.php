<?php
session_start();
$expected_in_session = ['user_is_logged_in', 'user_actual_name', 'user_auth_date'];
foreach($expected_in_session as $expected){
    if( (!isset($_SESSION[$expected])) || empty($_SESSION[$expected]) ) {
        die(header("Location: ./login.php"));
    }
}

if($_SESSION["user_is_logged_in"] !== true) {
    die(header("Location: ./login.php"));
}


require_once("./phpclasses-template/Template.php");

$page = new Template("Home");
$page->addHeadElement("<meta charset=\"utf-8\">");
$page->finalizeTopSection();
$page->finalizeBottomSection();


print $page->getTopSection();
print '<h1>Welcome, ' . $_SESSION["user_actual_name"] . '!</h1>';
print '<h2>You last authenticated on: <i>' . $_SESSION["user_auth_date"] . '</i></h2>';
print $page->getBottomSection();
?>
