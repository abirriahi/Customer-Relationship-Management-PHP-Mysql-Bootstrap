<?php session_start();

if(empty($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != '1')

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[4]="current";




$asupp =  $myadmin->ListeClientsASupprimer();



/*if(isset($_GET['list']) && $_GET['list']=='all')
{
	
}*/

if(isset($_GET['cl']))
{
	$myadmin->DeleteClient($_GET['cl']);
	$myadmin->DeleteRappelsClient($_GET['cl']);
	$myadmin->DeleteListeClientsASupprimer($_GET['cl']);
	$asupp =  $myadmin->ListeClientsASupprimer();
	
}

if(isset($_GET['Supprimer']))
{
	$myadmin->DeleteRappelsClient($_GET['Supprimer']);
	$myadmin->DeleteListeClientsASupprimer($_GET['Supprimer']);
	$asupp =  $myadmin->ListeClientsASupprimer();

	
}


require_once("_header.php");



?>



			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Demande de suppression des clients</h2>
				<div class="clear"></div><!-- end .content-box -->

				

			  <div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>Users</h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						<table class="pagination" rel="5"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->

							<thead>

								<tr>

									<th><span style="width:170px;">Entreprise</span></th>
									<th>Activité</th>
									<th>Ville</th>
									<th>Responsable</th>
									<th>Tél.</th>
									<th>Email</th>
									<th>Commercial</th>
									<th>        </th>
									<th> Actions </th>
									<th>        </th>

								</tr>

							</thead>

							

							<tfoot>

								<tr>

									<td colspan="8">			

										<div class="bulk-actions"><a href="?list=all" class="confirmation">Appliquer à toute la liste</a>

										</div>

									</td>

								</tr>

							</tfoot>

									

							<tbody>

									
					<?php
					foreach($asupp as $cf)
					{
						$cl = $myadmin->DetailsClient($cf['id_cl']);
						$comm = $myadmin->InfoLogger($cf['id_comm']);
					?>
								<tr>

									<td><?= stripslashes($cl['entreprise_cl']);?></td>
									<td><?= $myadmin->AfficherSecteur($cl['id_clcat'])?></td>
									<td><?= $myadmin->NomVille($cl['id_ville']);?></td>
									<td><?= $cl['nom_ctc'] ?></td>
									<td><?= $cl['tel_ctc'] ?></td>
									<td><a href="mailto:<?= $cl['email_ctc'] ?>"><?= $cl['email_ctc'] ?></a></td>
									<td><?= $comm['nom_comm'].' '.$comm['pnom_comm'];?></td>
									<td>
                                    <div class="bulk-actions"><a  href="?cl=<?= $cl['id_cl']?>" class="confirmation">Supprimer</a>

									</div>

									</td>

									<td>
									<?php
	if($commercialclient == $_SESSION['loginadmin'] || $_SESSION['loginadmin'] == '1')
	{
											//Mise a jour Statut client//
				if(isset($_POST['etatinteresse']))
				{
					$myadmin->UpdateStatutClient($_POST['interesse'],$cl['id_cl']);
					
					$libelleclient = stripslashes($cl['entreprise_cl']);
					$interretclient = $myadmin->AfficheLigneStatutCl($_POST['interesse']);
					$couleurclient = $myadmin->AfficheCodeCouleurClient($_POST['interesse']);
					
					$myadmin->LogMe('a changé le statut du client <a href="detailsclient.php?client='.$client.'" style="color:'.$couleurclient.'">'.$libelleclient.'</a> en '.$interretclient['libelle_cls'], $_SESSION['loginadmin']);
					
				
				$cl = $myadmin->DetailsClient($client);
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
						 echo '<br><span style="padding-left:10px; font-weight:bold;"><a href="choisir_editions.php?client='.$client.'" style="color:#ff0000;">Remplir les éditions signé</a></span>';
					 }
					 
					 
				 }
				 ?>
                 
                 </form>
                      
                 <?php
				 
				}	
				 ?>
									</td>
									
									
									<td><div class="bulk-actions"><a  href="?Supprimer=<?= $cl['id_cl']?>" class="confirmation"><img src="images/icons/cross.png"  /></a></td>

								</tr>

						<?php
					}
						?>			

							</tbody>

						</table>

						

					</div><!-- end .content-box-content -->

					

			  </div>

				

			  <div class="clear"></div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		