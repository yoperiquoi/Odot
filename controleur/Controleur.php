<?php
//On récupére les identifiant et les localisation de la base de données
$user = 'root';
$pass = '';
$dsn = 'mysql:host=localhost;dbname=OdotTest';

//On require tout ce qui se trouve dans le métier et le fichier de configuration

require_once(__DIR__ . "/../modele/gestionPersistance/Connection.php");
require_once(__DIR__ . "/../modele/gestionTaches/Tache.php");
require_once(__DIR__ . "/../modele/gestionPersistance/TacheGateway.php");
require_once(__DIR__ . "/../modele/gestionPersistance/UtilisateurGateway.php");
require_once(__DIR__ . "/../modele/gestionTaches/ListeTache.php");
require_once(__DIR__ . "/../modele/gestionUtilisateur/Utilisateur.php");
require_once(__DIR__ . '/../config/Validation.php');
//On instancie un tableau d'erreur
$TabErreur=array();


try{
    //Je récupére l'action
    $action=$_REQUEST['action'];
    //Instancie les deux gateways responsable de la gestion des taches et des utilisateurs
    $Gateway=new TacheGateway(new Connection($dsn,$user,$pass));
    $GatewayPrivee=new UtilisateurGateway(new Connection($dsn,$user,$pass));
    //Je récupére les taches publiques
    $ListesPublique=$Gateway->findAllListes();
    //En fonction de l'action j'exécute différents scripts et j'affiche des vues
    switch($action) {

        case NULL:
            require('../vue/pagePrincipale/PagePrincipale.php');
            break;

        case "ajouterListePublique":
            include_once('../modele/gestionTaches/AjouterListe.php');
            require('../vue/pagePrincipale/PagePrincipale.php');
            break;

        case "supprimerListePublique":
            include_once('../modele/gestionTaches/SupprimerListe.php');
            require('../vue/pagePrincipale/PagePrincipale.php');
            break;

        case "ajouterTachePublique":
            include_once('../modele/gestionTaches/AjouterTache.php');
            require('../vue/pagePrincipale/PagePrincipale.php');
            break;

        case "supprimerTachePublique":
            include_once('../modele/gestionTaches/SupprimerTache.php');
            require('../vue/pagePrincipale/PagePrincipale.php');
            break;

        case "pageConnection":
            require('../vue/pageConnexion/PageConnexion.php');
            break;

        case "seConnecter":
            include_once('../modele/gestionUtilisateur/TrouverUtilisateur.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            require('../vue/pagePrivee/PagePrivee.php');
            break;

        case "pagePrivée":
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            //if(isset($_SESSION['Utilisateur'])){
                require('../vue/pagePrivee/PagePrivee.php');
            //}else{
             //   require('../vue/pageConnexion/PageConnexion.php');
            //}
            break;

        case "ajouterListePrivee":
            include_once('../modele/gestionUtilisateur/AjouterListe.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            require('../vue/pagePrivee/PagePrivee.php');
            break;

        case "supprimerListePrivee":
            include_once('../modele/gestionUtilisateur/SupprimerListe.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            require('../vue/pagePrivee/PagePrivee.php');
            break;

        case "ajouterTachePrivee":
            include_once('../modele/gestionUtilisateur/AjouterTache.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            require('../vue/pagePrivee/PagePrivee.php');
            break;

        case "supprimerTachePrivee":
            include_once('../modele/gestionUtilisateur/SupprimerTache.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            require('../vue/pagePrivee/PagePrivee.php');
            break;

        case "pageInscription":
            require('../vue/pageInscription/PageInscription.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            break;

        case "créerUtilisateur":
            include_once('../modele/gestionUtilisateur/AjouterUtilisateur.php');
            $ListesPrivee=$GatewayPrivee->findAllListesUtilisateur("yoann_63115@hotmail.fr");
            require('../vue/pagePrivee/PagePrivee.php');
            break;

        //Si mauvaise action
        default:
            $dataVueErreur[] =	"Erreur d'appel php !";
            require (__DIR__.'../../vue/pagePrincipale/PagePrincipale.php');
            break;
    }
}catch (Exception $e2){ // Récupération des erreur venant du modèle et de l'interaction avec la BDD
    $dataVueErreur[]="Erreur métier ! ";
}catch (PDOException $e) {
    $dataVueErreur[] = "Erreur BDD ! ";
    require(__DIR__."/../../vue/pageErreur/PageErreur.php");
}