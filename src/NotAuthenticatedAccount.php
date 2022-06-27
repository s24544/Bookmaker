<?php

use JetBrains\PhpStorm\Pure;

require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\config\database.php';

class NotAuthenticatedAccount
{
    protected int $id;
    protected string $login;
    protected string $password;
    protected string $email;
    protected PDO $db;

    public function getLogin(): string{return $this->login;}
    public function setLogin(string $login): void{$this->login = $login;}
    public function getPassword(): string{return $this->password;}
    public function setPassword(string $password): void{$this->password = $password;}
    public function getEmail(): string{return $this->email;}
    public function setEmail(string $email): void{$this->email = $email;}
    public function getId(): int{return $this->id;}
    public function setId(int $id){$this->id = $id;}


    //register functions
    public function validateLogin(): bool{
        if(strlen($this->getLogin()) > 64 || strlen($this->getLogin()) < 4)
            return false;
        else
            return true;
    }

    public function validatePassword(): bool{
        /**
         * regex for at least:
         * 8 characters
         * 1 uppercase
         * 1 lower
         * 1 digit
         * 1 special char
         */
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/";
        return preg_match($regex, $this->getPassword());
    }

    public function validateEmail(): bool{
        if(strlen($this->getEmail()) > 320)
            return false;
        return filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL);
    }

    /* @return array ["login"] ["email"] if exists
         * @return boolean true if user can be logged in (doesnt check user activated)
     */
    public function checkIfUserExists(PDO $db) : array{
        try {
            $arrResult=[];
            $selectLoginSql = "SELECT id FROM bk.accounts WHERE login=:login;";
            $selectEmailSql = "SELECT id FROM bk.accounts WHERE email=:email;";
            $loginQuery = $db->prepare($selectLoginSql);
            $emailQuery = $db->prepare($selectEmailSql);
            $loginQuery->bindValue(':login', $this->getLogin(), PDO::PARAM_STR);
            $emailQuery->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $loginQuery->execute();
            $emailQuery->execute();
            $loginResult = $loginQuery->fetchAll(PDO::FETCH_ASSOC);
            $emailResult = $emailQuery->fetchAll(PDO::FETCH_ASSOC);
            if(count($loginResult) != 0)
                $arrResult["login"] = true;
            if(count($emailResult) != 0)
                $arrResult["email"] = true;

        } catch (PDOException $error) {
            echo $error->getMessage();
            die();
        }

        return $arrResult;
    }

    public function activateUser(int $id, PDO $db) : bool{
        try {
            $updateSql = "UPDATE bk.accounts SET active=1 WHERE id=:id";
            $updateQuery = $db->prepare($updateSql);
            $updateQuery->bindValue(':id', $id);
            if($updateQuery->execute())
                return true;
        } catch (PDOException $error) {
            die($error->getMessage());
        }
        return false;
    }


    /**
     * @param string $login user login
     * @param PDO $db db
     * @return bool true if account with given login is activated
     */
    public function checkIfUserActivated(string $login, PDO $db) : bool
    {
        try{
            $query = "SELECT active FROM bk.accounts WHERE login=:login";
            $selectQuery = $db->prepare($query);
            $selectQuery->bindValue(':login', $login, PDO::PARAM_STR);
            $selectQuery->execute();
            $results = $selectQuery->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $error){
            echo PHP_EOL.$error.PHP_EOL;
            exit();
        }
        return boolval($results['active']);
    }


}