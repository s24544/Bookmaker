<?php

class Game
{
    private $gameName;
    private $type;
    private $teams=array();
    private $teamsOdds=array();//assoc arr ["team" => (float)]
    private $gameBetStart;
    private $gameBetStop;
    private $gameCreateDateTime;

    public function addTeam(String $team) : void {$this->teams[] = $team;}
    public function getTeams() : array {return $this->teams;}
    public function setTeamOdd(String $team, float $odd) : void{$this->teamsOdds[$team] = $odd;}
    public function getTeamOdd(String $team) : float {return $this->teamsOdds[$team];}
    public function __construct(DateTime $gameCreateDateTime)
    {
        $this->gameCreateDateTime = date("Y-m-d H:m:s", time());
        $this->gameBetStart = $gameCreateDateTime;
    }


}
?>