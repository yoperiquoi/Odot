<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Page de type Todo dans le cadre d'un projet de DUT Informatique">
    <meta name="author" content="Emrick Pesce, Yoann Periquoi">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Odot</title>

    <link href="BootStrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/jpg" href="Images/OdotShortcut.jpg">
    <link href="vue/pagePrivee/CSSPagePrivee.css" rel="stylesheet">

    <meta name="theme-color" content="#563d7c">


</head>

<body class="bg">

<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="?action">Odot</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link " href="?action">Publique</a>
            </li>
            <li class="nav-item active">
                <a style="text-decoration: none" class="nav-link " href="#" tabindex="-1" aria-disabled="true">Privé<span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>

<main role='main' class='container bg-white py-3 px-5 border my-5'>
    <h4 class='mt-1 ml-3 col-sm-10'>Ajouter une liste</h4>
    <form  class='d-flex col-12 p-3' method='POST'>
        <input type='text' name='AjoutListe' class='form-control todo-list-input mr-1' placeholder='Nouvelle Liste'>
        <button type='submit' name='action' value='ajouterListePrivee' class='btn btn-primary'>Ajouter</button>
    </form>
    <p class="m-0 ml-5 text-danger font-weight-bold" ><?php print isset($dataVueErreur['erreurListe']) ? $dataVueErreur['erreurTache'] : ""; ?></p>
</main>
<p class="m-0 ml-5 text-danger font-weight-bold" ><?php print isset($dataVueErreur['erreurTache']) ? $dataVueErreur['erreurTache'] : ""; ?></p>
<main role='main' class='container bg-white py-2 px-5 border my-5'>
    <?php
    if($ListesPrivee!=NULL){
    foreach ($ListesPrivee as $ListePrivee) {
        print"
        <main role='main' class='container bg-white py-2 px-5 border my-5'>
        <form method='post' >
            <input type='text' name='NomListe' value='$ListePrivee' hidden>
            <button id='delete' name='action' value='supprimerListePrivee' class='mt-3 close justify-content-end col-sm1' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </form>
        <h5 class='mt-3 ml-3 col-sm-10'>$ListePrivee</h5>
        <form  class='d-flex col-12 p-3' method='POST'>
            <input type='hidden' name='Liste' value='$ListePrivee'/>
            <input type='text' name='Ajout' class='form-control todo-list-input mr-1' placeholder='Nouvelle Tache'>
            <button type='submit' name='action' value='ajouterTachePrivee' class='btn btn-primary'>Ajouter</button>
        </form>
    
        <ul class='list-unstyled shadow-sm mb-1'>";
        if ($ListePrivee->Taches != NULL) {
            $TachesPrivee = $ListePrivee->Taches;
            foreach ($TachesPrivee as $Tache) {
                if ($Tache->Effectue == false) {
                    print "<li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                <input type='checkbox' class='ml-4'>
                <label class='ml-2 pt-1 label-list col-sm-10'>$Tache</label>
                <form method='post' >
                <input type='text' name='NomTache' value='$Tache' hidden>
                <button id='delete' name='action' value='supprimerTachePrivee' class='close justify-content-end col-sm1' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                </form>
                </li>";
                } else {
                    print "<li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                <input type='checkbox' class='ml-4' checked>
                <label class='ml-2 pt-1 label-list col-sm-10'>$Tache</label>
                <form method='post' >
                <input type='text' name='NomTache' value='$Tache' hidden>
                <button id='delete' name='action' value='supprimerTachePrivee' class='close justify-content-end col-sm1' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                </form>
                </li>
                </ul>";
                }
            }
        }
        print "</main>";
    }

    }else{
        print "<h5 class='text-center'>Veuillez commencer par créer une liste !</h5>";
    }
    ?>
</main>

</body>
</html>