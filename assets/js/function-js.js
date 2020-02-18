/*
* Quand on clique sur declarer un incident dans la page commande
* il faut verification tout d'abord si cette commande n'est pas encore dans la table incident
*
*/
//Fonction qui verifie une ID de commande dans la table incident
function checkCommande(id){
	var result = '';
	//AJAX VERIFICATION COMMANDE ET INCIDENT
	$.ajax({
		url: 'services/verif-commande-incident-ajax.php',
		type: 'get',
		data:  {id_com : id},			
		success: function(result){				
			result = parseInt(result);
			if(result == 1){
				/*
				* On ouvre la boite de dialogue action interdit 
				* si la commande est déjà dans la table incident
				*/
				$( "#dialog-action-interdit" ).dialog( "open" );
				return;
				
			}else{						 
				 //Ou ouvre la boîte en cas du click sur un lien
				 $( "#dialog-declaration" ).dialog( "open" );
				 //dès l'ouverture du modal on quitte le champ input
				 $("#datepicker").blur();
			}
		}
	});
//FIN AJAX VERIFICATION
}


/*
*--------------------------------------------------------
* FONCTION POUR TRAITER LES INCIDENTS
*--------------------------------------------------------
*/


/*
* si on saisir des textes sur une champ du #cellule #Dossier transporteur
* les champs suivantes seront modifiés
#statut_gestion = 1
#la #cellule Statut Gestion devient <span id="notif-gest-id" class="stat cell-stat-gest stat-gest-id">En cours de gestion</span>
*
* Si on reclique à nouveau c'est OK
*/
function gestionDocumentTransporteur(obj){
		idIncident = obj.attr('id').split('-')[3];
		//On garde l'id du span cellule dossier transporteur cliqué et son contenu
		var idSpanDossierTrans = $('#span-doss-trans-'+ idIncident).attr('id'), textSpanDossierTrans = $('#span-doss-trans-'+ idIncident).text();
		/*
		*on vide la span, on mettre un champ textarea avec la valeur du span qui vient d'être recuperé
		* si l'incident n'est pas encore validé
		*/
		if(!$('#notif-gest-'+ idIncident).hasClass('stat-gest-2')){
			$('#span-doss-trans-'+ idIncident)
			.empty()
			.html("<textarea class='area-doss-trans' id='area-"+idIncident+"'>"+textSpanDossierTrans+"</textarea>");
		}
		
		//on mettre le textarea dans focus
		$('.area-doss-trans').focus()
		//quand l'user quitte le textearea
		.on('blur', function(){			
			//prendre le texte du champ textarea
			textAreaDossierTrans =$(this).val();
			//remettre dans le comportement originale
			//on supprime le text area
			$(this).remove();
			//on recharge la span avec la valeur du textarea
			$('#'+idSpanDossierTrans).text(textAreaDossierTrans);
			//on test s'il y a des modification entre l'ancien et le nouveau valeur
			if(textSpanDossierTrans != textAreaDossierTrans){
				//on fait une requete AJAX pour changer le champ: #dossier-transporteur du table incident
				if(textAreaDossierTrans!=''){
					$.ajax({
						  method: "POST",
						  url: "services/incident-ajax.php",
						  data: { key:"dossier_transporteur", value: textAreaDossierTrans, id_incident: idIncident },
						  success:function(){
							  //on modifie la cellule #dossier transporteur						  
							  $('#notif-gest-'+idIncident)
							  .text('En cours de gestion')
							  .removeClass('stat-gest-0')
							  .addClass('stat-gest-1');
							  //Normalement il faut mettre à jour une partie du menu filtre 
							  updateItemNumber('gerer-en-attente');
							  
						  }
					})					
				}else{
					$.ajax({
						  method: "POST",
						  url: "services/incident-ajax.php",
						  data: { key:"dossier_transporteur", value: textAreaDossierTrans, id_incident: idIncident, action:'annulation' },
						  success:function(){
							  //on modifie la cellule #dossier transporteur						  
							  $('#notif-gest-'+idIncident)
							  .text('Pas géré')
							  .removeClass('stat-gest-1')
							  .addClass('stat-gest-0');
							  //Normalement il faut mettre à jour une partie du menu filtre 
							  updateItemNumber('pas-gerer');
						  }
					})					
				}
			
			//sinon, si aucun changement est faite par l'utilisateur on quitte
			}else{
				return;
			}
		});	
}


/*
* si on clique sur le lien scanner un document dans la #cellule Document de gestion 
* on verifie tout dabord si le cette ligne incident n'a pas encore un document pdf liée à elle via le champ: #statut_doc et #statut_scan
*
* * s' ils sont à 1 donc pas d'action après click 
*
* * sinon il faut faire un upload de fichier, pour cela uploadé le fichier via AJAX après update cette ligne d'incident avec: #statut_doc=1 et #statut_scan=1
* Après, deux #cellules seraient modifié:
* #cellule Statut Gestion + <span id="dispo-doc-id" class="stat cell-stat-doc stat-doc-id">document prêt</span>
* #cellule Document de Gestion + <span id="pdf-name-id" class="stat doc-pdf">1-TNT.pdf</span>
*
* Si on reclique à nouveau c'est OK mais on supprime l'ancient document pdf lié à cette incident et on upload le nouveau
*/
function scannerUploadDocument(incident, transporteur){
		//on clique sur l'input invisible automatiquement
		$("#input-scan-"+idIncident+":hidden").trigger('click');
		
		//quand l'input invisible a changer c'est à dire chargé par le nom du fichier à uploader, donc fichier prêt
		$("#input-scan-"+idIncident+":hidden").on('change', function(){
			
			//Verification du type de fichier
			fileType = $("#input-scan-"+idIncident+":hidden")[0].files[0].type;
			fileSize = $("#input-scan-"+idIncident+":hidden")[0].files[0].size;
			valideFileUpload(fileType, fileSize);
			
			
			//Chargment du formulaire
			var file_data = $('#input-scan-'+idIncident).prop('files')[0];   
			var form_data = new FormData();                  
			form_data.append('file', file_data)              
			form_data.append('key', 'upload_scan')            
			form_data.append('id_incident', idIncident)
			form_data.append('transporteur', transporteur)
			form_data.append('value', idIncident+'-'+transporteur+'.pdf');
			//alert(form_data);return;
			$.ajax({
			url: 'services/upload-ajax.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			success: function(){
				//si le chargement de fichier se deroule bien
				//on fait la modification nécessaire du côte visuel de cette incident sur la page
				//on modifie la cellule #dossier transporteur
				$('#dispo-doc-'+idIncident)
				.text('document prêt')
				.removeClass('invisible')
				.removeClass('stat-doc-0')
				.addClass('stat-doc-1')
				.addClass('visible');
				
				//on modifie encore la cellule #document de gestion
				//on ajoute le libellé du document pdf
				//nom du fichier à inserer dans la DB
				nomFichierPdf = idIncident+'-'+transporteur+'.pdf';
				$('#pdf-name-'+idIncident)
				.text('')
				.text(nomFichierPdf)
				.removeClass('invisible')
				.addClass('visible');
				
				//on modifie encore la cellule #document de gestion
				//on ajoute le lien d'envoie de mail
				$('#link-mail-'+idIncident)
				.removeClass('invisible')
				.addClass('visible');
			}
			});
		});
	
}

/*
* si on clique sur le lien envoyer mail dans la #cellule Document de gestion  
* en envoyer un mail via AJAX
* Après l'envoie du mail, en update cette ligne d'incident avec: #statut_mail=1
* #cellule Statut Gestion + <span id="notif-mail-1" class="stat stat-mail">mail envoyé</span>
**/
function envoyerMail(idIncident){		
			$.ajax({
			url: 'services/incident-single-ajax.php',
			type: 'post',
			data:  {key : 'mail', id_incident: idIncident},
			success: function(result){
				if(result != 'Scanner le document'){
				   //mise à jour de la cellule #Statut gestion pour mettre la libellée #mail envoyé
				   $('#notif-mail-'+idIncident)
				   .text('mail envoyé')
				   .removeClass('invisible')
				   .addClass('visible');
				   
				   //mise à jour de la cellule #Document gestion pour mettre la libellée #valider le remboursement
				   $('#link-validate-'+idIncident)
				   .removeClass('invisible')
				   .addClass('visible');
				   
				}else{
					//On affiche un boite de dialogue modal pour dire à l'user de scanner dabord le fichier avant l'envoi de mail
					$( "#dialog-invitation-scan" ).dialog( "open" );
				}
			}			
			});
		
}

/*
* si on clique sur le lien valider le remboursement dans la #cellule Document de gestion 
* on modifie le champ #statut_remboursement de l'incident en question avec: #statut_remboursement=1
* #cellule Statut remboursement devient:
*  <span class="remb-ok">Remboursement OK</span>
*  <span class="remb-ok">le, </span>
*  <br>
*  <span class="remb-ok">30/01/2023</span>
*  &nbsp;
*  <span class="remb-ok">pour 165,32 €</span>
*
* Si on reclique KO donc verification nécessaire sur le champ #statut_remboursement avant de faire l'action de validation
*/

function validerRemboursement(obj){	
		
		key = 'validation';
		idIncident = obj.attr('id').split('-')[1];		
		/*
		*DATA1 pour permettre la verification de l'etat de remboursement
		* on envoie l'id de l'incident et le key pour distinguer cette requête à une autre requête
		* cette data est à utiliser dans l'AJAX1
		*/
		data1 = {key:key, id_incident: idIncident};
		//FIN DATA1
		
		
		/*controle
		* pour verifier si le remboursement de cette incident a été déjà valider
		*/		
		//AJAX1 verification etat remboursement
		$.ajax({		
			/* AJAX1 verification
			* si verification confirme que le remboursement est déjà ok 
			* on affiche une boite de dialogue pour demander à l'utilisateur 
			* s'il veut modifier l'information déjà en base de donnée
			*
			* si l'utilisateur clique sur annuler on annule l'action
			* si l'utilisateur clique sur Valider on execute l'ajax2 de mise à jour
			* AJAX2 de mise à jour 
			*/
			url: 'services/incident-single-ajax.php',
			type: 'post',
			data:  data1,			
			success: function(result){
				if(result === 'déjà remboursé'){
					//modal confirmation d'action utilisateur
					$( "#dialog-modifier-remboursement" ).dialog( "open" );
				}else{
					/*
					* si la verification indique qu'aucun information de remboursement 
					* se trouve sur cette ligne d'incident on affiche la boite de dialogue
					* pour permettre à l'utilisateur de saisir les informations de remboursement
					* et on execute tout de suite l'ajax2
					*/
					//modal pour saisir le montant de remboursement
					$( "#dialog-montant-remboursement" ).dialog( "open" );
					}
			}
		});
}

/*
* Cette fonction traite la mise à jour d'incident
* et concerne au remboursement fait par le transporteur
*/
function traitementRemboursement(data){
//AJAX nouveau remboursement
	$.ajax({
		url: 'services/remboursement-ajax.php',
		type: 'post',
		data:  data,			
		success: function(result){				
			//mettre à jour la cellule #Dossier transporteur
			$('#td-doss-transporteur-'+idIncident).off('dblclik');
			$('#notif-gest-'+idIncident)
			.text('Géré')
			.addClass('stat-gest-2');
			//mettre à jour la #cellule #Statut remboursement
			//traitement data
			amount = data.value[1];
			if(amount.match(',')){
				amount = amount.split(',')[0]+'.'+amount.split(',')[1];	
			}
			var locale = 'fr';
			var options = {style: 'currency', currency: 'eur', minimumFractionDigits: 2, maximumFractionDigits: 2};
			var formatter = new Intl.NumberFormat(locale, options);
			montantRemboursement = formatter.format(amount);
		    var currentdate = new Date(); 
			dateRemboursement = ("0" + currentdate.getDate()).slice(-2)+'/'+("0" + (currentdate.getMonth() + 1)).slice(-2)+'/'+currentdate.getFullYear();
			//traitement visuel
			$("#cell-stat-remb-"+idIncident).html("");
			$("#cell-stat-remb-"+idIncident).html('<span class="remb-ok">Remboursement OK </span><span class="remb-ok">le, </span><br><span class="remb-ok">'+dateRemboursement+'</span>&nbsp;<span class="remb-ok">pour '+montantRemboursement+'</span>');
			
			//Demande de Mise à jour des notification par état sur le filtre d'incident
			updateItemNumber('rembourser');	
		}
	});
//FIN AJAX nouveau remboursement
}

/*
* Fonction qui mettre à jour une partie du menu filtre
*/
function updateItemNumber(item){
	//AJAX COMPTE PAR ETAT
	$.ajax({
		url: 'services/compter-incident-par-etat-ajax.php',
		type: 'get',
		data:  item,			
		success: function(result){				
			data = JSON.parse(result);
			var numGererAtt = $('#gerer-en-attente').text(),
			    numPasgerer = $('#pas-gerer').text(),
			    numRemb = $('#rembourser').text();
            //['numPasgerer'=>$count_nge, 'numGererAtt'=>$count_get,'numRemb'=>$count_re]
			//Modification du couleur des notifications
			if(numGererAtt != data.numGererAtt){
				$('#gerer-en-attente').css({"color":"#fff","background-color":"#fb0404"});
			    $('#gerer-en-attente').text(data.numGererAtt);
			}else{
				$('#gerer-en-attente').css({"color":"#555","background-color":"#fff"});
			}
			
			if(numPasgerer != data.numPasgerer){
				console.log(numPasgerer+' '+numPasgerer.length+' '+data.numPasgerer+' '+(data.numPasgerer).length);
				$('#pas-gerer').css({"color":"#fff","background-color":"#fb0404"});
			    $('#pas-gerer').text(data.numPasgerer);
			}else{
				console.log(numPasgerer+' '+numPasgerer.length+' '+data.numPasgerer+' '+(data.numPasgerer).length);
				$('#pas-gerer').css({"color":"#555","background-color":"#fff"});
			}
			
			if(numRemb != data.numRemb){
				$('#rembourser').css({"color":"#fff","background-color":"#fb0404"});
				$('#rembourser').text(data.numRemb);
			}else{
				$('#rembourser').css({"color":"#555","background-color":"#fff"});
			}			
		}
	});
//FIN AJAX COMPTE PAR ETAT
}

/*
* La fonction suivante verifie et valide ou pas le fichier à envoyer
*/
function valideFileUpload(type, size){
	//alert(type+' '+size);
	if(type != 'application/pdf'){
		//alert('Vous devez choisir un fichier PDF');
		$( "#dialog-invitation-pdf" ).dialog( "open" );
		return;
	}
}