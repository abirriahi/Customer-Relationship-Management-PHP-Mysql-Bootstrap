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


$DmdLiOuv =  $myadmin->DmdListeOuv(); 
$commerciaux = $myadmin->ListeCommerciaux(); 

/*if(isset($_GET['list']) && $_GET['list']=='all')
{
	
}*/

if(isset($_GET['cl']))
{
	// $myadmin->UpdateLiOuvClient($_GET['cl'],1);
	$exist= $myadmin->Exist_Li_Ouv($_GET['cl']) ;
	if($exist==1){
	$myadmin->Ajouter_Liste_Ouv($_GET['cl'],date("d-m-Y"));
    $myadmin->DeleteListeClientsASupprimer($_GET['cl']);
	$myadmin->UpdateLiOuvClient($_GET['cl'],0);
	$myadmin->Delete_dmd_liste_Ouv($_GET['cl'],$_GET['comm']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Client à été Transmis avec succé
              </div> "; 
	}else {
		$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Client déja dans la liste Ouverte 
              </div> "; 
	}
	$DmdLiOuv =  $myadmin->DmdListeOuv(); 
}

if (isset($_POST['updatecommercial'])) {
    $myadmin->UpdateCommercialClient($_POST['updatecommercial'], $_POST['commerciaux']);
	$myadmin->DeleteListeClientsASupprimer($_POST['updatecommercial']);
	$myadmin->Delete_dmd_liste_Ouv($_POST['updatecommercial'],$_POST['comm']);
	
	$rappels=$myadmin->AfficherRappelClient($_POST['updatecommercial']);
		foreach($rappels as $cle)
	{
		$myadmin->MiseAJourRappelComm($_POST['updatecommercial'], $_POST['commerciaux'],$cle['id_rapp']);
	}
	
$DmdLiOuv =  $myadmin->DmdListeOuv(); 

// $myadmin->LogMe('a changé le statut du client <a href="detailsclient.php?client='.$client.'" style="color:'.$couleurclient.'">'.$libelleclient.'</a> en '.$interretclient['libelle_cls'], $_SESSION['loginadmin']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Commercial à été modifier avec succé
              </div> "; 
	$libelleclient = $myadmin->DetailsClient($_POST['updatecommercial']);
	$myadmin->LogMe('a Transférer le client : <a href="client.php?client=' . $client . '" style="color:'.$libelleclient['couleur_cls'].'">' . $libelleclient['entreprise_cl'] . '</a> à '.$infocomm['pnom_comm'].' '.$infocomm['nom_comm'].' ', $_SESSION['loginadmin']);	  
}


if(isset($_GET['Supprimer']))
{
	$myadmin->Delete_dmd_liste_Ouv($_GET['Supprimer'],$_GET['comm']);

$DmdLiOuv =  $myadmin->DmdListeOuv(); 

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
            Demandes de Transfére des clients
            <small><a href="#">Client </a></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">Client</a></li>
            <li class="active">Demandes de Transfére des clients</li>
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
              <h3 class="box-title">Demandes de Transfére des clients</h3>
            </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
									<th><span style="width:170px;">Entreprise</span></th>
									<th>Activité</th>
									<th>Ville</th>
									<th>Commercial</th>
									<th style="width: 15px;">        </th>
									<th style="width: 15px;">  </th>
									<th style="width: 15px;">        </th>

						     </tr>

                        </thead>
                        <tbody>

									
					<?php
					foreach($DmdLiOuv as $cf)
					{
						$cl = $myadmin->DetailsClient($cf['id_cl']);
						$comm = $myadmin->InfoLogger($cf['id_comm']);
					?>
								<tr>

									<td><?= stripslashes($cl['entreprise_cl']);?></td>
									<td><?= $myadmin->AfficherSecteur($cl['id_clcat']) ;?></td>
									<td><?= $myadmin->NomVille($cl['id_ville']);?></td>
									
									<td><?= $comm['nom_comm'].' '.$comm['pnom_comm'];?></td>
									<td>
									<button type="button" class="btn btn-block btn-succes" data-toggle="modal" data-target="#<?= $cl['id_cl'];?>" title="Accepter le demande !" >Accepter</button>
<div class="modal modal-default fade " id="<?= $cl['id_cl'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"> <?= stripslashes($cl['entreprise_cl']);?></h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de confirmer le demande de transfére un client à la liste ouvert </p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <a href="liste_ouv_request.php?cl=<?= $cl['id_cl'] ;?>&comm=<?= $cf['id_comm'];?>"> <button type="button" class="btn btn-info btn-ok">Confirmé</button></a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                </div>
            </div>
        </div>
    </div> 
									</td>

									<td>
									<button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#<?= $cl['id_cl'];?>listecommercial"  title="Changer le commercial de client !" >Affecter </button>
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
					<input name='comm' type='hidden' value='<?= $cf['id_comm'] ;?>'>
                </div>
				</form>
            </div>
        </div>
    </div>
	</td>
									<td><div class="bulk-actions"><button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#<?= $cl['id_cl'];?>supp" > <a  style="color: #ffffff;" title="supprimer le demande !" >Ignorer</a></button></td>
<div class="modal modal-default fade " id="<?= $cl['id_cl'];?>supp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"> <?= stripslashes($cl['entreprise_cl']);?></h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer le demande de transfére à la liste ouvert </p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <a href="liste_ouv_request.php?Supprimer=<?= $cl['id_cl']?>&comm=<?= $cf['id_comm'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                </div>
            </div>
        </div>
    </div> 
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
