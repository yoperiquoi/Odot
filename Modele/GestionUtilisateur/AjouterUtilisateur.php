<?php
$Email=$_POST['inputEmail'];
$Mdp=$_POST['inputPassword'];
$Pseudo=$_POST['inputPseudo'];

require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/UtilisateurGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new UtilisateurGateway(new Connection($dsn,$user,$pass));

$Gateway->ajoutUtilisateur($Email,$Pseudo,$Mdp);

header('Location: ../../Vue/PagePrincipale/PagePrivee.php');