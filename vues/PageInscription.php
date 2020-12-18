<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Emrick Pesce, Yoann PERIQUOI">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Inscription Odot</title>

    <!-- Bootstrap core CSS -->
    <link href="BootStrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/jpg" href="vues/Images/OdotLogo.jpg">


    <meta name="theme-color" content="#563d7c">


    <!-- Custom styles for this template -->
    <link href="vues/css/CSSPageInscription.css" rel="stylesheet">
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
                <a class="nav-link" href="?action">Publique<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Privé</a>
            </li>
        </ul>
        <label class="mr-sm-2 text-light mt-2">Invité</label>
        <a href="?action=pageConnection" class="form-inline mt-2 mt-md-0" style="text-decoration: none">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Se connecter</button>
        </a>
    </div>
</nav>
<main role='main' class='container bg-white py-2 px-5 border my-5  p-5 text-center'>
    <form class="form-signin" method="POST" >
        <img class="mb-4" src="vues/Images/OdotLogo.jpg" alt="" width="75" height="75">
        <h1 class="h3 mb-3 font-weight-normal">Inscrivez-vous !</h1>
        <label for="inputEmail" class="sr-only">Adresse mail</label>
        <input type="email" name="inputEmail" class="form-control mb-1 todo-list-input" placeholder="Adresse mail" required autofocus/>
        <input type="text" name="inputPseudo" class="form-control mb-1 todo-list-input" placeholder="Pseudonyme" required autofocus/>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" name="inputPassword" class="form-control mb-1 todo-list-input" placeholder="Mot de passe" required/>
        <button class="btn btn-lg btn-primary btn-block" name="action" value="creerUtilisateur" type="submit">S'incrire</button>
    </form>
</main>
</body>
</html>
