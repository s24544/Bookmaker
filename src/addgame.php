<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
require_once '../src/addFormHandler.php';
if($_SESSION['logged'] != true || !isset($_SESSION['logged']))
    header("Location: login.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);

if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");

if(!isset($_POST['game_datetime']) || !isset($_POST['start_bet']) || !isset($_POST["end_bet"]) || !isset($_POST["team"]) || !isset($_POST["odd"]))
    header("Location: ../view/adminpanel.php");

try{
    $insertGameSql = "INSERT INTO games(game_datetime, start_bet, end_bet, added_by_account_id) VALUES (:gdt, :sb, :eb, :uid)";
    $query = $db->prepare($insertGameSql);
    $query->bindValue(":gdt", $_POST["game_datetime"]);
    $query->bindValue(":sb", $_POST["start_bet"]);
    $query->bindValue(":eb", $_POST["end_bet"]);
    $query->bindValue(":uid", $user->getId());
    $query->execute();
    $lastId = $db->lastInsertId();
    var_dump($_POST);
    for($i=0;$i<count($_POST["odd"]);$i++)
        addTeamToGame($lastId, $_POST["team"][$i], $_POST["odd"][$i], "win", $db);


    $_SESSION["status"] = "Game added!";
    header("Location: ../view/adminpanel.php");
}catch (PDOException $error){
    echo $error->getMessage();
    die();
}
