<?php
$Nom=$_POST['NomTache'];

$TachesPublique=$Gateway->delTache($Nom);

header('Location: ../index.php');

