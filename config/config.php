<?php

//gen
$rep=__DIR__.'/../';

// liste des modules à inclure

//$dConfig['includes']= array('controleur/Validation.php');


//BD
$user = 'root';
$pass = '';
$dsn = 'mysql:host=localhost;dbname=OdotTest';

//Vues

$vues['index']='index.php';
$vues['erreur']='vues/PageErreur.php';
$vues['pageConnexion']='vues/PageConnexion.php';
$vues['pageInscription']='vues/PageInscription.php';
$vues['pagePrincipale']='vues/PagePrincipale.php';
$vues['pagePrivee']='vues/PagePrivee.php';
/*
//CSS

$css['pageConnexion']='vues/pageConnexion/CSSPageConnexion.php';
$css['pageInscription']='vues/pageInscription/CSSPageInscription.php';
$css['pagePrincipale']='vues/pagePrincipale/CSSPagePrincipale.php';

//BootStrap

$bootstrap['min.css']='BootStrap/css/bootstrap.min.css';
*/
?>






