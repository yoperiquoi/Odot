<?php

$Email = $_POST['inputEmail'];
$Mdp = $_POST['inputPassword'];

$Utilisateur=$GatewayPrivee->findUtilisateur($Email, $Mdp);

session_start();
$_SESSION['Utilisateur']=$Utilisateur->Email;
