<?php

namespace DAL\metier;

class Tache{
    public int $Id;
    public string $Nom;
    public bool $Effectue;

    function __construct(int $Id,string $Nom, bool $Effectue){
        $this->Id=$Id;
        $this->Nom=$Nom;
        $this->Effectue=$Effectue;
    }

    function cocher(){
        $this->Effectue=true;
    }

    function __toString() : string
    {
        return $this->Nom;
    }
}
