<?php



//chargement config
require_once(__DIR__.'/config/config.php');

//autoloader conforme norme PSR-0
require_once(__DIR__.'/config/SplClassLoader.php');
$myLibLoader = new SplClassLoader('controleur', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('config', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('DAL', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('DAL\metier', './');
$myLibLoader->register();
$myLibLoader = new SplClassLoader('modele', './');
$myLibLoader->register();

$cont = new controleur\FrontControleur();
?>