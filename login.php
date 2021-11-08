<?php
require_once("./phpclasses-template/Template.php");

$page = new Template("Login");
$page->addHeadElement("<meta charset=\"utf-8\">");
$page->finalizeTopSection();
$page->finalizeBottomSection();


print $page->getTopSection();
print "<form action=\"./auth.php\" method=\"POST\">\n";

# Username:
print "\t<p>\n";
print "\t\t<label for=\"username\">Username:</label><br>\n";
print "\t\t<input type=\"text\" id=\"username\" name=\"username\"><br>\n";
print "\t</p>\n";

# Password:
print "\t<p>\n";
print "\t\t<label for=\"password\">Password:</label><br>\n";
print "\t\t<input type=\"password\" id=\"password\" name=\"password\"><br>\n";
print "\t</p>\n";

print "\t<button type=\"submit\" value=\"register\">Login</button> <br>\n";
print "</form>\n";
print $page->getBottomSection();
?>
