<?php
require_once 'AuthenticatedAccount.php';
if(!isset($_SESSION["Gt_id"]) || !isset($_SESSION["pay"]) || $_SESSION["pay"] != true)
{
    $_SESSION["status"] = "ERROR";
    header("Location: ../view/adminpanel.php");
    die();
}


try{
    $selectTeam = "SELECT game_teams.Gt_id, teams.name FROM game_teams JOIN teams ON teams.id=game_teams.Teams_id JOIN sports ON sports.id=teams.sports_id WHERE Gt_id=:gtid";
    $q = $db->prepare($selectTeam);
    $q->bindValue(":gtid", $_SESSION["Gt_id"]);
    $q->execute();
    $result = $q->fetchAll(PDO::FETCH_ASSOC);
    if($result[0]["name"] != "")
        $team = $result[0]["name"];
    else
        $team = "Draw";

    $selectWinnersSql = "SELECT accounts.email, accounts.Profiles_Profile_id, transactions.money, odd, game_teams.status FROM transactions JOIN bets ON bets.id=transactions.Bets_id JOIN game_teams ON bets.gt_id=game_teams.Gt_id
JOIN accounts ON accounts.id=transactions.Accounts_id
JOIN account_profile ON account_profile.Profile_id=accounts.Profiles_Profile_id
WHERE game_teams.status IS NOT NULL AND game_teams.gt_id=:gid";
    $query = $db->prepare($selectWinnersSql);
    $query->bindValue(":gid", $_SESSION["Gt_id"]);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $betUser){
        if($betUser["status"] == 1) {
            $updateMoneySql = "UPDATE account_profile SET money=money+:money WHERE Profile_id=:pid";
            $query = $db->prepare($updateMoneySql);
            $query->bindValue(":money", round($betUser["odd"] * $betUser["money"], 2));
            $query->bindValue(":pid", $betUser["Profiles_Profile_id"]);
            if ($query->execute()) {
                mail($betUser["email"], "Bet won", "Hey! You have won the bet which you placed $".$betUser["money"]."on: ".$team." ".$betUser[""].". You won: ".round($betUser["odd"]*$betUser["money"], 2).". "." <a href='../view/mybets.php'>Click here for more info</a>");
            }
        }
        else{
            mail($betUser["email"], "Bet lost", "Hey! You have lost the bet which you placed $".$betUser["money"]." on ".$team." "." <a href='../view/mybets.php'>Click here for more info</a>");
        }
    }
    unset($_SESSION["pay"]);
    unset($_SESSION["Gt_id"]);
    $_SESSION["status"] = "Winners set!";
}catch (PDOException $error){
    echo $error->getMessage();
    die();
}
header("Location: ../view/adminpanel.php");