<?php

include_once "../../Modele/GestionUtilisateur/Utilisateur.php";
include_once "../../Modele/GestionTaches/ListeTache.php";
include_once "../../Modele/GestionTaches/Tache.php";

class UtilisateurGateway
{
    private $con;
    private $TU;

    public function __construct($c)
    {
        $this->con=$c;
    }


    public function findUtilisateur(string $email,string $mdp): Utilisateur{
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

    public function findAllListesUtilisateur(string $email){
        $query='SELECT IdListeTache,Titre FROM ListesTaches WHERE Email=:email';
        $this->con->executeQuery($query,array(':email'=> array($email,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $Titre=$row['Titre'];
            $query='SELECT * FROM ListeTachePrivee where IdListeTachesPrivee=:id';
            $this->con->executeQuery($query,array(':id' => array($row['IdListeTache'], PDO::PARAM_INT)));
            $resultats=$this->con->getResults();
            foreach ($resultats as $row){
                $query='SELECT Nom,Effectue FROM TachePrivee where IdTache=:id';
                $this->con->executeQuery($query,array(':id' => array($row['IdTache'], PDO::PARAM_INT)));
                $Tache=$this->con->getResults();
                foreach ($Tache as $value){
                    $Taches[]=new Tache($value['Nom'],$value['Effectue']);
                }
            }
            $ListesTachesPrivee[]=new ListeTache($Titre,$Taches);
            $Taches=[];
        }
        return $ListesTachesPrivee;
    }

    public function ajoutTache(string $liste,string $nom) {
        $query='SELECT IdTache FROM TACHEPRIVEE WHERE IdTache=(SELECT MAX(IdTache) from TACHEPrivee)';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }

        $idTache=$idTache+1;
        print $idTache;
        $query='INSERT INTO TachePrivee values (:idTache,:nom, false)';
        $this->con->executeQuery($query,array(':idTache' => array($idTache, PDO::PARAM_INT),':nom' => array($nom, PDO::PARAM_STR)));

        $query = 'SELECT IdListeTache FROM ListesTaches where Titre=:liste';
        $this->con->executeQuery($query, array(':liste' => array($liste, PDO::PARAM_STR)));
        $resultats =$this->con->getResults();
        foreach ($resultats as $idL) {
            $query = 'INSERT INTO ListeTachePrivee values (:idL, :idT)';
            $this->con->executeQuery($query, array(':idL' => array($idL['IdListeTache'], PDO::PARAM_INT), ':idT' => array($idTache, PDO::PARAM_INT)));
        }

    }


    public function delTache(string $nom): bool{
        $query='SELECT IdTache FROM tachePrivee WHERE Nom=:nom';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }

        $query='SELECT IdListeTachesPrivee FROM ListeTachePrivee where IdTache=:id ';
        $this->con->executeQuery($query,array(':id'=>array($idTache, PDO::PARAM_INT)));
        $resultats =$this->con->getResults();
        foreach ($resultats as $idL) {
            $id=$idL['IdListeTachesPrivee'];
        }

        $query='DELETE FROM ListeTachePrivee where IdTache=:id';
        $this->con->executeQuery($query,array(':id'=>array($idTache, PDO::PARAM_INT)));

        $query = 'DELETE FROM TachePrivee where nom=:nom';
        return $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
    }
}