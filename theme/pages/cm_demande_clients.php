<?php session_start();

if(empty($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != '1')

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}

require_once("../../_top.php");
//current
$page = 17;
require_once("_header.php");
$page = 17;
require_once("_side.php");

$demande =  $myadmin->Liste_cm_demande_clients(); 
$commerciaux = $myadmin->ListeCommerciaux();

/*if(isset($_GET['list']) && $_GET['list']=='all')
{
	
}*/

if (isset($_GET['cl']) && isset($_GET['comm']) ) {
    $myadmin->UpdateCommercialClient($_GET['cl'], $_GET['comm']);
	$myadmin->Delete_cm_demande_clients($_GET['cl'],$_GET['comm']);
	$demande =  $myadmin->Liste_cm_demande_clients();
    $cl = $myadmin->DetailsClient($_GET['cl']);
	$libelleclient = stripslashes($cl['entreprise_cl']);
$myadmin->LogMe('à Modifier le commercial du client : <a href="client.php?client=' . $client . '">' . $libelleclient . '</a>', $_SESSION['loginadmin']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Commercial à été modifier avec succé
              </div> "; 
}

if (isset($_POST['updatecommercial'])) {
    $myadmin->UpdateCommercialClient($_POST['updatecommercial'], $_POST['commerciaux']);
	$myadmin->Delete_cm_demande_clients($_GET['Supprimer'],$_POST['comm']);
	$demande =  $myadmin->Liste_cm_demande_clients();
    $cl = $myadmin->DetailsClient($_POST['updatecommercial']);
	$libelleclient = stripslashes($cl['entreprise_cl']);
$myadmin->LogMe('à Modifier le commercial du client : <a href="client.php?client=' . $client . '">' . $libelleclient . '</a>', $_SESSION['loginadmin']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Commercial à été modifier avec succé
              </div> "; 
}


if(isset($_GET['Supprimer']))
{
	$myadmin->Delete_cm_demande_clients($_GET['Supprimer'],$_GET['comm']);
	$demande =  $myadmin->Liste_cm_demande_clients();

// $myadmin->LogMe('a changé le statut du client <a href="detailsclient.php?client='.$client.'" style="color:'.$couleurclient.'">'.$libelleclient.'</a> en '.$interretclient['libelle_cls'], $_SESSION['loginadmin']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Le Demande à été supprimé avec succé 
              </div> "; 
}

?>



			
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Demandes des clients
            <small><a href="#">Client </a></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">Client</a></li>
            <li class="active">Demandes des clients</li>
        </ol>
	</section>
	<section class="content">
	                   <?= $succes  ?>
            <div class="row">
            <!-- left column -->
             <div class="col-xs-12">
                <!-- general form elements -->		
              <div class="box">
            <div class="box-header">
              <h3 class="box-title">Demandes des clients</h3>
            </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
									<th><span style="width:170px;">Entreprise</span></th>
									<th>Activité</th>                                    <th>commercial Actuel</th>
									<th>Ville</th>
									<th>Commercial demander  </th>
									<th style="width: 50px;" ></th>
									<th  style="width: 15px;"></th>
									<th  style="width: 15px;"></th>

						     </tr>

                        </thead>
                        <tbody>

									
					<?php
					foreach($demande as $cf)
					{
						$cl = $myadmin->DetailsClient($cf['id_cl']);
						$comm = $myadmin->InfoLogger($cf['id_comm']);
					?>
								<tr>

									<td> <a href="client.php?client=<?= $cl['id_cl'] ?>"  ><?= stripslashes($cl['entreprise_cl']);?></a></td>											                           								  
									<td><?= $myadmin->AfficherSecteur($cl['id_clcat']) ;?></td>									 									 							<?php									if ($cl['id_comm'] != $_SESSION['loginadmin']) {      	  $infocommercial = $myadmin->InfoLogger($cl['id_comm']);    $nomcommercial = $infocommercial['nom_comm'] . ' ' . $infocommercial['pnom_comm'];    } else  {  $nomcommercial =  'libre';}																		?>        									 									 									 									 									 <td><?= $nomcommercial ?></td>
									<td><?= $myadmin->NomVille($cl['id_ville']);?></td>
									
									<td><?= $comm['nom_comm'].' '.$comm['pnom_comm'];?></td>
									<td>
									<button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#<?= $cl['id_cl'];?>">Accepte</button>
<div class="modal modal-default fade " id="<?= $cl['id_cl'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Accepter le demande pour  <?= stripslashes($cl['entreprise_cl']);?></h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point d'accepter le demande d'affectation</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <a href="cm_demande_clients.php?cl=<?= $cl['id_cl'] ;?>&comm=<?= $cf['id_comm'];?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                </div>
            </div>
        </div>
    </div> 
									</td>

								
									<td>
									<button type="button" class="btn bg-orange" data-toggle="modal" data-target="#<?= $cl['id_cl'];?>listecommercial"  title="Changer le commercial de client !" ><i class="fa fa-fw fa-share-square-o"></i></button>
	<div class="modal modal-default fade " id="<?= $cl['id_cl'];?>listecommercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Changer le commercial de <?= stripslashes($cl['entreprise_cl']);?></strong></h4>
                </div>
            <form action='' method='post'>
                <div class="modal-body">
                    <p>Vous êtes sur le point de Changer le commercial d'un Client, </p>
                    <p>Vous voulez confirmer</p>
<div class="form-group">					 
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

                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
					<button type="submit" class="btn btn-primary btn-ok">Changer</button>
					<input name='updatecommercial' type='hidden' value='<?= $cl['id_cl'];?>'>
                </div>
				</form>
            </div>
        </div>
    </div>
	</td>
									<td><button type="button" class="btn btn-danger btn-flat" alt="Delete" data-toggle="modal" data-target="#3<?= $cl['id_cl'] ?>" ><i class="fa fa-close"></i></button>
									<div class="modal modal-danger fade " id="3<?= $cl['id_cl'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Ignorer demande:  <?= $cl['entreprise_cl']?> ==> <?= $comm['nom_comm'].' '.$comm['pnom_comm'];?> </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point d'ignorer, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="?Supprimer=<?= $cl['id_cl']?>&comm=<?= $cf['id_comm'];?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
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
$page= 17;
require_once("_footer.php");
?>
