<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\functions.php';
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\NotAuthenticatedAccount.php';
/** @var PDO $db */

$email = $_GET['email'];
$code = $_GET['activation_code'];
$now = date("Y-m-d H:i:s");

if(isUserLoggedIn())
    header('Location: app.php');



if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
    echo "Wrong email! Please contact administrator for more information! Email: random@mail.org";
    exit();
}

if(checkIfUserActivatedByEmail($email, $db))
    errorRedirector('User with this email is already active!', 'Location: index.php');



//check if code ok and not expired
try {
    $query = "SELECT bk.account_register.token, bk.account_register.create_date, bk.account_register.expire_date FROM bk.account_register JOIN bk.accounts on account_register.Register_id = accounts.Register_Register_id WHERE accounts.email=:email";
    $selectQuery = $db->prepare($query);
    $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $selectQuery->execute();
    $results = $selectQuery->fetch(PDO::FETCH_ASSOC);
    if(strtotime($results['expire_date']) < $now)
    {
        if($results['token'] != $code)
        {
            $_SESSION['error'] = "Wrong code!";
            header("Location: ../view/index.php");
        }

        $insertProfileSql = "INSERT INTO bk.account_profile (register_date, money) VALUES (NOW(), 0)";
        $insertAddressSql = "INSERT INTO bk.account_address () VALUES ()";
        $selectLastAddressSql = "SELECT LAST_INSERT_ID() FROM bk.account_address";
        $selectLastProfileSql = "SELECT LAST_INSERT_ID() FROM bk.account_profile";
        $send = $db->prepare($insertProfileSql);
        $send->execute();

        $send = $db->prepare($selectLastProfileSql);
        $send->execute();
        $result = $send->fetch(PDO::PARAM_INT);
        $profileId = $result[0];
        $updateSql = "UPDATE bk.accounts SET Profiles_Profile_id=:id WHERE id=:userid";
        $updateQuery = $db->prepare($updateSql);
        $updateQuery->bindValue('id', $result[0]);
        $updateQuery->bindValue('userid', getAccountIdFromEmail($email, $db));

        $user = new NotAuthenticatedAccount();
        if($updateQuery->execute())
            $user->activateUser(getAccountIdFromEmail($email, $db), $db);
        $send = $db->prepare($insertAddressSql);
        $send->execute();

        $send = $db->prepare($selectLastAddressSql);
        $send->execute();
        $result = $send->fetch(PDO::PARAM_INT);

        $updateSql = "UPDATE bk.account_profile SET Address_address_id=:aid WHERE Profile_id=:pid";
        $updateQuery = $db->prepare($updateSql);
        $updateQuery->bindValue('aid', $result[0]);
        $updateQuery->bindValue('pid', $profileId);
        $updateQuery->execute();
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
echo "Account activated!";
echo "<a href='../view/login.php'>Log in</a>";
#TODO: Redirect to login page