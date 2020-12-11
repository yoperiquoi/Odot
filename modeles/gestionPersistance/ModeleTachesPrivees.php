<?php


namespace modeles\gestionPersistance;


use DAL\UtilisateurGateway;

class ModeleTachesPrivees
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new UtilisateurGateway();
    }

    public function trouverUtilisateur(String $Email, String $Mdp) {
        return $this->gateway->findUtilisateur($Email, $Mdp);
    }

    public function toutesLesListes(String $session) {
        return $this->gateway->findAllListesUtilisateur($session);
    }

    public function ajouterListe(String $Nom, String $session) {
        $this->gateway->ajouterListe($Nom, $session);
    }

    public function supprimerListe(String $Nom, String $session) {
        $this->gateway->delListe($Nom, $session);
    }

    public function ajouterTache(String $Liste, String $Nom, String $Email) {
        $this->gateway->ajoutTache($Liste, $Nom,$Email);
    }

    public function supprimerTache(String $Nom) {
        $this->gateway->delTache($Nom);
    }

    public function AjouterUtilisateur(String $Email, String $Pseudo, String $Mdp) {
        $this->gateway->ajoutUtilisateur($Email, $Pseudo, $Mdp);
    }

    public function cocherTache(String $Nom, String $Liste, String $Email) {
        $this->gateway->cocherTache($Nom, $Liste, $Email);
    }
}