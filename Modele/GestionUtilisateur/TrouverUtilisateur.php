<?php

$Email = $_POST['inputEmail'];
$Mdp = $_POST['inputPassword'];

require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/UtilisateurGateway.php");

$user = 'root';
$pass = '';
$dsn = 'mysql:host=localhost;dbname=OdotTest';
$Gateway = new UtilisateurGateway(new Connection($dsn, $user, $pass));

$Utilisateur=$Gateway->findUtilisateur($Email, $Mdp);

session_id($Utilisateur->Email);
session_start();
$_SESSION['Utilisateur']=$Utilisateur->Email;

header('Location: ../../Vue/PagePrivee/PagePrivee.php');