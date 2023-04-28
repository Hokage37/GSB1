<?php
include("vues/v_sommaireV.php");
$action = $_REQUEST['action'];
$rep = $_POST['ok'];
switch($action){
	case 'validerFForfait':{
		if($rep == 'Valider'){
			$pdo->validerFrais($_SESSION['id_visit']);
		}
	}
}

?>
