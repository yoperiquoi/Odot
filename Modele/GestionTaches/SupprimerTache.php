<?php

$Nom=$_POST['NomTache'];

require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/TacheGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new TacheGateway(new Connection($dsn,$user,$pass));

$TachesPublique=$Gateway->delTache($Nom);

header('Location: ../../Vue/PagePrincipale/PagePrincipale.php');

