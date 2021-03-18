<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");



if (isset($_GET['cdr']) && isset($_GET['c'])) {
    $myadmin->ClientDeleteRequest($_SESSION['loginadmin'], $_GET['c']);

    $succes = "<div class=\"alert alert-warning alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre demande de suppression a été transmis avec succés            
				</div> "; 
}

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$me = $myadmin->InfoLogger($_SESSION['loginadmin']);


$commerciaux = $myadmin->ListeCommerciaux();

if((isset($_POST['saveme']))&& isset($_POST['liste']) )
{
	$ed_selectionne = $_POST['liste'];
  
 $zero=0 ;
	foreach($ed_selectionne as $key=>$value)
	{
		$myadmin->UpdateCommercialClient($value, $_POST['commerciaux']);
		$rappels=$myadmin->AfficherRappelClient($value);
		foreach($rappels as $cle)
	{
		$myadmin->MiseAJourRappelComm($value, $_POST['commerciaux'],$cle['id_rapp']);
	}
	}
	
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Commercial à été modifier avec succé
              </div> "; 	
}
if(isset($_POST['deleteme']) && isset($_POST['liste']) )
{
	$ed_selectionne = $_POST['liste'];
  
 $zero=0 ;
	foreach($ed_selectionne as $key=>$value)
	{
		$myadmin->ClientDeleteRequest($_SESSION['loginadmin'],$value);
         $succes = "<div class=\"alert alert-warning alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre demande de suppression a été transmis avec succés            
				</div> "; 
	}
}
if(isset($_POST['listouvme']) && isset($_POST['liste']))
{
	$ed_selectionne = $_POST['liste'];
  	foreach($ed_selectionne as $key=>$value)
	{
    $myadmin->AjouterDmd_Liste_Ouv($value,$_SESSION['loginadmin']);
    //$myadmin->UpdateLiOuvClient($value,1);
	$succes = "<div class=\"alert alert-info alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre Demande de Transmis à la liste Ouverte à été effectuer avec succé
              </div> "; 
	}
	}

	//current
$page= 2 ;
require_once("_header.php");
$page= 2 ;
require_once("_side.php");
?> 

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            TOTAL CLIENTS
            <small><a href="mesclients.php">Tous </a></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">CLIENT</a></li>
            <li class="active">TOTAL CLIENTS</li>
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
				<?= $succes  ?>
		<div class="row">
            <!-- left column -->
             <div class="col-xs-12">
                <!-- general form elements -->		
              <div class="box">
			  <form method="post" action="">
            <div class="box-header">
              <h3 class="box-title">LISTE TOTAL DES CLIENTS</h3>
            </div>
                <div class="box-body">
				<div class="box-tools">
                <!-- Check all button -->
                <button type="button" class="btn btn-default checkbox-toggle" title="Rediriger clients Vers liste ouverte !" data-toggle="modal" data-target="#listouv" ><i class="fa fa-caret-square-o-left text-yellow"></i></button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default" title="Supprimer liste des Clients !" data-toggle="modal" data-target="#supprimer" ><i class="fa fa-trash-o text-red"></i></button>
                  <?php if(($_SESSION['loginadmin'] == '1'))
                                    { ?>
				 <button type="button" class="btn btn-default" title="Rediriger clients à un Commercial !" data-toggle="modal" data-target="#liste" ><i class="fa fa-share text-purple"></i></button>
				 <a href="Export.php?action=total" target="_blank" ><button type="button" class="btn btn-default" title="Télécharger la liste  !" ><i class="fa fa-cloud-download text-green"></i></button> </a>
				  <?php } ?>
				   
                </div>
                <!-- /.btn-group -->
			       </div>
				   <br> 
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 15px;"><?php if( $_SESSION['loginadmin']== '1') { ?><button type="button" onClick="do_this()" id="toggle" value="select" class="btn btn-default btn-sm" ><i class="fa fa-check-square-o"></i></button><?php } ?> </th>
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
foreach ($allclient as $mcls) {
    $cts = $myadmin->PrincipalContact($mcls['id_cl']);
    
    $vcdr = $myadmin->VerifierClientOnDeleteRequest($mcls['id_cl']);
    if ($vcdr == 1) {
        $styletr = 'style="background-color: #f3dfdf;"';
    } else {
        $styletr = '';
    }
     $commercialclient = $mcls['id_comm'];
    $couleurclient = $myadmin->AfficheCodeCouleurClient($mcls['id_cls']);
	$grcl = $myadmin->GroupeParId($mcls['id_gr']);
if ($commercialclient == $_SESSION['loginadmin']) {
    $quiestlecommercial = 'Commercial : vous.';
} else {
    $infocommercial = $myadmin->InfoLogger($mcls['id_comm']);
    $nomcommercial = $infocommercial['nom_comm'] . ' ' . $infocommercial['pnom_comm'];
    $quiestlecommercial = 'Commercial : ' . $nomcommercial;
}
	 $nb=$nb+1;
    ?>	
                                <tr <?= $styletr ?>>
								    <td><input name="liste[]" type="checkbox" value="<?= $mcls['id_cl'] ?>"  <?php if( $_SESSION['loginadmin']!= '1') { echo' disabled '; } ?> ></td>
                                    <td><?= $nb ?> </td>
                                    <td style="font-weight:bold; "><a href="client.php?client=<?= $mcls['id_cl'] ?>" style="color:<?= $couleurclient ?>;" target="_blank" ><?= stripslashes($mcls['entreprise_cl']) ?></a></td>
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
                                    
									<?php if(($mcls['id_comm'] == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
                                    { ?>
										<button type="button" onclick="window.location.href='editclient.php?idclient=<?= $mcls['id_cl'] ?>'" class="btn btn-success btn-flat" alt="Edit"><i class="fa fa-pencil-square"></i></button>
									<?php } else { ?>
									    
										<button type="button" onclick="window.location.href='editclient.php?idclient=<?= $mcls['id_cl'] ?>'" disabled="disabled" class="btn btn-success btn-flat disabled" alt="Edit"><i class="fa fa-pencil-square"></i></button>
										
									<?php } ?>
									   
                                      </td>
                                     <td>
                                     <?php if(($mcls['id_comm'] == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
                                    { ?>									 
                                    <button type="button" class="btn btn-danger btn-flat"  data-toggle="modal" data-target="#2<?= $mcls['id_cl'] ?>" alt="Delete"><i class="fa fa-user-times"></i></button>
									 <?php } else { ?>
                                    <button type="button" class="btn btn-danger btn-flat disabled" disabled="disabled" data-toggle="modal" data-target="#2<?= $mcls['id_cl'] ?>"  alt="Delete"><i class="fa fa-user-times"></i></button>
									 <?php } ?>
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
                    <a href="total_clients.php?cdr=ok&c=<?= $mcls['id_cl'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
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
				 <div class="box-footer">
			   
			   
			   <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default checkbox-toggle" title="Rediriger clients Vers liste ouverte !" data-toggle="modal" data-target="#listouv" ><i class="fa fa-caret-square-o-left text-yellow"></i></button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default" title="Supprimer liste des Clients !" data-toggle="modal" data-target="#supprimer" ><i class="fa fa-trash-o text-red"></i></button>
                  <?php if(($_SESSION['loginadmin'] == '1'))
                                    { ?>
				 <button type="button" class="btn btn-default" title="Rediriger clients à un Commercial !" data-toggle="modal" data-target="#liste" ><i class="fa fa-share text-purple"></i></button>
				  <?php } ?>
                </div>
                <!-- /.btn-group -->
				 <!--****************************************************************** -->
				<div class="modal modal-default fade " id="liste" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Rediriger client à un Commercial  </h4>
                </div>
            
                <div class="modal-body">
                     
			    <div class="form-group">
				<label class="col-sm-4 control-label">Action AU Groupe</label>
				  <div class="col-sm-6">
				  <select name='commerciaux' id='commerciaux' class="form-control">
<option value=''>-- Commercial ? --</option>
<?php
foreach($commerciaux as $comm)
{
?>

<option value="<?=$comm['id_comm'];?>"><?=$comm['nom_comm'];?> <?=$comm['pnom_comm'];?> </option>
	<?php	} ?>
	
</select>
               </div>
			   
                </div>
				<br><br>
				
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <button type="submit" name="saveme" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>  
	 <!--****************************************************************** -->
	 <div class="modal modal-danger fade " id="supprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer liste des Clients </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <button type="submit" name="deleteme"  class="btn btn-danger btn-ok">Confirmé</button>
            </div>
        </div>
    </div> 
	</div>
	 <!--****************************************************************** -->
	 <div class="modal modal-default fade " id="listouv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> Redirection vers La liste ouverte </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous voulez confirmer le Redirection vers La liste ouverte !!! </p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <button type="submit" name="listouvme"  class="btn btn-warning btn-ok">Confirmé</button>
            </div>
        </div>
    </div> 
	</div>
	 <!--****************************************************************** -->
                
              </div>
            </div>
             
			  </form>
            </div>
             </div>
         </div>
	</section>

</div>
<!-- Page Script -->
<script type="text/javascript">

    function do_this(){

        var checkboxes = document.getElementsByName('liste[]');
        var button = document.getElementById('toggle');
        var clicks = $(this).data('clicks');
        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
			$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
			$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        }
		$(this).data("clicks", !clicks);
    }
</script>

<?php
$page= 2 ;
require_once("_footer.php");
?>
