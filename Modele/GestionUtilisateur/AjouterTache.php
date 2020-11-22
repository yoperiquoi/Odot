<?php
$Nom=$_POST['Ajout'];
$Liste=$_POST['Liste'];


require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/UtilisateurGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new UtilisateurGateway(new Connection($dsn,$user,$pass));

$Gateway->ajoutTache($Liste,$Nom);

header('Location: ../../Vue/PagePrivee/PagePrivee.php');
