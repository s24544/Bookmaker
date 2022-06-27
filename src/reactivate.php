<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
/** @var PDO $db */
//check if acc activated
//check if last code still ok, if yes then send email with it
//if code expired then update update_date and update new code, update expire date

/* 1. Check if account already activated
 * 2. Check if last code is at least 15 minutes old, if yes then update code and send new link, if not echo that please wait 15 minutes before getting new activation code
 *
 */
@session_start();
if(isUserLoggedIn())
    header('Location: app.php');

$email = $_GET['email'];
$now = strtotime(date("Y-m-d H:i:s"));

if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
    echo "Wrong email! Please contact administrator for more information! Email: email@localhost.org";
    exit();
}

if(checkIfUserActivatedByEmail($email, $db))
    errorRedirector('User with this email is already active!', 'Location: index.php');

//TODO: Reaktywacja konta jakby kod wygasl a uzytkownik
//check if account already active
//check if last code is at least 15 minutes old, if yes then update link, if not echo to wait 15 minutes
