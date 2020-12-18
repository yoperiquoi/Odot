<?php

namespace modeles;

use DAL\ListeGateway;
use DAL\TacheGateway;
use DAL\UtilisateurGateway;

class Modele
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

    public function toutesLesListes() {
        return $this->ListeGateway->findAllListes();
    }

    public function ajouterListe(String $Nom) {
        $this->ListeGateway->ajouterListe($Nom);
    }

    public function supprimerListe(String $Nom) {
        $this->ListeGateway->delListe($Nom);
    }

    public function ajouterTache(String $Liste, String $Nom) {
        $this->TacheGateway->ajoutTache($Liste, $Nom);
    }

    public function supprimerTache(String $Nom) {
        $this->TacheGateway->delTache($Nom);
    }

    public function cocherTache(String $Nom, String $Liste) {
        $this->TacheGateway->cocherTache($Nom, $Liste);
    }

    public function trouverUtilisateur(String $Email, String $Mdp) {
        return $this->UtilisateurGateway->findUtilisateur($Email, $Mdp);
    }

    public function toutesLesListesUtilisateur(String $session) {
        return $this->ListeGateway->findAllListesUtilisateur($session);
    }

    public function ajouterListeUtilisateur(String $Nom, String $session) {
        $this->ListeGateway->ajouterListeUtilisateur($Nom, $session);
    }

    public function supprimerListeUtilisateur(String $Nom, String $session) {
        $this->ListeGateway->delListeUtilisateur($Nom, $session);
    }

    public function ajouterTacheUtilisateur(String $Liste, String $Nom, String $Email) {
        $this->TacheGateway->ajoutTacheUtilisateur($Liste, $Nom,$Email);
    }

    public function supprimerTacheUtilisateur(String $Nom) {
        $this->TacheGateway->delTacheUtilisateur($Nom);
    }

    public function AjouterUtilisateur(String $Email, String $Pseudo, String $Mdp) {
        $this->UtilisateurGateway->ajoutUtilisateur($Email, $Pseudo, $Mdp);
    }

    public function cocherTacheUtilisateur(String $Nom, String $Liste, String $Email) {
        $this->TacheGateway->cocherTacheUtilisateur($Nom, $Liste);
    }

}