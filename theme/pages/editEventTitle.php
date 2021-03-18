<?php

require_once("../../_top.php");

if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	//$sql = "DELETE FROM events WHERE id = $id";
	$query = $myadmin->DeleteEvent($id);
	/*if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}*/
	
} elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$color = $_POST['color'];
	
	//$sql = "UPDATE events SET  title = '$title', color = '$color' WHERE id = $id ";
     //$query = $myadmin->prepare( $sql );
	 
	 $query= $myadmin->MiseAJourTitleEvent($id,$title,$color);
	 
	/*if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}*/

}
header('Location: '.basename($_SERVER['HTTP_REFERER']));

	
?>
