<?php

require_once("../../Modele/GestionPersistance/Connection.php");
require_once("../../Modele/GestionPersistance/TacheGateway.php");

$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
$Gateway=new TacheGateway(new Connection($dsn,$user,$pass));
/*
if ($_POST['Ajout']) {
    $Nom=$_POST['Ajout'];

    $Gateway->ajoutTache($Nom);

    header('Location: ../../Vue/PagePrincipale/PagePrincipale.php');
}
*/
if($_POST['Suppression']) {
    print $_POST['NomTache'];
    print "test";
}



