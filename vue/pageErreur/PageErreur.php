<html>
<head>
    <title>Erreur</title>
</head>

<body>

<h1>Il y a eu une erreur durant le traitement des données !!</h1>
<?php
if (isset($dataPageErreur)) {
    foreach ($dataPageErreur as $value){
        echo $value;
    }
}
?>



</body>
</html>

