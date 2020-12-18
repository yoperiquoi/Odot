<?php

namespace DAL\metier;

class Tache{
    public string $Nom;
    public bool $Effectue;

    function __construct(string $Nom, bool $Effectue){
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
