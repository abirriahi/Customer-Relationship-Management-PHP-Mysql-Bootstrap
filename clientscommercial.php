<?php session_start();

if(empty($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != '1')

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[1]="current";


if(isset($_GET['cdr']) && isset($_GET['c']))
{
	$myadmin->ClientDeleteRequest($_SESSION['loginadmin'],$_GET['c']);
	
	$msgdel = '<div class="notification warning" >
	Votre demande de suppression a été transmise à l\'administrateur elle sera validée prochainement (d\'ici là vous voyez le client coloré en rouge)					
</div>';
}



require_once("_header.php");

$mesclient = $myadmin->ListeClientsParCommercial($_GET['comm']);

$commercial = $myadmin->InfoLogger($_GET['comm']);

?>



			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Clients de <?= $commercial['nom_comm'].' '.$commercial['pnom_comm'];?></h2>
                
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
                
                
                
                <?php
				if(isset($msgdel))
				echo $msgdel;
				?>
                
                <div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>Liste des clients</h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						<table class="pagination" rel="15"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->

							<thead>

								<tr>

									<th style="width:170px;">Entreprise</th>
									<th style="width:225px;">Activité</th>
									<th style="width:50px;">Ville</th>
									<th style="width:120px;">Responsable</th>
									<th style="width:50px;">Tél.</th>
									<th style="width:100px;">Email</th>
									<!--<th style="width:125px;">Site web</th>-->
									<th style="width:100px;">Actions</th>

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
						
							foreach($mesclient as $mcls)
							{
					$cts = $myadmin->PrincipalContact($mcls['id_cl']);
					$sitehttp = substr($mcls['siteweb_cl'], 0, 7);
					if($sitehttp == 'http://')
					{
						$prefixe = '';
					}
					else
					{
						$prefixe = 'http://';
					}
					
					$vcdr = $myadmin->VerifierClientOnDeleteRequest($mcls['id_cl']);
					if($vcdr == 1) {$styletr = 'style="color:#F00;"';}
					else {$styletr = '';}
					
					$couleurclient = $myadmin->AfficheCodeCouleurClient($mcls['id_cls']);
							?>	
								<tr <?= $styletr?>>

									<td style="font-weight:bold;"><a href="detailsclient.php?client=<?= $mcls['id_cl']?>" target="_blank" style="color:<?= $couleurclient?>;"><?= stripslashes($mcls['entreprise_cl'])?></a></td>
									<td><?= $myadmin->AfficherSecteur($mcls['id_clcat'])?></td>

									<td><?= $myadmin->NomVille($mcls['id_ville']);?></td>
									<td><?= $cts['nom_ctc'] ?></td>
									<td><?= $cts['tel_ctc'] ?></td>
									<td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
									<!--<td><a href="<?php /*$prefixe.$mcls['siteweb_cl']*/?>" target="_blank"><?php /*$mcls['siteweb_cl']*/?></a></td>-->
									<td>
                                    
                                    <a href="detailsclient.php?client=<?= $mcls['id_cl']?>" target="_blank"><img src="images/icons/view.png" alt="Historique" /></a>

									<a href="editclients.php?client=<?= $mcls['id_cl']?>"><img src="images/icons/pencil.png" alt="Edit" /></a>

											<a href="mesclients.php?cdr=ok&c=<?= $mcls['id_cl']?>" class="confirmation"><img src="images/icons/cross.png" alt="Delete" /></a>

									</td>

								</tr>
							<?php
							}
							?>
										

							</tbody>

						</table>

						

					</div><!-- end .content-box-content -->

					

				</div>
                <div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		