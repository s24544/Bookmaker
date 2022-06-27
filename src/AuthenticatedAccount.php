<?php



require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\NotAuthenticatedAccount.php';

class AuthenticatedAccount extends NotAuthenticatedAccount
{
    private float $money;
    private array $profile =[
        'Profile_id' => '',
        'register_date' => '',
        'last_login' => '',
        'name' => '',
        'surname' => '',
        'money' => '',
        'avatar_path' => '',
        'Address_addres_id' => ''
    ];
    private array $permissions;

    public function getProfile(): array
    {return $this->profile;}


    public function getMoney(PDO $db): float{
        try{
            $selectSql = "SELECT money FROM bk.account_profile JOIN bk.accounts ON account_profile.Profile_id = accounts.Profiles_Profile_id WHERE id=$this->id";
            $selectQuery=$db->prepare($selectSql);
            $selectQuery->execute();
            $result = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
            $this->money = $result[0]['money'];
        }catch (PDOException $error){
            return $error->getMessage();
        }

        return $this->money;
    }
    public function addMoney(float $m){$this->money = $this->getMoney()+$m;}
    public function setMoney(float $m){$this->money = $m;}

    /* @param string $login user login
     * @param string $password user password
     * @param PDO $db db connection
     * @return boolean true if user can be logged in (doesnt check user activated)
     */
    public function authAccount(string $login, string $password, PDO $db) : bool
    {
        if ($login == "" || $login == null)
            return false;
        /** @var PDO $db */
        try {
            $query = "SELECT active, password FROM bk.accounts WHERE login=:login";
            $loginQuery = $db->prepare($query);
            $loginQuery->bindValue(':login', $login, PDO::PARAM_STR);
            $loginQuery->execute();
            $queryResult = $loginQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo $error->getMessage();
            die();
        }
        return ($queryResult[0]['active'] == 1 && password_verify($password, $queryResult[0]['password']) == true);
    }

    public function isAdmin(PDO $db) : bool{
        try{
            $selectSql = "SELECT admin_panel FROM account_permissions JOIN accounts ON account_permissions.Permission_id=accounts.Permissions_Permission_id WHERE id=:id";
            $selectQuery = $db->prepare($selectSql);
            $selectQuery->bindValue(":id", $this->getId());
            $selectQuery->execute();
            $result = $selectQuery->fetch(PDO::PARAM_INT);
        }catch (PDOException $error){
            echo $error->getMessage();
            die();
        }
        if($result)
            return true;
        else
            return false;
    }

    public function setData(PDO $db){
        $selectSql = "SELECT Profile_id, id, register_date, email, name, surname, avatar_path, city, country, district, postal_code, street FROM accounts LEFT JOIN account_profile ON account_profile.Profile_id=accounts.Profiles_Profile_id LEFT JOIN account_address ON account_address.address_id=account_profile.Address_address_id LEFT JOIN city ON city.city_id=account_address.City_city_id LEFT JOIN country ON country.country_id=city.Country_country_id WHERE login=:login";
        $selectQuery = $db->prepare($selectSql);
        $selectQuery->bindValue(":login", $this->getLogin());
        $selectQuery->execute();
        $selectResult = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
        if(count($selectResult) != 0){
            $this->setId($selectResult[0]['id']);
            $this->setEmail($selectResult[0]['email']);
            $this->profile['Profile_id'] = $selectResult[0]['Profile_id'];
            $this->profile['register_date'] = $selectResult[0]['register_date'];
            $this->profile['email'] = $selectResult[0]['email'];
            $this->profile['name'] = $selectResult[0]['name'];
            $this->profile['surname'] = $selectResult[0]['surname'];
            $this->profile['avatar_path'] = $selectResult[0]['avatar_path'];
            $this->profile['city'] = $selectResult[0]['city'];
            $this->profile['country'] = $selectResult[0]['country'];
            $this->profile['district'] = $selectResult[0]['district'];
            $this->profile['postal_code'] = $selectResult[0]['postal_code'];
            $this->profile['street'] = $selectResult[0]['street'];
            if($this->isAdmin($db))
                $this->profile['admin'] = true;
        }
    }

}


?>