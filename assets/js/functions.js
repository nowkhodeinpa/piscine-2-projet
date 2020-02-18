/*
* Fonction pour valider la date recu de l'input date picker
*/
function validateDate(date){
	var motif = /^\d{2}[//]\d{2}[//]\d{4}$/
	if(date.match(motif))
		return true;
	else
		return false;
}
