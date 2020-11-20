<?php

include_once "../../Modele/GestionTaches/Tache.php";

class TacheGateway
{
    private $con;
    private $TT;
    private $TU;

    public function __construct($c)
    {
        $this->con=$c;
    }

    public function findAllTaches():array{
        $query='SELECT * FROM Tache';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $row){
            $this->TT[]= new Tache($row['Nom'],$row["Effectue"]);
        }
        return $this->TT;
    }

    public function delTache(string $nom): bool{
        $query = 'DELETE FROM Tache where nom=:nom';
        return $this->con->executeQuery($query, array(':nom' => array($nom, PDO::PARAM_STR)));
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
            $this->TU= new Tache($row['Nom'],$row["Effectue"]);
        }
        return $this->TU;
    }

}