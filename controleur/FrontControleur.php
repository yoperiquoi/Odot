<?php


namespace controleur;


use \PDOException;

class FrontControleur
{
    function __construct()
    {
        global $dataPageErreur, $rep, $vues; // nécessaire pour utiliser variables globales

        $tabPublique = array("ajouterListePublique", "supprimerListePublique", "ajouterTachePublique", "supprimerTachePublique",
            "cocheTachePublique");

        $tabUser = array("pagePrivee", "ajouterListePrivee", "supprimerListePrivee", "ajouterTachePrivee", "supprimerTachePrivee",
            "pageConnection", "seConnecter", "pageInscription", "creerUtilisateur","seDeconnecter");

        try {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL;;
            //TODO : Nettoyer l'action
            if(in_array($action, $tabUser)) {
                if(!isset($_SESSION["Utilisateur"])) {
                    new UtilisateurControleur();
                    //TODO : Connection
                } else {
                    new UtilisateurControleur();
                    //TODO : Appelle controleur prive
                }
            } else if(in_array($action, $tabPublique) || $action == NULL) {
                new PubliqueControleur();
                //TODO : Appelle controleur publique
            } else {
                $dataPageErreur['erreurAppel'] = "Erreur d'appel php";
                require($rep . $vues['erreur']);
                //TODO : Appel vue erreur
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