<?php
$Nom=$_POST['AjoutListe'];



require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/TacheGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new TacheGateway(new Connection($dsn,$user,$pass));

$Gateway->ajouterListe($Nom);

header('Location: ../../Vue/PagePrincipale/PagePrincipale.php');