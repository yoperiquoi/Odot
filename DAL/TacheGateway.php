<?php

namespace DAL;

use \PDO;

class TacheGateway
{
    private $con;

    public function __construct($c=null)
    {
        if(isset($c) && $c != null) {
            $this->con = $c;
        } else {
            global $dsn, $user, $pass;
            $this->con=new Connection($dsn, $user, $pass);
        }
    }

    public function ajoutTache(string $liste,string $nom) {
        $query='SELECT IdTache FROM TACHE WHERE IdTache=(SELECT MAX(IdTache) from TACHE)';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }
        $idTache= isset($idTache) ? $idTache+1 : 1;
        $query='INSERT INTO Tache values (:idTache,:nom, false)';
        $this->con->executeQuery($query,array(':idTache' => array($idTache, PDO::PARAM_INT),':nom' => array($nom, PDO::PARAM_STR)));

        $query = 'SELECT IdListePublique FROM ListesPublique where Titre=:liste';
        $this->con->executeQuery($query, array(':liste' => array($liste, PDO::PARAM_STR)));
        $resultats =$this->con->getResults();
        foreach ($resultats as $idL) {
            $query = 'INSERT INTO ListeTachePublic values (:idL, :idT)';
            $this->con->executeQuery($query, array(':idL' => array($idL['IdListePublique'], PDO::PARAM_INT), ':idT' => array($idTache, PDO::PARAM_INT)));
        }

    }


    public function delTache(string $nom): bool{
        $query='SELECT IdTache FROM tache WHERE Nom=:nom';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }
        if(!isset($idTache)) throw new \PDOException("Pas de tache avec ce nom, veuillez réessayer", 1);
        $query='DELETE FROM ListeTachePublic where IdTache=:id';
        $this->con->executeQuery($query,array(':id'=>array($idTache, PDO::PARAM_INT)));

        $query = 'DELETE FROM Tache where nom=:nom';
        return $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
    }


    public function cocherTache(string $nom,string $liste){
        $query='SELECT IdTache FROM Tache WHERE Nom=:nom';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }
        if(!isset($idTache)) throw new \PDOException("Pas de tache avec ce nom, veuillez réessayer", 1);
        $query='SELECT Effectue FROM Tache where IdTache=:idTache ';
        $this->con->executeQuery($query,array(':idTache' => array($idTache, PDO::PARAM_INT)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $Effectue=$row['Effectue'];
        }
        if(!isset($idTache)) throw new \PDOException("La tache n'a pas d'id, veuillez réessayer", 1);
        if($Effectue==1){
            $query='Update Tache set Effectue=0 where IdTache=:idTache';
            $this->con->executeQuery($query,array(':idTache' => array($idTache, PDO::PARAM_INT)));
        }else{
            $query='Update Tache set Effectue=1 where IdTache=:idTache';
            $this->con->executeQuery($query,array(':idTache' => array($idTache, PDO::PARAM_INT)));
        }

    }

    public function ajoutTacheUtilisateur(string $liste,string $nom, string $email) {
        $query='SELECT IdTache FROM TACHEPRIVEE WHERE IdTache=(SELECT MAX(IdTache) from TACHEPrivee)';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache']+1;
        }
        if(!isset($idTache) || $idTache == null) $idTache = 1;
        $query='INSERT INTO TachePrivee values (:idTache,:nom, false)';
        $this->con->executeQuery($query,array(':idTache' => array($idTache, PDO::PARAM_INT),':nom' => array($nom, PDO::PARAM_STR)));

        $query = 'SELECT IdListeTache FROM ListesTaches where Titre=:liste and Email=:email';
        $this->con->executeQuery($query, array(':liste' => array($liste, PDO::PARAM_STR),':email' => array($email, PDO::PARAM_STR)));
        $resultats =$this->con->getResults();
        foreach ($resultats as $idL) {
            $query = 'INSERT INTO ListeTachePrivee values (:idL, :idT)';
            $this->con->executeQuery($query, array(':idL' => array($idL['IdListeTache'], PDO::PARAM_INT), ':idT' => array($idTache, PDO::PARAM_INT)));
        }
    }

    public function delTacheUtilisateur(string $nom,int $id): bool{
        $query='SELECT * from TachePrivee WHERE nom=:nom and IdTache=:id';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR), ':id' => array($id, PDO::PARAM_INT)));
        $this->con->getResults();

        $query='DELETE FROM ListeTachePrivee where IdTache=:id';
        $this->con->executeQuery($query,array(':id'=>array($id, PDO::PARAM_INT)));

        $query = 'DELETE FROM TachePrivee where nom=:nom and IdTache=:id';
        return $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR),':id' => array($id, PDO::PARAM_INT)));
    }

    public function cocherTacheUtilisateur(string $nom,int $id){
        $query='SELECT Effectue FROM TachePrivee where IdTache=:idTache and Nom=:nom';
        $this->con->executeQuery($query,array(':idTache' => array($id, PDO::PARAM_INT),':nom' => array($nom, PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $Effectue=$row['Effectue'];
        }
        if($Effectue==1){
            $query='Update TachePrivee set Effectue=0 where IdTache=:IdTache';
            $this->con->executeQuery($query,array(':IdTache' => array($id, PDO::PARAM_INT)));
        }else{
            $query='Update TachePrivee set Effectue=1 where IdTache=:IdTache';
            $this->con->executeQuery($query,array(':IdTache' => array($id, PDO::PARAM_INT)));
        }

    }
}