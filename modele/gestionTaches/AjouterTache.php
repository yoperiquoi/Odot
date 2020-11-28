<?php
$Nom=$_POST['Ajout'];
$Liste=$_POST['Liste'];


$Gateway->ajoutTache($Liste,$Nom);

header('Location: ../index.php');
