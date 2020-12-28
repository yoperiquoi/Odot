<?php


namespace controleur;

use modele\Modele;
use config\Validation;
use \PDOException;

class PubliqueControleur
{

    function __construct()
    {

        global $dataPageErreur; // nécessaire pour utiliser variables globales

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

                case "cocheTachePublique":
                    $this->cocheTachePublique();
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
        global $rep, $vues, $dataPageErreur, $dataVueErreur, $dataVueErreurNom, $pseudo, $nbListesPages, $nbPages, $page; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $page = Validation::val_page(isset($_GET["page"]) ? $_GET["page"] : 1);
        $nbPages = ceil($m->nbListes()/$nbListesPages);
        if($page < 1 || $page > $nbPages) $page = 1;

        try {
            $ListesPublique = $m->toutesLesListes($page, $nbListesPages);
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            $this->erreur();
            return;
        }

        if(isset($_SESSION['Utilisateur']) && Validation::val_email($_SESSION['Utilisateur'], $autre)) {
            $pseudo = $m->getPseudoUtilisateur($_SESSION['Utilisateur']);
        }

        require($rep . $vues['pagePrincipale']);
    }

    private function ajouterListePublique() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new Modele();

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
                    $this->erreur();
                    return;
                }
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                $this->erreur();
                return;
            }
        }

        $this->pagePrincipale();
    }

    private function supprimerListePublique() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = $_POST['NomListe'];

        if (!Validation::val_suppressionListe($Nom, $dataPageErreur)) {
            $this->erreur();
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
                $this->erreur();
                return;
            }
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            $this->erreur();
            return;
        }

        $this->pagePrincipale();
    }

    private function ajouterTachePublique() {
        global $rep, $vues, $dataVueErreur, $dataPageErreur, $dataVueErreurNom; // nécessaire pour utiliser les variables globales
        $m = new Modele();

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
                    $this->erreur();
                    return;
                }
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                $this->erreur();
                return;
            }
        }

        $this->pagePrincipale();
    }

    private function supprimerTachePublique() {
        global $rep, $vues, $dataPageErreur, $dataVueErreur; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = $_POST['NomTache'];

        if (!Validation::val_suppressionTache($Nom, $dataPageErreur)) {
            $this->erreur();
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
                $this->erreur();
                return;
            }
        } catch (\Exception $e) {
            $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
            $this->erreur();
            return;
        }

        $this->pagePrincipale();
    }

    private function cocheTachePublique() {
        global $rep, $vues, $dataPageErreur; // nécessaire pour utiliser les variables globales
        $m = new Modele();

        $Nom = "Arroser les plantes";
        $Liste= "Artistique";




        if (Validation::val_cocheTache($Nom, $Liste, $dataPageErreur)) {
            try {
                $m->cocherTache($Nom, $Liste);
            } catch (PDOException $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                $this->erreur();
                return;
            } catch (\Exception $e) {
                $dataPageErreur[] = "Erreur non prise en charge : " . $e->getMessage();
                $this->erreur();
                return;
            }
        }

        $this->pagePrincipale();
    }

    private function erreur() {
        global $rep, $vues, $dataPageErreur; // nécessaire pour utiliser les variables globales
        require($rep . $vues['erreur']);
    }

}