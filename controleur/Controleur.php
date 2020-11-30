<?php

namespace controleur;

use modeles\gestionPersistance\TacheGateway;
use modeles\gestionPersistance\Connection;
use modeles\gestionPersistance\UtilisateurGateway;
use modeles\gestionTaches\Tache;
use modeles\gestionTaches\ListeTache;
use modeles\gestionUtilisateur\Utilisateur;
use config\Validation;


class Controleur
{


    function __construct()
    {
        //A enlever après
        $user = 'root';
        $pass = '';
        $dsn = 'mysql:host=localhost;dbname=OdotTest';



        global $rep, $vues, $css, $bootstrap, $dataVueErreur; // nécessaire pour utiliser variables globales
// on démarre ou reprend la session si necessaire (préférez utiliser un modèle pour gérer vos session ou cookies)
//        session_start();


        $TabErreur = array();

        try {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL;
            $Gateway = new TacheGateway(new Connection($dsn, $user, $pass));
            $GatewayPrivee = new UtilisateurGateway(new Connection($dsn, $user, $pass));

            switch ($action) {

                case NULL:
                    $ListesPublique = $Gateway->findAllListes();
                    require($rep.$vues['pagePrincipale']);
                    break;

                case "ajouterListePublique":
                    $Nom=$_POST['AjoutListe'];

                    if(Validation::val_liste($Nom, $dataVueErreur)) {
                        try {
                            $Gateway->ajouterListe($Nom);
                        } catch (\Exception $e) {
                            $dataVueErreur['erreurListe'] = "Erreur non prise en charge : ".$e->getMessage();
                        }
                    }
                    $ListesPublique = $Gateway->findAllListes();
                    require($rep.$vues['pagePrincipale']);
                    break;

                case "supprimerListePublique":
                    $Nom = $_POST['NomListe'];

                    if(!Validation::val_suppressionListe($Nom, $dataVueErreur)) {
                        //Afficher la page d'erreur !!
                    } else {
                        try {
                            $Gateway->delListe($Nom);
                        } catch (\Exception $e) {
                            $dataVueErreur['pageErreur'] = "Erreur non prise en charge : ".$e->getMessage();
                            //Afficher page erreur
                        }
                    }
                    $ListesPublique = $Gateway->findAllListes();
                    require($rep.$vues['pagePrincipale']);
                    break;

                case "ajouterTachePublique":
                    $Nom=$_POST['Ajout'];
                    $Liste=$_POST['Liste'];

                    if(Validation::val_tache($Nom, $Liste, $dataVueErreur)) {
                        try {
                            $Gateway->ajoutTache($Liste,$Nom);
                        } catch (\Exception $e) {
                            $dataVueErreur['erreurTache'] = "Erreur non prise en charge : ".$e->getMessage();
                        }
                    }
                    $ListesPublique = $Gateway->findAllListes();
                    require($rep.$vues['pagePrincipale']);

                    break;

                case "supprimerTachePublique":
                    $Nom=$_POST['NomTache'];
                    //Faut pas mettre le nom de la liste dans laquelle supprimer ??

                    if(!Validation::val_suppressionTache($Nom, $Liste, $dataVueErreur)) {
                        //Afficher page erreur
                    } else {
                        try {
                            $TachesPublique=$Gateway->delTache($Nom);
                        } catch (\Exception $e) {
                            $dataVueErreur['pageErreur'] = "Erreur non prise en charge : ".$e->getMessage();
                            //Afficher page erreur
                        }
                    }

                    $ListesPublique = $Gateway->findAllListes();
                    require($rep.$vues['pagePrincipale']);
                    break;

                case "pageConnection":
                    require($rep.$vues['pageConnexion']);
                    break;

                case "seConnecter":
                    $Email = $_POST['inputEmail'];
                    $Mdp = $_POST['inputPassword'];

                    $Utilisateur=$GatewayPrivee->findUtilisateur($Email, $Mdp);

                    session_start();
                    $_SESSION['Utilisateur']=$Utilisateur->Email;
                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    require($rep.$vues['pagePrivee']);
                    break;

                case "pagePrivée":
                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    //if(isset($_SESSION['Utilisateur'])){
                    require($rep.$vues['pagePrivee']);
                    //}else{
                    //   require($rep.$vues['pageConnexion']);
                    //}
                    break;

                case "ajouterListePrivee":
                    $Nom=$_POST['AjoutListe'];
                    $GatewayPrivee->ajouterListe($Nom,"yoann_63115@hotmail.fr");

                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    require($rep.$vues['pagePrivee']);
                    break;

                case "supprimerListePrivee":
                    $Nom=$_POST['NomListe'];
                    $GatewayPrivee->delListe($Nom,"yoann_63115@hotmail.fr");

                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    require($rep.$vues['pagePrivee']);
                    break;

                case "ajouterTachePrivee":
                    $Nom=$_POST['Ajout'];
                    $Liste=$_POST['Liste'];
                    $GatewayPrivee->ajoutTache($Liste,$Nom);

                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    require($rep.$vues['pagePrivee']);
                    break;

                case "supprimerTachePrivee":
                    $Nom=$_POST['NomTache'];
                    $TachesPrivee=$GatewayPrivee->delTache($Nom);

                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    require($rep.$vues['pagePrivee']);
                    break;

                case "pageInscription":
                    require($rep.$vues['pageInscription']);
                    break;

                case "creerUtilisateur":
                    $Email=$_POST['inputEmail'];
                    $Mdp=$_POST['inputPassword'];
                    $Pseudo=$_POST['inputPseudo'];
                    $GatewayPrivee->ajoutUtilisateur($Email,$Pseudo,$Mdp);

                    $ListesPrivee = $GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
                    require($rep.$vues['pagePrivee']);
                    break;

//mauvaise action
                default:
                    $dataVueErreur['erreurAppel'] = "Erreur d'appel php";
                    require($rep.$vues['pagePrincipale']);
                    break;
            }
        } catch (Exception $e2) {
            $TabErreur[] = "Erreur métier ! ";
        }

    }
}catch (Exception $e2){ // Récupération des erreur venant du modèle et de l'interaction avec la BDD
    $dataVueErreur[]="Erreur métier ! ";
}catch (PDOException $e) {
    $dataVueErreur[] = "Erreur BDD ! ";
    require(__DIR__."/../../vue/pageErreur/PageErreur.php");
}