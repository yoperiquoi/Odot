<?php
require_once "../../Modele/GestionPersistance/Connection.php";
require_once "../../Modele/GestionTaches/Tache.php";
require_once "../../Modele/GestionPersistance/TacheGateway.php";
$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=OdotTest';
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Page de type Todo dans le cadre d'un projet de DUT Informatique">
    <meta name="author" content="Emrick Pesce, Yoann Periquoi">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Odot</title>

    <!-- Bootstrap core CSS -->
    <link href="../../BootStrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


    <meta name="theme-color" content="#563d7c">


    <!-- Custom styles for this template -->
    <link href="CSSPagePrincipale.css" rel="stylesheet">

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <a class="navbar-brand" href="#">Odot</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Publique<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Privé</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <label class="mr-sm-2 text-light">Invité</label>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Se connecter</button>
            </form>
        </div>
    </nav>
</head>

<body>

<main role="main" class="container bg-white py-2 px-5 border my-5">
    <h5 class="mt-3 ml-3">Magnifique Todo list</h5>

    <form action="../../Modele/GestionTaches/Ajouter.php" class="d-flex col-12 p-3" method="POST">
        <input type="text" name="Ajout" class="form-control todo-list-input mr-1" placeholder="Que doit-on faire aujourd'hui ?">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <ul class="list-unstyled shadow-sm">

        <?php
        $Gateway=new TacheGateway(new Connection($dsn,$user,$pass));
        $TachesPublique=$Gateway->findAllTaches();
        foreach ($TachesPublique as $Tache){
            if($Tache->Effectue==false){
                print "<li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                <input type='checkbox' class='ml-4'>
                <label class='ml-2 pt-1 label-list col-sm-10'>$Tache</label>
                <form method='post' action='../../Modele/GestionTaches/supprimer.php'>
                <input type='text' name='NomTache' value='$Tache' hidden>
                <button id='delete' class='close justify-content-end col-sm1' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                </form>
                </li>";
            }else{
                print "<li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                <input type='checkbox' class='ml-4' checked>
                <label class='ml-2 pt-1 label-list col-sm-10'>$Tache</label>
                <form method='post' action='../../Modele/GestionTaches/supprimer.php'>
                <input type='text' name='NomTache' value='$Tache' hidden>
                <button id='delete' class='close justify-content-end col-sm1' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                </form>
                </li>";
            }
        }
        ?>

    </ul>

</main>

</body>
</html>