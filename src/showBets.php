<?php
require_once "../config/database.php";

/* @var PDO $db */
function getActiveTeamsBets(PDO $db): array|string
{
    try {
        $selectSql = "SELECT game_id, game_datetime, start_bet, end_bet, teams.name as first_team, game_teams.odd as first_odd, sports.name as sport_name FROM games JOIN game_teams ON game_teams.Games_game_id=games.game_id JOIN teams ON teams.id=game_teams.Teams_id JOIN sports ON sports.id=teams.sports_id WHERE NOW() > bk.games.start_bet AND NOW() < bk.games.end_bet AND sports.name NOT LIKE 'Golf' AND sports.name NOT LIKE 'Swimming' AND sports.name NOT LIKE 'Horse racing'";
        $send = $db->prepare($selectSql);
        $send->execute();
        $bets = $send->fetchAll(PDO::FETCH_ASSOC);

    }catch (PDOException $error){
        return $error->getMessage();
    }
    $result = [];
    for($i=0;$i<count($bets);$i+=2){
        $bets[$i]["second_team"] = $bets[$i+1]["first_team"];
        $bets[$i]["second_odd"] = $bets[$i+1]["first_odd"];
        $result[] = $bets[$i];
    }
    return $result;
}

function printActiveTeamsBets(array $bets){
    foreach ($bets as $bet){
        echo $bet["sport_name"]."<br>";
        echo "Game date: ".$bet["game_datetime"]."<br>";
        echo '<form action="../view/placebetform.php" method="post">';
        echo '<input type="hidden" name="game_id" value="'.$bet["game_id"].'">';
        echo '<input type="hidden" name="game_datetime" value="'.$bet["game_datetime"].'">';
        echo '<input type="hidden" name="first_team" value="'.$bet["first_team"].'">';
        echo '<input type="hidden" name="second_team" value="'.$bet["second_team"].'">';
        echo '<input type="hidden" name="first_odd" value="'.$bet["first_odd"].'">';
        echo '<input type="hidden" name="second_odd" value="'.$bet["second_odd"].'">';
        echo $bet["first_team"]." vs. ".$bet["second_team"]."<br>";
        echo "Odds: [".$bet["first_odd"]."]:[".$bet["second_odd"]."]<br>";
        echo "Bet active to: ".$bet["end_bet"]."<br>";
        echo "<button>PLACE BET</button>";
        echo '</form>';
        echo "<br>";
    }
}

function getActiveSportBets(int $sportId, PDO $db): array|string
{
    {
        try {
            $selectSql = "SELECT game_id, game_datetime, start_bet, end_bet, teams.name as first_team, game_teams.odd as first_odd, sports.name as sport_name FROM games JOIN game_teams ON game_teams.Games_game_id=games.game_id JOIN teams ON teams.id=game_teams.Teams_id JOIN sports ON sports.id=teams.sports_id WHERE NOW() > bk.games.start_bet AND NOW() < bk.games.end_bet AND sports.id=:id";
            $send = $db->prepare($selectSql);
            $send->bindValue(":id", $sportId);
            $send->execute();
            $bets = $send->fetchAll(PDO::FETCH_ASSOC);

        }catch (PDOException $error){
            return $error->getMessage();
        }
        $result = array();
        for($i=0;$i<count($bets);$i+=2){
            $bets[$i]["second_team"] = $bets[$i+1]["first_team"];
            $bets[$i]["second_odd"] = $bets[$i+1]["first_odd"];
            $result[] = $bets[$i];
        }
        return $result;
    }
}


function printActiveNonteamsBets(array $bets){
    foreach ($bets as $bet){
        echo $bet["sport_name"]."<br>";
        echo "Game date: ".$bet["game_datetime"]."<br>";
        echo "Bet active to: ".$bet["end_bet"]."<br><br>";
    }
}


function getSports(PDO $db): string
{
    try {
        $selectSql = "SELECT id, name FROM bk.sports;";
        $query = $db->prepare($selectSql);
        $query->execute();
        $result = $query->fetchAll();
    } catch (PDOException $error) {
        return $error->getMessage();
    }
    $sports = '';
    foreach ($result as $sport) {
        $sports .= '<option value="' . $sport["id"] . '">' . $sport['name'] . '</option>';
    }
    return $sports;
}

function printSportSelect(PDO $db) : void{
    $sports = getSports($db);

    echo '<form action="app.php" method="post"><label for="sport">
Sport: <select name="id" id="">'.$sports.'</select><br>
<button type="submit">Search</button><br></label></form>';
}

function getGameInfo(int $gameId, PDO $db){
    $result = [];
    try{
        $selectSql = "SELECT Gt_id, Teams_id, odd, game_result FROM game_teams JOIN games ON games.game_id=game_teams.Games_game_id WHERE Games_game_id=:id";
        $query = $db->prepare($selectSql);
        $query->bindValue(":id", $gameId);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $error){
        return $error->getMessage();
    }
    return $result;
}

function getTeamName(int $teamId, PDO $db)
{
    try{
        $selectSql = "SELECT name FROM bk.teams WHERE id=:id";
        $query = $db->prepare($selectSql);
        $query->bindValue(":id", $teamId);
        $query->execute();
        return $query->fetch(PDO::PARAM_STR);
    }catch (PDOException $error){
        return $error->getMessage();
    }
}

function getBetInfo(int $Gt_id, PDO $db){
    try{
        $selectSql = "SELECT Teams_id, odd, game_result FROM bk.game_teams WHERE Gt_id=:id";
        $query = $db->prepare($selectSql);
        $query->bindValue(":id", $Gt_id);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch (PDOException $error){
        return $error->getMessage();
    }
}

function getUserBets(int $userId, PDO $db)
{

    try{
        $selectSql = "SELECT accounts.id as account_id, transactions.Bets_id as bet_id, transactions.money as bet_money,  bets.bet_place_date as datetime, game_teams.odd as odd,game_teams.game_result as game_result, game_teams.status as game_status, game_teams.Teams_id FROM accounts JOIN transactions ON transactions.Accounts_id=accounts.id JOIN bets ON bets.id=transactions.Bets_id JOIN game_teams ON game_teams.Gt_id=bets.gt_id WHERE accounts.id=:id";
        $query = $db->prepare($selectSql);
        $query->bindValue(":id", $userId);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) < 1)
            $result[] = "You haven't bet yet! Would you like to bet? Click <a href='../view/app.php'>here</a>";
        return $result;
    }catch (PDOException $error){
        exit($error);
    }
}