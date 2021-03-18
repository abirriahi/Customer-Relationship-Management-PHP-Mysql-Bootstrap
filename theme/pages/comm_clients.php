<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");

//current
$page= 1 ;
require_once("_header.php");
$page= 1 ;
require_once("_side.php");

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$tousmesclients = $myadmin->ListeClientsParCommercial($_GET['comm']);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($_GET['comm']);


?> 



<?php
/* * ******************************************************************************************************************** */
if (isset($_GET['cdr']) && isset($_GET['c'])) {
    $myadmin->ClientDeleteRequest($_GET['comm'], $_GET['c']);

    $msgdel = '<div class="notification warning" >
	Votre demande de suppression a été transmise à l\'administrateur elle sera validée prochainement (d\'ici là vous voyez le client coloré en rouge)					
</div>';
}

if (isset($_GET['interesse'])) {
    $mesclient = $myadmin->ClientInteresseParCommercial($_GET['interesse'], $_GET['comm']);
} else if (($_GET['activite'] == 0 && $_GET['ville'] != 0) || ($_GET['activite'] != 0 && $_GET['ville'] == 0)) {
    if ($_GET['activite'] == 0) {
        $mesclient = $myadmin->FiltreParVille($_GET['ville'], $_GET['comm']);
        $act = $myadmin->AfficherSecteur($_GET['activite']);
        $vil = $myadmin->NomVille($_GET['ville']);
        $filtre = ' Liste des client de ' . $vil;
    } else if ($_GET['ville'] == 0) {
        $mesclient = $myadmin->FiltreParCategorie($_GET['activite'], $_GET['comm']);
        $act = $myadmin->AfficherSecteur($_GET['activite']);
        $vil = $myadmin->NomVille($_GET['ville']);
        $filtre = 'les client de secteur : ' . $act;
    }
} else if (isset($_GET['activite']) && isset($_GET['ville'])) {
    $mesclient = $myadmin->FiltreCategorieVille($_GET['activite'], $_GET['ville'], $_GET['comm']);

    $act = $myadmin->AfficherSecteur($_GET['activite']);
    $vil = $myadmin->NomVille($_GET['ville']);
    $filtre = $act . ' à ' . $vil;
} else {
    $mesclient = $myadmin->ListeClientsParCommercial($_GET['comm']);
}


//*****************************************************************************
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CLIENTS DE <?= $me['nom_comm'].' '.$me['pnom_comm'] ?>
            <small><a href="mesclients.php">Tous </a></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">CLIENT</a></li>
            <li class="active"><?= $me['nom_comm'].' '.$me['pnom_comm'] ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<?php
			   
			  
			   
				if($_SESSION['loginadmin'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><h4><i class="icon fa fa-info"></i> Alert!</h4>Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a></p>
					
					</div>';
				} 
				     ?>
        <div class="row">
            <!-- left column -->
             <div class="col-xs-12">
                <!-- general form elements -->

                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filtre</h3>
                    </div>

                    <div class="box-body">
                        <form action="" method="get" > 
                            <div class="row">

                                <div class="col-xs-5">
                                    <label>Secteur</label>
                                    <select class="form-control" name="activite" id="activite" onchange="makeRequest('repPhpAjax_activite.php','activite','monactivite')">
                                        <option value="0">Secteur</option>
<?php
$secteurs = $myadmin->ListeSecteur();
foreach ($secteurs as $sec) {
    ?>
                                            <option value="<?= $sec['id_clcat'] ?>"><?= $sec['libelle_clcat'] ?></option>

    <?php
}
?>
                                    </select>
                                </div>

                                <div class="col-xs-5">
                                    <label>Ville</label>
                                    <select class="form-control" name="ville">
                                        <option value="0">Ville</option> 
<?php
$ville = $myadmin->ListeVille();
foreach ($ville as $v) {
    ?>

                                            <option value="<?= $v['id_ville'] ?>"><?= $v['nom_ville'] ?></option>

                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                 <div class="col-xs-2">
								     <br>
								     <button type="submit" class="btn btn-primary">Filtrer</button>
							     </div>	
                            </div>

                            <!-- /.box-body -->
                        </form>
                    </div>
				 </div>
        </div>
         </div>
                <!--   end row *************-->
				
		<div class="row">
            <!-- left column -->
             <div class="col-xs-12">
                <!-- general form elements -->		
              <div class="box">
            <div class="box-header">
              <h3 class="box-title">CLIENTS DE <?= $me['nom_comm'].' '.$me['pnom_comm'] ?></h3>
            </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
							    <th>#</th>
                                <th>Entreprise</th>
                                <th>Activité</th>
                                <th>Ville</th>
								<th style="width:120px;">Responsable</th>
                                <!--<th style="width:125px;">Site web</th>-->
									<th style="width:100px;">Email</th>
                                <th></th>
								<th></th>
								<th></th>

                            </tr>

                        </thead>
                        <tbody>

<?php
$nb=0;
foreach ($mesclient as $mcls) {
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
                                   <td><?= $nb ?> </td>
                                    <td style="font-weight:bold; "><a href="client.php?client=<?= $mcls['id_cl'] ?>" style="color:<?= $couleurclient ?>;"><?= stripslashes($mcls['entreprise_cl']) ?></a></td>
                                    <td><?= $myadmin->AfficherSecteur($mcls['id_clcat']) ?></td>

                                    <td><?= $myadmin->NomVille($mcls['id_ville']); ?></td>
									
									<td><?= $cts['nom_ctc'] ?></td>
									<td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
                                    <td>
                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#<?= $mcls['id_cl'] ?>" alt="Historique"><i class="fa fa-street-view"></i></button>
                                    
		<div class="modal fade" id="<?= $mcls['id_cl'] ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Profile Client</h4>
              </div>
              <div class="modal-body">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="../dist/img/client.jpg" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?= $mcls['entreprise_cl'] ?></h3>
              <h5 class="widget-user-desc"><?= $mcls['activite_cl'] ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Activité <span class="pull-right"><?= $myadmin->AfficherSecteur($mcls['id_clcat']) ; ?></span></a></li>
                <li><a href="#">Ville <span class="pull-right"><?= $myadmin->NomVille($mcls['id_ville']); ?></span></a></li>
				<li><a href="#">Région <span class="pull-right"><?= $mcls['region_cl'] ?></span></a></li>
				<li><a href="#">Adresse <span class="pull-right"><?= $mcls['adresse_cl'] ?></span></a></li>
				<li><a href="#">Téléphone <span class="pull-right"><?= $mcls['tel1_cl'] ?> / <?= $mcls['tel2_cl'] ?></span></a></li>
				<li><a href="#">Fax <span class="pull-right"><?= $mcls['fax_cl'] ?></span></a></li>
                <li><a href="#">Email <span class="pull-right"><?= $cts['email_ctc'] ?></span></a></li>
				<li><a href="#">Site Web  <span class="pull-right"><?= $mcls['siteweb_cl'] ?></span></a></li>
				<li><a href="#">Commercial <span class="pull-right"><?= $quiestlecommercial; ?></span></a></li>
				<?php if (isset($grcl['labelle_gr'])) { ?>
				<li><a href="#">Groupe <span class="pull-right"><?= $grcl['labelle_gr'] ?></span></a></li>
				<?php } ?>
              </ul>
            </div>
          <!-- /.widget-user -->
        </div> 
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info pull-right" data-dismiss="modal">Fermer</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

                                    </td>
                                    <td>

                                    <a href="editclient.php?idclient=<?= $mcls['id_cl'] ?>"><button type="button" class="btn btn-block btn-success btn-flat"  alt="Edit"><i class="fa fa-pencil-square"></i></button></a>
                                    </td>
                                    <td>

                                    <button type="button" class="btn btn-danger btn-flat"  data-toggle="modal" data-target="#2<?= $mcls['id_cl'] ?>" alt="Delete"><i class="fa fa-user-times"></i></button>
<div class="modal modal-danger fade " id="2<?= $mcls['id_cl'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $mcls['entreprise_cl'] ?> </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="mesclients.php?idclient?cdr=ok&c=<?= $mcls['id_cl'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
                </div>
            </div>
        </div>
    </div>  
                                    </td>

                                </tr>
                                <?php
								
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
             </div>
         </div>
	</section>

</div>


<?php
$page= 1 ;
require_once("_footer.php");
?>
