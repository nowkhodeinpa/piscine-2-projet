<?php 
/*
* $path est une variable qui contient le chemin racine du projet
*/
$path = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);

require_once ($path.'/const/parameters.php');
require_once ($path.'/services/services.php');
require_once ($path.'/modele/incidents.php');

//test d'erreur de chargement de fichier
if 
( 0 < $_FILES['file']['error'] ) {
	
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
	//Teste si le fichier existe déjà
	if(file_exists($path."/pdf-declaration/".$_POST['value'])){
		//on le supprime s'il existe déjà
		unlink($path."/pdf-declaration/".$_POST['value']);
	}
	//on charge et on deplace et renome le fichier télécharger
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path.'/pdf-declaration/'.$_POST['value'])){
		//se connecter à la base de donnée
		$conn = getConnection();
		//on fait la mise à jour de l'incident
		update_incidents($conn, $_POST);		
	}
}






?>
