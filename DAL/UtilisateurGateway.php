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

    public function findAllListesUtilisateur(string $email):array{
        $query='SELECT IdListeTache,Titre FROM ListesTaches WHERE Email=:email';
        $this->con->executeQuery($query,array(':email'=> array($email,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        if($results==NULL)return array();
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
            if(empty($Taches)){
                $ListesTachesPrivee[]=new ListeTache($Titre,$Taches=[]);
            }else{
                $ListesTachesPrivee[]=new ListeTache($Titre,$Taches);
            }
            $Taches=[];
        }
        return $ListesTachesPrivee;
    }

    public function ajoutTache(string $liste,string $nom, string $email) {
        $query='SELECT IdTache FROM TACHEPRIVEE WHERE IdTache=(SELECT MAX(IdTache) from TACHEPrivee)';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        foreach ($results as $value){
            $idTache=$value['IdTache'];
        }
        $idTache = 1;
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
        return TRUE;
    }

    public function delListe(string $nom,string $email){
        $query='SELECT IdListeTache FROM ListesTaches where Titre=:nom and Email=:email';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR),':email' => array($email,PDO::PARAM_STR)));
        $result=$this->con->getResults();
        foreach ($result as $value){
            $IdListe=$value['IdListeTache'];
        }
        $query='SELECT IdTache FROM ListeTachePrivee where IdListeTachesPrivee=:IdListe';
        $this->con->executeQuery($query, array(':IdListe' => array($IdListe,PDO::PARAM_STR)));
        $result=$this->con->getResults();
        foreach ($result as $value){
            $query='SELECT Nom from TachePrivee WHERE IdTache=:IdTache';
            $this->con->executeQuery($query, array(':IdTache' => array($value['IdTache'],PDO::PARAM_STR)));
            $results=$this->con->getResults();
            foreach ($results as $nom){
                $this->delTache($nom['Nom']);
            }
        }
        $query='DELETE FROM ListesTaches WHERE IdListeTache=:IdListe';
        $this->con->executeQuery($query, array(':IdListe' => array($IdListe,PDO::PARAM_STR)));
    }

    public function ajouterListe(string $nom,string $email){
        $query='SELECT IdListeTache FROM ListesTaches WHERE IdListeTache=(SELECT MAX(IdListeTache) FROM ListesTaches)';
        $this->con->executeQuery($query,array());
        $result=$this->con->getResults();
        if($result==NULL){
            $Id=1;
        }
        foreach ($result as $value){
            $Id=$value['IdListeTache']+1;
        }
        $query='INSERT INTO ListesTaches VALUES(:id,:email,:nom)';
        $this->con->executeQuery($query,array(':email' => array($email,PDO::PARAM_STR),':id' => array($Id,PDO::PARAM_INT),':nom' => array($nom,PDO::PARAM_STR)));
    }


    public function cocherTache(string $nom,string $liste, string $email){
        $query='SELECT IdListeTache from ListesTache WHERE titre=:liste and email=:email';
        $this->con->executeQuery($query,array(':liste' => array($liste, PDO::PARAM_STR), ':email' => array($email, PDO::PARAM_STR)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $IdListe=$row['IdListePublic'];
        }
        $query='SELECT IdTache from ListeTachePrivee WHERE IdListe=:idListe and IdTache=(SELECT IdTache from TachePrivee where nom=:nom)';
        $this->con->executeQuery($query,array(':idListe' => array($IdListe, PDO::PARAM_INT)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $IdListe=$row['IdTache'];
        }
        $query='SELECT Effectue FROM TachePrivee where IdTache=:idTache ';
        $this->con->executeQuery($query,array(':idTache' => array($IdListe, PDO::PARAM_INT)));
        $results=$this->con->getResults();
        foreach ($results as $row){
            $Effectue=$row['Effectue'];
        }
        if($Effectue==1){
            $query='Update TachePrivee set Effectue=0 where IdTache=:IdTache';
            $this->con->executeQuery($query,array(':idTache' => array($IdListe, PDO::PARAM_INT)));
        }else{
            $query='Update TachePrivee set Effectue=1 where IdTache=:IdTache';
            $this->con->executeQuery($query,array(':idTache' => array($IdListe, PDO::PARAM_INT)));
        }

    }
}