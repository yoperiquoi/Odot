<?php


namespace controleur;


use config\Validation;
use modele\Modele;
use \PDOException;

class UtilisateurControleur
{
    function __construct()
    {
        global $dataPageErreur; // nécessaire pour utiliser variables globales
        // on démarre ou reprend la session si necessaire (préférez utiliser un modèle pour gérer vos session ou cookies)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL;

            switch ($action) {
                case NULL:
                case "pagePrivee":
                    if(isset($_SESSION['Utilisateur'])){
                        $this->pagePrivee();
                    }else{
                        $this->pageConnection();
                    }
                    break;

                case "ajouterListePrivee":
                    $this->ajouterListePrivee();
                    break;

                case "supprimerListePrivee":
                    $this->supprimerListePrivee();
                    break;

                case "ajouterTachePrivee":
                    $this->ajouterTachePrivee();
                    break;

                case "supprimerTachePrivee":
                    $this->supprimerTachePrivee();
                    break;

                case "pageConnection":
                    if (isset($_SESSION['Utilisateur'])) {
                        $this->pagePrivee();
                    } else {
                        $this->pageConnection();
                    }
                    break;

                case "seConnecter":
                    $this->seConnecter();
                    break;

                case "pageInscription":
                    $this->pageInscription();
                    break;

                case "creerUtilisateur":
                    $this->creerUtilisateur();
                    break;

                case "seDeconnecter" :
                    $this->seDeconnecter();
                    break;

                //mauvaise action
                default:
                    $dataPageErreur['erreurAppel'] = "Erreur d'appel php";
                    $this->erreur();
                    break;
            }
        } catch (PDOException $e) {
            $dataPageErreur[] = "Erreur BDD ! ";
            $this->erreur();
            return;
        } catch (\Exception $e2) { // Récupération des erreurs venant du modèle et de l'interaction avec la BDD
            $dataPageErreur[] = "Erreur métier ! ";
            $this->erreur();
            return;
        }
    }


    private function pagePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dataVueErreurNom, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        if(!Validation::val_email($_SESSION['Utilisateur'], $dataPageErreur)) {
            $this->erreur();
            return;
        }

        try {
            $ListesPrivee = $m->toutesLesListesUtilisateur($_SESSION['Utilisateur']);
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            $this->erreur();
            return;
        }
        require($rep.$vues['pagePrivee']);
    }

    private function ajouterListePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = $_POST['AjoutListe'];

        if(Validation::val_liste($Nom, $dataVueErreur)) {
            if(!Validation::val_email($_SESSION['Utilisateur'], $dataPageErreur)) {
                $this->erreur();
                return;
            }
            $m->ajouterListeUtilisateur($Nom, $_SESSION['Utilisateur']);
        }
        $this->pagePrivee();
    }

    private function supprimerListePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = $_POST['NomListe'];

        if(!Validation::val_suppressionListe($Nom, $dataVueErreur)) {
            $this->erreur();
            return;
        }

        if(!Validation::val_email($_SESSION['Utilisateur'], $dataPageErreur)) {
            $this->erreur();
            return;
        }

        try {
            $m->supprimerListeUtilisateur($Nom, $_SESSION['Utilisateur']);
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            $this->erreur();
            return;
        }

        $this->pagePrivee();
    }

    private function ajouterTachePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dataVueErreurNom, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = $_POST['Ajout'];
        $Liste = $_POST['Liste'];

        if (Validation::val_tache($Nom, $Liste, $dataVueErreur, $dataVueErreurNom)) {
            try {
                $m->ajouterTacheUtilisateur($Liste, $Nom,$_SESSION['Utilisateur']);
            } catch (PDOException $e) {
                if($e->getCode() == 23000) {
                    $dataVueErreur['erreurTache'] = "Une tâche avec ce nom existe déjà";
                    $dataVueErreurNom['erreurTache'] = $Liste;
                    $this->pagePrivee();
                    return;
                } else {
                    $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                    $this->erreur();
                    return;
                }
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                $this->erreur();
                return;
            }
        }

        $this->pagePrivee();
    }

    private function supprimerTachePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = $_POST['NomTache'];
        $Id = $_POST['IdTache'];

        if(!Validation::val_suppressionTache($Nom, $dataPageErreur)) {
            $this->erreur();
            return;
        }

        try {
            $m->supprimerTacheUtilisateur($Nom,$Id);
        } catch (\Exception $e) {
            $dataPageErreur['erreurTache'] = "Erreur non prise en charge : " . $e->getMessage();
            $this->erreur();
            return;
        }

        $this->pagePrivee();
    }

    private function pageConnection() {
        global $rep, $vues; // nécessaire pour utiliser les variables globales
        require($rep . $vues['pageConnexion']);
    }

    private function seConnecter() {
        global $rep, $vues, $dataVueErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Email = $_POST['inputEmail'];
        $Mdp = $_POST['inputPassword'];

        if(!Validation::val_connection($Email, $Mdp, $dataVueErreur)) {
            $_REQUEST['action'] = "pageConnection";
            require ($rep . $vues['index']);
            return;
        }

        try {
            if($m->trouverUtilisateur($Email, $Mdp)){
                $_SESSION['Utilisateur'] = $Email;
                $this->pagePrivee();
            }else{
                $dataVueErreur['erreurMdp'] = "L'email ou le mot de passe n'est pas correct";
                $_REQUEST['action'] = "pageConnection";
                require ($rep . $vues['index']);
                return;
            }
        } catch (\Exception $e) {
            $dataVueErreur['erreurMdp'] = "L'email ou le mot de passe n'est pas correct";
            $_REQUEST['action'] = "pageConnection";
            require ($rep . $vues['index']);
            return;
        }

    }

    private function seDeconnecter(){
        session_unset();
        session_destroy();
        $_SESSION=array();
        $this->pageConnection();
    }

    private function pageInscription() {
        global $rep, $vues, $dataVueErreur; // nécessaire pour utiliser les variables globales
        require($rep . $vues['pageInscription']);
    }

    private function creerUtilisateur() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Email = $_POST['inputEmail'];
        $Mdp = $_POST['inputPassword'];
        $Pseudo = $_POST['inputPseudo'];

        if(Validation::val_inscription($Pseudo, $Email, $Mdp, $dataVueErreur)) {
            try {
                $m->AjouterUtilisateur($Email, $Pseudo, $Mdp);
                $_SESSION['Utilisateur'] = $Email;
            } catch (\Exception $e) {
                $dataPageErreur['erreurTache'] = "Erreur non prise en charge : " . $e->getMessage();
                $this->erreur();
                return;
            }
        }

        $this->pagePrivee();
    }

    private function erreur() {
        global $rep, $vues, $dataPageErreur; // nécessaire pour utiliser les variables globales
        require($rep . $vues['erreur']);
    }
}