<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
/** @var PDO $db */

$email = $_GET['email'];
$code = $_GET['activation_code'];
$now = strtotime(date("Y-m-d H:i:s"));

if(isUserLoggedIn())
    header('Location: main.php');



if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
    echo "Wrong email! Please contact administrator for more information! Email: email@localhost.org";
    exit();
}

if(checkIfUserActivatedByEmail($email, $db))
    errorRedirector('Account with this email is already active!', 'Location: index.php');



//check if code ok and not expired
try {
    $query = "SELECT register.activation_code, accounts.account_email, register.expiry_at FROM register JOIN accounts on register.account_id = accounts.account_id WHERE account_email=:email AND register.activation_code=:code";
    $selectQuery = $db->prepare($query);
    $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $selectQuery->bindValue(':code', $code, PDO::PARAM_STR);
    $selectQuery->execute();
    $results = $selectQuery->fetch(PDO::FETCH_ASSOC);
    if(strtotime($results['expiry_at']) > $now)
    {
        if($results['activation_code'] == $code)
        {
            $id=getAccountIdFromEmail($email, $db);
            activateUser($id, $db);
            echo "Account activated";
        }
    }
    else
    {
        $_SESSION['error'] = "Code expired, new code sent to your email!";//TODO: go to reactivation
        header("Location: reactivate.php?=email");
    }

}
catch(PDOException $error)
{
    echo $error;
    exit();
}