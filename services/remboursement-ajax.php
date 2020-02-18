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

//Verifie si l'incident a été déjà valider

$incident = get_one_incident($conn, $_POST['id_incident']);
if((!$incident['statut_remboursement']) && ($incident['statut_remboursement']=== "")){
	echo 'first time';
}else{
	
/*
*Préparation des parameters à envoyer dans le script 
* de mise à jour d'incident avec les infos de remboursement
*/

$arr_post['key'] = $_POST['key'];
$arr_post['id_incident'] = $_POST['id_incident'];
$arr_val = array_values($_POST['value']);
$arr_key = ['date_remboursement', 'montant_remboursement'];
$arr_infos =(array_combine($arr_key, $arr_val));
$arr_infos = ['value'=>$arr_infos];
$params = array_merge($arr_post, $arr_infos);

//Mettre à jour l'incident
update_incidents($conn, $params);
}




