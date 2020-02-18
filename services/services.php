<?php


//Cette fonction est utilisé pour retourner la titre de la page courrante
function get_title(){
 $title = '';
 $uri = $_SERVER['REQUEST_URI'];
 $uri = explode('?', $uri)[0];
 switch($uri){
	 case '/list-commandes.php':
	 $title = PARAM_PAGE_TITLE[1];
	 break;
	 case '/list-incidents.php':
	 $title = PARAM_PAGE_TITLE[2];
	 break;
	 default:
	 $title = PARAM_PAGE_TITLE[0];
	 break;
 }
 return $title; 
}

//cette fonction test s'il faut affiché ou non la filtre d'incident sur le menu
function get_uri(){
 $title = '';
 $uri = $_SERVER['REQUEST_URI'];
 $uri = explode('?', $uri)[0];
 return $uri; 
}

//Cette fonction retourne une instance de la base de donnée mysqli
function getConnection(){
    static $conn = null;	
	// Create connection
	$conn = mysqli_connect(PARAM_DB['db_server'], PARAM_DB['db_user'], PARAM_DB['db_pass'],  PARAM_DB['db_name']);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	return $conn;
}


//cette fonction test le nom du document utiliser dans une incident
function validateDocumentName(?string $doc):bool {
    $motif = '#^[0-9]+-[a-zA-Z]+(\.pdf)#';
    if(preg_match($motif, $doc)){
        return true;
    }
    return false;
}

/*
* Cette function retourne le nombre de toutes les incidents
*/
function nombre_incident():int{
	global $conn;
    $count = count_all_incident($conn);
	return $count;
}

/*
* compter le nombre des incidents par rapport à son etat
* Les fonctions suivantes retourne le nombre des incidents suivant un ou des statut spécifique
*/

//pour les incident non geré
function nombre_incident_non_gere():int{
	global $conn;
	$state = ['statut_gestion'=>0];
	$count = count_incident_with_state($conn, $state);	
	return $count;
}

//pour les incident géré en attente de remboursement
function nombre_incident_gere_enattente_remboursement():int{
	global $conn;
	$state = ['statut_gestion'=>1, 'statut_remboursement'=>0];
	$count = count_incident_with_state($conn, $state);	
	return $count;
}

//pour les incident remboursé
function nombre_incident_rembourser():int{
	global $conn;
    $state = ['statut_remboursement'=>1];
	$count = count_incident_with_state($conn, $state);	
	return $count;
}

/*
* pagination
* fonction pour retourner le numero du page visité actuellement
* 
*/
function pagination_get_current_page():int{
	if (isset($_GET['page_no']) && $_GET['page_no']!="") {
		$page_no = (int) $_GET['page_no'];
    } else {
        $page_no = 1;
    }
	return $page_no;
}

/*
* pagination
* fonction pour retourner l'offset utiliser dans la pagination
*/
function pagination_offset():int{
	$page_no = pagination_get_current_page();
	$offset = ($page_no - 1) * PARAM_TOTAL_RECORD_PER_PAGE;
	return $offset;
}
//pagination page commande
function pagination_offset_commande():int{
	$page_no = pagination_get_current_page();
	$offset = ($page_no - 1) * PARAM_TOTAL_RECORD_PER_PAGE_COMMANDE;
	return $offset;
}


/*
* pagination
* fonction pour retourner le numéro du page suivante
*/
function pagination_next():int{
	$page_no = pagination_get_current_page();
	$next = $page_no + 1;
	return $next;
}

/*
* pagination
* fonction pour retourner le numéro du page précedente
*/
function pagination_prev():int{
	$page_no = pagination_get_current_page();
	$prev = $page_no - 1;
	return $prev;
}

/*
* pagination
* fonction pour retourner l'adjacents
*/
function pagination_adjacents():string{
	$adjacents = "2";
	return $adjacents;
}

/*
* pagination
* fonction pour retourner le nombre total de la page
* total_records est une variable assigné avec le retour d'une fonction dans la modele
* qui retourne le nombre totale d'un enregistrement spécifique
*/
//pour la table commande
function pagination_total_page_no_commande():int{
	global $conn;
	$total_records = count_all_commande($conn);
	$total_no_of_pages = ceil($total_records / PARAM_TOTAL_RECORD_PER_PAGE_COMMANDE);
	return $total_no_of_pages;
}

//Pour la table incident
function pagination_total_page_no_incident():int{	
    global $conn;
	$total_records = 0;
	
	/*
	* le total_records varie en fonction du query string
	*/
	
	/*
	* CAS 1
	* si query string n'existe pas 
	* ou contient state=all  , on veut prend toutes les incidents dans la table incident. Donc
	* count_all_incident()
	*/
	if(!isset($_GET['state-ge']) and !isset($_GET['state-re'])){
	  $total_records = count_all_incident($conn);
	}	
	
	/*
	* CAS 2
	* state-ge = 0  
	* veut dire qu'on ne veut que des incindent non géré. Donc
	* $total_records = nombre_incident_non_gere()
	*
	*/
	if(isset($_GET['state-ge']) and $_GET['state-ge']==0){	
			$total_records = nombre_incident_non_gere();
	}
	/*
	* si le query string existe il peut contenir des informations suivantes
	*
	*/
	
	/*
	* CAS 3
	* state-ge = 1  
    * state-remb = 0
	* veut dire qu'on ne veut que des incindent géré mais encore en attente de remboursement. Donc
	* $total_records = nombre_incident_gere_enattente_remboursement()
	*
	*/
	if( (isset($_GET['state-ge']) and $_GET['state-ge']==1) and ((isset($_GET['state-re']) and $_GET['state-re']==0)) ){
		$total_records = nombre_incident_gere_enattente_remboursement();
	}
	
	/*
	* CAS 4 
    * state-remb = 1
	* veut dire qu'on ne veut que des incindent r. Donc
	* $total_records = nombre_incident_rembourser()
	*
	*/
	if(isset($_GET['state-re']) and $_GET['state-re']==1){	
			$total_records = nombre_incident_rembourser();
	}
	//var_dump($total_records);die;
	
	/*On Calcul le nombre total du page*/
	$total_no_of_pages = ceil($total_records / PARAM_TOTAL_RECORD_PER_PAGE);
	return $total_no_of_pages;
}

/*
* pagination
* fonction pour retourner le second last
*/
function pagination_second_last($total_no_of_pages):int{
	$second_last = $total_no_of_pages - 1;
	return $second_last;
}

/*
* fonction pour retourner le tableau de bord de la pagination
* total_no_of_pages est une variable assigné avec le retour d'une fonction 
* qui retourne le nombre totale de la page
*/
//Pour la commande
function no_page_of_total_commande():string{
	$page_no = pagination_get_current_page();
	$total_no_of_pages = pagination_total_page_no_commande();
	$str = $page_no." sur ".$total_no_of_pages;
	return $str;
}

//Pour l'incident
function no_page_of_total_incident():string{
	$page_no = pagination_get_current_page();
	$total_no_of_pages = pagination_total_page_no_incident();
	$str = $page_no." sur ".$total_no_of_pages;
	return $str;
}

/*
*cette fonction retourne et creer des chaines equivalent au query string
* la variable get page_no est exclus dans la chaine retourner
*/
function pagination_query_string(){	
	$query = '';
	if(count($_GET) > 0){
		if(array_keys($_GET)[0]!= 'page_no'){
			$points = $_GET;
			$count = count($points);
			for($i=0; $i <= $count-1; $i++){
				$key = array_keys($points)[$i];
				if($key != 'page_no'){
					$query .= $key;
					$query .= '=';
					$query .= $points[$key];
					if($i<$count-1){
						$query .= '&';
					}					
				}
			}
		}
	}
	return $query;
}

//Cette fonction prepare la chaine du query string à utiliser dans la pagination
function pagination_build_query_string(int $num_page):string{
	
	$query_string = pagination_query_string();
	
	if(strlen($query_string) > 0 ){		
		/*
		* on test si le query_string contient déjà un caractère &
		*/
		if(strpos(strrev($query_string), '&') === 0)
			$page = 'page_no=';
		else
			$page = '&page_no=';
		
		$query_string = '?'.$query_string;
	}else{
		$page = '?page_no=';
	}
	
	$query_string .= $page;
	$query_string .= (string) $num_page;
	return $query_string;
}