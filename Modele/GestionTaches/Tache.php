<?php


class Tache{
    public string $Nom;
    public int $Effectue;

    function __construct(string $Nom){
        $this->Nom=$Nom;
        $this->Effectue=false;
    }

    function cocher(){
        $this->Effectue=true;
    }

    function __toString() : string
    {
        return $this->Nom;
    }
}
