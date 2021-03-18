<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}


require_once("../../_top.php");
//current
$page='home' ;
require_once("_header.php");

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$tousmesclients = $myadmin->ListeClientsParCommercial($_SESSION['loginadmin']);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($_SESSION['loginadmin']);


       $page='home' ;
       require_once("_side.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tableau de bord
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tableau de bord</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->                 
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <a href="add_clients.php" Style="color: #ffffff;"> <h3> Nouveau </h3> </a>

              <p><a href="add_clients.php.php" Style="color: #ffffff;" >Client</a></p>
            </div>
            <div class="icon">
              <a href="add_clients.php.php" Style="color: #00a3cb ;" ><i class="fa fa-user-plus"></i></a>
            </div>
            <a href="add_clients.php" class="small-box-footer">Nouveau Client <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $nbrmesclients ?> </h3>

              <p>Mes clients</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="mesclients.php" class="small-box-footer">Plus d'info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		    <?php
				
					 $oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['loginadmin'],date("Y-m-d"));
						if(!empty($oldrappels))
						{
						 $nbroldrapps = sizeof($oldrappels);
						}
						 else  
						 $nbroldrapps = 0 ;	
				?>
		<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?=$nbroldrapps ?></h3>

              <p>Anciens rappels</p>
            </div>
            <div class="icon">
              <i class="fa fa-bullhorn"></i>
            </div>
            <a href="rappels.php" class="small-box-footer">Plus d'info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
		
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
			
              <a href="recherche.php" Style="color: #ffffff;"><h3>Recherche</h3></a>

              <a href="recherche.php" Style="color: #ffffff;"><p>Client</p></a>
            </div>
            <div class="icon">
               <a href="recherche.php" Style="color: #35795a;"><i class="fa fa-search-plus"></i> </a>
            </div>
            <a href="recherche.php" class="small-box-footer">Recherche Client <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
	           <div class="col-lg-5">
              <div class="box box-solid">	
			  <div class="box-header">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Liste des rappels</h3>
			  
            </div>
               <div class="box-body">
			    <div class="row">
				 <?php
						$rappels =  $myadmin->AfficherMesRappel($_SESSION['loginadmin'],date("Y-m-d"));
						if(!empty($rappels))
						{
							$nbrrapps = sizeof($rappels);
								}
					else
		{
			            $nbrrapps = 0;
		}
         ?>
                <div class="col-xs-6 col-md-4 text-center">
                  <a href="rappels.php" style="color: #001f3f;"><input type="text" class="knob" value="<?=$nbrrapps ?>" data-skin="tron"  data-width="100" data-height="100" data-fgColor="#001f3f" data-readonly="true"></a>

                  <div class="knob-label"><span style="font-weight:bold; font-size:12px;"><?=$nbrrapps ?> rappels aujourd'hui </span></div>
                </div>
				<?php
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['loginadmin'],date("Y-m-d"));
						if(!empty($oldrappels))
						{
							$nbroldrapps = sizeof($oldrappels);
													
						}
					else
						{
							$nbroldrapps =0 ; 
						}
						?>
				<div class="col-xs-6 col-md-4 text-center">
                  <a href="rappels.php" style="color: #932ab6 ;" ><input type="text" class="knob" value="<?=$nbroldrapps ?>" data-skin="tron"  data-width="100" data-height="100" data-fgColor="#932ab6" data-readonly="true"></a>

                  <div class="knob-label"><span style="font-weight:bold; font-size:12px;"><?=$nbroldrapps ?> anciens rappels </span></div>
                </div>
				<?php   $events = $myadmin->Aujourdevent($_SESSION['loginadmin'],date("Y-m-d")); 
			        $nbreven =  $events; 
					 
						if(!empty($nbreven))
						{
							$nbreven = sizeof($nbreven);
								}
					else
		               {
			            $nbreven = 0;
		                   }
			?>
			
			  <?php
				if($_SESSION['loginadmin'] == 1)
				{
					   $demande = $myadmin->AlertAdminForCm_demande_clients(); 
			        $nbrdmd =  $demande; 
					 
						if(!empty($nbrdmd))
						{
							$nbrdmd = sizeof($nbrdmd);
								}
					else
		               {
			            $nbrdmd = 0;
		                   }
			
				?>
				<div class="col-xs-6 col-md-4 text-center">
                  <a href="cm_demande_clients.php" style="color: #ff0000 ;" ><input type="text" class="knob" value="<?= $nbrdmd ; ?>" data-skin="tron"  data-width="100" data-height="100" data-fgColor="#ff0000" data-readonly="true"></a>

                  <div class="knob-label"><span style="font-weight:bold; font-size:12px;"><?= $nbrdmd ; ?> Demande(s) de Affectation </span></div>
                </div>
				<?php } else { ?> 
				<div class="col-xs-6 col-md-4 text-center">
                  <a href="rappels.php" style="color: #39CCCC ;" ><input type="text" class="knob" value="<?= $nbreven ;?>" data-skin="tron"  data-width="100" data-height="100" data-fgColor="#39CCCC" data-readonly="true"></a>

                  <div class="knob-label"><span style="font-weight:bold; font-size:12px;"><?= $nbreven ;?> Evennement(s) pour Aujourd'hui </span></div>
                </div>
				
				<?php } ?> 
				</div>
				
                </div>
               </div>
              </div>			   
				
              <div class="col-lg-7">
              <div class="box box-solid">	
               <div class="box-body">	
              <div class="box-header">
              <i class="fa fa-bar-chart-o"></i>
              <h3 class="box-title">Statistiques Clients</h3>
			  
            </div>			   
			             <?php
						
						$interesse = $myadmin->ListeStatutInteresse();
						foreach($interesse as $inter)
						{
							$lisinterr = $myadmin->ClientInteresseParCommercial($inter['id_cls'],$_SESSION['loginadmin']);
							$nbrinterr = sizeof($lisinterr);
						?>                      
						
                <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="<?= $nbrinterr ?>" data-width="100" data-height="100"
                         data-fgColor="<?= $inter['couleur_cls'] ?>">

                  <div class="knob-label"><span style="font-weight:bold;">Nbr de clients <?= '<a href="mesclients.php?interesse='.$inter['id_cls'].'" target="_blank" style="color:'.$inter['couleur_cls'].'">'.$inter['libelle_cls'].'</a>' ?></span></div>
                </div>
				
			     <?php
						}
				 ?>	
				</div>
               </div>
              </div>
              <!-- /.row -->
			  </div>

		        <!-- row -->
            <div class="row">
			
              <div class="col-md-7">
			<?php
				if($_SESSION['loginadmin'] == 1)
				{
					  $request = $myadmin->AlertAdminForClientDeleteRequest();
					  $asupp =  $myadmin->ListeClientsASupprimer();
					  $DmdLiOuv =  $myadmin->DmdListeOuv(); 
					 
						if(!empty($asupp))
						{ $supreq = sizeof($asupp); }
					    else
		                { $supreq = 0; }
					
                               if(!empty($DmdLiOuv))
						       { $LiOuvreq = sizeof($DmdLiOuv); }
					            else
		                       { $LiOuvreq = 0; }
				
				?>
			  <div class="callout callout-danger" style="margin-right: 30px;">
                <p style="font-size: 15px; " ><a href="clientdeleterequest.php">Vous avez <strong> <?=$supreq ?> demande(s) de suppression client </strong></a> </p>
              </div>
			  <?php } ?>			  
             <!-- The time line -->
              <ul class="timeline">
              <!-- timeline time label -->
                 <li class="time-label">
                  <span class="bg-red">
                    Les infos Logs
                  </span>
                 </li>
            <!-- /.timeline-label -->
                      <?php
				//Pour Administrateur
				         if($_SESSION['loginadmin'] == 1)
				         {		
				       $listelogs = $myadmin->ListeDesLogs(200);	
				         foreach($listelogs as $llogs)
			             	{
					       $logger = $myadmin->InfoLogger($llogs['id_comm']);
					       $logger = $logger['nom_comm'].' '.$logger['pnom_comm'];
					  ?>					
		   <li>
              <i class="fa fa-user bg-aqua"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?= date("d/m/Y H:i:s", strtotime($llogs['date_log'])) ?></span>

                <p class="timeline-body no-border"><a href="#"> <?= $logger?></a> <?= stripslashes($llogs['contenu_log']) ?></p>
              </div>
            </li>
            <!-- END timeline item -->
			<?php
				}
						 }
				//Pour commercial
				else
				{
					$listelogs = $myadmin->ListeDesLogsParCommercial(200,$_SESSION['loginadmin']);	
				foreach($listelogs as $llogs)
				{
					$logger = $myadmin->InfoLogger($llogs['id_comm']);
					$logger = $logger['nom_comm'].' '.$logger['pnom_comm'];
					?>
            <!-- timeline item -->
            <li>
              <i class="fa fa-user bg-aqua"></i>

              <div class="timeline-item">
               <span class="time"><i class="fa fa-clock-o"></i> <?= date("d/m/Y H:i:s", strtotime($llogs['date_log'])) ?></span>
                <p class="timeline-header no-border"><a href="#"> <?= $logger?> </a> <?= stripslashes($llogs['contenu_log']) ?></p>
              </div>
            </li>
			<?php
				}
				}
			?>
            <!-- END timeline item -->			
			
			
		  5
              </ul>
             </div>
			 	
		
	<!--****************************************************************-->	
			 								 
          <div class="col-md-5">
		  <?php
				if($_SESSION['loginadmin'] == 1)
				{
					  $request = $myadmin->AlertAdminForClientDeleteRequest();
					  $asupp =  $myadmin->ListeClientsASupprimer();
					  $DmdLiOuv =  $myadmin->DmdListeOuv(); 
					 
						if(!empty($asupp))
						{ $supreq = sizeof($asupp); }
					    else
		                { $supreq = 0; }
					
                               if(!empty($DmdLiOuv))
						       { $LiOuvreq = sizeof($DmdLiOuv); }
					            else
		                       { $LiOuvreq = 0; }
				
				?>
				
			  <div class="callout callout-warning">
                <p style="font-size: 15px; " ><a href="clientdeleterequest.php">Vous avez <strong> <?=$supreq ?> demande(s) de suppression client </strong></a> </p>
				<p style="font-size: 15px; " ><a href="liste_ouv_request.php">Vous avez <strong> <?=$LiOuvreq ?> demande(s) de transféresà la liste ouvert </strong></a> </p>
              </div>
			  
			  <?php } ?>
			<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">LISTE OUVERTE</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Entreprise</th>
                  <th>Email</th>
                  <th style="width: 70px">Tel</th>
                </tr>
				
				<?php
$listeouverte = $myadmin->Liste_Huit_Ouv();
$nb=0;
foreach ($listeouverte as $li) {
	$mcls= $myadmin->DetailsClient($li['id_cl']);
    $cts = $myadmin->PrincipalContact($mcls['id_cl']);
    
    $vcdr = $myadmin->VerifierClientOnDeleteRequest($mcls['id_cl']);
    if ($vcdr == 1) {
        $styletr = 'style="color:#F00;"';
    } else {
        $styletr = '';
    }

    $couleurclient = $myadmin->AfficheCodeCouleurClient($mcls['id_cls']);
	
	 $nb=$nb+1;
    ?>
	
                <tr>
                  <td><?= $nb ?></td>
                  <td style="font-weight:bold; "><a href="client.php?client=<?= $mcls['id_cl'] ?>" style="color:<?= $couleurclient ?>;"><?= stripslashes($mcls['entreprise_cl']) ?></a></td>
                  <td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
                  <td><?= $cts['tel_ctc'] ?></td>
                </tr>
				            <?php
								
                            }
                            ?> 
							
              </table>
            </div>
            <!-- /.box-body -->
          </div>
		  </div>
		  <!--****************************************************************-->		 
			 
						<?php
/* * ******************************************************************************************************************** */

$resultat = $myadmin->ClientHuitParCommercial($_SESSION['loginadmin']);


//*****************************************************************************
?>
<br><br> 
			<div class="col-md-5">
			<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Dernier Clients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Entreprise</th>
                  <th>Email</th>
                  <th style="width: 70px">Tel</th>
                </tr>
				
				<?php
$nb=0;
foreach ($resultat as $mcls) {
    $cts = $myadmin->PrincipalContact($mcls['id_cl']);
    
    $vcdr = $myadmin->VerifierClientOnDeleteRequest($mcls['id_cl']);
    if ($vcdr == 1) {
        $styletr = 'style="color:#F00;"';
    } else {
        $styletr = '';
    }

    $couleurclient = $myadmin->AfficheCodeCouleurClient($mcls['id_cls']);
	
	 $nb=$nb+1;
    ?>
	
                <tr>
                  <td><?= $nb ?></td>
                  <td style="font-weight:bold; "><a href="client.php?client=<?= $mcls['id_cl'] ?>" style="color:<?= $couleurclient ?>;"><?= stripslashes($mcls['entreprise_cl']) ?></a></td>
                  <td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
                  <td><?= $cts['tel_ctc'] ?></td>
                </tr>
				            <?php
								
                            }
                            ?> 
							
              </table>
            </div>
            <!-- /.box-body -->
          </div>
		  </div>
		  <!--****************************************************************-->			 
			 
			 
			 
        <!-- /.col -->
           
		   
		      <?php
				if($_SESSION['loginadmin'] == 1)
				{
				?>
				<!-- Start 2nd .widget-user -->
		<div class="col-md-5">
				   <br><br>
			<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">CLIENTS PAR COMMERCIAL</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
			
						  <?php
$lescommerciaux = $myadmin->ListeCommerciaux();
foreach($lescommerciaux as $lescomms)
{
$cpcomm = $myadmin->ListeClientsParCommercial($lescomms['id_comm']);

$nbrcpcomm = sizeof($cpcomm);
?>

<div class="box-body">
<li><a href="comm_clients.php?comm=<?=$lescomms['id_comm']?>"> Clients </a> de <?= '<span style="color:#06F"><a href="page_comm.php?part=home&comm='.$lescomms['id_comm'].'">'.$lescomms['nom_comm'].' '.$lescomms['pnom_comm'].'</a></span> '?> <span class="pull-right badge bg-blue"> <?=$nbrcpcomm ?></span></li>
</div>
            <!-- /.box-body -->

<?php
}
?>
			
          </div>
          <!-- /.box -->

        </div>		
		<!--************************************************************************* -->
	
		<div class="col-md-5">
				   <br>
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <h3><i class="fa fa-fw fa-sitemap"></i>CATEGORIES DES CLIENTS </h3>
			  <h5 class="widget-user-desc">Statistiques reservé à l'administrateur</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
			  
			      <?php
$secteurs = $myadmin->ListeSecteur();
foreach($secteurs as $sect)
{
$cpsect = $myadmin->ListeClientsParSecteurs($sect['id_clcat']);

$nbrcpsect = sizeof($cpsect);
?>
					 <li><a href="ClientsParCatg.php?catg=<?= $sect['id_clcat'] ?>"  ><?= $sect['libelle_clcat'] ?> <span class="pull-right badge bg-red"><?= $nbrcpsect ?></span></a></li>
					 
<?php
}
?>
			  
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
		
              <?php
				}
				?>
			<!--	******************************************************************** -->

			
				</div>
        </section>
      </div>
      <!-- /.row (main row) -->
  </div>
 
        <?php
		unset($_POST['recherche']);
		$page='home' ;
       require_once("_footer.php");
        ?>

