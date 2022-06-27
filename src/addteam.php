<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
$user = unserialize($_SESSION['user'], array(true));
if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");
if(!isset($_POST['sport_name']) || !isset($_POST["team"]))
    header("Location: ../view/adminpanel.php");

try{
    if($_POST["logo_path"] != "")
        $insertSql = "INSERT INTO teams(sports_id, name, logo_path) VALUES (:sid, :name, :lp)";
    else
        $insertSql = "INSERT INTO teams(sports_id, name) VALUES (:sid, :name)";
    
    $query = $db->prepare($insertSql);
    $query->bindValue(":sid", $_POST["sport_name"]);
    $query->bindValue(":name", $_POST["team"]);
    if($_POST["logo_path"] != "")
        $query->bindValue(":lp", $_POST["logo_path"]);
    $query->execute();
    $_SESSION["status"] = "Team added!";
    header("Location: ../view/adminpanel.php");
}catch (PDOException $error){
    echo $error->getMessage();
    die();
}