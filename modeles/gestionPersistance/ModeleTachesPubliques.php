<?php


namespace modeles\gestionPersistance;


use DAL\TacheGateway;
use DAL\ListeGateway;

class ModeleTachesPubliques
{
    private $ListeGateway;
    private $TacheGateway;

    public function __construct()
    {
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

}