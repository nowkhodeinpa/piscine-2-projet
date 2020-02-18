<?php
/*
*Scripts pour gerer les commandes
	id_commandes
	id_trans
	nbr_bt	
    ref_commande
    date_commande
*/

/*
* Function pour ajouter une nouvelle commande
*/
function set_commande(mysqli $conn, int $id_trans, string $nbr_bt, string $ref_commande, string $date_commande):void {
	$sql = 'INSERT INTO commande (id_trans, nbr_bt, ref_commande, date_commande) VALUES (?,?,?,?)';
	if ($stmt = mysqli_prepare($conn, $sql)) {
		//var_dump($sql);die;
		//* Lecture des marqueurs /
		mysqli_stmt_bind_param($stmt, 'dsss', $id_trans, $nbr_bt, $ref_commande, $date_commande);
		//* Exécution de la requête /
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
* fonction pour compter le nombre de toutes les commandes enregistrés
*/
function count_all_commande(mysqli $conn):int{
	$sql = "SELECT COUNT(*) as nbr FROM commande";			
	if (!$result = mysqli_query($conn, $sql)) {
        printf("Erreur - SQLSTATE %s.\n", mysqli_sqlstate($conn));
	}else {
		$result = mysqli_fetch_row($result);
		return $result[0];
	}	
}

/*
*function pour prendre tout les informations des commandes
*/
function get_all_commandes(mysqli $conn, $offset){
	$tab_comandes = []; 
	$sql = "SELECT 
	c.id_commandes, 
	c.nbr_bt, 
	t.nom_transporteur
	FROM commande as c
	INNER JOIN transporteur as t
	ON c.id_trans = t.id_transporteur
	ORDER BY c.id_commandes
	LIMIT $offset, ".PARAM_TOTAL_RECORD_PER_PAGE_COMMANDE."";
	
	if (!$result = mysqli_query($conn, $sql)) {
        printf("Erreur - SQLSTATE %s.\n", mysqli_errno($conn));
	}else {
		if (mysqli_num_rows($result) > 0) {
			$i=0;
			while($row = mysqli_fetch_assoc($result)) { 
				$tab_comandes[$i] = $row;
				$i++;
			}
		return $tab_comandes;
		} else {
			return 0;
		}
	}
}


/*
* Fonction pour verifier si une commande est déjà dans la table incident
*/
function is_commande_in_incident(mysqli $conn, int $id_comm ):int{
	
	$sql = 'SELECT COUNT(*) as num FROM incident WHERE id_comm = ?';
	
	if($stmt = mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($stmt, "d", $id_comm);

		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_assoc($result);
			return $row['num'];		
		}else{
			echo "Error: " . $sql . "<br>" . mysqli_stmt_error($stmt);
		}
	}else{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
}