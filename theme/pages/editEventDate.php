<?php

// Connexion à la base de données
require_once("../../_top.php");

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2]))
{
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];

	//$sql = "UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ";
    //$query = $bdd->prepare( $sql );
	$query= $myadmin->MiseAJourEvent($id,$start,$end);
	/*
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}else{
		die ('OK');
	}
             */
}
header('Location: '.basename($_SERVER['HTTP_REFERER']));

	
?>
