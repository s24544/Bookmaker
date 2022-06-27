<?php
require_once '..\src\AuthenticatedAccount.php';
if(!isset($_SESSION['logged']) || $_SESSION['logged'] != true)
    header("Location: ../view/index.php");
$user = unserialize($_SESSION['user'], array(true));
$user->setData($db);
//if(!isset($_POST["Gt_id"]) || !isset($_POST["money"]) || $_POST["money"] <= 0 || $_POST["money"] > $user->getMoney($db)){
//    header("Location: ../view/index.php");
//}

try{
    $insertBetSql = "INSERT INTO bk.bets (gt_id, bet_place_date) VALUES (:gtid, NOW())";
    $insertTransactionSql = "INSERT INTO bk.transactions (Accounts_id, Bets_id, money) VALUES (:accid, :betid, :money)";
    $updateAccountWalletSql = "UPDATE bk.account_profile SET money=:m WHERE Profile_id=:pid";
    $query = $db->prepare($insertBetSql);
    $query->bindValue(":gtid", $_POST["Gt_id"]);
    $query->execute();
    $lastId = $db->lastInsertId();

    $query = $db->prepare($insertTransactionSql);
    $query->bindValue(":accid", $user->getId());
    $query->bindValue(":betid", $lastId);
    $query->bindValue(":money", $_POST["money"]);
    $query->execute();

    $query = $db->prepare($updateAccountWalletSql);
    $query->bindValue(":pid", $user->getProfile()["Profile_id"]);
    $query->bindValue(":m", $user->getMoney($db)-$_POST["money"]);
    $query->execute();

}catch (PDOException $error){
    echo $error->getMessage();
    die();
}
$_SESSION["bet"] = "Bet placed!";
header("Location: ../view/app.php");

