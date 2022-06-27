<?php


require_once "AuthenticatedAccount.php";
require_once 'functions.php';
unset($_SESSION['error']);

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    header("Location: ../view/app.php");



if($_POST['login'] != "" && $_POST['password'] != "")
{
    $login = filter_input(INPUT_POST, 'login');
    $password = filter_input(INPUT_POST, 'password');
    $user = new AuthenticatedAccount();
    $user->setLogin($login);
    $user->setPassword($password);


    /** @var PDO $db from database.php **/
    if($user->authAccount($user->getLogin(), $user->getPassword(), $db)) {
        $user->setData($db);
        $_SESSION['user'] = serialize($user);
        $_SESSION['logged'] = true;
        header('Location: ../view/app.php');
    }
    else {
        $_SESSION['error'] = "Wrong login and/or password!";
        header("Location: ../view/login.php");
    }
}
else
{
    unset($_SESSION['error']);
    header("Location: ../view/login.php");
}
