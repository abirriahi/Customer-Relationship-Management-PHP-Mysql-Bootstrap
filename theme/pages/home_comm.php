<?php session_start();
if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../../index.php"</SCRIPT>';

}
require_once("../../_top.php");
$page='home' ;
require_once("_header_com.php");
$page='home' ;
require_once("_side_comm.php");


$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$tousmesclients = $myadmin->ListeClientsParCommercial($_SESSION['comm']);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($_SESSION['comm']);


       
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
            <a href="page_comm.php?comm=<?= $_SESSION['comm']?>&part=mesclient" class="small-box-footer">Plus d'info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
		    <?php
				
					 $oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['comm'],date("Y-m-d"));
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
						$rappels =  $myadmin->AfficherMesRappel($_SESSION['comm'],date("Y-m-d"));
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
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['comm'],date("Y-m-d"));
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
				<?php   $events = $myadmin->Aujourdevent($_SESSION['comm'],date("Y-m-d")); 
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
			  <div class="col-xs-6 col-md-4 text-center">
                  <a href="rappels.php" style="color: #39CCCC ;" ><input type="text" class="knob" value="<?= $nbreven ;?>" data-skin="tron"  data-width="100" data-height="100" data-fgColor="#39CCCC" data-readonly="true"></a>

                  <div class="knob-label"><span style="font-weight:bold; font-size:12px;"><?= $nbreven ;?> Evennement(s) pour Aujourd'hui </span></div>
                </div>
				
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
							$lisinterr = $myadmin->ClientInteresseParCommercial($inter['id_cls'],$_SESSION['comm']);
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
				
				//Pour commercial
				$listelogs = $myadmin->ListeDesLogsParCommercial(20,$_SESSION['comm']);	
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
				
			?>
            <!-- END timeline item -->			
			
			
		  
              </ul>
             </div>
			 	
		
	<!--****************************************************************-->	
			 								 
          <div class="col-md-5">
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
$listeouverte = $myadmin->ListeDixOuverte();
$nb=0;
foreach ($listeouverte as $mcls) {
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
                  <td style="font-weight:bold; "><a href="page_comm.php?part=client&comm=<?=$_SESSION['comm']?>&client=<?= $mcls['id_cl'] ?>" style="color:<?= $couleurclient ?>;"><?= stripslashes($mcls['entreprise_cl']) ?></a></td>
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
if(isset($_POST['search']))
{
	$resultat =  $myadmin->SearchClient(addslashes($_POST['recherche']));
}
else{
$resultat = $myadmin->ClientDixParCommercial($_SESSION['comm']);
}

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
                  <td style="font-weight:bold; "><a href="page_comm.php?part=client&comm=<?=$_SESSION['comm']?>&client=<?= $mcls['id_cl'] ?>" style="color:<?= $couleurclient ?>;"><?= stripslashes($mcls['entreprise_cl']) ?></a></td>
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

