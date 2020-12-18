<html>
<head>
    <title>Erreur</title>
    <link href="vue/css/CSSPageErreur.css" rel="stylesheet">
    <link href="BootStrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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

</head>
<body class="bg">
<main role='main' class='container bg-white py-2 px-5 border my-5  p-5 text-center'>
<h1>Il y a eu une erreur durant le traitement des données !!</h1>
    <main role='main' class='container bg-white py-2 px-5 border my-5  p-5 text-center'>
            <?php
            if (isset($dataPageErreur)) {
                foreach ($dataPageErreur as $value){
                   print "<p class='m-0 ml-4 text-danger font-weight-bold'>$value</p>";
                }
            }
            ?>
    </main>
</main>


</body>
</html>

