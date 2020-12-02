
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

    <meta name="theme-color" content="#563d7c">

    <link href="vue/PagePrincipale/CSSPagePrincipale.css" rel="stylesheet">


</head>

<body class="bg">

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="#">Odot</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link active" href="#">Publique<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?action=pagePrivee" tabindex="-1" aria-disabled="true">Privé</a>
            </li>
        </ul>
        <label class="mr-sm-2 text-light mt-2">Invité</label>
        <a href="?action=pageConnection" class="form-inline mt-2 mt-md-0" style="text-decoration: none">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Se connecter</button>
        </a>
    </div>
</nav>

<?php
//if(isset($dataVueErreur)){
//    foreach ($dataVueErreur as $erreur) {
//        print "<div class='mt-2 alert alert-danger alert-dismissible fade show text-center ' role='alert'>
//         $erreur
//          </div>";
//    }
//}
?>

<main role='main' class='container bg-white py-3 px-5 border my-5'>
    <h4 class='mt-1 ml-3 col-sm-10'>Ajouter une liste</h4>
    <form  class='d-flex col-12 p-3' method='POST'>
        <input type='text' name='AjoutListe' class='form-control todo-list-input mr-1' placeholder='Nouvelle Liste'>
        <button type='submit' name="action" value="ajouterListePublique" class='btn btn-primary'>Ajouter</button>
    </form>
    <p class="m-0 ml-4 text-danger font-weight-bold" ><?php print isset($dataVueErreur['erreurListe']) ? $dataVueErreur['erreurListe'] : ""; ?></p>
</main>
<main role='main' class='container bg-white py-2 px-5 border '>
    <?php
        if($ListesPublique!=NULL) {
            foreach ($ListesPublique as $ListePublique) {
                print"
            <main role='main' class='container bg-white py-2 px-5 border my-5'>
            <form method='post' >
                    <input type='text' name='NomListe' value='$ListePublique' hidden>
                    <button id='delete' name='action' value='supprimerListePublique' class='close justify-content-end col-sm1' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
            </form>
            <h5 class='mt-3 ml-3 col-sm-10'>$ListePublique</h5>
            <form  class='d-flex col-12 p-3' method='POST'>
                <input type='hidden' name='Liste' value='$ListePublique'/>
                <input type='text' name='Ajout' class='form-control todo-list-input mr-1' placeholder='Nouvelle Tache'>
                <button type='submit' name='action' value='ajouterTachePublique' class='btn btn-primary'>Ajouter</button>
            </form>";
                if(isset($dataVueErreur['erreurTache'])) {
                    if($dataVueErreurNom['erreurTache'] == $ListePublique) {
                        print "<p class='m-0 ml-4 text-danger font-weight-bold'>".$dataVueErreur['erreurTache']."</p>";
                    }
                }

    print "<ul class='list-unstyled shadow-sm mb-1'>";
                if ($ListePublique->Taches != NULL) {
                    $TachesPublique = $ListePublique->Taches;
                    foreach ($TachesPublique as $Tache) {
                        if ($Tache->Effectue == false) {
                            print "<li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                    <input type='checkbox' class='ml-4'>
                    <label class='ml-2 pt-1 label-list col-sm-10'>$Tache</label>
                    <form method='post'>
                    <input type='text' name='NomTache' value='$Tache' hidden>
                    <button id='delete' name='action' value='supprimerTachePublique' class='close justify-content-end col-sm1' aria-label='Close'>
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
                    <button id='delete' name='action' value='supprimerTachePublique' class='close justify-content-end col-sm1' aria-label='Close'>
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
            print "<h5 class='text-center mt-2'>Veuillez commencer par créer une liste !</h5>";
        }
        ?>
</main>

</body>
</html>