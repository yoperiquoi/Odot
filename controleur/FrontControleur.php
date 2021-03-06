<?php


namespace controleur;


use config\Validation;
use \PDOException;

class FrontControleur
{
    function __construct()
    {
        global $dataPageErreur, $rep, $vues, $nbListesPages, $nbPages; // nécessaire pour utiliser variables globales
        $nbListesPages = 3;

        // on démarre ou reprend la session si necessaire (préférez utiliser un modèle pour gérer vos session ou cookies)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $tabPublique = array("ajouterListePublique", "supprimerListePublique", "ajouterTachePublique", "supprimerTachePublique",
            "cocheTachePublique");

        $tabUser = array("pagePrivee", "ajouterListePrivee", "supprimerListePrivee", "ajouterTachePrivee", "supprimerTachePrivee",
            "pageConnection", "seConnecter", "pageInscription", "creerUtilisateur","seDeconnecter","cocheTachePrivee");

        try {
            $action = Validation::val_action($action);
            if(in_array($action, $tabUser)) {
                if(!isset($_SESSION["Utilisateur"])) {
                    new UtilisateurControleur();
                } else {
                    new UtilisateurControleur();
                }
            } else if(in_array($action, $tabPublique) || $action == NULL) {
                new PubliqueControleur();
            } else {
                $dataPageErreur['erreurAppel'] = "Erreur d'appel php";
                require($rep . $vues['erreur']);
            }

        } catch (PDOException $e) {
            $dataPageErreur[] = "Erreur BDD ! ";
            require($rep . $vues['erreur']);
            return;
        } catch (\Exception $e2) { // Récupération des erreurs venant du modèle et de l'interaction avec la BDD
            $dataPageErreur[] = "Erreur métier ! ";
            require($rep . $vues['erreur']);
            return;
        }
    }

}