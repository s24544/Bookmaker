<?php
require_once "../config/database.php";

function printSportForm() : void{
    echo '<form action="../src/addsport.php" method="post">
    Sport name: <input type="text" name="name" maxlength="50"><br>
    Sport logo (path): <input type="text" name="logo_path" maxlength="256"><br>
    <button type="submit">Submit</button>
</form>';
}

function printGameForm($db) : void{
    echo '<form action="../view/addgameform.php" method="post">
    <label for="game_datetime">
    Game date and time:
        <input type="datetime-local" name="game_datetime" step="1">
    </label><br>
    <label for="start_bet">
        Allow bets from: <input type="datetime-local" name="start_bet" step="1">
    </label><br>
    <label for="end_bet">
        Allow bets to: <input type="datetime-local" name="end_bet" step="1">
    </label><br>
    <label for="teams">';
    echo 'Sport: <select name="sport">'.getSports($db).'</select><br>';
    echo 'How many teams/players: <input type="number" name="number" min="1" step="1">
    </label><br>
    <button type="submit">Add game</button>
</form>
';
}

function addTeamToGameForm(){
    echo "Active games: ";
    try{
        
    }catch (PDOException $error){
        $_SESSION["status"] = $error->getMessage();
        header("Location: ../view/adminpanel.php");
    }
}

function printMoneyForm() : void{
    echo '<form action="../view/add.php" method="post">User login/email: <input type="text" name="search"><br><input type="submit" value="search"></form><br>';
}

function userList(string $search, PDO $db) : void
{
    try {
        $selectSql = "SELECT id, login, email, money FROM bk.accounts JOIN bk.account_profile ON account_profile.Profile_id=accounts.Profiles_Profile_id WHERE login LIKE :login OR email LIKE :email";
        $query = $db->prepare($selectSql);
        $query->bindValue(':login', "%$search%");
        $query->bindValue(':email', "%$search%");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
    if(count($result) == 0) {
        echo "No result";
        return;
    }

    echo "<table>
    <tr>
        <td>ID</td>
        <td>LOGIN</td>
        <td>EMAIL</td>
        <td>MONEY</td>
        <td>CHANGE</td>
    </tr>";

    foreach ($result as $user) {
        echo '<form action="../view/addmoneyform.php" id="list" method="post">';
        echo '<tr><td><input type="hidden" name="user[id]" value="' . $user["id"] . '">' . $user["id"] . '</td><td><input type="hidden" name="user[login]" value="' . $user["login"] . '">' . $user["login"] . '</td><td><input type="hidden" name="user[email]" value="' . $user["email"] . '">' . $user["email"] . '</td><td><input type="hidden" name="user[money]" value="' . $user["money"] . '">'.$user["money"].'</td><td><input type="submit" value="ADD" /></td></tr>';
        echo '</form>';
    }
    echo "</table>";
}

function getSports(PDO $db): string
{
    try {
        $selectSql = "SELECT id, name FROM bk.sports;";
        $query = $db->prepare($selectSql);
        $query->execute();
        $result = $query->fetchAll();
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
    $sports = '';
    foreach ($result as $sport) {
        $sports .= '<option value="' . $sport["id"] . '">' . $sport['name'] . '</option>';
    }
    return $sports;
}

function getTeams(int $sportId, PDO $db){
    try{
        $selectSql = "SELECT teams.id, teams.name FROM teams JOIN sports ON teams.sports_id=sports.id WHERE sports.id=:id";
        $query = $db->prepare($selectSql);
        $query->bindValue(":id", $sportId);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $error) {
        echo $error->getMessage();
        die();
    }
}

function printteamForm(PDO $db) : void{
    $sports = getSports($db);

    echo '<form action="../src/addteam.php" method="post"><label for="team_name">
Sport: <select name="sport_name" id="">'.$sports.'</select><br>
Team name: <input type="text" name="team" id=""></label><br>
<label for="logo_path">Logo path: <input type="text" name="logo_path"></label><br>
<button type="submit">ADD</button></form>';
}

function printWinnerForm(PDO $db) {
    try{
        $selectSql = 'SELECT Gt_id, Teams_id, odd, game_result, teams.name as teamname, games.game_datetime, sports.name as sportname FROM games RIGHT JOIN game_teams ON games.game_id=game_teams.Games_game_id LEFT JOIN teams ON teams.id=game_teams.Teams_id 
                        LEFT JOIN sports ON sports.id=teams.sports_id
                        WHERE game_teams.status IS NULL AND game_datetime IS NOT NULL';
        $query = $db->prepare($selectSql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $error){
        echo $error->getMessage();
        die();
    }
    $form = "";
    foreach ($result as $bet){
        $form .= '<form action="../src/setwinner.php" method="post">';
        $form .= '<input type="hidden" name="Gt_id" value="'.$bet["Gt_id"].'">';
        if($bet["sportname"] != "")
            $form .= "Sport: ".$bet["sportname"]."<br>";
        $form .= 'Game datetime: '.$bet["game_datetime"]."<br>";
        if($bet["sportname"] == "Tennis" || $bet["sportname"] == "Golf" || $bet["sportname"] == "Boxing" || $bet["sportname"] == "Swimming")
            $form .= 'Player: '.$bet["teamname"]."<br>";
        else
            if ($bet["game_result"] != "draw" && $bet["game_result"] != "remis")
                $form .= 'Team: ' . $bet["teamname"] . "<br>";

        $form .= 'Game result: '.$bet["game_result"]."<br>";
        $form .= "Set status: ";
        $form .= '<select name="status" id="">';
        $form .= '<option value="0">False</option>';
        $form .= '<option value="1">True</option>';
        $form .= '</select><br>';
        $form .= '<button type="submit">Save</button>';
        $form .= '</form>';
        $form .= '<br>';
    }

    echo $form;
}

function addTeamToGame(int $gameId, int $teamId, float $odd, string $game_result, PDO $db){
    try {
        $insertGtSql = "INSERT INTO game_teams(Games_game_id, Teams_id, odd, game_result) VALUES (:lid, :tid, :odd, :gr)";
        $query = $db->prepare($insertGtSql);
        $query->bindValue(":lid", $gameId);
        $query->bindValue(":tid", $teamId);
        $query->bindValue(":odd", $odd);
        $query->bindValue(":gr", $game_result);
        $query->execute();
    }catch (PDOException $error){
        echo $error->getMessage();
        die();
    }
}



?>
