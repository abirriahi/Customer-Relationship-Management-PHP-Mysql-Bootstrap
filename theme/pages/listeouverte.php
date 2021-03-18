<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");

//current
$page= 1 ;
require_once("_header.php");
$page= 20 ;
require_once("_side.php");

// ******************
// $li_ouv = $myadmin->ListeOuverte();
// foreach($li_ouv as $lo)
	// {
		// $myadmin->Ajouter_Liste_Ouv($lo['id_cl'],date("d-m-Y"));
	// }
// ****************	
$allclient = $myadmin->Liste_Ouv();
$nbrallclient = sizeof($allclient);


$ListeOuverte = $myadmin->Liste_Ouv();

$nbrListeOuverte = sizeof($ListeOuverte);

$me = $myadmin->InfoLogger($_SESSION['loginadmin']);
$commerciaux = $myadmin->ListeCommerciaux();


if(isset($_POST['saveme'])&& isset($_POST['liste']))
{
	$ed_selectionne = $_POST['liste'];
  
 $zero=0 ;
	foreach($ed_selectionne as $key=>$value)
	{
		$myadmin->UpdateCommercialClient($value, $_POST['commerciaux']);
		// $myadmin->UpdateLiOuvClient($value,0);
		$myadmin->Delete_liste_Ouv($value);
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


if (isset($_GET['vieux'])) {
    //$myadmin->UpdateCommercialClient($_POST['vieux'],$_SESSION['loginadmin']);
	$myadmin->cm_demande_clients($_SESSION['loginadmin'], $_GET['vieux']);
    $libelleclient = stripslashes($_GET['nom_cl']);
    $myadmin->LogMe('a demandé le client : <a href="client.php?client=' . $client . '">' . $libelleclient . '</a>', $_SESSION['loginadmin']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre demande d'ajout d'un client a été transmis avec succés 
              </div> "; 
}

if(isset($_POST['maliste']) && isset($_POST['liste']))
{
	$ed_selectionne = $_POST['liste'];
  	foreach($ed_selectionne as $key=>$value)
	{
		
	$myadmin->cm_demande_clients($_SESSION['loginadmin'], $value);
    $libelleclient = stripslashes($_GET['nom_cl']);
    $myadmin->LogMe('a demandé le client : <a href="client.php?client=' . $client . '">' . $libelleclient . '</a>', $_SESSION['loginadmin']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre demande d'ajout d'un client a été transmis avec succés 
              </div> "; 
	}
	}
?> 

<?php
/* * ******************************************************************************************************************** */
if (isset($_GET['cdr']) && isset($_GET['c'])) {
    $myadmin->ClientDeleteRequest($_SESSION['loginadmin'], $_GET['c']);
	// $myadmin->UpdateLiOuvClient($_GET['c'],0);
	$myadmin->Delete_liste_Ouv($_GET['c']);
    $succes = "<div class=\"alert alert-warning alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre demande de suppression a été transmis avec succés            
				</div> "; 
}


    $ListeOuverte = $myadmin->Liste_Ouv();

//*****************************************************************************
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            LISTE OUVERTE
            <small><a href="listeouverte.php">Tous </a></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">CLIENT</a></li>
            <li class="active">Liste Ouverte</li>
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
              <h3 class="box-title">LISTE OUVERTE</h3>
            </div>
                <div class="box-body">
				 <div class="box-tools">
                <!-- Check all button -->
                <button type="button" class="btn btn-default checkbox-toggle" title="Ajouter Ce Client à mes clients !" data-toggle="modal" data-target="#malistecl" ><i class="fa fa-heart text-maroon"></i></button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default" title="Supprimer liste des Clients !" data-toggle="modal" data-target="#supprimer" ><i class="fa fa-trash-o text-red"></i></button>
                  <?php if(($_SESSION['loginadmin'] == '1'))
                                    { ?>
				 <button type="button" class="btn btn-default" title="Rediriger clients à un Commercial !" data-toggle="modal" data-target="#liste" ><i class="fa fa-share text-purple"></i></button>
				<a href="Export.php?action=li_ouv" target="_blank" ><button type="button" class="btn btn-default" title="Télécharger la liste  !" ><i class="fa fa-cloud-download text-green"></i></button> </a>
				  <?php } ?>
                </div>
                <!-- /.btn-group -->
			       </div>
			      <br>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
							    <th style="width: 15px;"><button type="button" onClick="do_this()" id="toggle" value="select" class="btn btn-default btn-sm" ><i class="fa fa-check-square-o"></i></button></th>
							    <th style="width: 15px;">#</th>
                                <th style="width: 400px;" >Entreprise</th>
                                <th>Activité</th>
                                <th>Ville</th>
								<th style="width:120px;">Responsable</th>
                                <!--<th style="width:125px;">Site web</th>-->
									<th style="width:100px;">Email</th>
                                <th style="width: 15px;"></th>
								<th style="width: 15px;"></th>
								<?php if($_SESSION['loginadmin'] == '1')
                                    { ?>
								<th style="width: 15px;"></th>
								<th style="width: 15px;"></th>
									<?php } ?>
                            </tr>

                        </thead>
                        <tbody>

<?php
$nb=0;
foreach ($ListeOuverte as $mcls) {
	$client = $myadmin->DetailsClient($mcls['id_cl']);
    $cts = $myadmin->PrincipalContact($client['id_cl']);
    
    $vcdr = $myadmin->VerifierClientOnDeleteRequest($client['id_cl']);
    if ($vcdr == 1) {
        $styletr = 'style="background-color: #f3dfdf;"';
    } else {
        $styletr = '';
    }

    $couleurclient = $myadmin->AfficheCodeCouleurClient($client['id_cls']);
	
	 $nb=$nb+1;
    ?>	
                                <tr <?= $styletr ?> >
								   <td><input name="liste[]" type="checkbox" value="<?= $client['id_cl'] ?>"></td>
                                   <td><?= $nb ?> </td>
                                    <td style="font-weight:bold; " ><a href="client.php?client=<?= $client['id_cl'] ?>" style="color:<?= $couleurclient ?> ;" target="_blank" ><?= stripslashes($client['entreprise_cl']) ?></a></td>
                                    <td><?= $myadmin->AfficherSecteur($client['id_clcat']) ?></td>

                                    <td><?= $myadmin->NomVille($client['id_ville']); ?></td>
									
									<td><?= $cts['nom_ctc'] ?></td>
									<td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
                                    <td>
                                    <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#<?= $client['id_cl'] ?>" ><i class="fa fa-street-view"></i></button>
                                    
		<div class="modal fade" id="<?= $client['id_cl'] ?>">
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
              <h3 class="widget-user-username"><?= $client['entreprise_cl'] ?></h3>
              <h5 class="widget-user-desc"><?= $client['activite_cl'] ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Activité <span class="pull-right"><?= $myadmin->AfficherSecteur($client['id_clcat']) ; ?></span></a></li>
                <li><a href="#">Ville <span class="pull-right"><?= $myadmin->NomVille($client['id_ville']); ?></span></a></li>
				<li><a href="#">Région <span class="pull-right"><?= $client['region_cl'] ?></span></a></li>
				<li><a href="#">Adresse <span class="pull-right"><?= $client['adresse_cl'] ?></span></a></li>
				<li><a href="#">Téléphone <span class="pull-right"><?= $client['tel1_cl'] ?> / <?= $client['tel2_cl'] ?></span></a></li>
				<li><a href="#">Fax <span class="pull-right"><?= $client['fax_cl'] ?></span></a></li>
                <li><a href="#">Email <span class="pull-right"><?= $cts['email_ctc'] ?></span></a></li>
				<li><a href="#">Site Web  <span class="pull-right"><?= $client['siteweb_cl'] ?></span></a></li>
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
                                    <button type="button" class="btn btn-block bg-maroon btn-maroon btn-flat"  data-toggle="modal" data-target="#3<?= $client['id_cl'] ?>"  title="Ajout à mes client !!" ><i class="fa fa-heart"></i></button>
	<div class="modal modal-default fade " id="3<?= $client['id_cl'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ajouter <?= $client['entreprise_cl'] ?>  à mes Client</h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point D'ajouter un client à Votre Liste des Clients</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="listeouverte.php?vieux=<?= $client['id_cl'] ?>&nom_cl=<?= $client['entreprise_cl'] ?>"> <button type="button" class="btn bg-maroon btn-ok">Confirmé</button></a>
                </div>
            </div>
        </div>
    </div>
                                    </td>
									<?php if($_SESSION['loginadmin'] == '1')
                                    { ?>
                                    <td>
                                    <a href="editclient.php?idclient=<?= $client['id_cl'] ?>" target="_blank" ><button type="button" class="btn btn-block btn-success btn-flat"  alt="Edit"><i class="fa fa-pencil-square"></i></button></a>
                                    </td>
                                    <td>

                                    <button type="button" class="btn btn-danger btn-flat"  data-toggle="modal" data-target="#2<?= $client['id_cl'] ?>" alt="Delete"><i class="fa fa-user-times"></i></button>
<div class="modal modal-danger fade " id="2<?= $client['id_cl'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $client['entreprise_cl'] ?> </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="listeouverte.php?cdr=ok&c=<?= $client['id_cl'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
                </div>
            </div>
        </div>
    </div>  
                                    </td>
									<?php
                                           }
                                     ?>

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
               <button type="button" class="btn btn-default checkbox-toggle" title="Ajouter Ce Client à mes clients !" data-toggle="modal" data-target="#malistecl" ><i class="fa fa-heart text-maroon"></i></button>
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
		<div class="modal modal-default fade " id="malistecl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ajouter cette liste à mes Client</h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point D'ajouter client(s) à Votre Liste des Clients</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <button type="submit" name="maliste" class="btn bg-maroon btn-ok">Confirmé</button>
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
$page= 1 ;
require_once("_footer.php");
?>
