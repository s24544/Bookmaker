<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
$user = unserialize($_SESSION['user'], array(true));
if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");
if(!isset($_POST['name']))
    header("Location: ../view/adminpanel.php");

try{
    if($_POST["logo_path"] != "")
        $insertSql = "INSERT INTO sports(name, logo_path) VALUES (:name, :logo_path)";
    else
        $insertSql = "INSERT INTO sports(name) VALUES (:name)";
    $query = $db->prepare($insertSql);
    $query->bindValue(":name", $_POST["name"]);
    if($_POST["logo_path"] != "")
        $query->bindValue("logo_path", $_POST["logo_path"]);
    $query->execute();
    $_SESSION["status"] = "Sport added!";
    header("Location: ../view/adminpanel.php");
}catch (PDOException $error){
    $_SESSION["status"] = $error->getMessage();
    header("Location: ../view/adminpanel.php");
}