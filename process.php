<?php
$name = $_POST["name"];
$email = $_POST["email"];
$details = $_POST["details"];

echo "<pre>";
$email_body = "";
$email_body .= "Name: " . $name . "\n"; //Line Breaks 
$email_body .= "Email: " . $email. "\n";
$email_body .= "Details: " . $details. "\n";
echo $email_body;
echo "</pre>";// .= tells code to keep everything in the variable and add the following info to the end of that value

//To DO: Send Email
header("Location:thanks.php"); //redirect to another php file
