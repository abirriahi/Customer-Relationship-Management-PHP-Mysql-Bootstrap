<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");

//current
$page= 11 ;
require_once("_header.php");
$page= 11 ;
require_once("_side.php");


if (isset($_GET['comm'])) {
$connected = $myadmin->InfoLogger($_GET['comm']); 
}
else if (isset($_SESSION["id"])) {
	$connected = $myadmin->InfoLogger($_SESSION["id"]); 
	
}
	else {
$connected = $id; 
}

?> 



<div class="content-wrapper">
                         
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            PROFILE <?= $connected['nom_comm'].' '.$connected['pnom_comm'] ?>
            <small><a href="mesclients.php">Tous </a></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active"><?= $connected['nom_comm'].' '.$connected['pnom_comm'] ?></li>
        </ol>
		
	  
	                 <?php
					if(isset($_POST['updateme']))
					{
						$myadmin->UpdateCommercialInfo($connected['id_comm'],$_POST['nom'],$_POST['pnom'],$_POST['login'],$_POST['password']);
						
						$connected = $myadmin->InfoLogger($_SESSION['loginadmin']);
						
						echo '<br>
						<div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a> 
                           <strong>'. $connected['nom_comm'].' '.$connected['pnom_comm'].' </strong>Les informations ont été mise à jour.
                           </div> ';
						   unset($_SESSION["succes"]);
						   unset($_SESSION["id"]);
					}
					
					if(isset($_POST['updatimg']))
					{
						
						
						//$target_dir = "../dist/img/";

$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("jpeg", "jpg", "gif");
if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    echo "Le fichier n'a pas l'extension attendue";
} else {    
    // Copie dans le repertoire du script avec un nom
    // incluant l'heure a la seconde pres 
    $repertoireDestination = dirname(__FILE__)."/img/";
    $nomDestination = "".date("YmdHis").".".$extensionFichier;

    if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                                     $repertoireDestination.$nomDestination)) {
       // echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"]. " a été déplacé vers ".$repertoireDestination.$nomDestination;
	                 $myadmin->UpdateCommercialAvatar($connected['id_comm'],$nomDestination);
						
						$connected = $myadmin->InfoLogger($_SESSION['loginadmin']);
						
						echo '<br>
						<div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a> 
                           <strong>'. $connected['nom_comm'].' '.$connected['pnom_comm'].' </strong>Les informations ont été mise à jour.
                           </div> ';
    } else {
        echo '<br>
						<div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a> 
                           Le fichier n\'a pas été uploadé (trop gros ?) ou '.
                                   'Le déplacement du fichier temporaire a échoué'.' vérifiez l\'existence du répertoire'.$repertoireDestination.'
                           </div> ';
    }
}
                    unset($_SESSION["succes"]);
	  
				          	}
							
				     	?>
	   
	  
    </section>
	<section class="content">
	<br> <br>
     <div class="row">
	 <div class="col-xs-12">
                <!-- general form elements -->
				<?php 
						 if (isset($_SESSION["succes"])) {
								echo $_SESSION["succes"] ;								
							}
						 ?>

	<form class="form-horizontal" enctype="multipart/form-data" role="form" action="" method="post" >
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="text-center">
        <img src="img/<?= $connected['avatar']?> " style="width: 300px; height: 300px;" class="avatar img-circle img-thumbnail" alt="avatar">
        <h6>Upload a different photo...</h6>
        <input type="file" name="monfichier" id="monfichier" class="text-center center-block well well-sm">
            <input class="btn btn-primary" name="updatimg" value="Valider " type="submit">
      </div>
    </div>
    <!-- edit form column -->
    <div class="col-md-7 col-sm-5 col-xs-10 personal-info">
      <h3>Edition Profile</h3>
      
        <div class="form-group">
          <label class="col-lg-3 control-label">Nom :</label>
          <div class="col-lg-8">
            <input class="form-control" name="nom" id="nom" value="<?= $connected['nom_comm']?>" type="text" required placeholder="Nom " >
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Prénom :</label>
          <div class="col-lg-8">
            <input class="form-control" name="pnom" id="pnom" type="text" required placeholder="Prénom "value="<?= $connected['pnom_comm']?>"  type="text">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Login :</label>
          <div class="col-lg-8">
            <input class="form-control" name="login" type="text" required value="<?= $connected['login_comm']?>"  >
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-lg-3 control-label">Mot de passe :</label>
          <div class="col-lg-8">
            <input class="form-control" name="password" id="password" type="password" value="<?= base64_decode($connected['passw_comm'])?>" required placeholder="Mot de passe" >
          </div>
        </div>
		
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input class="btn btn-primary" name="updateme" value="Valider " type="submit">
            <span></span>
            <input class="btn btn-default pull-right" value="Cancel" type="reset">
          </div>
        </div>
      
    </div>
	</form>
    </div>
  </div>
  </section>
</div>


<?php

?>


<?php
$page= 11 ;
require_once("_footer.php");
?>
