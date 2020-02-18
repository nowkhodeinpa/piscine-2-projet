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

$subject = '';
$content = <<< contentMail
Bonjour,<br><br>

Le colis dont le numéro de transport est le n_bt. a été acheminé par vos soins.<br>
L'expdédition a été réalisée de notre entrepôt en date du dat_envoi.<br>

Nous n'avons aucune preuve de livraison et le destinataire nous confirme bien ne<br>
pas avoir reçu son colis. Nous vous demandons donc par la présente </br>
l'indemnisation de ce colis. Nous demandons donc par la présente l'indemnisation<br>
de ce colis selon les règles établies.<br>

Vous trouverez ci-joint:
<ul>
 <li>la déclaration de sinistre pour ce colis</li>
 <li>la facture</li>
 <li>notre RIB</li>
 
Nous restons à votre disposition pour tous renseignements complémentaires et<br> 
attendons votre remboursement.

Cordialement,

--
nom_admin
responsable_admin
tel_admin

contentMail;
/*
* J'ignore la fonction d'envoie mail car je suis dans localhost donc il est nécessaire d'utiliser un bibliothèque PHP ecrit en objet
* Je pourais le faire si c'est nécéssaire (fonctionnalité à developpé après feedback)
*/

/*
* Mise à jour de l'incident en question 
* après l'envoi mail
*/
update_incidents($conn, $_POST);



