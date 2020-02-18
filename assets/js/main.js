/*
* Les fonctions appélées dans cette fichier se trouvent dans le fichier: "js/functions-js.js"
*/
$(function(){
	/*
	* Si on double click sur la cellule #dossier transporteur la cellule devient editable
	* PS-- dans le cahier de charge on demande un simple clique mais je le fais en double click pour mieux gerer le comportement attendu
	
	*/
	$('.dossier-transporteur').on('dblclick', function(){
		obj = $(this);
		
		//appel à une fonction
		gestionDocumentTransporteur(obj);
	});
	

/*
* quand on clique sur le lien scanner un document, 
* un explorateur de fichier s'ouvre automatiquement 
* pour choisir le fichier à uploader
* 
*/	
	$(".upload_link").on('click', function(e){
		//on annule le comportement par defaut du lien scanner un document
		e.preventDefault();
		
		//on recupere l'id d'incident et son transporteur
		idIncident = $(this).attr('id').split('_')[2];
		transporteur = $(this).attr('id').split('_')[3];
		
		//appel à une fonction
		scannerUploadDocument(idIncident, transporteur);
	});

/*
*Quand on clique sur le lien envoyer mail
*On verifier tout dabord si le champ #statut_scanner est bien à 1 :
*si ou l'envoi de mail est autorisé
*si non il faut invité l'utilisateur de scanner tout dabord le document avant d'envoyé le mail
*/
	
	$(".cell-doc-gest").on('click', ".a-send-mail", function(e){
		//on annule le comportement par defaut du lien
		e.preventDefault();
		
		//verifier le champ #status_scann
		idIncident = $(this).attr('id').split('-')[1];
		
		//appel à une fonction
		envoyerMail(idIncident);
	});
/*
* Quand on clique sur le lien valider le remboursement
* Un popup s'ouvre et qui contient un champ text
* pour pouvoir saisir le montant de remboursement payé par le transporteur
*/
	
	$(".cell-doc-gest").on('click', ".a-validate-doc", function(e){
		//on annule le comportement par defaut du lien
		e.preventDefault();
		obj = $(this);
		
		//appel à une fonction
		validerRemboursement(obj);
	});

});