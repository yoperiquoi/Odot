<?php

namespace DAL;

use modeles\gestionUtilisateur\Utilisateur;
use modeles\gestionTaches\ListeTache;
use modeles\gestionTaches\Tache;
use PDO;

class UtilisateurGateway
{
    private $con;
    private $TU;

    public function __construct($c=null)
    {
        if(isset($c) && $c != null) {
            $this->con=$c;
        } else {
            global $dsn, $user, $pass;
            $this->con=new Connection($dsn, $user, $pass);
        }
    }

    public function findUtilisateur(string $email,string $mdp): ?Utilisateur{
        $query='SELECT * FROM Utilisateur where email=:email and mdp=:mdp';
        $this->con->executeQuery($query,array(':email' => array($email, PDO::PARAM_STR),':mdp' => array($mdp, PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $this->TU= new Utilisateur($row["Email"],$row['Pseudonyme'],$row["Mdp"]);
        }
        return $this->TU;
    }

    public function ajoutUtilisateur(string $email,string $pseudonyme,string $mdp){
        $query='INSERT INTO UTILISATEUR VALUES(:email,:pseudonyme,:mdp)';
        $this->con->executeQuery($query,array(':email' => array($email, PDO::PARAM_STR),':mdp' => array($mdp, PDO::PARAM_STR),':pseudonyme'=>(array($pseudonyme,PDO::PARAM_STR))));
    }
}