<?php

namespace DAL;

use \PDO;

class UtilisateurGateway
{
    private $con;

    public function __construct($c=null)
    {
        if(isset($c) && $c != null) {
            $this->con=$c;
        } else {
            global $dsn, $user, $pass;
            $this->con=new Connection($dsn, $user, $pass);
        }
    }

    public function findUtilisateur(string $email,string $mdp): bool{
        $query='SELECT * FROM Utilisateur where Email=:email';
        $this->con->executeQuery($query,array(':email' => array($email, PDO::PARAM_STR)));
        $results=$this->con->getResults();
        if(isset($results[0]['Email'])){
            return password_verify($mdp,$results[0]['Mdp']);
        }
        else return false;
    }

    public function ajoutUtilisateur(string $email,string $pseudonyme,string $mdp){
        $mdp=password_hash($mdp,PASSWORD_DEFAULT);
        $query='INSERT INTO UTILISATEUR VALUES(:email,:pseudonyme,:mdp)';
        $this->con->executeQuery($query,array(':email' => array($email, PDO::PARAM_STR),':mdp' => array($mdp, PDO::PARAM_STR),':pseudonyme'=>(array($pseudonyme,PDO::PARAM_STR))));
    }

    public function getPseudoUtilisateur(string $email) {
        $query='SELECT Pseudonyme FROM Utilisateur where Email=:email';
        $this->con->executeQuery($query,array(':email' => array($email, PDO::PARAM_STR)));
        $results=$this->con->getResults();
        if(isset($results[0]['Pseudonyme'])){
            return $results[0]['Pseudonyme'];
        }
        else return null;
    }
}