<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


$menu[0] ="current";






require_once("_header.php");

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$tousmesclients = $myadmin->ListeClientsParCommercial($_SESSION['loginadmin']);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($_SESSION['loginadmin']);




?>

<script src="includes/calender/src/js/jscal2.js"></script>
 <script src="includes/calender/src/js/lang/fr.js"></script>
 <link rel="stylesheet" type="text/css" href="includes/calender/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="includes/calender/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="includes/calender/src/css/matrix/matrix.css" />
     <style type="text/css">
      .highlight { color: #f00 !important; }
      .highlight2 { color: #0f0 !important; font-weight: bold; }
    </style>

			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Gestion des clients</h2>
                
                
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

			

				<div class="notification information" style="font-weight:bold; font-size:14px">

					Bienvenue 
					<?= $me['nom_comm'].' '.$me['pnom_comm'] ?>
				 </div>

				

				<div class="content-box column-left sidebar"><!-- use the class .sidebar in combination with .column-left to create a sidebar --><!-- using .closed makes sure the content box is closed by default -->

					<div class="content-box-header">

						<h3>Statistiques</h3>

					</div>

					

					<div class="content-box-content">

						<p>Nombre total des clients dans la base : <?= $nbrallclient ?> client(s)</p>
                        
                        <p>Nombre total de mes clients: <?= $nbrmesclients ?> client(s)</p>
                        
                        <?php
						
						$interesse = $myadmin->ListeStatutInteresse();
						foreach($interesse as $inter)
						{
							$lisinterr = $myadmin->ClientInteresseParCommercial($inter['id_cls'],$_SESSION['loginadmin']);
							$nbrinterr = sizeof($lisinterr);
						?>
                        <p>Nbr de mes clients <?= '<span style="font-weight:bold;"><a href="mesclients.php?interesse='.$inter['id_cls'].'" target="_blank" style="color:'.$inter['couleur_cls'].'">'.$inter['libelle_cls'].'</a></span>' ?>: <?= $nbrinterr ?></p>
                        <?php
						}
						?>
                       

						

					</div>

				</div>
                
                
                
                
                
                
                
                
              

				

				<div class="content-box column-right main">

					<div class="content-box-header">

						<h3 style=" color:#03F;">
                        Liste des rappels pour aujourd'hui le : <?= date("d/m/Y")?>
                        </h3>

					</div>

					<div class="content-box-content">
                    
                     <?php
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['loginadmin'],date("Y-m-d"));
						if(!empty($oldrappels))
						{
							$nbroldrapps = sizeof($oldrappels);
							echo '<span style="color:red; font-size:12px;">Vous avez <span style="font-weight:bold; font-size:14px;">'.$nbroldrapps.'</span> anciens rappels qui ne sont pas commenté ou appelé </span>';
							echo '<div style="clear:both; height:5px;"></div>';
						
						}
					else
						{
							echo '';
						}
						?>
                    
                    
						 <?php
						$rappels =  $myadmin->AfficherMesRappel($_SESSION['loginadmin'],date("Y-m-d"));
						if(!empty($rappels))
						{
							$nbrrapps = sizeof($rappels);
							echo '<span style="color:green;font-size:12px;">Vous avez <span style="font-weight:bold; font-size:14px;">'.$nbrrapps.'</span> rappels pour aujourd\'hui </span>';
						
						}
					else
		{
			echo '<span class="messagenoclient"> Il n\'y a pas des rappels pour aujourd\'hui</span>';
		}
		
		
		
		
		//Afficahge des rappel du jour
		
				if(!empty($rappels))
						{
						foreach($rappels as $rapp)
						{
							
							
							$quiclient = $myadmin->DetailsClient($rapp['id_cl']);
							$quiclient = $quiclient['entreprise_cl'];
							$vueornot = $rapp['etat_rapp'];
							
						
							
							if($vueornot == '0' && ($rapp['time_rapp'] > date("H:i")))
							{
								$classnotif="rappelnotification";
							}
							if($vueornot == '0' && ($rapp['time_rapp'] < date("H:i")))
							{
								$classnotif="rappeloubliernotification";
							}
							if($vueornot == '1' && ($rapp['time_rapp'] > date("H:i")))
							{
								$classnotif="rappelvuenotification";
							}
							
							if($vueornot == '1' && ($rapp['time_rapp'] < date("H:i")))
							{
								$classnotif="rappeloubliernotification";
							}
							
							
							
							
						?>
						<p>
                        <div class="<?= $classnotif ?>">
                       Rappel avec le client : <?= stripslashes($quiclient) ?> à <?= $rapp['time_rapp']?> --- <a href="detailsclient.php?client=<?= $rapp['id_cl'];?>&commentaire=<?= $rapp['id_cm'];?>&statut=read#commentslist">Voir la fiche client</a>
                        </div>
                        </p>
                        <?php
						}
						}
						
						?>
						

						

					</div>

					<!-- end .content-box-content -->

				</div>
                
              <div class="clear"></div>
                
                <?php
				//Pour Administrateur
				if($_SESSION['loginadmin'] == 1)
				{				
				?>
                <div class="content-box column-right main" style="width:630px;">

					<div class="content-box-header">

						<h3>Les infos Logs</h3>

					</div>

					

					<div class="content-box-content">
					<?php
				$listelogs = $myadmin->ListeDesLogs(20);	
				foreach($listelogs as $llogs)
				{
					$logger = $myadmin->InfoLogger($llogs['id_comm']);
					$logger = $logger['nom_comm'].' '.$logger['pnom_comm'];
					?>
						<p><?= $logger.' '.stripslashes($llogs['contenu_log']).' Le : '.date("d/m/Y H:i:s", strtotime($llogs['date_log'])) ?></p>
					<?php
				}
					?>	
					

						

					</div>

				</div>
                
                
                <?php
				}
				//Pour commercial
				else
				{
				?>
                <div class="content-box column-right main" style="width:630px;">

					<div class="content-box-header">

						<h3>Mes infos Logs</h3>

					</div>

					

					<div class="content-box-content">
					<?php
				$listelogs = $myadmin->ListeDesLogsParCommercial(20,$_SESSION['loginadmin']);	
				foreach($listelogs as $llogs)
				{
					$logger = $myadmin->InfoLogger($llogs['id_comm']);
					$logger = $logger['nom_comm'].' '.$logger['pnom_comm'];
					?>
						<p><?= $logger.' '.stripslashes($llogs['contenu_log']).' Le : '.date("d/m/Y H:i:s", strtotime($llogs['date_log'])) ?></p>
					<?php
				}
					?>	
					

						

					</div>

				</div>
                
                <?php
				}
				?>
                
                  <?php
				if($_SESSION['loginadmin'] == 1)
				{
				?>
                <div class="content-box column-left sidebar"><!-- use the class .sidebar in combination with .column-left to create a sidebar --><!-- using .closed makes sure the content box is closed by default -->

					<div class="content-box-header">

						<h3>Statistiques reservé à l'administrateur</h3>

					</div>

					

					<div class="content-box-content">

<?php
$lescommerciaux = $myadmin->ListeCommerciaux();
foreach($lescommerciaux as $lescomms)
{
$cpcomm = $myadmin->ListeClientsParCommercial($lescomms['id_comm']);

$nbrcpcomm = sizeof($cpcomm);
?>
<p>Nbr des clients de <?= '<span style="color:#06F"><a href="home_comm.php?comm='.$lescomms['id_comm'].'">'.$lescomms['nom_comm'].' '.$lescomms['pnom_comm'].'</a></span> : <a href="clientscommercial.php?comm='.$lescomms['id_comm'].'">'.$nbrcpcomm ?>client(s) </a></p>
<?php
}
?>
				  </div>

				</div>
                
                <?php
				}
				?>
                
                
                
                
                 <?php
				if($_SESSION['loginadmin'] == 1)
				{
				?>
                <div class="content-box column-left sidebar"><!-- use the class .sidebar in combination with .column-left to create a sidebar --><!-- using .closed makes sure the content box is closed by default -->

					<div class="content-box-header">

						<h3>Statistiques reservé à l'administrateur</h3>

					</div>

					

					<div class="content-box-content">

<?php
$secteurs = $myadmin->ListeSecteur();
foreach($secteurs as $sect)
{
$cpsect = $myadmin->ListeClientsParSecteurs($sect['id_clcat']);

$nbrcpsect = sizeof($cpsect);
?>
					<p><?= $sect['libelle_clcat'].' : '.$nbrcpsect.' Client(s)';?></p>
<?php
}
?>
				  </div>

				</div>
                
                <?php
				}
				?>
                
                
                <div class="content-box column-left sidebar"><!-- use the class .sidebar in combination with .column-left to create a sidebar --><!-- using .closed makes sure the content box is closed by default -->

					<div class="content-box-header">

						<h3>Calendrier des rappels </h3>

					</div>

					

					<div class="content-box-content">
					  <p>
                      
                      
                      
                      </p>
				  </div>

				</div>
                   
                
                
           
              <div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		