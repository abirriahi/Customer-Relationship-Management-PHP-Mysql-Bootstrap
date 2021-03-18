<?php session_start();

if(empty($_SESSION['loginadmin']))

     {

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}



require_once("_top.php");


//current
$menu[1]="current";


if(isset($_GET['client']))
{
	$client = $_GET['client'];
	$cl = $myadmin->DetailsClient($client);
}


$sitehttp = substr($cl['siteweb_cl'], 0, 7);
if($sitehttp == 'http://')
{
	$prefixe = '';
}
else
{
	$prefixe = 'http://';
}


$custom_includes ='

<style type="text/css">
.titre
{
	font-weight:bold;
	font-size:14px;
}

.fiche
{
border: 1px solid #000000;
padding: 60px 0;
color:#000000;
text-align: center; width: 300px;
-webkit-border-radius: 15px;
-moz-border-radius: 15px;
border-radius: 15px;
-webkit-box-shadow: #666 0px 2px 5px;
-moz-box-shadow: #666 0px 2px 5px;
box-shadow: #666 0px 2px 5px;
background: #FFE1E7;
background: -webkit-gradient(linear, 0 0, 0 bottom, from(#FFE1E7), to(#FE8A91));
background: -webkit-linear-gradient(#FFE1E7, #FE8A91);
background: -moz-linear-gradient(#FFE1E7, #FE8A91);
background: -ms-linear-gradient(#FFE1E7, #FE8A91);
background: -o-linear-gradient(#FFE1E7, #FE8A91);
background: linear-gradient(#FFE1E7, #FE8A91);
float:left;
margin-right:10px;
}

.nomcontact
{
	color:#000000;
	font-size:16px;
	font-weight:bold;
	
}

.fctcontact
{
	color:#000000;
	font-size:12px;
	font-weight:bold;
	font-style:italic;
	
}

.emailcontact
{
	color:#000000;
	font-size:12px;
	font-weight:bold;
}

.telcontact
{
	color:#000000;
	font-size:15px;
	font-weight:bold;
}

.messagenoclient
{
	color:#000000;
	font-size:15px;
	font-weight:bold;
	clear:both;
	
}

.space
{
	height:10px;
}

</style>


';


 if(isset($_POST['updatecommercial']))
{
	$myadmin->UpdateCommercialClient($client,$_POST['commerciaux']);
	$cl = $myadmin->DetailsClient($client);
}

//Mise à jour du statut de rappel
if(isset($_GET['statut'])&& $_GET['statut']=='read' && isset($_GET['commentaire']))
{
	$myadmin->MiseAJourRappelRead($client,$_GET['commentaire'],'1');
}

$interretclient = $myadmin->AfficheLigneStatutCl($cl['id_cls']);



require_once("_header.php");


$commercialclient = $cl['id_comm'];
if($commercialclient == $_SESSION['loginadmin'])
{
	$quiestlecommercial = 'Commercial : vous.';
}
else
{
	$infocommercial = $myadmin->InfoLogger($cl['id_comm']);
	$nomcommercial = $infocommercial['nom_comm'].' '.$infocommercial['pnom_comm'];
	$quiestlecommercial = 'Commercial : '.$nomcommercial;
}
?>
<script type="text/javascript" src="includes/scripts/select_ajax.js"></script>

<script src="includes/calender/src/js/jscal2.js"></script>
 <script src="includes/calender/src/js/lang/fr.js"></script>
 <link rel="stylesheet" type="text/css" href="includes/calender/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="includes/calender/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="includes/calender/src/css/steel/steel.css" />
			

			<div id="content">

			

			  <h2><img src="images/icons/user_32.png" alt="Manage Users" />Details du client</h2>
              
              
               <?php
			   
			  
			   
				if($_SESSION['loginadmin'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="notification error" >
					Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a>
					</div>';
				}
				
				 if($cl['id_cls'] == '5')
				{
					$listemagazine = $myadmin->ListeEditionsClient($client);
					$listmag = '';
					if(!empty($listemagazine))
					{
						foreach($listemagazine as $lmag)
						{
							$listmag .= $lmag['num_mag'].' ; ';
						}
					}
					
					echo '<div class="clientsigne" style="font-weight:bold;" >
					Le client a signé pour les éditions : <span style="font-size:15px;">'.$listmag.'</span>
					</div>';
				}
				
				?>
                
                
				<div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>
                <?php
	if($_SESSION['loginadmin'] == '1')
	{
		
		echo '<a style="cursor:pointer;" onclick="makeRequest(\'repPhpAjax_ChangeCommercial.php\',\'commercialclient\',\'listecommercial\')">Changer le commercial</a> 
		
		<div id="listecommercial">&nbsp;</div>
		
		';
	}
	
	?>
    
    
  			  <?php
			  //Sauvgarde commentaire
				if(isset($_POST['savecomments']))
				{
					
					$idcommentaire = $myadmin->InsererCommentaire($_POST['comment'],$client,$_POST['contactclient'],$_SESSION['loginadmin']);
					
					$timerappel =  $_POST['heurerappel'].':'. $_POST['minuterappel'];
					
					$idnewrappel = $myadmin->AjouterRappel($_SESSION['loginadmin'],$client,$idcommentaire, $_POST['daterappel'], $timerappel);
					
					$myadmin->MiseAJourAncienRappel($client, $idnewrappel, '2');
					
					echo '<div class="notification information">

					L\'enregistrement à été ajouté.

				</div>';
				
				$libelleclient = stripslashes($cl['entreprise_cl']);
				
				
				$myadmin->LogMe('a ajouté un commentaire dans la fiche du client : <a href="detailsclient.php?client='.$client.'">'.$libelleclient.'</a>', $_SESSION['loginadmin']);
	
				}
				
				?>
				<div class="content-box">

					

					

					<div class="content-box-content">

	<h1 style="color:<?= $interretclient['couleur_cls']?>;"><?= stripslashes($cl['entreprise_cl']);?> 
    
    
    <?php
	if($commercialclient == $_SESSION['loginadmin'] || $_SESSION['loginadmin'] == '1')
	{
	?>
	  <a href="editclients.php?client=<?= $client?>"><img src="images/icons/pencil.png" width="16" height="16" /></a> 
      <?php
	}
	  ?>
      <input name="commercialclient" id="commercialclient" type="hidden" value="<?= $commercialclient; ?>" />
      
      <span style="font-size:14px;font-style:italic; color:#000000; float:right;">
	  <?= $quiestlecommercial ?></span></h1>
    
    <span style="float:right"><a href="mesclients.php"><img src="images/icon/back.png" width="64" height="64" alt="Retour" title="Retour" /></a></span>
    
    <p style="font-style:italic; font-size:14px;">
	<?php
	if($cl['id_clcat'] == 3)
	{
		echo $myadmin->AfficherSecteur($cl['id_clcat']).' ('.$cl['activite_cl'].')';
	}
	else
	{
		echo $myadmin->AfficherSecteur($cl['id_clcat']);
	}
	
	
	?>
    </p>

					
				<p><span class="titre">Adresse :</span> <?= stripslashes($cl['adresse_cl'].' '.stripslashes($cl['region_cl']))?></p>
                <p><span class="titre">Ville : </span><?= $myadmin->NomVille($cl['id_ville'])?></p>
                <p><span class="titre">Site web :</span> <a href="<?= $prefixe.$cl['siteweb_cl'];?>" target="_blank"><?= $cl['siteweb_cl'];?></a></p>
                <hr />
                <p><span class="titre">Téléphone :</span> <?= $cl['tel1_cl']?> <?php if($cl['tel2_cl'] != '') echo ' / '.$cl['tel2_cl']?></p>
                
                <p><span class="titre">Fax :</span> <?= $cl['fax_cl']?></p>
                
                <hr />
                
                <h2 style="color:#F00;">Contacts</h2>
                <?php
				$contactclient = $myadmin->ListeContactParClient($client);
				foreach($contactclient as $lcc)
				{
					echo '<div class="fiche">
					<span class="nomcontact">'.$lcc['nom_ctc'].'</span>
					<br><br><span class="fctcontact">'.$myadmin->AfficherFonctionContact($lcc['id_fct']).'</span>
					<br><br><span class="emailcontact"> <a href="mailto:'.$lcc['email_ctc'].'">'.$lcc['email_ctc'].'</a></span>
					<br><br><span class="telcontact">'.$lcc['tel_ctc'].'</span>
					</div>';
				}
				?>
                
                
                 <?php
	if($commercialclient == $_SESSION['loginadmin'] || $_SESSION['loginadmin'] == '1')
	{
		
		//Mise a jour Statut client//
				if(isset($_POST['etatinteresse']))
				{
					$myadmin->UpdateStatutClient($_POST['interesse'],$client);
					
					$libelleclient = stripslashes($cl['entreprise_cl']);
					$interretclient = $myadmin->AfficheLigneStatutCl($_POST['interesse']);
					$couleurclient = $myadmin->AfficheCodeCouleurClient($_POST['interesse']);
					
					$myadmin->LogMe('a changé le statut du client <a href="detailsclient.php?client='.$client.'" style="color:'.$couleurclient.'">'.$libelleclient.'</a> en '.$interretclient['libelle_cls'], $_SESSION['loginadmin']);
					
				
				$cl = $myadmin->DetailsClient($client);
				}
	?>
    
                <div style="clear:both; height:10px;"></div>
                <a name="interret"></a>
                    <hr />
                    <?php
					//Client Intéressé oui ou non
					
					if($cl['id_cls'] == '0')
					{
						echo '<h2 style="color:#F00; ">Client intéressé ? Veuillez choisir</h2>';
					}
					else 
					{
						echo '<h2 style="color:'.$interretclient['couleur_cls'].'; ">Client '.$interretclient['libelle_cls'].'</h2>';
					}
					
					?>
				
                 <form action="#interret" method="post">
                 <input name="etatinteresse" type="hidden" value="" />
                 <select name="interesse" required>
                   <option value="">--Changer--</option>
                   <?php
				   $statut = $cl['id_cls'];
				   $listeinterr = $myadmin->ListeStatutInteresse();
				   foreach($listeinterr as $lint)
				   {
					   if($statut == $lint['id_cls'])
					   $selected = 'selected="selected"';
					   else
					   $selected = '';
				   ?>
                   <option value="<?= $lint['id_cls'] ?>" style="background-color:<?= $lint['couleur_cls'] ?>; color:#ffffff;" <?= $selected ?>  ><?= $lint['libelle_cls'] ?></option>
                	<?php
					}
					?>
                 
                 </select>
                 
                 <input type="submit" value="Mettre à jour" onclick="makeRequest('repPhpAjax_miseajourstatut.php','activite','monactivite')" />
                 
                 <?php
				 if($statut == '5')
				 {
					 if(!empty($listemagazine))
					 {
						 echo '<span style="padding-left:10px; font-weight:bold;"><a href="choisir_editions.php?client='.$client.'" style="color:#ff0000;">Mettre à jour les éditions signé</a></span>';
					 }
					 else
					 {
						 echo '<span style="padding-left:10px; font-weight:bold;"><a href="choisir_editions.php?client='.$client.'" style="color:#ff0000;">Remplir les éditions signé</a></span>';
					 }
					 
					 
				 }
				 ?>
                 
                 </form>
                      
                 <?php
				 
				}	
				 ?>
               
                        
					  <div class="clear"></div>

						

					</div>

				</div>

							

			</div><!-- end #content -->
            
            
            
            <div id="content">

			

			
				<div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>
                
                 <?php
	if($commercialclient == $_SESSION['loginadmin'] || $_SESSION['loginadmin'] == '1')
	{
	?>
                
                <a name="commentslist"></a>
                
                <a href="#commentsbloc">Ajouter un nouveau commentaire</a>		                &nbsp;&nbsp;&nbsp; 
                <?php
				if(sizeof($contactclient) > 1)
				{
					echo 'Afficher les messages de ';
					foreach($contactclient as $lcc)
					{
						echo '<a href="detailsclient.php?client='.$client.'&contactavec='.$lcc['id_ctc'].'#commentslist">'.$lcc['nom_ctc'].'</a> | ';
               
					}
					
					echo '  <a href="detailsclient.php?client='.$client.'#commentslist">Tous</a>';
				}
				?>
              	
                <div class="space"></div>
                
                <?php
	}
				?>
                
				<div class="content-box">

				<?php
				if($commercialclient == $_SESSION['loginadmin'] || $_SESSION['loginadmin'] == '1')
				{
				
				?>
                
                <div class="content-box-content">
 <form action="detailsclient.php?client=<?= $client?>#commentslist" method="post">               
<input name="client" id="client" type="hidden" value="<?= $client?>" />
<input name="savecomments" id="savecomments" type="hidden" value="1" />
		<?php
		if(isset($_GET['contactavec']))
		{
			$marequete = $myadmin->CommentaireClientContact($client, $_GET['contactavec']);
		}
		else
		{
			$marequete =$myadmin->CommentaireClient($client);
		}
		
		$comm = $marequete;
		$nbrcomments = sizeof($comm);
		if(!empty($comm))
		{
		foreach($comm as $key => $com)
		{
			$nbr = $nbrcomments - $key;
			$ctc = $myadmin->DetailsContact($com['id_ctc']);
		?>			
        <p><span class="titre">Contact le : <?php echo date("d/m/Y H:i:s", strtotime($com['date_cm']));?></span>
        <span style="float:right">Commentaire N° : <?php echo $nbr ?></span></p>
        
		<p><span class="titre">Avec : </span><?= $ctc['nom_ctc']?> (<?= $ctc['tel_ctc']?>) / <span class="titre">Email :</span><a href="mailto: <?= $ctc['email_ctc'] ?>"> <?= $ctc['email_ctc'] ?></a>
        
        <?php
		//Verifier si il y a un rappel pour ce commentaire//
	$rappelcommentaire = $myadmin->RappelParCommentaire($client , $com['id_cm']);
	if(!empty($rappelcommentaire))
	{
		if($rappelcommentaire['etat_rapp']=='0')
		$colornotif = 'color:#ff0000;';
		if($rappelcommentaire['etat_rapp']=='1')
		$colornotif = 'color:#ff0000;';
		if($rappelcommentaire['etat_rapp']=='2')
		$colornotif = 'color:#090;';
		?>
        <span style="float:right; <?= $colornotif?>  ">Rappel programé pour le : <?= $rappelcommentaire['date_rapp']?> à <?= $rappelcommentaire['time_rapp']?></span>
        <?php
	}
		?>
        <br />
        <span style="float:right; color:#06F;">
		<?php 
		if($com['id_comm'] != '0')
		{
			echo 'Commercial : ';
		$comemrcialquiacontacter = $myadmin->InfoLogger($com['id_comm']);
		echo $comemrcialquiacontacter['nom_comm'].' '.$comemrcialquiacontacter['pnom_comm'];
		}
		 ?></span>
        </p>
		<p><span class="titre">Note : </span><?= stripslashes($com['contenu_cm'])?>
       
        </p>
        
		<hr />
         <?php
		}
		
		//Liste contact
		$listecpcl = $myadmin->ListeContactParClient($client);
			$listederoulante="";
			$listederoulante.="

 <p>  
 <label>Contact </label>
<select name='contactclient' id='contactclient' required>";

$listederoulante.="<option value=''>-- Qui vous avez contacter ? --</option>";

foreach($listecpcl as $lcc)
{
$fct = $myadmin->AfficherFonctionContact($lcc['id_fct']);

$listederoulante.="<option value=".$lcc['id_ctc'].">".$lcc['nom_ctc']." ( ".$fct." )</option>"; 

		}
	
$listederoulante.="</select>
</p>";
			echo $listederoulante;
		
		
		}
		else
		{
			echo '<span class="messagenoclient"> Il n\'y a pas des commentaires pour ce client</span>';
			echo '<div class="space">&nbsp;</div>';
			$listecpcl = $myadmin->ListeContactParClient($client);
			$listederoulante="";
			$listederoulante.="

 <p>  
 <label>Contact </label>
<select name='contactclient' id='contactclient' required>";

$listederoulante.="<option value=''>-- Qui vous avez contacter ? --</option>";

foreach($listecpcl as $lcc)
{
$fct = $myadmin->AfficherFonctionContact($lcc['id_fct']);

$listederoulante.="<option value=".$lcc['id_ctc'].">".$lcc['nom_ctc']." ( ".$fct." )</option>"; 

		}
	
$listederoulante.="</select>
</p>";
			echo $listederoulante;
		}
		
		
		
		
		?>     
        		<a name="commentsbloc"></a>
          
       							<p>
									Commentaire : 
                                    <br />
						<textarea class="wysiwyg"  name="comment" required></textarea>

								</p>
                                
                                <p>
                                Date de prochain rappel :
                                <br />
                                <input id="f_date1" type="hidden"  />
                                 <input size="10" name="daterappel" id="f_date" required />
                                 <input size="4" name="heurerappel" id="f_hour" required />
                                 <input size="4" name="minuterappel" id="f_minute" required />
                                 
                                 <button id="f_btn1">...</button><br />

    <script type="text/javascript">//<![CDATA[
	 function updateFields(cal) {
              var date = cal.selection.get();
              if (date) {
                      date = Calendar.intToDate(date);
                      document.getElementById("f_date").value = Calendar.printDate(date, "%Y-%m-%d");
              }
              document.getElementById("f_hour").value = cal.getHours();
              document.getElementById("f_minute").value = cal.getMinutes();
      };

	
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        showTime   : 24,
        dateFormat : "%Y-%m-%d %H:%M",
		onSelect     : updateFields,
        onTimeChange : updateFields
      });
    //]]></script>
                                
                                </p>
                        
					  <div class="clear"></div>
			<input type="submit" value="Enregistrer" />
					</form>	

					</div>
                
                
                <?php
				
				}
				?>	

					

					

				</div>

							

			</div>

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		