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
    <link rel="shortcut icon" type="image/jpg" href="vues/Images/OdotShortcut.jpg">

    <meta name="theme-color" content="#563d7c">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="vues/js/JSPagePrincipale.js"></script>

    <link href="vues/css/CSSPagePrivee.css" rel="stylesheet">
</head>

<body class="bg">

<nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="?action">
        <img class="mr-2 mb-2" src="vues/Images/OdotShortcut.jpg" alt="" width="23" height="23">
        Odot
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link " href="?action">Publique</a>
            </li>
            <li class="nav-item active">
                <a style="text-decoration: none" class="nav-link " href="#" tabindex="-1" >Privé<span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>

    <label class='mr-sm-2 text-light mt-2'><?php print $pseudo; ?></label>

    <a href="?action=seDeconnecter" class="form-inline mt-2 mt-md-0" style="text-decoration: none">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Se Déconnecter</button>
    </a>
</nav>

<main role='main' class='container bg-white py-3 px-5 border my-5'>
    <h4 class='mt-1 ml-3 col-sm-10'>Ajouter une liste</h4>
    <form  class='d-flex col-12 p-3' method='POST'>
        <input type='text' name='AjoutListe' class='form-control todo-list-input mr-1' placeholder='Nouvelle Liste'>
        <button type='submit' name='action' value='ajouterListePrivee' class='btn btn-primary'>Ajouter</button>
    </form>
    <p class="m-0 ml-5 text-danger font-weight-bold" ><?php print isset($dataVueErreur['erreurListe']) ? $dataVueErreur['erreurTache'] : ""; ?></p>
</main>
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
                </form>";
                if(isset($dataVueErreurNom['erreurTache'])) {
                    if($dataVueErreurNom['erreurTache'] == $ListePrivee) {
                        print "<p class='m-0 ml-4 text-danger font-weight-bold'>".$dataVueErreur['erreurTache']."</p>";
                    }
                }
            
                print "<ul class='list-unstyled shadow-sm mb-1 todo-list'>";
                if ($ListePrivee->Taches != NULL) {
                    $TachesPrivee = $ListePrivee->Taches;
                    foreach ($TachesPrivee as $Tache) {
                        if ($Tache->Effectue == false) {
                            print "
                                    <li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                                        <input type='checkbox' class='ml-4 checkbox'>
                                        <label for='$Tache' id='Tache' class='ml-2 pt-1 label-list col-sm-10 tache'>$Tache</label>
                                        <form method='post'>
                                            <input type='text' name='NomTache' value='$Tache' hidden>
                                            <input type='text' name='IdTache' value='$Tache->Id' hidden>
                                            <button id='delete' name='action' value='supprimerTachePrivee' class='close justify-content-end col-sm1' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </form>
                                    </li>";
                        } else {
                            print "
                                    <li class='d-flex align-items-center p-3 my-3 border-bottom border-gray'>
                                        <input type='checkbox' class='ml-4 checkbox' checked>
                                        <label for='$Tache' id='Tache' class='ml-2 pt-1 label-list col-sm-10 tache'>$Tache</label>
                                        <form method='post'>
                                            <input type='text' name='NomTache' value='$Tache' hidden>
                                            <input type='text' name='IdTache' value='$Tache->Id' hidden>
                                            <button id='delete' name='action' value='supprimerTachePrivee' class='close justify-content-end col-sm1' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </form>
                                    </li>";
                        }
                    }
                    print "</ul>";
                }
                print "</main>";
            }

        }else{
            print "<h5 class='text-center'>Veuillez commencer par créer une liste !</h5>";
        }
    ?>
</main>

</body>

<footer class="d-flex justify-content-center mt-5 bottom-0">
    <main role='main' class='w-100 bg-dark border d-flex justify-content-center pt-3'>
        <nav aria-label="Page navigation navbar navbar-expand">
            <ul class="pagination">
                <?php
                if($nbPages == null && $page == null) {
                    $nbPages = 1;
                    $page = 1;
                }
                ?>
                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="?action=pagePrivee&amp;page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>

                <?php
                if($nbPages < 10){
                    for($p = 1; $p <= $nbPages; $p++): ?>
                        <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?action=pagePrivee&amp;page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php
                    endfor;
                } else {
                    for($p = 1; $p <= 3; $p++): ?>
                        <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?action=pagePrivee&amp;page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php
                    endfor;

                    if($page <= 3 || $page >= $nbPages - 2) {
                        if($page == 3){
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="?action=pagePrivee&amp;page=<?= $page + 1 ?>"><?= $page + 1 ?></a>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="page-item disabled"><a class="page-link " href="#">...</a></li>
                        <?php
                        if($page == $nbPages - 2){
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="?action=pagePrivee&amp;page=<?= $page - 1 ?>"><?= $page - 1 ?></a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                        <?php
                        if($page - 1 != 3) {
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="?action=pagePrivee&amp;page=<?= $page - 1 ?>"><?= $page - 1 ?></a>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="page-item active">
                            <a class="page-link" href="?action=pagePrivee&amp;page=<?= $page ?>"><?= $page ?></a>
                        </li>
                        <?php
                        if($page + 1 != $nbPages - 2) {
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="?action=pagePrivee&amp;page=<?= $page + 1 ?>"><?= $page + 1 ?></a>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                        <?php
                    }

                    for($p = $nbPages - 2; $p <= $nbPages; $p++): ?>
                        <li class="page-item  <?= ($p == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?action=pagePrivee&amp;page=<?= $p ?>"><?= $p ?></a>
                        </li>
                    <?php
                    endfor;
                }
                ?>
                <li class="page-item <?= ($page == $nbPages) ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="?action=pagePrivee&amp;page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </main>
</footer>
</html>