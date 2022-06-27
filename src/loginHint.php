<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
/** @var PDO $db */
unset($_SESSION['error']);
$email ="";


if($_REQUEST)
{
    if(isset($_REQUEST["login"])){
        $login = $_REQUEST["login"];
        $exist = checkIfAlreadyExists($login, $email, $db);
        if($exist["login"] == true)
            echo 'User with this login already exists!<br>';
    }
    if(isset($_REQUEST["email"]))
    {
        $email = $_REQUEST["email"];
        $login ="";
        $exist = checkIfAlreadyExists($login, $email, $db);
        if($exist["email"] == true)
            echo 'User with this email already exists!<br>';
    }
}

