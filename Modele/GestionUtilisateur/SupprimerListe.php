<?php
$Nom=$_POST['NomListe'];



require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/TacheGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new UtilisateurGateway(new Connection($dsn,$user,$pass));

$Gateway->delListe($Nom,"yoann_63115@hotmail.fr");

header('Location: ../../Vue/PagePrincipale/PagePrivee.php');