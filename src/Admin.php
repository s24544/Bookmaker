<?php

require_once 'AuthenticatedAccount.php';

class Admin extends User
{
    public static function setMoney($m, $user){$user->money = $m;}
    public function addGame($gameid){}
    public function removeGame($gameid){}
    public function setOdd($p){}

}

?>