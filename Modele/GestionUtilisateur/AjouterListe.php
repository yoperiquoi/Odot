<?php
$Nom=$_POST['AjoutListe'];



require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/UtilisateurGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new UtilisateurGateway(new Connection($dsn,$user,$pass));

$Gateway->ajouterListe($Nom,"yoann_63115@hotmail.fr");

header('Location: ../../Vue/PagePrincipale/PagePrivee.php');