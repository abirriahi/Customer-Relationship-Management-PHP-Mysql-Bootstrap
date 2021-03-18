<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}

require_once("../../_top.php");

if(isset($_GET['idclient']))
{  
	//$clt = $_GET['idclient'];
	$clt = $myadmin->DetailsClient($_GET['idclient']);


$commercialclient = $clt['id_comm'];

if(($commercialclient == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
{


$page= 4 ;
require_once("_header.php");
$page= 4 ;
require_once("_side.php");


?>

<script type="text/javascript" src="../../includes/scripts/select_ajax.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Modifier Client
        <small>Modification de <a href="client.php?client=<?= $_GET['idclient'] ?>"> <?= $clt['entreprise_cl']?></a></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Client</a></li>
        <li class="active">Modifier client : <a href="client.php?client=<?= $client?>"><?= $clt['entreprise_cl']?></a></li>
      </ol>
    </section>
		
							<?php
				if(isset($_POST['editclt']))
				{
					$verif= $myadmin->UpdateClient($_POST['entreprise'],$_POST['activite'], $_POST['adresse'], $_POST['region'], $_POST['ville'], $_POST['groupe'],$_POST['siteweb'],$_POST['tel1'],$_POST['tel2'],$_POST['fax'],$commercialclient,$_POST['monactivite'],$_GET['idclient']);
									
				$myadmin->LogMe('a mis à jour les information du client : <a href="client.php?client='.$_GET['idclient'].'">'.$_POST['entreprise'].'</a>', $_SESSION['loginadmin']);
					
					
					$clt = $myadmin->DetailsClient($_GET['idclient']);
					$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                <p>Mise à jour Client effectué Avec Succes. </p>
                 </div> "; 
	
				}
				
					if(isset($_POST['addcontact']))
						{
						$myadmin->AjouterContact($_POST['nompnom1'],$_POST['emailcontact1'],$_POST['telcontact1'],$_POST['fonctioncontact1'],$_GET['idclient']);
						$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                <p>Traitement effectué Avec Succes.  </p>
                 </div> "; 
						}
					if(isset($_POST['editcontact']))
						{
							$clt = $myadmin->DetailsClient($_GET['idclient']);
							$myadmin->UpdateContact($_POST['nompnom1'],$_POST['emailcontact1'],$_POST['telcontact1'],$_POST['fonctioncontact1'],$_GET['idclient'],$_GET['idedit']);
							$myadmin->LogMe('a mis à jour les information du Contact : <a href="client.php?client='.$_GET['idclient'].'">'.$clt['entreprise_cl'].'</a>', $_SESSION['loginadmin']);
							$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                <p>Mise à jour Contact effectué Avec Succes.  </p>
                 </div> "; 
						}
					
					
				?>
				
	
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
        <div class="col-md-6">
          <!-- information de entreprise  -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Modifier Client</h3>
			  <div class="box-tools pull-right">
                <a href="client.php?client=<?= $_GET['idclient'] ?>"><i class="fa fa-user"></i></a>
              </div>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
                    <form class="form-horizontal" role="form" action="editclient.php?idclient=<?= $_GET['idclient'] ?>" method="post">
              <div class="box-body">
                             			                    
								<div class="form-group">
                                   <label class="col-sm-3 control-label">Nom Client <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
                                   <input name="entreprise" id="entreprise" type="text"  class="form-control" required  value="<?= stripslashes($clt['entreprise_cl'])?>" placeholder="Nom entreprise ... ">
								   <span class="notification information" id="clientverif">Veuillez entrer le nom de la société .....</span>
								   </div>
                                </div>	

									
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">Secteur <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
								   
                                    <select name="activite" id="activite"class="form-control" onchange="makeRequest('repPhpAjax_activite.php','activite','monactivite')">
                                    
                                   <option value="0">--Sélectionner--</option> 
                            
                                    <?php
									$secteurs = $myadmin->ListeSecteur();
									foreach($secteurs as $sec)
									{
										if($clt['id_clcat']==$sec['id_clcat']) $select = 'selected="selected"'; else $select ="";
									?>
			
										<option value="<?= $sec['id_clcat']?>" <?= $select?> ><?= $sec['libelle_clcat']?></option>
                                        
                                        <?php
										}
										?>

									</select>
									 <div id="monactivite">
                                     &nbsp;
                                 
                                     </div> 
                                                                        
                                </div>
                                </div>	
                                
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">Adresse <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
                                   <input name="adresse" id="adresse" type="text" class="form-control" required value="<?= stripslashes($clt['adresse_cl'])?>" placeholder="adresse...">
								   </div>
                                </div>	

                                
								<div class="form-group">
                                   <label class="col-sm-3 control-label">Région </label>
								   <div class="col-sm-9">
                                   <input name="region" id="region" type="text" class="form-control" required value="<?= stripslashes($clt['region_cl'])?>" placeholder="region entreprise ...">
								   </div>
                                </div>	
							   
							   <div class="form-group">
                                   <label class="col-sm-3 control-label">Ville <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9" >
								   
									<select name="ville" class="form-control">
                                    
                                    <?php
									$ville = $myadmin->ListeVille();
									foreach($ville as $v)
									{
										if($clt['id_ville']==$v['id_ville']) $select = 'selected="selected"'; else $select ="";
									?>
			
										<option value="<?= $v['id_ville']?>" <?= $select?>><?= $v['nom_ville']?></option>
                                        
                                        <?php
										}
										?>

									</select>
                                                                        
                                </div>
                                </div>	
							   
                                 <div class="form-group">
                                   <label class="col-sm-3 control-label">Site web</label>
								   <div class="col-sm-9">
                                   <input name="siteweb" id="siteweb" type="text" class="form-control" required  value="<?= $clt['siteweb_cl']?>" placeholder="www.siteweb.com">
								   </div>
                                </div>	
                        
                                  <div class="form-group">
                                   <label class="col-sm-3 control-label">Téléphone <i class="fa fa-asterisk text-red"></i> </label>
								<div class="row">
								   <div class="col-sm-4">
                                   <input name="tel1" id="tel1" type="text" class="form-control" pattern="[0-9]{2}[0-9]{6}"  format="NNNNNNNN" required  value="<?= $clt['tel1_cl']?>"   placeholder="Téléphone 1" >
								   </div>
								   
								   <div class="col-sm-4">
								   <input name="tel2" id="tel2" type="text" class="form-control" pattern="[0-9]{2}[0-9]{6}" format="NNNNNNNN"   value="<?= $clt['tel2_cl']?>" placeholder="Téléphone 2" >
								   </div>
                                 </div>								   
                                </div>	
                        	
                                
                                
                                 <div class="form-group">
                                   <label class="col-sm-3 control-label">Fax</label>
								   <div class="col-sm-9">
                                   <input name="fax" id="fax" type="text" class="form-control"  pattern="[0-9]{2}[0-9]{6}" placeholder="fax" value="<?= $clt['fax_cl']?>" >
								   </div>
                                </div>

        
		                        <div class="form-group">
                                   <label class="col-sm-3 control-label">Groupe <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
								   
									<select name="groupe" class="form-control">
                                    
                                    <option value="0" selected="selected">Pas de groupe</option>
                                    
                                    <?php
									$groupe = $myadmin->ListeGroupe();
									foreach($groupe as $g)
									{
										if($clt['id_gr']==$g['id_gr']) $select = 'selected="selected"'; else $select ="";
									?>
										<option value="<?= $g['id_gr']?>" <?= $select?>><?= $g['libelle_gr']?></option>
                                        
                                        <?php
										}
										?>

									</select>
                                </div>
                                </div>	
								<input name="idclient" type="hidden" class="pull-right" value="<?= $_GET['idclient'];?>">
								
			   <br>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
				 <button type="reset" class="btn btn-default">Annuler</button>
				 <input name="editclt" type="hidden" class="pull-right" value="">
                <button name="editclt" type="submit" class="btn btn-primary pull-right">Modifier</button>
              </div>
			
			  </form>
          </div>
          <!-- /.box -->
           </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- information client  -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ajouter un Nouveau Contact</h3>
            </div>
            <!-- /.box-header -->
			
				<form class="form-horizontal" role="form" action="editclient.php?idclient=<?= $_GET['idclient'] ?>" method="post"> 
			<div class="box-body">
                 
			                     <div class="form-group">
								 <div class="col-sm-12">
                                   <label>Nom et prénom <i class="fa fa-asterisk text-red"></i></label>
								   </div>
                                   <div class="col-sm-12">
								   <input name="nompnom1" id="nompnom1" type="text"  class="form-control" required placeholder="Nom et prénom" >
								   <span class="notification information">Nom et prénom.</span>
								   </div>
                                </div>

                                
                                  <div class="form-group">
								  <div class="col-sm-12">
                                   <label>Email du contact <i class="fa fa-asterisk text-red"></i></label>
								   </div>
								   <div class="col-sm-12">
                                   <input name="emailcontact1" id="emailcontact1" type="email"  class="form-control" required placeholder="Email" >
									<span class="notification information" id="verifemailcontact">Email du contact.</span>
									</div>
                                  </div>
								
                                <div class="form-group">
								 <div class="col-sm-12">
                                   <label>Téléphone <i class="fa fa-asterisk text-red"></i></label>
								   </div>
								   <div class="col-sm-12">
                                   <input name="telcontact1" id="telcontact1" type="text" pattern="[0-9]{2}[0-9]{6}" class="form-control" required placeholder="Téléphone" >
									<span class="notification information" id="veriftelcontact">Téléphone</span>
									</div>
                                </div>
								
								<div class="form-group">
								<div class="col-sm-12">
                                   <label>Fonction <i class="fa fa-asterisk text-red"></i></label>
								   </div>
								   <div class="col-sm-12">
                                    <select name="fonctioncontact1" class="form-control">
                                      <?php $fct = $myadmin->ListeFonction(); foreach($fct as $fc) { ?>
			                         <option value="<?= $fc['id_fct']?>"><?= $fc['libelle_fct']?></option> <?php } ?>
									</select>  
                                     <span class="notification information">Fonction du contact.</span>		
                                     </div>									 
                                </div>	
								<input name="idclient" type="hidden" class="pull-right" value="<?= $_GET['idclient'];?>">
			</div>
            <!-- /.box-body -->
			
			  <div class="box-footer">
			    <button type="submit" class="btn btn-default">Annuler</button>
                <button name="addcontact" type="submit" class="btn btn-primary pull-right">Ajouter</button>
				<input name="addcontact" type="hidden" value="">
              </div>
			  </form> 
          </div>
		    
         </div> 
          <!--/.col (right) -->
		
      </div>
      <!-- /.row -->
	  <div class="row">
        <div class="col-xs-12">
	     <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Contacts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nom et prénom</th>
                  <th>Email du contact</th>
                  <th>Téléphone</th>
				  <th>Groupe</th>
				  <th style="width: 10px"></th>
				  <th style="width: 10px">Action</th>
				  <th style="width: 10px"></th>
                </tr>
				<?php
				$nb=0;
				$contactclient = $myadmin->ListeContactParClient($_GET['idclient']);
          foreach ($contactclient as $ctcs) 
		        {   
		           $fct = $myadmin->AfficherFonctionContact($ctcs['id_fct']);
		             $nb= $nb+1 ; 
		               ?>	
                <tr>
                  <td><?= $nb ?></td>
                  <td><?= stripslashes($ctcs['nom_ctc']) ?></td>
                  <td><a href="mailto: <?= stripslashes($ctcs['email_ctc']) ?> "> <?= stripslashes($ctcs['email_ctc']) ?> </a></td>
                  <td><?= stripslashes($ctcs['tel_ctc']) ?></td>
				  <td><?= stripslashes($fct) ?></td>
				  <td><button data-id="<?= $ctcs['id_ctc'] ?>" name="btninfo" type="button" class="btninfo btn btn-info" data-toggle="modal" data-target="#modal-default"><i class="fa fa-street-view"></i></button></td>
				  <td><button id="<?= $ctcs['id_ctc'] ?>" type="button" class="btn btn-block btn-success btn-flat" data-toggle="modal" data-target="#modal-edit<?= $ctcs['id_ctc'] ?>" alt="Edit"><i class="fa fa-pencil-square"></i></button>
				      <!-- /.modal *********************************************************************************************-->		
        <div class="modal fade" id="modal-edit<?= $ctcs['id_ctc'] ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modifier Contact</h4>
              </div>
              <div class="modal-body">
			  
			  <form class="form-horizontal" role="form" action="editclient.php?idclient=<?= $_GET['idclient']?>&idedit=<?= $ctcs['id_ctc'] ?>" method="post"> 
			<div class="box-body">
			                     <div class="form-group">
								 <div class="col-sm-12">
                                   <label>Nom et prénom</label> 
								   </div>
                                   <div class="col-sm-12">
								   <input name="nompnom1" id="nompnom1" type="text"  class="form-control" required value="<?= stripslashes($ctcs['nom_ctc']) ?>" >
								   <span class="notification information">Nom et prénom.</span>
								   </div>
                                </div>

                                
                                  <div class="form-group">
								  <div class="col-sm-12">
                                   <label>Email du contact</label>
								   </div>
								   <div class="col-sm-12">
                                   <input name="emailcontact1" id="emailcontact1" type="email"  class="form-control" required value="<?= stripslashes($ctcs['email_ctc']) ?>" >
									<span class="notification information" id="verifemailcontact">Email du contact.</span>
									</div>
                                  </div>
								
                                <div class="form-group">
								 <div class="col-sm-12">
                                   <label>Téléphone</label>
								   </div>
								   <div class="col-sm-12">
                                   <input name="telcontact1" id="telcontact1" type="text" pattern="[0-9]{2}[0-9]{6}" class="form-control" required value="<?= stripslashes($ctcs['tel_ctc']) ?>" >
									<span class="notification information" id="veriftelcontact">Téléphone</span>
									</div>
                                </div>
								
								<div class="form-group">
								<div class="col-sm-12">
                                   <label>Fonction</label>
								   </div>
								   <div class="col-sm-12">
                                    <select name="fonctioncontact1" class="form-control">
                                      <?php $fct = $myadmin->ListeFonction(); foreach($fct as $fc) { if($clt['id_fct'] == $fc['id_fct']) $select = 'selected="selected"'; else $select ="";?>
			                         <option value="<?= $fc['id_fct']?>" <?= $select?> ><?= $fc['libelle_fct']?></option> <?php } ?>
									</select>  
                                     <span class="notification information">Fonction du contact.</span>		
                                     </div>									 
                                </div>	
								<input name="idclient" type="hidden" class="pull-right" value="<?= $_GET['idclient'];?>">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                <button name="editcontact" type="submit" class="btn btn-primary pull-right">Envoie</button>
				<input name="editcontact" type="hidden" value="">
              </div>
			  </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		</div>
        <!-- /.modal -->
				  </td>
				 
		
				 <!-- /.modal   <td><button id="<?= $ctcs['id_ctc'] ?>" type="button" class="btn btn-block btn-danger btn-flat"  data-href="editclient.php?idclient=<?= $_GET['idclient']?>&idelete=<?= $ctcs['id_ctc'] ?>" data-toggle="modal" data-target="#confirm-delete"  alt="Delete"><i class="fa fa-user-times"></i></button></td>
                  *********************************************************************************************-->		
		<div class="modal modal-danger fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer un Contact d'un client</h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a class="btn btn-danger btn-ok">Confirmé</a>
                </div>
            </div>
        </div>
    </div>
				  <!-- /.modal *********************************************************************************************-->		
				</tr>
				<?php } ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		</div>
       </div>	

	   
    </section>
    <!-- /.content -->
  </div>
		

<?php 
$page= 4 ;
require_once("_footer.php");
}
}

else{ 

$page= 4 ;
require_once("_header.php");
$page= 4 ;
require_once("_side.php");
?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Modifier Client
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Client</a></li>
        <li class="active">Modifier Client</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

		
		
		<p style="font-size :100px ;color : #b4aea4 ; align: center ;margin : 50px 200px 0px 100px">Erreur </p>
		<h1 style="margin : 0px 200px"><small>ce client n'est pas lier à vous</small></h1>
		
		
		
		
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 
$page= 4 ;
require_once("_footer.php");
}
?>		