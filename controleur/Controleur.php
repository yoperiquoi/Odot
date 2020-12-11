<?php

namespace controleur;

use modeles\gestionPersistance\ModeleTachesPrivees;
use modeles\gestionPersistance\ModeleTachesPubliques;
use config\Validation;
use PDOException;


class Controleur
{
    function __construct()
    {

        global $dataPageErreur; // nécessaire pour utiliser variables globales
// on démarre ou reprend la session si necessaire (préférez utiliser un modèle pour gérer vos session ou cookies)
        session_start();

        try {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL;

            switch ($action) {
                case NULL:
                    $this->pagePrincipale();
                    break;

                case "ajouterListePublique":
                    $this->ajouterListePublique();
                    break;

                case "supprimerListePublique":
                    $this->supprimerListePublique();
                    break;

                case "ajouterTachePublique":
                    $this->ajouterTachePublique();
                    break;

                case "supprimerTachePublique":
                    $this->supprimerTachePublique();
                    break;

                case "pageConnection":
                    if(isset($_SESSION['Utilisateur'])){
                       $this->pagePrivee();
                    }else {
                        $this->pageConnection();
                    }
                    break;

                case "seConnecter":
                    $this->seConnecter();
                    break;

                case "pagePrivee":
                    $this->pagePrivee();
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

                case "pageInscription":
                    $this->pageInscription();
                    break;

                case "creerUtilisateur":
                    $this->creerUtilisateur();
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

    private function pagePrincipale() {
        global $rep, $vues, $dataPageErreur, $dataVueErreur, $dataVueErreurNom; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPubliques();

        try {
            $ListesPublique = $m->toutesLesListes();
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            require($rep . $vues['erreur']);
            return;
        }
        require($rep . $vues['pagePrincipale']);
    }

    private function ajouterListePublique() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPubliques();

        $Nom = $_POST['AjoutListe'];

        if (Validation::val_liste($Nom, $dataVueErreur)) {
            try {
                $m->ajouterListe($Nom);
            } catch (PDOException $e) {
                if($e->getCode() == 23000) {
                    $dataVueErreur['erreurListe'] = "Une liste avec ce nom existe déjà";
                    $_REQUEST['action'] = null;
                    require($rep.$vues['index']);
                    return;
                } else {
                    $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                    require($rep . $vues['erreur']);
                    return;
                }
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                require($rep . $vues['erreur']);
                return;
            }
        }

        $this->pagePrincipale();
    }

    private function supprimerListePublique() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPubliques();

        $Nom = $_POST['NomListe'];

        if (!Validation::val_suppressionListe($Nom, $dataPageErreur)) {
            require($rep . $vues['erreur']);
            return;
        }
        try {
            $m->supprimerListe($Nom);
        } catch (PDOException $e) {
            if($e->getCode() == 1) {
                $dataVueErreur['erreurListe'] = "La liste à supprimer n'existe pas, veuillez réessayer";
                $_REQUEST['action'] = null;
                require($rep.$vues['index']);
                return;
            } else {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage() ." Code :".$e->getCode();
                require($rep . $vues['erreur']);
                return;
            }
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            require($rep . $vues['erreur']);
            return;
        }

        $this->pagePrincipale();
    }

    private function ajouterTachePublique() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dataVueErreurNom; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPubliques();

        $Nom = $_POST['Ajout'];
        $Liste = $_POST['Liste'];

        if (Validation::val_tache($Nom, $Liste, $dataVueErreur, $dataVueErreurNom)) {
            try {
                $m->ajouterTache($Liste, $Nom);
            } catch (PDOException $e) {
                if($e->getCode() == 23000) {
                    $dataVueErreur['erreurTache'] = "Une tâche avec ce nom existe déjà";
                    $dataVueErreurNom['erreurTache'] = $Liste;
                    $_REQUEST['action'] = null;
                    require($rep.$vues['index']);
                    return;
                } else {
                    $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                    require($rep . $vues['erreur']);
                    return;
                }
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                require($rep . $vues['erreur']);
                return;
            }
        }

        $this->pagePrincipale();
    }

    private function supprimerTachePublique() {
        global $rep, $vues, $dataPageErreur, $dataVueErreur; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPubliques();

        $Nom = $_POST['NomTache'];

        if (!Validation::val_suppressionTache($Nom, $dataPageErreur)) {
            require($rep . $vues['erreur']);
            return;
        }
        try {
            $m->supprimerTache($Nom);
        } catch (PDOException $e) {
            if($e->getCode() == 1) {
                $dataVueErreur['erreurListe'] = $e->getMessage();
                $_REQUEST['action'] = null;
                require($rep.$vues['index']);
                return;
            } else {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                require($rep . $vues['erreur']);
                return;
            }
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            require($rep . $vues['erreur']);
            return;
        }

        $this->pagePrincipale();
    }

    private function pageConnection() {
        global $rep, $vues; // nécessaire pour utiliser les variables globales
        require($rep . $vues['pageConnexion']);
    }

    private function seConnecter() {
        global $rep, $vues, $dataVueErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        $Email = $_POST['inputEmail'];
        $Mdp = $_POST['inputPassword'];

        if(!Validation::val_connection($Email, $Mdp, $dataVueErreur)) {
            $_REQUEST['action'] = "pageConnection";
            require ($rep . $vues['index']);
            return;
        }

        try {
            $Utilisateur = $m->trouverUtilisateur($Email, $Mdp);
        } catch (\Exception $e) {
            $dataVueErreur['erreurMdp'] = "L'email ou le mot de passe n'est pas correct";
            $_REQUEST['action'] = "pageConnection";
            require ($rep . $vues['index']);
            return;
        }

        if($Utilisateur == null) {
            $dataVueErreur['erreurMdp'] = "L'email ou le mot de passe n'est pas correct";
            $_REQUEST['action'] = "pageConnection";
            require ($rep . $vues['index']);
            return;
        }

        $_SESSION['Utilisateur'] = $Utilisateur->Email;

        $this->pagePrivee();
    }

    private function pagePrivee() {
        global $rep, $vues, $dataPageErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        if(!Validation::val_email($_SESSION['Utilisateur'], $dataPageErreur)) {
            require($rep . $vues['erreur']);
            return;
        }

        try {
            $ListesPrivee = $m->toutesLesListes($_SESSION['Utilisateur']);
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            require($rep . $vues['erreur']);
            return;
        }
        require($rep.$vues['pagePrivee']);
    }

    private function ajouterListePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        $Nom = $_POST['AjoutListe'];

        if(Validation::val_liste($Nom, $dataVueErreur)) {
            if(!Validation::val_email($_SESSION['Utilisateur'], $dataPageErreur)) {
                require($rep . $vues['erreur']);
                return;
            }
            $m->ajouterListe($Nom, $_SESSION['Utilisateur']);
        }
        $this->pagePrivee();
    }

    private function supprimerListePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        $Nom = $_POST['NomListe'];

        if(!Validation::val_suppressionListe($Nom, $dataVueErreur)) {
            require($rep . $vues['erreur']);
            return;
        }

        if(!Validation::val_email($_SESSION['Utilisateur'], $dataPageErreur)) {
            require($rep . $vues['erreur']);
            return;
        }

        try {
            $m->supprimerListe($Nom, $_SESSION['Utilisateur']);
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            require($rep . $vues['erreur']);
            return;
        }

        $this->pagePrivee();
    }

    private function ajouterTachePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dsn, $user, $pass; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        $Nom = $_POST['Ajout'];
        $Liste = $_POST['Liste'];

        if (Validation::val_tache($Nom, $Liste, $dataVueErreur, $dataVueErreurNom)) {
            try {
                $m->ajouterTache($Liste, $Nom,$_SESSION['Utilisateur']);
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                require($rep . $vues['erreur']);
                return;
            }
        }

        $this->pagePrivee();
    }

    private function supprimerTachePrivee() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        $Nom = $_POST['NomTache'];

        if(!Validation::val_suppressionTache($Nom, $dataPageErreur)) {
            require($rep . $vues['erreur']);
            return;
        }

        try {
            $m->supprimerTache($Nom);
        } catch (\Exception $e) {
            $dataPageErreur['erreurTache'] = "Erreur non prise en charge : " . $e->getMessage();
            require($rep . $vues['erreur']);
            return;
        }

        $this->pagePrivee();
    }

    private function pageInscription() {
        global $rep, $vues, $dataVueErreur; // nécessaire pour utiliser les variables globales
        require($rep . $vues['pageInscription']);
    }

    private function creerUtilisateur() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new ModeleTachesPrivees();

        $Email = $_POST['inputEmail'];
        $Mdp = $_POST['inputPassword'];
        $Pseudo = $_POST['inputPseudo'];

        if(Validation::val_inscription($Pseudo, $Email, $Mdp, $dataVueErreur)) {
            try {
                $m->AjouterUtilisateur($Email, $Pseudo, $Mdp);
            } catch (\Exception $e) {
                $dataPageErreur['erreurTache'] = "Erreur non prise en charge : " . $e->getMessage();
                require($rep . $vues['erreur']);
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
