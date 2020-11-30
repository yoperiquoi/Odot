<?php
$Nom=$_POST['AjoutListe'];

$Gateway->ajouterListe($Nom);

header('Location: ../index.php');