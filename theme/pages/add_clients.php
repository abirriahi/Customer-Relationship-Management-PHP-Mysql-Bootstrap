<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}

require_once("../../_top.php");


$allcustomers = $myadmin->ListeClients();
$custom_includes = '
	<link rel="stylesheet" href="../../includes/autocomplete/themes/base/jquery.ui.all.css">
	<script src="../../includes/autocomplete/jquery-1.7.1.js"></script>
	<script src="../../includes/autocomplete/ui/jquery.ui.core.js"></script>
	<script src="../../includes/autocomplete/ui/jquery.ui.widget.js"></script>
	<script src="../../includes/autocomplete/ui/jquery.ui.position.js"></script>
	<script src="../../includes/autocomplete/ui/jquery.ui.autocomplete.js"></script>
	
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
	
	
	<script type="text/javascript" src="../../includes/scripts/select_ajax.js"></script>	
	
	
	<script type="text/javascript" 
<script type="text/javascript" src="../../includes/scripts/ajax-functions.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		JQFUNCTIONS.inp();
	});
	
</script>
';



$page= 3 ;
require_once("_header.php");
$page= 3 ;
require_once("_side.php");


?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Nouveau Client
        <small>Ajout</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Client</a></li>
        <li class="active">Nouveau client</li>
      </ol>
    </section>
		<?php
				if(isset($_POST['addcls']))
				{
				 $exist = $myadmin->ExistClient($_POST['entreprise'],$_POST['telcontact1'],$_POST['emailcontact1']);
				 if($exist == 1)
					{
						if(!isset($_POST['region']))
				          { $region= 'NULL'; }
					    if(!isset($_POST['siteweb']))
				          { $siteweb= 'NULL'; }
					    if(!isset($_POST['tel2']))
				          { $tel2= 'NULL'; } 
					    if(!isset($_POST['fax']))
				          { $fax= 'NULL'; } 
					$client = $myadmin->AjoutClient($_POST['entreprise'],$_POST['activite'], $_POST['adresse'], $region, $_POST['ville'], $_POST['groupe'],$siteweb,$_POST['tel1'],$tel2,$fax,$_SESSION['loginadmin'],$_POST['monactivite']);
					
					
					$myadmin->AjouterContact($_POST['nompnom1'],$_POST['emailcontact1'],$_POST['telcontact1'],$_POST['fonctioncontact1'],$client);
					
				$myadmin->LogMe('a ajouté le client : <a href="client.php?client='.$client.'">'.$_POST['entreprise'].'</a>', $_SESSION['loginadmin']);
                echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="editclient.php?idclient='.$client.'"</SCRIPT>';
					}
					
					else
					{
						$succes = "<div class=\"alert alert-warning alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Ce client ou Contact existe déja veuillez <a href=\"recherche.php\">rechercher le client dans la base</a>
                 </div> "; 
						
					}
	
				}
				 
				if(isset($_POST['addcontact']))
				{ 
			     $exist2 = $myadmin->ExistClient($_POST['telcontact1'],$_POST['emailcontact1']);
				 if($exist2 == 1)
					{
				$idclient = $myadmin->IdClientExisted($_POST['entreprise'],$_POST['telcontact1'],$_POST['emailcontact1']);
				$myadmin->AjouterContact($_POST['nompnom1'],$_POST['emailcontact1'],$_POST['telcontact1'],$_POST['fonctioncontact1'],$idclient);
				echo '<div class="notification information">

					L\'enregistrement à été ajouté.

				</div>';
					}
				else
					{
						echo '<div class="notification warning">

					Ce client existe déja veuillez <a href="recherche.php">rechercher le client dans la base</a>

				</div>';
					}
	
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
	  <form class="form-horizontal" role="form" action="add_clients.php" method="post"> 
        <!-- left column -->
        <div class="col-md-6">
		        
          <!-- information de entreprise  -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Nouveau Client</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
              <div class="box-body">
                             			                    
								<div class="form-group">
                                   <label class="col-sm-3 control-label">Nom de l'entreprise <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
                                   <input name="entreprise" id="entreprise" type="text"  class="form-control" required   placeholder="Nom entreprise ... ">
								   <span class="notification information" id="clientverif">Veuillez entrer le nom de la société .....</span>
								   </div>
                                </div>	

									
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">Secteur d'activité <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
								   
                                    <select name="activite" id="activite" class="form-control" onchange="makeRequest('repPhpAjax_activite.php','activite','monactivite')">
                                                                
                                    <?php $secteurs = $myadmin->ListeSecteur(); foreach($secteurs as $sec) { ?> 
									<option value="<?= $sec['id_clcat']?>" > <?= $sec['libelle_clcat']?></option>  <?php } ?>

									</select>
									 <div id="monactivite">
                                     &nbsp;
                                 
                                     </div> 
                                                                        
                                </div>
                                </div>	
                                
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">Adresse <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
                                   <input name="adresse" id="adresse" type="text" class="form-control" required  placeholder="adresse...">
								   </div>
                                </div>	

                                
								<div class="form-group">
                                   <label class="col-sm-3 control-label">Région</label>
								   <div class="col-sm-9">
                                   <input name="region" id="region" type="text" class="form-control"   placeholder="region entreprise ...">
								   </div>
                                </div>	
							   
							   <div class="form-group">
                                   <label class="col-sm-3 control-label">Ville <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9" >
								   
                                    <select  name="ville" class="form-control">
                                    
                                      <?php $ville = $myadmin->ListeVille(); foreach($ville as $v) { ?>
			
										<option value="<?= $v['id_ville']?>" ><?= $v['nom_ville']?></option>  <?php  } ?>

									</select>
                                                                        
                                </div>
                                </div>	
							   
                                 <div class="form-group">
                                   <label class="col-sm-3 control-label">Site web</label>
								   <div class="col-sm-9">
                                   <input name="siteweb" id="siteweb" type="text" class="form-control"  placeholder="www.siteweb.com">
								   </div>
                                </div>	
                        
                                  <div class="form-group">
                                   <label class="col-sm-3 control-label">Téléphone <i class="fa fa-asterisk text-red"></i></label>
								<div class="row">
								   <div class="col-sm-4">
                                   <input name="tel1" id="tel1" type="text" class="form-control" pattern="[0-9]{2}[0-9]{6}"  format="NNNNNNNN" required placeholder="Téléphone 1" >
								   </div>
								   
								   <div class="col-sm-4">
								   <input name="tel2" id="tel2" type="text" class="form-control" pattern="[0-9]{2}[0-9]{6}" format="NNNNNNNN"  placeholder="Téléphone 2" >
								   </div>
                                 </div>								   
                                </div>	
                        	
                                
                                
                                 <div class="form-group">
                                   <label class="col-sm-3 control-label">Fax </label>
								   <div class="col-sm-9">
                                   <input name="fax" id="fax" type="text" class="form-control"  pattern="[0-9]{2}[0-9]{6}" placeholder="fax"  >
								   </div>
                                </div>

        
		                        <div class="form-group">
                                   <label class="col-sm-3 control-label">Groupe <i class="fa fa-asterisk text-red"></i></label>
								   <div class="col-sm-9">
								   
                                    <select name="groupe" class="form-control">
									<option value="0" selected="selected">Pas de groupe</option>
                                      <?php $groupe = $myadmin->ListeGroupe(); foreach($groupe as $g) { ?>
			                         <option value="<?= $g['id_gr']?>" ><?= $g['libelle_gr']?></option> <?php } ?>
									</select> 
                                </div>
                                </div>	
			   <br>
              </div>
              <!-- /.box-body -->
			  
          </div>
          <!-- /.box -->
           </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- information client  -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ajouter un Contact</h3>
            </div>
            <!-- /.box-header -->
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
			                         <option value="<?= $fc['id_fct']?>" ><?= $fc['libelle_fct']?></option> <?php } ?>
									</select>  
                                     <span class="notification information">Fonction du contact.</span>		
                                     </div>									 
                                </div>	
			</div>
            <!-- /.box-body -->
          </div>
		  <!-- Ajout Big button  -->
          <div class="box">
            <div class="box-body">
			<br>
              <p>
			    <!--<input name="addcls" type="hidden" value=""> --> 
                <button name="addcls" type="submit" class="col-sm-11 btn btn-block bg-purple btn-flat"><i class="fa fa-fw fa-hand-o-right"></i> Ajouter Client</button>
              </p>
              <br><br>
            </div>
          </div>
		
          <!-- /.box -->    
         </div> 
          <!--/.col (right) -->
			</form> 
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
		
		          

<?php 
$page= 3 ;
require_once("_footer.php");

?>		