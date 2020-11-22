<?php


class Utilisateur
{
    private $Pseudonyme;
    public $Email;
    private $Mdp;

    function __construct(string $Email,string $Pseudonyme, string $Mdp){
        $this->Pseudonyme=$Pseudonyme;
        $this->Email=$Email;
        $this->Mdp=$Mdp;
    }


}