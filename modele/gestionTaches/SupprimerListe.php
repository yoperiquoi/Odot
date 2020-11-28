<?php

$Nom = $_POST['NomListe'];

$Gateway->delListe($Nom);

header('Location: ../index.php');