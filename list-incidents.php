<?php
require_once 'const/parameters.php';
require_once 'services/services.php';
require_once 'modele/commandes.php';
require_once 'modele/incidents.php';

$conn = getConnection();

/*
* Variables pour les paginations
*/
$offset = pagination_offset();


$no_page_of_total = no_page_of_total_incident();


$total_no_of_pages = pagination_total_page_no_incident();

/*
* on prend dans la base de donnée
* les enregistrements dans la table incidents
*/
$incident_multidim = get_all_incident($conn, $offset);


require_once 'template/header.php';
require_once 'template/content.php';
require_once 'template/menu.php';
//Templates spécial pour la page incident
require_once 'template/page-incident.php';
require_once 'template/modal-incident.php';
//Fin template spécial
require_once 'template/footer.php';
