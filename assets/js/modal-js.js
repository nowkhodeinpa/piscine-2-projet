$(document).ready(function(){
	$('.a-demande-rembour').on("click", function(e){
		e.preventDefault();
	});
	/*
	* POUR LE MODAL DECLARATION D'INCIDENT
	*/
	 var dateSouhaiter = '', idCommande = '';
	//initialisation du dialogue
	$( "#dialog-declaration" ).dialog({
		  width: 500,
		  height: 250,
		  draggable: false,
		  buttons: [
			{
			  text: "Annuler",
			  click: function() {
				$( this ).dialog( "close" );
			  }
			},
			{
			  text: "Valider",
			  click: function() {
				dateSouhaiter = $(".date_remboursement_souhaiter").val();
				/*Les données à envoyer en AJAX*/
				/*validation du date
				* cette fonction se trouve dans le fichier:
				* "js/functions.js"
				*/
				dateValide = validateDate(dateSouhaiter);
				
				/*Si la date sasisser par l'user est valide*/
				
				if(dateValide){					
					$( this ).dialog( "close" );
					
					//formatage du date pour la base de donnée
					dateSouhaiter = dateSouhaiter.split('/')[2]+'-'+dateSouhaiter.split('/')[1]+'-'+dateSouhaiter.split('/')[0];
					
					//extraction de l'id du commande
					idCommande = idCommande.split('-')[3];
					
					//ID admin est une donnée static avec valeur
					adminConnecterId = 1;
					
					//Enregistrement d'un incident
					$.ajax({
						  method: "POST",
						  url: "services/ajout-incident-ajax.php",
						  data: { idCommande: idCommande, dateSouhaiter: dateSouhaiter, idAdmin: 1}
						  
				    });

					
				}else{
				/*Si la date sasisser par l'user n'est pas valide*/
				alert('non');
					return;
				}
			  }
			}
		  ]
	});
	
	//fermeture	
	$( "#dialog-declaration" ).dialog("close");
	
	//ouverture du dialogue
	$('.demande-remboursement').on('click', function(){
		 //on recupere l'id du commande souhaiter
		 idCommande = $(this).attr('id');
		 idCommande = idCommande.split('-')[3];
         //Verifier si la commande n'est pas encore dans la table incident
		 checkCommande(idCommande);
	}); 
	
	//datePicker
	$("#datepicker").on("click", function(){
		$(this).blur();
	});
	$("#datepicker").on("focus", function(){
		//dès l'ouverture du datepicker on quitte le champ input
		$("#datepicker").blur();
		
		//On utilise le format du date fr 
		$(this).datepicker({
			dateFormat: "dd/mm/yy"
		});
		//Mettre la date du jour comme date par défaut du datepicker
		$('#datepicker').datepicker('setDate', new Date());
	});
	/*
	* FIN MODAL DECLARATION D'INCIDENT
	*/
	
	
	
	
	/*
	* POUR LE MODAL POUR L'ACTION INTERDIT
	*/
	$( "#dialog-action-interdit" ).dialog({
						  width: 500,
						  height: 210,
						  draggable: false,
						  buttons: [
							{
							  text: "OK",
							  click: function() {
								$( this ).dialog( "close" );
							  }
							}
						  ]
					});
	$( "#dialog-action-interdit" ).dialog( "close" );
	/*
	* FIN MODAL D'ACTION INTERDIT
	*/
	
	
	
	
	/*
	*------------------------------------------------------------------ 
	*Les modals suivants sont pour la gestion des incidents
	*------------------------------------------------------------------
	*/
	
	/*
	* POUR LE MODAL D'INVITATION AU SCAN
	*/
	$( "#dialog-invitation-scan" ).dialog({
						  width: 500,
						  height: 170,
						  draggable: false,
						  buttons: [
							{
							  text: "OK",
							  click: function() {
								$( this ).dialog( "close" );
							  }
							}
						  ]
					});
	$( "#dialog-invitation-scan" ).dialog( "close" );
	/*
	* FIN MODAL D'INVITATION AU SCAN
	*/
	
	
	
	
	
	
	
	
	
	/*
	* POUR LE MODAL CONFIRMATION FORMAT PDF
	*/
	$( "#dialog-invitation-pdf" ).dialog({
						  width: 500,
						  height: 170,
						  draggable: false,
						  buttons: [
							{
							  text: "OK",
							  click: function() {
								$( this ).dialog( "close" );
								//on vide le champ hidden du fichier
								$("#input-scan-"+idIncident+":hidden").val('');
								//on ouvre l'explorateur windows
								$("#input-scan-"+idIncident+":hidden").trigger('click');
								
							  }
							}
						  ]
					});
	$( "#dialog-invitation-pdf" ).dialog( "close" );
	/*
	* FIN MODAL CONFIRMATION FORMAT PDF
	*/
	
	
	/*
	* POUR LE MODAL D'INFORMATION REMBOURSEMENT
	*/
	$( "#dialog-montant-remboursement" ).dialog({
						  width: 500,
						  height: 200,
						  draggable: false,
						  buttons: [
							{
							  text: "Annuler",
							  click: function() {
								$( this ).dialog( "close" );
								$("#input-montant-remboursement").val("");
								$("#input-montant-remboursement").removeClass("input-err");
								$('.span-err-mnt')
								.addClass("invisible")
								.removeClass("visible")
								.removeClass("error");
							  }
							},
							{
							  text: "Valider",
							  click: function() {
									
									/*
									*DATA2 à mettre dans le script du popup d'infos de remboursement
									* cette data est à utiliser dans l'AJAX2
									*/
									//Date Remboursement
									var currentdate = new Date(); 
									var datetime = currentdate.getFullYear() + "-"
													+ (currentdate.getMonth()+1)  + "-" 
													+ currentdate.getDate() + " "
													+ currentdate.getHours() + ":"  
													+ currentdate.getMinutes() + ":" 
													+ currentdate.getSeconds();
									dateRemboursement = datetime;
									
									//Montant Remboursement
									montantRemboursement = $("#input-montant-remboursement").val();
									/*
									*Verification du donnée entrée par l'utilisateur
									*/
									isValid = montantRemboursement.search(/^\d+(,|.)?/) >= 0 ;
									if(isValid){									
										//fermeture									
										$( this ).dialog( "close" );								
										
										//data2 pour le nouveau montant et date remboursement
										data2 = {key:key, id_incident: idIncident, value:[dateRemboursement, montantRemboursement]};
										//FIN DATA2
										$("#input-montant-remboursement").val("");
										$("#input-montant-remboursement").removeClass("input-err");
										$('.span-err-mnt')
										.addClass("invisible")
										.removeClass("visible")
										.removeClass("error");
										
										//AJAX2
										/*
										* cette fonction se trouve dans le fichier:
										* "js/functions-js.js"
										*/
										traitementRemboursement(data2);
									}else{
										$("#input-montant-remboursement").addClass("input-err");										
										$(".span-err-mnt")
										.removeClass("invisible")
										.addClass("visible")
										.addClass("error");
									}
							  }
							}
						  ]
					});
					$( "#dialog-montant-remboursement" ).dialog( "close" );
	/*
	* FIN MODAL D'INFORMATION REMBOURSEMENT
	*/
	
	
	/*
	* POUR LE MODAL DE MODIFICATION D'INFORMATION D'UN REMBOURSEMENT
	*/
	$( "#dialog-modifier-remboursement" ).dialog({
						  width: 500,
						  height: 200,
						  draggable: false,
						  buttons: [
							{
							  text: "Annuler",
							  click: function() {
								//Fermeture du modal
								$( this ).dialog( "close" );
							  }
							},
							{
							  text: "Valider",
							  click: function() {
								//Fermeture du modal  
								$( this ).dialog( "close" );
								//Ouverture du modal montant remboursement
								$( "#dialog-montant-remboursement" ).dialog( "open" );
							  }
							}
						  ]
					});
	$( "#dialog-modifier-remboursement" ).dialog( "close" );
	/*
	* FIN MODAL DE MODIFICATION D'INFORMATION D'UN REMBOURSEMENT
	*/
	
	
 });