<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
/** @var PDO $db */
//check if acc activated
//check if last code still ok, if yes then send email with it
//if code expired then update last code and send new
session_start();
if(isUserLoggedIn())
    header('Location: main.php');

$email = $_GET['email'];
$now = strtotime(date("Y-m-d H:i:s"));

if(isUserLoggedIn())
    header('Location: main.php');

if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
    echo "Wrong email! Please contact administrator for more information! Email: email@localhost.org";
    exit();
}

if(checkIfUserActivatedByEmail($email, $db))
    errorRedirector('Account with this email is already active!', 'Location: index.php');
