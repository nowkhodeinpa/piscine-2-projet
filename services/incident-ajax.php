<?php 
/*
* $path est une variable qui contient le chemin racine du projet
*/
$path = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);

require_once ($path.'/const/parameters.php');
require_once ($path.'/services/services.php');
require_once ($path.'/modele/incidents.php');

//se connecter à la base de donnée
$conn = getConnection();

update_incidents($conn, $_POST);



