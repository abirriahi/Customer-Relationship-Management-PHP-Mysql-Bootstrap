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
	  <a href="liste_ouv_request.php?cl=<?= $cl['id_cl'] ;?>&comm=<?= $cf['id_comm'];?>"> <button type="button" class="btn btn-info btn-ok">Confirmé</button></a>
                  
	
}*/
/*
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
*/



$allclient = $myadmin->ListeClients();

$nbrallclient = sizeof($allclient);





$me = $myadmin->InfoLogger($_SESSION['loginadmin']);





$commerciaux = $myadmin->ListeCommerciaux();

if($_POST["listouvme1" ]=="listouvme1")  
{  
$checkbox1 = $_POST['liste1'] ;  

    foreach($checkbox1 as $key=>$value)

	
{  
$myadmin->Ajouter_Liste_Ouv($value);

	/*	$sql = mysql_query("INSERT INTO cm_liste_ouverte(`id_cl`) VALUES ('".$value. "')");

		return true;*/
$myadmin->UpdateLiOuvClient($value,0);

$myadmin->Delete_dmd_liste_Ouv_multiple($value);

		

		
}
header("Location: https://lereflexeimmobilier.net/clientmanager/theme/pages/listeouverte.php");
exit();
  
 
}







if((($_POST['saveme']))&& ($_POST['liste']) )


{
	echo "<script>alert(\"la variable est nulle\")</script>";
 
	/*$ed_selectionne = $_POST['liste'];

  

 $zero=0 ;

	foreach($ed_selectionne as $key=>$value)

	{

		$myadmin->UpdateCommercialClient($value, 25);

		$rappels=$myadmin->AfficherRappelClient($value);

		foreach($rappels as $cle)

	{

		$myadmin->MiseAJourRappelComm($value, 25,$cle['id_rapp']);

	}

	}

	

	$succes = "<div class=\"alert alert-success alert-dismissible\">

                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>

                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>

                Commercial à été modifier avec succé

              </div> "; 	*/

}

if(isset($_POST['deleteme']) && isset($_POST['liste']) )

{

	$ed_selectionne = $_POST['liste'];

  

 $zero=0 ;

	foreach($ed_selectionne as $key=>$value)

	{

		$myadmin->ClientDeleteRequest2($_SESSION['loginadmin'],$value);

         $succes = "<div class=\"alert alert-warning alert-dismissible\">

                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>

                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>

                Votre demande de suppression a été transmis avec succés            

				</div> "; 

	}

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
              <h3 class="box-title">Demandes de Transfére des clients à la liste ouverte</h3>
            </div>
                <div class="box-body">
				
						<div class="box-tools">

                <!-- Check all button -->

                <button type="button" class="btn btn-default checkbox-toggle" title="Rediriger clients Vers liste ouverte !" data-toggle="modal" data-target="#listouv" ><i class="fa fa-caret-square-o-left text-yellow"></i></button>

                <div class="btn-group">

                  <button type="button" class="btn btn-default" title="Supprimer liste des Clients !" data-toggle="modal" data-target="#supprimer" ><i class="fa fa-trash-o text-red"></i></button>


			 <button type="button" class="btn btn-default" title="Rediriger clients à un Commercial !" data-toggle="modal" data-target="#liste" ><i class="fa fa-share text-purple"></i></button>


				   

                </div>

                <!-- /.btn-group -->

			       </div>

				   <br> 

				
				<form action="liste_ouv_request.php" method="post">  

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
							   <th style="width: 15px;"> #</th>

									<th><span style="width:170px;">Entreprise</span></th>
									<th>Activité</th>
									<th>Ville</th>
									<th>Commercial</th>

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
    <td><input name="liste1[ ]" type="checkbox" value="<?= $cl['id_cl'] ?>" ></td>

									<td><?= stripslashes($cl['entreprise_cl']);?></td>
									<td><?= $myadmin->AfficherSecteur($cl['id_clcat']) ;?></td>
									<td><?= $myadmin->NomVille($cl['id_ville']);?></td>
									
									<td><?= $comm['nom_comm'].' '.$comm['pnom_comm'];?></td>
									<td>
				
						<?php
					}
						?>			

							 </tbody>
                    </table>
                </div>

            </div>
			 <div class="box-footer">

			   

			   

			   <div class="mailbox-controls">

                <!-- Check all button 

                <button type="button" class="btn btn-default checkbox-toggle" title="Rediriger clients Vers liste ouverte !" data-toggle="modal" data-target="#listouv" ><i class="fa fa-caret-square-o-left text-yellow"></i></button>

                <div class="btn-group">-->

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

                    <button type="submit" name="saveme"  class="btn btn-primary">Submit</button> 

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

          <a href="listeouverte.php"><button type="submit" name="listouvme1" value="listouvme1"class="btn btn-warning btn-ok">Confirmé</button></a>

            </div>

        </div>

    </div> 

	</div>

	 <!--****************************************************************** -->
</form>
                

              </div>

            </div>

             </div>
         </div>
	</section>

</div>
<!-- Page Script -->




<?php
$page= 17;
require_once("_footer.php");
?>
