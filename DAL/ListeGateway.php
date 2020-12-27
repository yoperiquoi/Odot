<?php


namespace DAL;


use DAL\metier\ListeTache;
use DAL\metier\Tache;
use \PDO;

class ListeGateway
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

    public function nbListes() {
        $query='SELECT count(*) FROM ListesPublique';
        $this->con->executeQuery($query,array());
        $results=$this->con->getResults();
        return $results[0]['count(*)'] == null ? 0 : $results[0]['count(*)'];
    }

    public function findAllListes(int $page, int $nbListesPages):array{
        $query='SELECT * FROM ListesPublique LIMIT :debut,:nb';
        $this->con->executeQuery($query,array(':debut' => array(($page-1)*$nbListesPages, PDO::PARAM_INT),
        										':nb' => array($nbListesPages, PDO::PARAM_INT)));
        $results=$this->con->getResults();
        if($results==NULL)return array();
        foreach ($results as $row){
            $Titre=$row['Titre'];
            $query='SELECT * FROM ListeTachePublic where IdListePublique=:id';
            $this->con->executeQuery($query,array(':id' => array($row['IdListePublique'], PDO::PARAM_INT)));
            $resultats=$this->con->getResults();
            foreach ($resultats as $row){
                $query='SELECT IdTache,Nom,Effectue FROM Tache where IdTache=:id';
                $this->con->executeQuery($query,array(':id' => array($row['IdTache'], PDO::PARAM_INT)));
                $Tache=$this->con->getResults();
                foreach ($Tache as $value){
                    $Taches[]=new Tache($value['IdTache'],$value['Nom'],$value['Effectue']);
                }
            }
            if(empty($Taches)){
                $ListesTachesPublique[]=new ListeTache($Titre,$Taches=[]);
            }else{
                $ListesTachesPublique[]=new ListeTache($Titre,$Taches);
            }
            $Taches=[];
        }
        return $ListesTachesPublique;
    }

    public function delListe(string $nom){
        $query='SELECT IdListePublique FROM ListesPublique where Titre=:nom';
        $this->con->executeQuery($query, array(':nom' => array($nom,PDO::PARAM_STR)));
        $result=$this->con->getResults();
        foreach ($result as $value){
            $IdListe=$value['IdListePublique'];
        }
        if(!isset($IdListe)) throw new \PDOException("Pas de liste avec ce nom", 1);
        $query='SELECT IdTache FROM ListeTachePublic where IdListePublique=:IdListe';
        $this->con->executeQuery($query, array(':IdListe' => array($IdListe,PDO::PARAM_STR)));
        $result=$this->con->getResults();
        foreach ($result as $value){
            $query='SELECT Nom from Tache WHERE IdTache=:IdTache';
            $this->con->executeQuery($query, array(':IdTache' => array($value['IdTache'],PDO::PARAM_STR)));
            $results=$this->con->getResults();
            foreach ($results as $nom){
                (new TacheGateway())->delTache($nom['Nom']);
            }
        }
        $query='DELETE FROM ListesPublique WHERE IdListePublique=:IdListe';
        $this->con->executeQuery($query, array(':IdListe' => array($IdListe,PDO::PARAM_STR)));
    }

    public function ajouterListe(string $nom){
        $query='SELECT IdListePublique FROM ListesPublique WHERE IdListePublique=(SELECT MAX(IdListePublique) FROM ListesPublique)';
        $this->con->executeQuery($query,array());
        $result=$this->con->getResults();
        if($result==NULL){
            $Id=1;
        }
        else {
            foreach ($result as $value) {
                $Id = $value['IdListePublique'] + 1;
            }
        }
        $query='INSERT INTO ListesPublique VALUES(:id,:nom)';
        $this->con->executeQuery($query,array(':id' => array($Id,PDO::PARAM_INT),':nom' => array($nom,PDO::PARAM_STR)));
    }

    public function nbListesUtilisateur(string $email) {
        $query='SELECT count(*) FROM ListesTaches WHERE Email=:email';
        $this->con->executeQuery($query,array(':email'=> array($email,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        return $results[0]['count(*)'] == null ? 0 : $results[0]['count(*)'];
    }

    public function findAllListesUtilisateur(string $email, int $page, int $nbListesPages):array{
        $query='SELECT IdListeTache,Titre FROM ListesTaches WHERE Email=:email  LIMIT :debut,:nb';
        $this->con->executeQuery($query,array(':email'=> array($email,PDO::PARAM_STR),
            ':debut' => array(($page-1)*$nbListesPages, PDO::PARAM_INT),
            ':nb' => array($nbListesPages, PDO::PARAM_INT)));
        $results=$this->con->getResults();
        if($results==NULL)return array();
        foreach ($results as $row){
            $Titre=$row['Titre'];
            $query='SELECT * FROM ListeTachePrivee where IdListeTachesPrivee=:id';
            $this->con->executeQuery($query,array(':id' => array($row['IdListeTache'], PDO::PARAM_INT)));
            $resultats=$this->con->getResults();
            foreach ($resultats as $row){
                $query='SELECT IdTache,Nom,Effectue FROM TachePrivee where IdTache=:id';
                $this->con->executeQuery($query,array(':id' => array($row['IdTache'], PDO::PARAM_INT)));
                $Tache=$this->con->getResults();
                foreach ($Tache as $value){
                    $Taches[]=new Tache($value['IdTache'],$value['Nom'],$value['Effectue']);
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

    public function delListeUtilisateur(string $nom,string $email){
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
                (new TacheGateway())->delTache($nom['Nom']);
            }
        }
        $query='DELETE FROM ListesTaches WHERE IdListeTache=:IdListe';
        $this->con->executeQuery($query, array(':IdListe' => array($IdListe,PDO::PARAM_STR)));
    }

    public function ajouterListeUtilisateur(string $nom,string $email){
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

}