<?php
require_once "User.php";
require_once 'functions.php';

if(isset($_SESSION['logged']))
{
    if($_SESSION['logged'] == true)
        header("Location: main.php");
    else
        header("Location: index.php");
}


if($_POST['login']!="" || $_POST['password']!="")
{
    $user = new User();
    $login = filter_input(INPUT_POST, 'login', FILTER_DEFAULT);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $user->setLogin($login);
    $user->setPassword($password);
    /**
     * @var User $_SESSION['user']  unserialize($_SESSION['user], array(true)) to read*
     */
    $_SESSION['user'] = serialize($user);


    /** @var PDO $db from database.php **/
    if($user->logIntoSite($login, $password, $db))
    {
        if(checkIfUserActivatedByLogin($login, $db))
        {
            $_SESSION['logged'] = true;
            header('Location: main.php');
        }
        else{
            $_SESSION['logged'] = false;
            errorRedirector('Account is not activated', 'Location: reactivate.php');
        }
    }
    else
        errorRedirector('Wrong login and/or password!', 'Location: index.php');
}
else
{
    unset($_SESSION['error']);
    header("Location: index.php");
}
