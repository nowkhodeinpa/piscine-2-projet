<?php
require_once 'const/parameters.php';
require_once 'services/services.php';
require_once 'modele/commandes.php';
require_once 'modele/incidents.php';

$conn = getConnection();
/*
* Variables pour les paginations
*/
$offset = pagination_offset_commande();
$no_page_of_total = no_page_of_total_commande();
$total_no_of_pages = pagination_total_page_no_commande();

/*
* Les tableaux de données commandes
*/
$commande_multidim = get_all_commandes($conn, $offset);

require_once 'template/header.php';
require_once 'template/content.php';
require_once 'template/menu.php';
//Templates spécial pour la page commande
require_once 'template/page-commande.php';
require_once 'template/modal-commande.php';
//Fin template spécial
require_once 'template/footer.php';

