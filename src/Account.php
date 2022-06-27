<?php
require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';

abstract class Account
{
    protected string $login;
    protected string $password;
    protected string $email;
    protected string $accountType;

    public function getLogin(): string{return $this->login;}
    public function setLogin(string $login): void{$this->login = $login;}
    public function getPassword(): string{return $this->password;}
    public function setPassword(string $password): void{$this->password = $password;}
    public function getAccountType(): string{return $this->accountType;}
    public function setAccountType(string $accountType): void{$this->accountType = $accountType;}
    public function getEmail(): string{return $this->email;}
    public function setEmail(string $email): void{$this->email = $email;}
    public function getNick(): string{return $this->nick;}
    public function setNick(string $nick): void{$this->nick = $nick;}


    /* @param string $login user login
     * @param string $password user password
     * @param PDO $db db
     * @return boolean true if user can be logged in (doesnt check user activated)
     */
    public static function logIntoSite(string $login, string $password, PDO $db) : bool
    {
        if ($login == "" || $password == "" || $login == null || $password == null)
            return false;
            /** @var PDO $db */
            try {
                $query = "SELECT account_login, account_password FROM bookmaker.accounts WHERE account_login=:login";
                $loginQuery = $db->prepare($query);
                $loginQuery->bindValue(':login', $login, PDO::PARAM_STR);
                $loginQuery->execute();
                $queryResult = $loginQuery->fetch();
            } catch (PDOException $error) {
                echo $error;
                exit(PHP_EOL . 'Log-in error!');
            }
            return ($queryResult['account_login'] == $login && password_verify($password, $queryResult['account_password']) == true);
    }


}
?>