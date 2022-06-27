<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\AuthenticatedAccount.php';
$user = unserialize($_SESSION['user'], array(true));
if (!isset($user->getProfile()['admin']) || $user->getProfile()['admin'] != true)
    header("Location: index.php");
if(!isset($_POST['user']) || count($_POST["user"]) != 4 || !isset($_POST["money"]))
    header("Location: ../view/adminpanel.php");

$userFromList = $_POST["user"];

try{
    $selectSql = "SELECT Profiles_profile_id FROM accounts WHERE id=:id";
    $query = $db->prepare($selectSql);
    $query->bindValue(":id", $userFromList["id"]);
    $query->execute();
    $Profiles_profile_id = $query->fetchAll(PDO::FETCH_ASSOC);

    $updateSql = "UPDATE account_profile SET money=:money WHERE Profile_id=:pid";
    $query = $db->prepare($updateSql);
    $query->bindValue(":pid", $Profiles_profile_id[0]["Profiles_profile_id"]);
    $query->bindValue(":money", $userFromList["money"]+$_POST["money"]);
    $query->execute();
    $_SESSION["status"] = "Money added!";
    header("Location: ../view/adminpanel.php");
}catch (PDOException $error){
    echo $error->getMessage();
}


