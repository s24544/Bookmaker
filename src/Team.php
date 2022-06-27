<?php

class Team
{
    private $teamId;
    private $teamName;
    private $teamSport;
    private $teamLogo;//url
    private $teamInfo;

    public function getTeamId() {return $this->teamId;}
    public function setTeamId($teamId): void{$this->teamId = $teamId;}
    public function getTeamName(){return $this->teamName;}
    public function setTeamName($teamName): void{$this->teamName = $teamName;}
    public function getTeamSport(){return $this->teamSport;}
    public function setTeamSport($teamSport): void{$this->teamSport = $teamSport;}
    public function getTeamLogo(){return $this->teamLogo;}
    public function setTeamLogo($teamLogo): void {$this->teamLogo = $teamLogo;}
    public function getTeamInfo(){return $this->teamInfo;}
    public function setTeamInfo($teamInfo): void {$this->teamInfo = $teamInfo;}


}