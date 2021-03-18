<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");

$email= $_POST['val_sel'];

$x = $myadmin->VerifContactEmail($email);

if($x == 1)
echo '<span style="color:#ff0000">Cette email est présent dans la base</span>';


			
?>

