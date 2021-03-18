<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

if(isset($_GET['comm']))
{
	$_SESSION['commercial']=$comm;

}

require_once("_top.php");


$menu[0] ="current";

require_once("_header.php");

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);

if(isset($_GET['comm']))
{
	$commerc = $_GET['comm'];
}

$tousmesclients = $myadmin->ListeClientsParCommercial($commerc);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($commerc);




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

								                 
              if(isset($_GET['comm']))
                 {
              $cm = $myadmin->commercial_by_id($_GET['comm']);
                 } 

				?>
		

                   <?php
					$head=$commerc;
				require_once("_headerr.php");
				?>

	             <div class="notification information" style="font-weight:bold; font-size:14px">

					<?= $cm['nom_comm']?> <?= $cm['pnom_comm']?>

            
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
							$lisinterr = $myadmin->ClientInteresseParCommercial($inter['id_cls'],$commerc);
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
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($commerc,date("Y-m-d"));
						if(!empty($oldrappels))
						{
							$nbroldrapps = sizeof($oldrappels);
							echo '<span style="color:red; font-size:12px;">Vous avez <span style="font-weight:bold; font-size:14px;">'.$nbroldrapps.'</span> anciens rappels qui ne sont pas commente ou appele </span>';
							echo '<div style="clear:both; height:5px;"></div>';
						
						}
					else
						{
							echo '';
						}
						?>
                    
                    
						 <?php
						$rappels =  $myadmin->AfficherMesRappel($commerc['loginadmin'],date("Y-m-d"));
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
				
				//Pour commercial
				
				?>
                <div class="content-box column-right main" style="width:630px;">

					<div class="content-box-header">

						<h3>Mes infos Logs</h3>

					</div>

					

					<div class="content-box-content">
					<?php
				$listelogs = $myadmin->ListeDesLogsParCommercial(20,$commerc);	
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