<?php

require_once 'C:\Users\jankr\PhpstormProjects\wprgcwiczenia\Bookmaker\src\Account.php';

class User extends Account
{
    private $money;
    public function getMoney(): float{return $this->money;}
    public function __construct()
    {

    }

}

?>