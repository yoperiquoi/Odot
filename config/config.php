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
$vues['erreur']='vue/PageErreur.php';
$vues['pageConnexion']='vue/PageConnexion.php';
$vues['pageInscription']='vue/PageInscription.php';
$vues['pagePrincipale']='vue/PagePrincipale.php';
$vues['pagePrivee']='vue/PagePrivee.php';
/*
//CSS

$css['pageConnexion']='vue/pageConnexion/CSSPageConnexion.php';
$css['pageInscription']='vue/pageInscription/CSSPageInscription.php';
$css['pagePrincipale']='vue/pagePrincipale/CSSPagePrincipale.php';

//BootStrap

$bootstrap['min.css']='BootStrap/css/bootstrap.min.css';
*/
?>






