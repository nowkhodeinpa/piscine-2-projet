<?php
//Fichier PHP serveur AJAX pour compter les nombres des incidents par rapport à un etat bien déterminer
 
/*
* $path est une variable qui contient le chemin racine du projet
*/
$path = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);

require_once ($path.'/const/parameters.php');
require_once ($path.'/services/services.php');
require_once ($path.'/modele/incidents.php');

//se connecter à la base de donnée
$conn = getConnection();

$key = array_keys($_GET)[0];
if(in_array($key, ['gerer-en-attente', 'pas-gerer', 'rembourser'])){
	$count_get = nombre_incident_gere_enattente_remboursement();
	$count_nge = nombre_incident_non_gere();
	$count_re = nombre_incident_rembourser();
	$count = json_encode(['numPasgerer'=>$count_nge, 'numGererAtt'=>$count_get,'numRemb'=>$count_re]);
	echo $count;	
}




