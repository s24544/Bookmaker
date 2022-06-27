<?php
//session_start();
/** Only functions definitions */
/** @var PDO $db */


/** @param string $errorDetails session error string
 * @param string $header full header, typicaly redirect to register
 * @return void redirect to header register.php and set session['error']
 */
function errorRedirector(string $errorDetails, string $header = 'Location: register.php') : void
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
 * @param PDO $db db pdo
 * @return array if result[0] == true then login is in database, if [1] true then email...
 */

function checkIfAlreadyExists(string $login, string $email, PDO $db) : array
{
    $arrResult = array();
    $arrResult[0] = false;
    $arrResult[1] = false;
    try {
        $selectLogin = "SELECT account_id FROM bookmaker.accounts WHERE account_login=:login;";
        $selectEmail = "SELECT account_id FROM bookmaker.accounts WHERE account_email=:email;";
        $loginQuery = $db->prepare($selectLogin);
        $emailQuery = $db->prepare($selectEmail);
        $loginQuery->bindValue(':login', $login, PDO::PARAM_STR);
        $emailQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $loginQuery->execute();
        $emailQuery->execute();
        $loginResult = $loginQuery->fetchAll(PDO::FETCH_ASSOC);
        $emailResult = $emailQuery->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($loginResult) > 0)
            $arrResult[0] = true;
        if(sizeof($emailResult) > 0)
            $arrResult[1] = true;

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
        $query = "SELECT account_id FROM bookmaker.accounts WHERE account_login=:login;";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(":login", $login, PDO::PARAM_STR);
        $selectQuery->execute();
        return $selectQuery->fetchColumn();
    } catch (PDOException $error) {
        echo $error;
        exit(PHP_EOL . 'Select account_id from login error');
    }
}


/**
 * @param string $login user email
 * @param PDO $db db
 * @return mixed|void returns (if exists) account ID from given email, else false
 */
function getAccountIdFromEmail(string $email, PDO $db){
    try {
        $query = "SELECT account_id FROM bookmaker.accounts WHERE account_email=:email;";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(":email", $email, PDO::PARAM_STR);
        $selectQuery->execute();
        return $selectQuery->fetchColumn();
    } catch (PDOException $error) {
        echo $error;
        exit(PHP_EOL . 'Select account id from email error');
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
        $query = "SELECT account_register_date FROM accounts WHERE account_email=:email";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $selectQuery->execute();
        $results = $selectQuery->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $error){
        echo PHP_EOL.$error.PHP_EOL;
        exit();
    }
    return boolval($results['account_register_date']);
}

/**
 * @param string $login user login
 * @param PDO $db db
 * @return bool true if account with given login is activated
 */
function checkIfUserActivatedByLogin(string $login, PDO $db) : bool
{
    try{
        $query = "SELECT account_register_date FROM accounts WHERE account_login=:login";
        $selectQuery = $db->prepare($query);
        $selectQuery->bindValue(':login', $login, PDO::PARAM_STR);
        $selectQuery->execute();
        $results = $selectQuery->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $error){
        echo PHP_EOL.$error.PHP_EOL;
        exit();
    }
    return boolval($results['account_register_date']);
}

/**
 * update register_date in accounts, set activated=1 in register, add wallet in wallets
 * @param int $id account_id to activate
 * @param PDO $db pdo db
 *
 */
function activateUser(int $id, PDO $db){

    try {
        $updateRegDate = "UPDATE accounts SET account_register_date=NOW() WHERE account_id=:id";
        $updateActivated = "UPDATE register SET activated = 1 WHERE account_id=:id";
        $updateQuery = $db->prepare($updateRegDate);
        $updateQuery->bindValue(':id', $id, PDO::PARAM_INT);
        $updateQuery->execute();
        $updateQuery = $db->prepare($updateActivated);
        $updateQuery->bindValue(':id', $id, PDO::PARAM_INT);
        $updateQuery->execute();
    } catch (PDOException $error) {
        echo $error;
        exit(PHP_EOL . 'Register date in accounts error or activated=1 error!');
    }

    try {
        $insertWallet = "INSERT INTO wallets(`Accounts_account_id`, `wallet_coins`, `wallet_currency`) VALUES (:id, 0, 'PLN')";
        $insertQuery = $db->prepare($insertWallet);
        $insertQuery->bindValue(':id', $id, PDO::PARAM_INT);
        $insertQuery->execute();
    } catch (PDOException $error) {
        echo $error;
        exit(PHP_EOL . 'Register date in accounts error or activated=1 error!');
    }
}

/** @param string $email user email
 * @param PDO $db db
 * @return string returns activation code for given email
 */
function getActivationCode(string $email, PDO $db)
{
    try{
        $selectCode = "SELECT register.activation_code FROM register JOIN accounts a on a.account_id = register.account_id WHERE account_email=:email";
        $selectQuery = $db->prepare($selectCode);
        $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
        $selectQuery->execute();
        return $selectQuery->fetchColumn();;
    }
    catch (PDOException $error)
    {
        echo "get code error <br>";
        echo $error;
        exit();
    }

}