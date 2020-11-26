<?php

include_once "../../Modele/GestionTaches/Tache.php";
include_once "../../Modele/GestionTaches/ListeTache.php";

class TacheGateway
{
    private $con;

    public function __construct($c)
    {
        $this->con=$c;
    }

    public function ajoutTache(string $liste,string $nom) {
        $query='SELECT IdTache FROM TACHE WHERE IdTache=(SELECT MAX(IdTache) from TACHE)';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }
        $idTache=$idTache+1;
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

    public function findAllListes():array{
        $query='SELECT * FROM ListesPublique';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $row){
            $Titre=$row['Titre'];
            $query='SELECT * FROM ListeTachePublic where IdListePublique=:id';
            $this->con->executeQuery($query,array(':id' => array($row['IdListePublique'], PDO::PARAM_INT)));
            $resultats=$this->con->getResults();
            foreach ($resultats as $row){
                $query='SELECT Nom,Effectue FROM Tache where IdTache=:id';
                $this->con->executeQuery($query,array(':id' => array($row['IdTache'], PDO::PARAM_INT)));
                $Tache=$this->con->getResults();
                foreach ($Tache as $value){
                    $Taches[]=new Tache($value['Nom'],$value['Effectue']);
                }
            }
            $ListesTachesPublique[]=new ListeTache($Titre,$Taches);
            $Taches=[];
        }
        return $ListesTachesPublique;
    }

    public function delTache(string $nom): bool{
        $query='SELECT IdTache FROM tache WHERE Nom=:nom';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }
        $query='DELETE FROM ListeTachePublic where IdTache=:id';
        $this->con->executeQuery($query,array(':id'=>array($idTache, PDO::PARAM_INT)));

        $query = 'DELETE FROM Tache where nom=:nom';
        return $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
    }

    public function nbTaches(){
        $query='SELECT count(*) FROM Tache';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        return $results[0]['count(*)'];
    }

    public function findTache(string $nom): Tache{
        $query='SELECT * FROM Tache where nom=:nom';
        $this->con->executeQuery($query,array(':nom' => array($nom, PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $TU= new Tache($row['Nom'],$row['Effectue']);
        }
        return $TU;
    }

}