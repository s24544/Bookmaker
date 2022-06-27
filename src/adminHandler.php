<?php
require_once "AuthenticatedAccount.php";
$user=unserialize($_SESSION['user'], array(true));
if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");

switch ($_POST[0]){
    case "sport":
        header("Location: ../view/addsportform.php");
        break;
    case "team":
        header("Location: ../view/addteamform.php");
        break;
    case "money":
        header("Location: ../view/addmoneyform.php");
        break;
    case "game":
        header("Location: ../view/addgameform.php");
        break;
    case "winner":
        header("Location: ../view/addwinnerform.php");
        break;
}