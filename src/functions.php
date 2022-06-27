<?php
/** Only functions definitions */

/** @var PDO $db */


/** @param string $errorDetails session error string
 * @param string $header full header, typicaly redirect to register
 * @return void redirect to header signup.php and set session['error']
 */
function errorRedirector(string $errorDetails, string $header = 'Location: ../view/signup.php') : void
{
    $_SESSION['error'] = $errorDetails;
    header($header);
}

/** @return bool true if user logged in */
function isUserLoggedIn() : bool
{
    return (isset($_SESSION['logged']) && $_SESSION['logged'] == true);
}


/**
 * @param string $login user login
 * @param string $email user email
 * @param PDO $db db
 * @return array if result[0] == true then login is in database, if [1] true then email...
 */

function checkIfAlreadyExists(string $login, string $email, PDO $db) : array
{
    $arrResult = array();
    $arrResult[0] = false;
    $arrResult[1] = false;
    try {
        $selectLogin = "SELECT id FROM bk.accounts WHERE login=:login;";
        $selectEmail = "SELECT id FROM bk.accounts WHERE email=:email;";
        $loginQuery = $db->prepare($selectLogin);
        $emailQuery = $db->prepare($selectEmail);
        $loginQuery->bindValue(':login', $login, PDO::PARAM_STR);
        $emailQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $loginQuery->execute();
        $emailQuery->execute();
        $loginResult = $loginQuery->fetchAll(PDO::FETCH_ASSOC);
        $emailResult = $emailQuery->fetchAll(PDO::FETCH_ASSOC);
        if(count($loginResult) == 0)
            $arrResult["login"] = true;
        if(count($emailResult) == 0)
            $arrResult["email"] = true;

    } catch (PDOException $error) {
        echo $error;
        exit(PHP_EOL . 'Checking error!');
    }
    return $arrResult;
}

/**
 * @param string $login user login
 * @param PDO $db db
 * @return mixed|void returns (if exists) account ID from given login, else false
 */

function getAccountIdFromLogin(string $login, PDO $db){
    try {
        $query = "SELECT id FROM bk.accounts WHERE login=:login;";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(":login", $login, PDO::PARAM_STR);
        $selectQuery->execute();
        return $selectQuery->fetchColumn();
    } catch (PDOException $error) {
        echo $error->getMessage();
        die();
    }
}


/**
 * @param string $login user email
 * @param PDO $db db
 * @return mixed|void returns (if exists) account ID from given email, else false
 */
function getAccountIdFromEmail(string $email, PDO $db){
    try {
        $query = "SELECT id FROM bk.accounts WHERE email=:email;";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(":email", $email, PDO::PARAM_STR);
        $selectQuery->execute();
        return $selectQuery->fetchColumn();
    } catch (PDOException $error) {
        echo $error->getMessage();
        die();
    }
}

/**
 * @param string $email user email
 * @param PDO $db db
 * @return bool if account is active return true
 */
function checkIfUserActivatedByEmail(string $email, PDO $db) : bool
{
    try{
        $query = "SELECT active FROM bk.accounts WHERE email=:email";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $selectQuery->execute();
        $results = $selectQuery->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $error){
        echo $error->getMessage();
        die();
    }
    return boolval($results['active']);
}


/**
 * update register_date in accounts, set activated=1 in register, add wallet in wallets
 * @param int $id account_id to activate
 * @param PDO $db pdo db
 *
 */
function activateUser(int $id, PDO $db){

    try {
        $updateSql = "UPDATE bk.accounts SET active=1 WHERE id=:id";
        $updateQuery = $db->prepare($updateSql);
        $updateQuery->bindValue(':id', $id);
        $updateQuery->execute();
    } catch (PDOException $error) {
        echo $error->getMessage();
        die();
    }

}

/** @param string $email user email
 * @param PDO $db db
 * @return string returns activation code for given email
 */
function getActivationCode(string $email, PDO $db)
{
    try{
        $selectCode = "SELECT bk.account_register.token FROM bk.account_register JOIN bk.accounts a on a.Register_Register_id = account_register.Register_id WHERE bk.accounts.email=:email";
        $selectQuery = $db->prepare($selectCode);
        $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $selectQuery->execute();
        return $selectQuery->fetchColumn();
    }
    catch (PDOException $error)
    {
        echo "get code error <br>";
        echo $error;
        exit();
    }

}