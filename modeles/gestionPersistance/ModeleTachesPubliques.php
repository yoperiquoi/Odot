<?php


namespace modeles\gestionPersistance;


use DAL\TacheGateway;

class ModeleTachesPubliques
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new TacheGateway();
    }

    public function toutesLesListes() {
        return $this->gateway->findAllListes();
    }

    public function ajouterListe(String $Nom) {
        $this->gateway->ajouterListe($Nom);
    }

    public function supprimerListe(String $Nom) {
        $this->gateway->delListe($Nom);
    }

    public function ajouterTache(String $Liste, String $Nom) {
        $this->gateway->ajoutTache($Liste, $Nom);
    }

    public function supprimerTache(String $Nom) {
        $this->gateway->delTache($Nom);
    }

}