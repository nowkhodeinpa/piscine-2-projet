<?php
//Ici on trouve toute les constantes à utiliser dans la logic du code
define('PARAM_DB', ['db_server'=>'localhost', 'db_name'=>'test-tech-ibonia', 'db_user'=>'root', 'db_pass'=>'']);
define('PARAM_STATUT_GESTION', ['Pas géré', 'En cours de gestion', 'Géré',]);
define('PARAM_STATUT_DOC', ['', 'document prêt',]);
define('PARAM_STATUT_MAIL', ['', 'mail envoyé',]);
define('PARAM_STATUT_REMBOURSEMENT', ['En attente de remboursement', 'Remboursement OK',]);
define('PARAM_FILTRE', ['Afficher tout', 'Pas gérés', 'Géré en attente de remboursement', 'Colis Remboursés',]);
define('PARAM_STATUT_DOSSIER_LINK', ['Scanner un document', 'Envoyer mail', 'Valider le remboursement',]);
define('PARAM_FILTRE_INCIDENT', ['state', 'state-ge', 'state-re']);
define('PARAM_FILTRE_STATUT_GESTION', [0, 1]);
define('PARAM_FILTRE_STATUT_REMBOURSEMENT', [1]);
define('PARAM_FILTRE_STATUT_NONE', ['all']);
define('PARAM_TOTAL_RECORD_PER_PAGE', 3);
define('PARAM_TOTAL_RECORD_PER_PAGE_COMMANDE', 7);
define('PARAM_DEFAULT_OFFSET', 0);
define('PARAM_PAGE_TITLE', ['Index', 'Commandes', 'Incidents']);



