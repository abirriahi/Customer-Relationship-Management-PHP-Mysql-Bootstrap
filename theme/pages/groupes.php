
<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");
if(isset($_POST['addgrc']))
				{
				$myadmin->AjoutGroupe($_POST['groupe']);
				$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                L\'enregistrement à été ajouté..
              </div> "; 
	unset($_GET['addgrc']);
				}
				
if(isset($_GET['cdr']) && isset($_GET['grp']))
{
	$myadmin->DeleteGroupe($_GET['grp']);
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Groupe à été supprimé avec succé
              </div> "; 
	unset($_GET['cdr']);
	unset($_GET['grp']);
	
	
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
            Gestionnaire des Groupes 
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">Groupes</a></li>
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
        <div class="row" >
		
			<div class="col-md-12">
                <div class="box box-primary">
                     <div class="box-header with-border">
                         <h3 class="box-title">Ajouter un groupe client</h3>
                     </div>     
					 <!-- /.box-header -->
                   <!-- /.box-header -->
                <div class="box-body">
				
						<form action="groupes.php" method="post" >
						<div class="form-group">
                  <label for="exampleInputEmail1">Veuillez entrer le nom du groupe qui regroupes les société</label>
                  <input name="groupe" id="groupe" type="text" required placeholder="Groupe client"  class="form-control" >
                </div>
						<input name="addgrc" type="hidden" value="">
				</div>	
                     
							<div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                              </div>

					</form>	
						
                </div>		 
             </div>	                   
       
         </div>		
       

	   <div class="row">
            <!-- Box Comment -->

            <div class="col-md-12">
                <div class="box box-primary">
                     <div class="box-header with-border">
                         <h3 class="box-title">Liste des Groupe Clients</h3>
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
							$listegroupe = $myadmin->ListeGroupe();
							foreach($listegroupe as $lgr)
							{ $nb=$nb+1;
							?>		

                <tr>
                  <td><?= $nb?>.</td>
                  <td><?= $lgr['libelle_gr']?></td>
                  
				  <td>

                  <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#<?= $lgr['id_gr']?>" alt="Delete"><i class="fa fa-user-times"></i></button>
<div class="modal modal-danger fade " id="<?= $lgr['id_gr']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $lgr['libelle_gr']?></h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="groupes.php?cdr=ok&amp;grp=<?= $lgr['id_gr']?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
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
