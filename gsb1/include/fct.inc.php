<?php
 /**
 * Teste et retourne vrai ou faux si visiteur  
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}
/**
 * save dans variable session id, nom et prenom */
function connecter($id,$nom,$prenom){
	$_SESSION['idVisiteur']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
}

function deconnecter(){
	session_destroy();
}

function estPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

function estTabEntiers($tabEntiers) {
	$resu = true;
	foreach($tabEntiers as $unEntier){
		if(!estPositif($unEntier)){
		 	$resu=false; 
		}
	}
	return $resu;
}

function ajouterErreur($msg){
	if (! isset($_REQUEST['erreurs'])){
	   $_REQUEST['erreurs']=array();
	 } 
	$_REQUEST['erreurs'][]=$msg;
 }

function DateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnnePasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnnePasse); 
}

function DateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTabEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Vérif tab que des num
*/
function lesQteFraisValides($lesFrais){
	return estTabEntiers($lesFrais);
}
/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant 
 
 * des message d'erreurs sont ajoutés au tableau des erreurs
 
 * @param $dateFrais 
 * @param $libelle 
 * @param $montant
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!Datevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(DateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}



function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}

function dateAnglaisToFr($maDate){
	@list($annee,$mois,$jour)=explode('-',$maDate);
	$date="$jour"."/".$mois."/".$annee;
	return $date;
 }

 function dateFrToAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}

function getMois($date){
	@list($jour,$mois,$annee) = explode('/',$date);
	if(strlen($mois) == 1){
		$mois = "0".$mois;
	}
	return $annee.$mois;
}
?>