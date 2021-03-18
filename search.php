<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[5]="current";

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
';



if(isset($_POST['search']))
{
	$resultat =  $myadmin->SearchClient(addslashes($_POST['entreprise']));
}

require_once("_header.php");



?>



			

			<div id="content">

			

			  <h2><img src="images/icons/tools_32.png" alt="Manage Users" />Rechercher un client</h2>
              
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
				<div class="content-box">

					<div class="content-box-header">

						<h3>Chercher un client dans toute la base</h3>

					</div>

					

					<div class="content-box-content">

						<form action="" method="post" >

							<fieldset>

								<p>

									<label></label>

									<input name="entreprise" id="entreprise" type="text" class="small" required   />
									<!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez entrer le nom de l'entreprise ou bien le numéro de téléphone...</span>

								</p>

						


							</fieldset>

						<input name="search" type="hidden" value="">

							<input type="submit" value="Rechercher" />

						</form>

					</div>

				</div>
                
                <div class="clear"></div>
                
                
                <?php
				if(sizeof($resultat) != 0)
				{
				?>
                <div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>Resulat de la recherche</h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						<table class="pagination" rel="10"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->

							<thead>

								<tr>

									<th>Entreprise</th>
									<th>Activité</th>

									<th>Ville</th>
									<th>Responsable</th>
									<th>Tél.</th>
									<th>Email</th>
									<th>Site web</th>
									<th>Actions</th>

								</tr>

							</thead>

							

							
							<tfoot>

								<tr>

									<td colspan="8">			

										

									</td>

								</tr>

							</tfoot>

									

							<tbody>

									
						<?php
						
							foreach($resultat as $res)
							{
					$cts = $myadmin->PrincipalContact($res['id_cl']);
					$sitehttp = substr($res['siteweb_cl'], 0, 7);
					if($sitehttp == 'http://')
					{
						$prefixe = '';
					}
					else
					{
						$prefixe = 'http://';
					}
					
					$couleurclient = $myadmin->AfficheCodeCouleurClient($res['id_cls']);
							?>	
								<tr>

									<td style="font-weight:bold;"><a href="detailsclient.php?client=<?= $res['id_cl']?>" style="color:<?= $couleurclient?>"><?= stripslashes($res['entreprise_cl'])?></a></td>
									<td><?= $myadmin->AfficherSecteur($res['id_clcat'])?></td>

									<td><?= $myadmin->NomVille($res['id_ville']);?></td>
									<td><?= $cts['nom_ctc'] ?></td>
									<td><?= $cts['tel_ctc'] ?></td>
									<td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
									<td><a href="<?= $prefixe.$res['siteweb_cl']?>" target="_blank"><?= $res['siteweb_cl']?></a></td>
									<td>
                                    
                                    <a href="detailsclient.php?client=<?= $res['id_cl']?>"><img src="images/icons/view.png" alt="Historique" /></a>

							<?php
	if($res['id_comm'] == $_SESSION['loginadmin'] || $_SESSION['loginadmin'] == '1')
	{
	?>		
 
  <a href="editclients.php?client=<?= $res['id_cl']?>"><img src="images/icons/pencil.png" alt="Edit" /></a>
                                    
       <?php
	}
	   ?>                             
                                    

									<!--		<a href="#" class="confirmation"><img src="images/icons/cross.png" alt="Delete" /></a>--><!-- to create a tooltip-style confirmation, just add .confirmation to the <a>-tag -->

									</td>

								</tr>
							<?php
							}
							?>
										

							</tbody>

						</table>

						

					</div><!-- end .content-box-content -->

					

				</div>
                <?php
				}
				?>
                

							

			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		