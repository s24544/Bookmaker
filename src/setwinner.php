<?php

require_once 'AuthenticatedAccount.php';


if(!isset($_POST["Gt_id"]) || !isset($_POST["status"]) || !is_numeric($_POST["Gt_id"]) || !is_numeric($_POST["status"])) {
    $_SESSION["status"] = "ERROR";
    header("Location: ../view/adminpanel.php");
}

try{
    $updateSql = "UPDATE game_teams SET status=:status WHERE Gt_id=:gtid";
    $query = $db->prepare($updateSql);
    $query->bindValue(":status", $_POST["status"]);
    $query->bindValue(":gtid", $_POST["Gt_id"]);
    $query->execute();
    $_SESSION["Gt_id"] = $_POST["Gt_id"];
    $_SESSION["pay"] = true;
    header("Location: pay.php");
}catch (PDOException $error){
    echo $error->getMessage();
    die();
}
