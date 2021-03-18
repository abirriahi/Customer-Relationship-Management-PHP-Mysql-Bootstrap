
<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");
if(isset($_POST['addsec']))
				{
				$myadmin->AjoutSecteur($_POST['secteur']);	
				$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                L\'enregistrement à été ajouté..
              </div> "; 
	unset($_GET['addsec']);
				}
				
if(isset($_GET['cdr']) && isset($_GET['sec']))
{
	$myadmin->DeleteSecteur($_GET['sec']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Secteur à été supprimé avec succé
              </div> "; 
	unset($_GET['cdr']);
	unset($_GET['sec']);
	
	
}				
$page = 17;
require_once("_header.php");
$page = 17;
require_once("_side.php");


?>
							
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	    <h1>
            Gestionnaire des Secteurs 
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">Secteurs</a></li>
        </ol>
      	
    </section>

    <!-- Main content -->
    <section class="content">
	    
	      <?= $succes  ?>
           
        <div class="row">
            <!-- Box Comment -->

            <div class="col-md-6">
                <div class="box box-primary">
                     <div class="box-header with-border">
                         <h3 class="box-title">Liste des Secteur d'activité</h3>
                     </div>     
					 <!-- /.box-header -->
                   <!-- /.box-header -->
                <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                <th style="width: 10px">#</th>
                  <th>Libelle</th>
				  <th style="width: 50px">#</th>
                </tr>
				          <?php
						   $nb=0;
							$listesect = $myadmin->ListeSecteur();
							foreach($listesect as $sect)
							{
								$nb=$nb+1;
							?>		

                <tr>
                  <td><?= $nb?>.</td>
                  <td><?= $sect['libelle_clcat']?></td>
                  <td>

                  <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#<?= $sect['id_clcat']?>" alt="Delete"><i class="fa fa-user-times"></i></button>
<div class="modal modal-danger fade " id="<?= $sect['id_clcat'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $sect['libelle_clcat'] ?></h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="secteurs.php?cdr=ok&amp;sec=<?= $sect['id_clcat'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
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
            <!-- /.box-body -->
             </div>
			</div>
			
			<div class="col-md-6">
                <div class="box box-primary">
                     <div class="box-header with-border">
                         <h3 class="box-title">Ajouter un secteur d'activité</h3>
                     </div>     
					 <!-- /.box-header -->
                   <!-- /.box-header -->
                <div class="box-body">
				
						<form action="secteurs.php" method="post" >
						<div class="form-group">
                  <label for="exampleInputEmail1">Veuillez entrer le secteur d'activité .....</label>
                  <input name="secteur" id="secteur" type="text" required placeholder="Secteur d'activité" class="form-control" >
                </div>
						<input name="addsec" type="hidden" value="">
				</div>	
                     
							<div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                              </div>

					</form>	
						
                </div>		 
             </div>	                   
        <!-- /.row -->
		</div>	  
    </section>
    <!-- /.content -->
	</div>	
<!-- /.content-wrapper -->
<?php
$page = 17;
require_once("_footer.php");
?>							
