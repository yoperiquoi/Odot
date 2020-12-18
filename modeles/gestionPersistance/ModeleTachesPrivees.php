<?php


namespace modeles\gestionPersistance;


use DAL\ListeGateway;
use DAL\TacheGateway;
use DAL\UtilisateurGateway;

class ModeleTachesPrivees
{
    private $UtilisateurGateway;
    private $ListeGateway;
    private $TacheGateway;

    public function __construct()
    {
        $this->UtilisateurGateway = new UtilisateurGateway();
        $this->TacheGateway = new TacheGateway();
        $this->ListeGateway = new ListeGateway();
    }

    public function trouverUtilisateur(String $Email, String $Mdp) {
        return $this->UtilisateurGateway->findUtilisateur($Email, $Mdp);
    }

    public function toutesLesListes(String $session) {
        return $this->ListeGateway->findAllListesUtilisateur($session);
    }

    public function ajouterListe(String $Nom, String $session) {
        $this->ListeGateway->ajouterListeUtilisateur($Nom, $session);
    }

    public function supprimerListe(String $Nom, String $session) {
        $this->ListeGateway->delListeUtilisateur($Nom, $session);
    }

    public function ajouterTache(String $Liste, String $Nom, String $Email) {
        $this->TacheGateway->ajoutTacheUtilisateur($Liste, $Nom,$Email);
    }

    public function supprimerTache(String $Nom) {
        $this->TacheGateway->delTache($Nom);
    }

    public function AjouterUtilisateur(String $Email, String $Pseudo, String $Mdp) {
        $this->UtilisateurGateway->ajoutUtilisateur($Email, $Pseudo, $Mdp);
    }


}