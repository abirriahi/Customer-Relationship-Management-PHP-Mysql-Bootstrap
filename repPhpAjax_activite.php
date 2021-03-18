
<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");

// Connexion a la base de donnees  


$activite = $_POST['val_sel'];

if($activite == 3)
{

// construction de la liste deroulante" .
$aff="";
$aff.="

 <p>

									<label></label>

									<input name='monactivite' id='monactivite' type='text' class='small'   /><!-- add .align-right to align the input elements to the right -->

									<span class='notification information'>Activité.</span>

								</p>

";
// envoi reponse Php a Ajax	
echo $aff; 
}

else
{
echo '<input name="monactivite" type="hidden" value="">';	
}

?>


