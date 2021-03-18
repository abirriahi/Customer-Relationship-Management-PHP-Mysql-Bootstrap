<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");

//current
$page= 13 ;
require_once("_header.php");
$page= 13 ;
require_once("_side.php");

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$tousmesclients = $myadmin->ListeClientsParCommercial($_SESSION['loginadmin']);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($_SESSION['loginadmin']);


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
	$resultat =  $myadmin->SearchClient(addslashes($_POST['recherche']));
}
if(isset($_POST['entreprise']))
{
	$resultat =  $myadmin->SearchClient(addslashes($_POST['entreprise']));
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Rechercher
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">Rechercher</li>
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
                        <h3 class="box-title">Chercher un client</h3>
                    </div>

					
					<div class="box-body">

						<form action="" method="post" >
                                    <div class="form-group">
									<label> l'entreprise ou bien le numéro de téléphone...</label>

									<input name="entreprise" id="entreprise" type="text" class="form-control" required  onkeyup="autocomplet()" >
									<ul id="entreprise_cl_list_id"></ul>
									<!-- add .align-right to align the input elements to the right -->
                                    </div>


						<input name="search" type="hidden" value="">

							<button name="search" class="btn btn-warning" type="submit" >Rechercher</button>

						</form>

					</div>
                 </div>
                
                <?php
				if(sizeof($resultat) != 0)
				{
				?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resulat de la recherche</h3>
                    </div>

					
					<div class="box-body">
					
						<table class="table table-striped"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->
                             <tr>
                                    <th>#</th>
									<th>Entreprise</th>
									<th>Activité</th>

									<th>Ville</th>
									<th>Responsable</th>
									<th>Tél.</th>
									<th>Email</th>
									<th style="width:60px;"></th>
									<th style="width:60px;"></th>
									<th style="width:60px;"></th>

								</tr>
							
									
						<?php
						$nb=0;
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
					$nb=$nb+1;
							?>	
								 <tr>
                                    <td><?= $nb ?></td>
									<td style="font-weight:bold;"><a href="client.php?client=<?= $res['id_cl']?>" style="color:<?= $couleurclient?>"><?= stripslashes($res['entreprise_cl'])?></a></td>
									<td><?= $myadmin->AfficherSecteur($res['id_clcat'])?></td>

									<td><?= $myadmin->NomVille($res['id_ville']);?></td>
									<td><?= $cts['nom_ctc'] ?></td>
									<td><?= $cts['tel_ctc'] ?></td>
									<td><a href="mailto:<?= $cts['email_ctc'] ?>"><?= $cts['email_ctc'] ?></a></td>
									<td>
                                    
<button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#<?= $res['id_cl'] ?>" alt="Historique"><i class="fa fa-street-view"></i></button>
                                    
		<div class="modal fade" id="<?= $res['id_cl'] ?>">
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
              <h3 class="widget-user-username"><?= $res['entreprise_cl'] ?></h3>
              <h5 class="widget-user-desc"><?= $res['activite_cl'] ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Activité <span class="pull-right"><?= $myadmin->AfficherSecteur($res['id_clcat']) ; ?></span></a></li>
                <li><a href="#">Ville <span class="pull-right"><?= $myadmin->NomVille($res['id_ville']); ?></span></a></li>
				<li><a href="#">Région <span class="pull-right"><?= $res['region_cl'] ?></span></a></li>
				<li><a href="#">Adresse <span class="pull-right"><?= $res['adresse_cl'] ?></span></a></li>
				<li><a href="#">Téléphone <span class="pull-right"><?= $res['tel1_cl'] ?> / <?= $res['tel2_cl'] ?></span></a></li>
				<li><a href="#">Fax <span class="pull-right"><?= $res['fax_cl'] ?></span></a></li>
                <li><a href="#">Email <span class="pull-right"><?= $cts['email_ctc'] ?></span></a></li>
				<li><a href="#">Site Web  <span class="pull-right"><?= $res['siteweb_cl'] ?></span></a></li>
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
                                    	<?php if(($res['id_comm'] == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
                                    { ?>
										<button type="button" onclick="window.location.href='editclient.php?idclient=<?= $res['id_cl'] ?>'" class="btn btn-success btn-flat" alt="Edit"><i class="fa fa-pencil-square"></i></button>
									<?php } else { ?>
									    
										<button type="button" onclick="window.location.href='editclient.php?idclient=<?= $res['id_cl'] ?>'" disabled="disabled" class="btn btn-success btn-flat disabled" alt="Edit"><i class="fa fa-pencil-square"></i></button>
										
									<?php } ?>
									</td>
                                    <td>

                                   <?php if(($res['id_comm'] == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
                                    { ?>									 
                                    <button type="button" class="btn btn-danger btn-flat"  data-toggle="modal" data-target="#2<?= $res['id_cl'] ?>" alt="Delete"><i class="fa fa-user-times"></i></button>
									 <?php } else { ?>
                                    <button type="button" class="btn btn-danger btn-flat disabled" disabled="disabled" data-toggle="modal" data-target="#2<?= $res['id_cl'] ?>"  alt="Delete"><i class="fa fa-user-times"></i></button>
									 <?php } ?>
									 
<div class="modal modal-danger fade " id="2<?= $res['id_cl'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $res['entreprise_cl'] ?> </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="mesclients.php?idclient?cdr=ok&c=<?= $res['id_cl'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
                </div>
            </div>
        </div>
    </div>  
									</td>

								</tr>
							<?php
							}
							?>
										


						</table>

						
					

				</div>
                <?php
				}
				?>
                



	      </div>
        
		 </div>
		  </div>
	</section>

</div>	

<script type="text/javascript">
function autocomplet() {
	var keyword = $('#entreprise').val();
	$.ajax({
		url: 'ajax_refresh.php',
		type: 'POST',
		data: {keyword:keyword},
		success:function(data){
			$('#entreprise_cl_list_id').show();
			$('#entreprise_cl_list_id').html(data);
		}
	});
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	$('#entreprise').val(item);
	// hide proposition list
	$('#entreprise_cl_list_id').hide();
}
</script>

<?php 
$page= 13 ;
require_once("_footer.php");
?>		