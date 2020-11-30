<?php
$Email=$_POST['inputEmail'];
$Mdp=$_POST['inputPassword'];
$Pseudo=$_POST['inputPseudo'];


$GatewayPrivee->ajoutUtilisateur($Email,$Pseudo,$Mdp);
