<?php

namespace DAL\metier;

class ListeTache
{
    private $Titre;
    public $Taches;

    function __construct(string $Titre,array $Taches){
        $this->Titre=$Titre;
        if(!empty($Taches)) {
            foreach ($Taches as $value) {
                $this->Taches[] = new Tache($value->Id,$value->Nom, $value->Effectue);
            }
        }
    }

    function __ToString():string{
        return $this->Titre;
    }
}