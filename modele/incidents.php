<?php
/*
*Scripts pour gerer les incidents
	id_incident
	id_comm
	id_admin
    statut_gestion
    statut_dossier_transporteur
	dossier_transporteur
	statut_remboursement
	doc_gestion
	date_decl_incident
	date_remboursement
	montant_remboursement
	statut_document
	statut_mail
	statut_scanner
*/

/*
* Function pour ajouter un nouveau incident
*/
function set_incident(mysqli $conn, int $id_comm, int $id_adm, string $date_declaration):void {
	$sql = 'INSERT INTO incident (id_comm, id_adm, date_decl_incident) VALUES (?,?,?)';
	if ($stmt = mysqli_prepare($conn, $sql)) {
		/* Lecture des marqueurs */
		mysqli_stmt_bind_param($stmt, 'dds', $id_comm, $id_adm, $date_declaration);
		/* Exécution de la requête */
		if(mysqli_stmt_execute($stmt)){
			printf("%d ligne insérée.\n", mysqli_stmt_affected_rows($stmt));
		}else{
			 echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
		}    
    }else{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	} 
}

/*
* function pour la mise à jour d'un incident
*/
function update_incidents(mysqli $conn, array $params):void {
	$key = $params['key'];
	if(isset($params['value'])){	
		if(!is_array($params['value'])){
		  $value = $params['value'];	
		}else{
			$value1 = $params['value']['date_remboursement'];
			//$value1 = time();
			$value2 = str_replace(",", ".", $params['value']['montant_remboursement']);	
		}
	}
	
	$id_incident = $params['id_incident'];
	switch($key){
		case 'dossier_transporteur':
		    //quand le champ est vide
		    if($params['action'] == 'annulation'){
			   $statut_gestion = 0;	
			}else{
				$statut_gestion = 1;
			}
			
			$sql = "UPDATE incident SET dossier_transporteur = ?, statut_gestion = ? WHERE id_incident = ?";
			if ($stmt = mysqli_prepare($conn, $sql)) {
				mysqli_stmt_bind_param($stmt, 'sdd', $value, $statut_gestion, $id_incident);
				if(mysqli_stmt_execute($stmt)){
					printf("%d ligne mis à jour.\n", mysqli_stmt_affected_rows($stmt));
				}else{
					 echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
				}    
			}else{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			} 
		break;
		case 'upload_scan':
			$statut_document = 1;
			$statut_scanner = 1;
			$sql = "UPDATE incident SET statut_document = ?, doc_gestion = ?, statut_scanner = ? WHERE id_incident = ?";
			if ($stmt = mysqli_prepare($conn, $sql)) {
				mysqli_stmt_bind_param($stmt, 'dsdd', $statut_document, $value, $statut_scanner, $id_incident);
				if(mysqli_stmt_execute($stmt)){
					printf("%d ligne mis à jour.\n", mysqli_stmt_affected_rows($stmt));
				}else{
					 echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
				}    
			}else{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			} 
		break;
		case 'mail':
		    $statut_mail = 1;
			$sql = "UPDATE incident SET statut_mail = ? WHERE id_incident = ?";
			if ($stmt = mysqli_prepare($conn, $sql)) {
				mysqli_stmt_bind_param($stmt, 'dd', $statut_mail, $id_incident);
				if(mysqli_stmt_execute($stmt)){
					printf("%d ligne mis à jour.\n", mysqli_stmt_affected_rows($stmt));
				}else{
					 echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
				}    
			}else{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			} 
		break;
		case 'validation':
		$statut_gestion = 2;
		$statut_remboursement = 1;
		$sql = "UPDATE incident SET statut_gestion = ?, statut_remboursement = ?, date_remboursement = ?, montant_remboursement = ? WHERE id_incident = ?";
			if ($stmt = mysqli_prepare($conn, $sql)) {
				mysqli_stmt_bind_param($stmt, 'ddsdd', $statut_gestion, $statut_remboursement, $value1, $value2, $id_incident);
				if(mysqli_stmt_execute($stmt)){
					printf("%d ligne mis à jour.\n", mysqli_stmt_affected_rows($stmt));
				}else{
					 echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
				}    
			}else{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			} 
		break;
	}
}

/*
*function pour prendre tout les informations des incidents dans les tables
*/

function get_all_incident_test(mysqli $conn){
	$tab_incidents = [];
	
		$sql = 'SELECT 
				i.id_incident as id, 
				c.ref_commande as ref_com,
				t.nom_transporteur as trans_nom, 
				t.ref_transporteur as trans_ref, 
				a.nom_admin as admin_nom,
				DATE_FORMAT(a.date_admin, "%d/%m/%Y") as admin_date, 
				i.statut_gestion as stat_gest,
				i.dossier_transporteur as doss_trans, 
				i.statut_remboursement as stat_remb, 
				i.doc_gestion as pdf, 
				i.statut_document as stat_doc,  
				i.statut_scanner as stat_scan, 
				i.statut_mail as stat_mail, 
				DATE_FORMAT(i.date_remboursement, "%d/%m/%Y") as date_remb, 
				i.montant_remboursement as mt_remb,
				t.id_transporteur as id_trans 
				FROM `incident` as i 
				INNER JOIN commande as c 
				ON i.id_comm = c.id_commandes 
				INNER JOIN admin as a 
				ON i.id_adm = a.id_admin 
				INNER JOIN transporteur as t 
				ON c.id_trans = t.id_transporteur
			';
			$where ='';
	
	if (!$result = mysqli_query($conn, $sql)) {
        printf("Erreur - SQLSTATE %s.\n", mysqli_sqlstate($conn));
	}else {
		if (mysqli_num_rows($result) > 0) {
			$i=0;
			while($row = mysqli_fetch_assoc($result)) { 
				$tab_incidents[$i] = $row;
				$i++;
			}
		return $tab_incidents;
		} else {
			return 0;
		}
	}
}




/*
* function pour recuperer une seule ligne d'incident
* mila ampiana ny informatio azo ato
* tokony alaina ato avokoa ny mahakasika ny transpo, date envoie colis, admin incident sns...
*/

function get_one_incident(mysqli $conn, int $incident):array{
	
	$qry = 'SELECT * FROM incident WHERE id_incident = ?';
	if($stmt = mysqli_prepare($conn,$qry)){
        mysqli_stmt_bind_param($stmt, "d", $incident);

		if(mysqli_stmt_execute($stmt)){
			$row = mysqli_stmt_get_result($stmt);
			$incident = mysqli_fetch_assoc($row);
			
			return $incident;		
		}else{
			echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
		}
	}else{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}


}

/*
* fonction pour prendre des lignes d'incidents avec un status spécifique
*/
function get_incident_with_state(mysqli $conn, array $state):array{
	var_dump($state);die;
}

/*
* fonction pour compter le nombre des incidents par rapport à un status spécifique
*/
function count_incident_with_state(mysqli $conn, array $state):int{
	if(1 === count($state)){
	   $sql = "SELECT COUNT(*) as nbr FROM incident WHERE ".array_keys($state)[0]." = ".array_values($state)[0];	
	}else{
	   $sql = "SELECT COUNT(*) as nbr FROM incident WHERE ".array_keys($state)[0]." = ".array_values($state)[0]." AND ".array_keys($state)[1]." = ".array_values($state)[1]."";	
	}
	
	if (!$result = mysqli_query($conn, $sql)) {
        printf("Erreur - SQLSTATE %s.\n", mysqli_sqlstate($conn));
	}else {
		$result = mysqli_fetch_row($result);
		return $result[0];
	}
	
}

/*
* fonction pour compter le nombre de toutes les incidents enregistrés
*/
function count_all_incident(mysqli $conn):int{
	$sql = "SELECT COUNT(*) as nbr FROM incident";			
	if (!$result = mysqli_query($conn, $sql)) {
        printf("Erreur - SQLSTATE %s.\n", mysqli_sqlstate($conn));
	}else {
		$result = mysqli_fetch_row($result);
		return $result[0];
	}	
}



/*
*function tsy test
*/

function get_all_incident(mysqli $conn, $offset){
	 	
	//Variable à utiliser pour le clause limit de la requête
	$limit = PARAM_TOTAL_RECORD_PER_PAGE;
	$tab_incidents = [];
	
		$sql = "SELECT 
				i.id_incident as id, 
				c.ref_commande as ref_com,
				t.nom_transporteur as trans_nom, 
				t.ref_transporteur as trans_ref, 
				a.nom_admin as admin_nom,
				DATE_FORMAT(a.date_admin, '%d/%m/%Y') as admin_date, 
				i.statut_gestion as stat_gest,
				i.dossier_transporteur as doss_trans, 
				i.statut_remboursement as stat_remb, 
				i.doc_gestion as pdf, 
				i.statut_document as stat_doc,  
				i.statut_scanner as stat_scan, 
				i.statut_mail as stat_mail, 
				DATE_FORMAT(i.date_remboursement, '%d/%m/%Y') as date_remb, 
				i.montant_remboursement as mt_remb,
				t.id_transporteur as id_trans 
				FROM `incident` as i 
				INNER JOIN commande as c 
				ON i.id_comm = c.id_commandes 
				INNER JOIN admin as a 
				ON i.id_adm = a.id_admin 
				INNER JOIN transporteur as t 
				ON c.id_trans = t.id_transporteur				
			";
			
			
			/*Les clauses where peuvent être à utiliser*/
			$cas = 1;
			if(isset($_GET['state-ge']) and $_GET['state-ge']==0){			
				/*cas 1 par defaut
				* n'affiche que les incidents pas géré
				* on filtre par le champ statut_gestion
				*
				* statut_gestion = 0
				*/
				$statut_gestion = 0;
				$where = " WHERE statut_gestion = ? ";
				$sql .= $where;
			    $cas = 1;
				
			}elseif(!isset($_GET['state-ge']) and !isset($_GET['state-re'])){			
				/*cas 2 
				* on affiche tous
				* pas de filtre par champ
				*
				$where = "";
				*/
				$where = "";
				$sql .= $where;
			    $cas = 2;
				
			}elseif((isset($_GET['state-ge']) and $_GET['state-ge']==1) and ((isset($_GET['state-re']) and $_GET['state-re']==0))){			
				/*cas 3 
				* n'affiche que les incidents géré mais encore en attente de remboursement
				* on filtre par les champs statut_gestion et statut_remboursement
				*
				* statut_gestion = 1
				* statut_remboursement = 0
				$where = "WHERE statut_gestion = ? AND statut_remboursement = ?";
				*/
				
				$where = "WHERE statut_gestion = ? AND statut_remboursement = ?";
				$statut_gestion = 1;
				$statut_remboursement = 0;
				$sql .= $where;
			    $cas = 3;
				
			}elseif(isset($_GET['state-re']) and $_GET['state-re']==1){			
				/*cas 4 
				* n'affiche que les incidents géré et rembourser
				* on filtre avec le champ statut_remboursement
				*
				* statut_remboursement = 1
				*/
				
				$statut_remboursement = 1;
				$where = " WHERE statut_remboursement = ? ";
				$sql .= $where;
			    $cas = 4;
				
			}
			
			/*Le clause order by à utiliser*/
			$order_by = " ORDER BY id";
			$sql .= $order_by;
			
			/*Le clause limit à utiliser*/
			
			$lim = " LIMIT ?, ?";
			
			/*le SQL finale avec la clause limit*/
			$sql .= $lim;
	
	if ($stmt = mysqli_prepare($conn, $sql)) {
		/* Lecture des marqueurs */
		switch($cas){
			case 1:
			//Cas 1 on filtre avec le champ statut_gestion
			mysqli_stmt_bind_param($stmt, 'ddd', $statut_gestion ,$offset, $limit);
			break;
			case 2:		
			//Cas 2 pas de filtre
			mysqli_stmt_bind_param($stmt, 'dd', $offset, $limit);
			break;
			case 3:		
			//Cas 3 on filtre avec les champs statut_gestion et statut_remboursement
			mysqli_stmt_bind_param($stmt, 'dddd', $statut_gestion, $statut_remboursement, $offset, $limit);
			break;
			case 4:
			//Cas 4 on affiche que les incident rembourser			
			mysqli_stmt_bind_param($stmt, 'ddd', $statut_remboursement, $offset, $limit);
			break;
		}
		
		/*Execution */
		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);
			$i = 0;
			while ($row = mysqli_fetch_assoc($result))
			{
				$tab_incidents[$i] = $row;
				$i++;
			}
			return $tab_incidents;		
		}else{
			echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
		}		
	}else {
		printf("Erreur - SQLSTATE %s.\n", mysqli_sqlstate($conn));
	}
}