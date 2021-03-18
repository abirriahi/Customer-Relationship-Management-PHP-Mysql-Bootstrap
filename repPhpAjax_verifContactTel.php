<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");

$tel= $_POST['val_sel'];

$x = $myadmin->VerifContactTel($tel);

if($x == 1)
echo '<span style="color:#ff0000">Ce numéro de téléphone est présent dans la base</span>';


			
?>

