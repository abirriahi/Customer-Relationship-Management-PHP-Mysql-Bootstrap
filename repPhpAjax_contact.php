
<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");

// Connexion a la base de donnees  


$listecpcl = $myadmin->ListeContactParClient($_POST['val_sel']);


// construction de la liste deroulante" .
$aff="";
$aff.="

 <p>  
<select name='contactclient' id='contactclient'   >";

$aff.="<option value=''>-- Qui vous avez contacter ? --</option>";

foreach($listecpcl as $lcc)
{
$fct = $myadmin->AfficherFonctionContact($lcc['id_fct']);

$aff.="<option value=".$lcc['id_ctc'].">".$lcc['nom_ctc']." ( ".$fct." )</option>"; 

		}
	
$aff.="</select>
</p>

";
// envoi reponse Php a Ajax	
echo $aff; 
//echo "<br><br>Valeur postee: ".$_POST['val_sel'];
			
?>


