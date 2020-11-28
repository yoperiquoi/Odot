<?php
$user = 'root';
$pass = '';
$dsn = 'mysql:host=localhost;dbname=OdotTest';

require_once(__DIR__ . "/../modele/gestionPersistance/Connection.php");
require_once(__DIR__ . "/../modele/gestionTaches/Tache.php");
require_once(__DIR__ . "/../modele/gestionPersistance/TacheGateway.php");
require_once(__DIR__ . "/../modele/gestionPersistance/UtilisateurGateway.php");
require_once(__DIR__ . "/../modele/gestionTaches/ListeTache.php");
require_once(__DIR__ . "/../modele/gestionUtilisateur/Utilisateur.php");
require_once(__DIR__ . '/../config/Validation.php');
$TabErreur=array();

try{
    $action=$_REQUEST['action'];
    print"$action";
    $Gateway=new TacheGateway(new Connection($dsn,$user,$pass));
    $GatewayPrivee=new UtilisateurGateway(new Connection($dsn,$user,$pass));
    $ListesPublique=$Gateway->findAllListes();
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

//mauvaise action
        default:
            $dataVueErreur[] =	"Erreur d'appel php";
            require (__DIR__.'../../vue/pagePrincipale/PagePrincipale.php');
            break;
    }
}catch (Exception $e2){
    $TabErreur[]="Erreur métier ! ";
}