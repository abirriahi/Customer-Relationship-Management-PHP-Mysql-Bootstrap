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

$commercialclient = $cl['id_comm'];

if(($commercialclient == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
{
	


require_once("_header.php");




?>


<script type="text/javascript" src="includes/scripts/select_ajax.js"></script>
			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Edition Client</h2>
                
                
                
                 <?php
				if($_SESSION['loginadmin'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="notification error" >
					Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a>
					</div>';
				}
				
				?>
                
                
				<div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>

				

							<?php
				if(isset($_POST['udpatecls']))
				{
				
					$myadmin->UpdateClient($_POST['entreprise'],$_POST['activite'], $_POST['adresse'], $_POST['region'], $_POST['ville'], $_POST['groupe'],$_POST['siteweb'],$_POST['tel1'],$_POST['tel2'],$_POST['fax'],$commercialclient,$_POST['monactivite'],$client);
					
					
					
					$myadmin->UpdateContact($_POST['nompnom1'],$_POST['emailcontact1'],$_POST['telcontact1'],$_POST['fonctioncontact1'],$client,$_POST['idcontact1']);
					
					$contactclient = $myadmin->ListeContactParClient($client);
				    $sizecontactclient = sizeof($contactclient);
					
					
					if(!isset($_POST['contact2']))
					{
						if($sizecontactclient == 2 || $sizecontactclient == 3)
						{
						$myadmin->UpdateContact($_POST['nompnom2'],$_POST['emailcontact2'],$_POST['telcontact2'],$_POST['fonctioncontact2'],$client,$_POST['idcontact2']);
						}
						else
						{
							$myadmin->AjouterContact($_POST['nompnom2'],$_POST['emailcontact2'],$_POST['telcontact2'],$_POST['fonctioncontact2'],$client);
						}
					}
					
					if(!isset($_POST['contact3']))
					{
						if($sizecontactclient == 3)
						{
						$myadmin->UpdateContact($_POST['nompnom3'],$_POST['emailcontact3'],$_POST['telcontact3'],$_POST['fonctioncontact3'],$client,$_POST['idcontact3']);
						}
						else
						{
							$myadmin->AjouterContact($_POST['nompnom3'],$_POST['emailcontact3'],$_POST['telcontact3'],$_POST['fonctioncontact3'],$client);
						}
					}
					
					
					if(isset($_POST['nompnom2']))
					{
						
					}
					
					if(isset($_POST['nompnom3']))
					{
						
					}
					
					
					
					echo '<div class="notification information">

					Mise à jour effectué. <a href="detailsclient.php?client='.$client.'">Voir la fiche client</a>

				</div>';
				
				$myadmin->LogMe('a mis à jour les information du client : <a href="detailsclient.php?client='.$client.'">'.$_POST['entreprise'].'</a>', $_SESSION['loginadmin']);
					
					
					$cl = $myadmin->DetailsClient($client);
	
				}
				?>
				

                
                <div class="clear"></div>
                
                
                
                <div class="content-box">

					<div class="content-box-header">

						<h3>Editer le client : <?= $cl['entreprise_cl']?></h3>

					</div>

					

					<div class="content-box-content">

						<form action="" method="post" >

							<fieldset>

								<p>

									<label></label>

									<input name="entreprise" id="entreprise" type="text" class="small" required  value="<?= stripslashes($cl['entreprise_cl'])?>" />
									<!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez modifier le nom de la société .....</span>

 <span style="float:right"><a href="detailsclient.php?client=<?= $client?>"><img src="images/icon/back.png" width="64" height="64" alt="Retour" title="Retour" /></a></span>

								</p>
                                
                                
                                <p>
                                
                                <select name="activite" id="activite" onchange="makeRequest('repPhpAjax_activite.php','activite','monactivite')">
                                    
                                   <option value="0">--Sélectionner--</option> 
                            
                                    <?php
									$secteurs = $myadmin->ListeSecteur();
									foreach($secteurs as $sec)
									{
										if($cl['id_clcat']==$sec['id_clcat']) $select = 'selected="selected"'; else $select ="";
									?>
			
										<option value="<?= $sec['id_clcat']?>" <?= $select?> ><?= $sec['libelle_clcat']?></option>
                                        
                                        <?php
										}
										?>

									</select>
                                    
                                    <span class="notification information">Secteur d'activité</span>
                                    
                                  
                                
                                </p>
                                
                                
                                 <div id="monactivite">
                                 &nbsp;
                                 
                                 </div> 
                                
                                
                              <p>

									<label></label>

									<input name="adresse" id="adresse" type="text" class="medium" value="<?= stripslashes($cl['adresse_cl'])?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Adresse de la société .....</span>

								</p>
                                
                                
                                <p>

									<label></label>

									<input name="region" id="region" type="text" class="small" value="<?= stripslashes($cl['region_cl'])?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">La région.</span>

								</p>
                                
                                
                                	<p>

								

									<select name="ville">
                                    
                                    <?php
									$ville = $myadmin->ListeVille();
									foreach($ville as $v)
									{
										if($cl['id_ville']==$v['id_ville']) $select = 'selected="selected"'; else $select ="";
									?>
			
										<option value="<?= $v['id_ville']?>" <?= $select?>><?= $v['nom_ville']?></option>
                                        
                                        <?php
										}
										?>

									</select>

									<span class="notification information">Ville</span>

									

								</p>
                                
                                 <p>

									<label></label>

									<input name="siteweb" id="siteweb" type="text" class="small" value="<?= $cl['siteweb_cl']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Site web de l'entreprise.</span>

								</p>
                                
                                
                                 <p>

									<label></label>

									<input name="tel1" id="tel1" type="text" class="small" pattern="[0-9]{2}[0-9]{6}" value="<?= $cl['tel1_cl']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Téléphone 1.</span>

								</p>
                                
                                
                              <p>

									<label></label>

									<input name="tel2" id="tel2" type="text" class="small"  pattern="[0-9]{2}[0-9]{6}" value="<?= $cl['tel2_cl']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information"> Téléphone 2.</span>

								</p>
                                
                                
                                 <p>

									<label></label>

									<input name="fax" id="fax" type="text" class="small" pattern="[0-9]{2}[0-9]{6}" value="<?= $cl['fax_cl']?>"  /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Fax.</span>

								</p>
                                
                                
                                <p>

								

									<select name="groupe">
                                    
                                    
                                    <option value="0" selected="selected">Pas de groupe</option>
                                    
                                    <?php
									$groupe = $myadmin->ListeGroupe();
									foreach($groupe as $g)
									{
									?>
			
										<option value="<?= $g['id_gr']?>"><?= $g['libelle_gr']?></option>
                                        
                                        <?php
										}
										?>

									</select>

									<span class="notification information">Groupe</span>

									

								</p>
                                
                                <hr />
                         
						<h3>Editer les Contacts</h3>

					  <hr />
                      <?php
					  
					$contactclient = $myadmin->ListeContactParClient($client);
				    $sizecontactclient = sizeof($contactclient);
					
					for($i=0;$i<$sizecontactclient;$i++)
					{
						
					  
					  ?>
                      
                      <p>

									<label></label>

									<input name="nompnom<?= $i+1?>" id="nompnom<?= $i+1?>" type="text" class="small" value="<?= $contactclient[$i]['nom_ctc']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Nom et prénom.</span>

								</p>
                                
                                  <p>

									<label></label>

									<input name="emailcontact<?= $i+1?>" id="emailcontact<?= $i+1?>" type="email" class="small" required value="<?= $contactclient[$i]['email_ctc']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Email du contact.</span>

								</p>
                                
                                
                                
                                  <p>

									<label></label>

									<input name="telcontact<?= $i+1?>" id="telcontact<?= $i+1?>" type="text" pattern="[0-9]{2}[0-9]{6}" class="small" required value="<?= $contactclient[$i]['tel_ctc']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Téléphone.</span>

								</p>
                                
                                
                                  <p>

									<select name="fonctioncontact<?= $i+1?>">
                                    
                                 
                                    
                                    <?php
									$fct = $myadmin->ListeFonction();
									foreach($fct as $fc)
									{
										if($contactclient[$i]['id_fct']==$fc['id_fct']) $select = 'selected="selected"'; else $select ="";
									?>
			
										<option value="<?= $fc['id_fct']?>" <?= $select ?>><?= $fc['libelle_fct']?></option>
                                        
                                        <?php
										}
										?>

									</select>

									<span class="notification information">Fonction du contact.</span>

								</p> 
                                <input name="idcontact<?= $i+1?>" type="hidden" value="<?= $contactclient[$i]['id_ctc']?>" />
                      <hr />
                      <?php
					  
					}
					  
					  ?>
                         
				<?php
				if($sizecontactclient == 1)
				{
				?>
                <a style="cursor:pointer;" onClick="makeRequest('repPhpAjax_addcontact.php','nompnom1','infocontact2')">Ajouter un nouveau contact</a>
                        
                        
                        
 <div id="infocontact2"> 	<input name="contact2" type="hidden" value=""></div>
 <div id="infocontact3"> 	<input name="contact3" type="hidden" value=""> </div>
 
 				<?php
				}
				if($sizecontactclient == 2)
				{
				?>
                <a style="cursor:pointer;" onClick="makeRequest('repPhpAjax_addanothercontact.php','nompnom1','infocontact3')">Ajouter un nouveau contact</a>
<div id="infocontact3"> 	<input name="contact3" type="hidden" value=""> </div>
                <?php
				}
				if($sizecontactclient == 3)
				{
					echo '';
				}
				?>
                

						
								

							</fieldset>

						<input name="udpatecls" type="hidden" value="">

							<input type="submit" value="Mise à jour" />

						</form>

					</div>

				</div>
				

				

							

			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");
}
?>		