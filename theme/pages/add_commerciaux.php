<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");

if(isset($_POST['addcom']))
				{
				
 
				$img ="Avatar-0.jpg";
				$id=$myadmin->AjoutCommercial($_POST['nom'],$_POST['pnom'],$_POST['login'],$_POST['password'],$_POST['level'],$img);		
				$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                L'enregistrement à été ajouté..".$id."
              </div> "; 
			     $_SESSION["id"]=$id;    
                 $_SESSION["succes"]=$succes;			 
			     echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="profile.php"</SCRIPT>';
				}
				unset($_POST['addcom']);
$page = 14;
require_once("_header.php");
$page = 14;
require_once("_side.php");


?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      	
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
            <!-- Box Comment -->

            <div class="col-md-6">
                <div class="box box-primary">
                     <div class="box-header with-border">
                         <h3 class="box-title">Ajouter un commercial</h3>
                     </div>     
					 <!-- /.box-header -->
            <!-- form start -->
            <form role="form"action="add_commerciaux.php" method="post"  >
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Veuillez entrer le nom du commercial</label>
                  <input type="text" class="form-control" name="nom" id="nom" required placeholder="Nom commercial">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Veuillez entrer le prénom du commercial</label>
                  <input class="form-control" name="pnom" id="pnom" type="text"  required placeholder="Prénom commercial">
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Veuillez entrer le login</label>
                  <input class="form-control" name="login"  type="text" required placeholder="Login">
                </div>
               <div class="form-group">
                  <label for="exampleInputPassword1">Veuillez entrer le mot de passe</label>
                  <input class="form-control"name="password" id="password" type="text" required placeholder="Mot de passe">
                </div>
				<div class="form-group">
                  <label>Niv</label>
                  <select name="level" class="form-control">
                    <option value="2">Commercial(e)</option>
                    <option value="1">Administrateur</option>
                  </select>
                </div>
				
                <input name="addcom" type="hidden" value="">
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
						
         </div> 
       <div class="col-md-6 col-sm-8 col-xs-12">
        <div class="text-center">
        <img src="img/Avatar-0.jpg" style="width: 400px ; height:400px " class="avatar img-circle img-thumbnail" alt="avatar">
      </div>
    </div>		 
                                 
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
$page = 14;
require_once("_footer.php");
?>	
						