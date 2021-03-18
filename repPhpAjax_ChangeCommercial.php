
<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");

// Connexion a la base de donnees  


$commerciaux = $myadmin->ListeCommerciaux();


// construction de la liste deroulante" .
$aff="";
$aff.="
<p>
&nbsp;
</p>
<form action='' method='post'>
 <p>  
<select name='commerciaux' id='commerciaux'   >";

$aff.="<option value=''>-- Commercial ? --</option>";

foreach($commerciaux as $comm)
{


$aff.="<option value=".$comm['id_comm'].">".$comm['nom_comm']." ".$comm['pnom_comm']."</option>"; 
		}
	
$aff.="</select>
</p>
<p>
&nbsp;
</p>
<input name='updatecommercial' type='hidden' value='1'>
<input type='submit' value=' Changer ' />


</form>


<p>
&nbsp;
</p>
";
// envoi reponse Php a Ajax	
echo $aff; 
//echo "<br><br>Valeur postee: ".$_POST['val_sel'];
			
?>


