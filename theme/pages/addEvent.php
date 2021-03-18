<?php  session_start();

// Connexion à la base de données
require_once("../../_top.php");
$me = $myadmin->InfoLogger($_SESSION['loginadmin']);
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){
	
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	//$sql = "INSERT INTO events(title, start, end, color) values ('$title', '$start', '$end', '$color')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	
	//echo $sql;
	
	//$query = $bdd->prepare( $sql );
	
  $query = $myadmin->AjouterEvent($_SESSION['loginadmin'],$title,$start, $end, $color);

	/*if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	} */
header('Location: '.basename($_SERVER['HTTP_REFERER']));
}
else{ echo 'error'; }

	
?>
