<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[2]="current";


$allcustomers = $myadmin->ListeClients();
$custom_includes = '
	<link rel="stylesheet" href="includes/autocomplete/themes/base/jquery.ui.all.css">
	<script src="includes/autocomplete/jquery-1.7.1.js"></script>
	<script src="includes/autocomplete/ui/jquery.ui.core.js"></script>
	<script src="includes/autocomplete/ui/jquery.ui.widget.js"></script>
	<script src="includes/autocomplete/ui/jquery.ui.position.js"></script>
	<script src="includes/autocomplete/ui/jquery.ui.autocomplete.js"></script>
	
	<script>
	$(function() {
		var availableTags = [';
foreach($allcustomers as $allcus)
{		
$custom_includes .='	"'.$allcus['entreprise_cl'].'", ';
}
$custom_includes .='			""
		];
		$( "#entreprise" ).autocomplete({
			source: availableTags
		});
	});
	</script>
	
	
	<script type="text/javascript" src="includes/scripts/select_ajax.js"></script>
	
	
	
	
	
	
	
	
	<script type="text/javascript" 
<script type="text/javascript" src="includes/scripts/ajax-functions.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		JQFUNCTIONS.inp();
	});
	
</script>
';




require_once("_header.php");



?>



		

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Nouveau client</h2>
                
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
				if(isset($_POST['addcls']))
				{
				 $exist = $myadmin->ExistClient($_POST['entreprise'],$_POST['telcontact1'],$_POST['emailcontact1']);
				 if($exist == 1)
					{
					$client = $myadmin->AjoutClient($_POST['entreprise'],$_POST['activite'], $_POST['adresse'], $_POST['region'], $_POST['ville'], $_POST['groupe'],$_POST['siteweb'],$_POST['tel1'],$_POST['tel2'],$_POST['fax'],$_SESSION['loginadmin'],$_POST['monactivite']);
					
					
					
					$myadmin->AjouterContact($_POST['nompnom1'],$_POST['emailcontact1'],$_POST['telcontact1'],$_POST['fonctioncontact1'],$client);
					
					
					if(!isset($_POST['contact2']))
					{
						$myadmin->AjouterContact($_POST['nompnom2'],$_POST['emailcontact2'],$_POST['telcontact2'],$_POST['fonctioncontact2'],$client);
					}
					
					if(!isset($_POST['contact3']))
					{
						$myadmin->AjouterContact($_POST['nompnom3'],$_POST['emailcontact3'],$_POST['telcontact3'],$_POST['fonctioncontact3'],$client);
					}
					
					echo '<div class="notification information">

					L\'enregistrement à été ajouté.

				</div>';
				
				
				$myadmin->LogMe('a ajouté le client : <a href="detailsclient.php?client='.$client.'">'.$_POST['entreprise'].'</a>', $_SESSION['loginadmin']);
					}
					
					else
					{
						echo '<div class="notification warning">

					Ce client existe déja veuillez <a href="search.php">rechercher le client dans la base</a>

				</div>';
					}
	
				}
				?>
				

                
                <div class="clear"></div>
                
                
                
                <div class="content-box">

					<div class="content-box-header">

						<h3>Ajouter un client</h3>

					</div>

					

					<div class="content-box-content">

						<form action="clients.php" method="post" >

							<fieldset>
                            
                           
								<p>

									<label></label>

									<input name="entreprise" id="entreprise" type="text" class="small" required placeholder="Nom de l'entreprise" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information" id="clientverif">Veuillez entrer le nom de la société .....</span>

								</p>
                                
                                
                                <p>
                                
                                <select name="activite" id="activite" onchange="makeRequest('repPhpAjax_activite.php','activite','monactivite')">
                                    
                                   <option value="0">--Sélectionner--</option> 
                            
                                    <?php
									$secteurs = $myadmin->ListeSecteur();
									foreach($secteurs as $sec)
									{
									?>
			
										<option value="<?= $sec['id_clcat']?>"><?= $sec['libelle_clcat']?></option>
                                        
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

									<input name="adresse" id="adresse" type="text" class="medium"  placeholder="Adresse de la société" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Adresse de la société .....</span>

								</p>
                                
                                
                                <p>

									<label></label>

									<input name="region" id="region" type="text" class="small" placeholder="Région" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">La région.</span>

								</p>
                                
                                
                                	<p>

								

									<select name="ville">
                                    
                                    <?php
									$ville = $myadmin->ListeVille();
									foreach($ville as $v)
									{
									?>
			
										<option value="<?= $v['id_ville']?>"><?= $v['nom_ville']?></option>
                                        
                                        <?php
										}
										?>

									</select>

									<span class="notification information">Ville</span>

									

								</p>
                                
                                 <p>

									<label></label>

									<input name="siteweb" id="siteweb" type="text" class="small" placeholder="www.siteweb.com" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Site web de l'entreprise.</span>

								</p>
                                
                                
                                 <p>

									<label></label>

									<input name="tel1" id="tel1" type="text" class="small" pattern="[0-9]{2}[0-9]{6}" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information" id="telverif">Téléphone 1. (Format : Sans espace)</span>

								</p>
                                
                                
                              <p>

									<label></label>

									<input name="tel2" id="tel2" type="text" class="small"  pattern="[0-9]{2}[0-9]{6}" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information" id="telverif2"> Téléphone 2. (Format : Sans espace)</span>

								</p>
                                
                                
                                 <p>

									<label></label>

									<input name="fax" id="fax" type="text" class="small" pattern="[0-9]{2}[0-9]{6}"  /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Fax. (Format : Sans espace)</span>

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
                         
						<h3>Ajouter un Contact</h3>

					  <hr />
                      
                          <p>

									<label></label>

									<input name="nompnom1" id="nompnom1" type="text" class="small" required placeholder="Nom et prénom" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Nom et prénom.</span>

								</p>
                                
                                  <p>

									<label></label>

									<input name="emailcontact1" id="emailcontact1" type="email" class="small" required placeholder="Email"  /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information" id="verifemailcontact">Email du contact.</span>

								</p>
                                
                                
                                
                                  <p>

									<label></label>

									<input name="telcontact1" id="telcontact1" type="text" pattern="[0-9]{2}[0-9]{6}" class="small" required placeholder="Téléphone" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information" id="veriftelcontact">Téléphone. (Format : Sans espace)</span>

								</p>
                                
                                
                                  <p>

									<select name="fonctioncontact1">
                                    
                                 
                                    
                                    <?php
									$fct = $myadmin->ListeFonction();
									foreach($fct as $fc)
									{
									?>
			
										<option value="<?= $fc['id_fct']?>"><?= $fc['libelle_fct']?></option>
                                        
                                        <?php
										}
										?>

									</select>

									<span class="notification information">Fonction du contact.</span>

								</p>


						<a style="cursor:pointer;" onClick="makeRequest('repPhpAjax_addcontact.php','nompnom1','infocontact2')">Ajouter un nouveau contact</a>
                        
                        
                        
 <div id="infocontact2"> 	<input name="contact2" type="hidden" value=""></div>
 <div id="infocontact3"> 	<input name="contact3" type="hidden" value=""> </div>
								

							</fieldset>

						<input name="addcls" type="hidden" value="">

							<input type="submit" value="Submit" />

						</form>

					</div>

				</div>
				

				

							

			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		