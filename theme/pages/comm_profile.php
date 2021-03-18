<?php session_start();



if(empty($_SESSION['loginadmin']))



{



echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';



}



require_once("../../_top.php");

//current

$page = 15;

require_once("_header.php");

$page = 15;

require_once("_side.php");

if(isset($_GET['cdr']) && isset($_GET['comm']))

{

	$myadmin->DeleteCommercial($_GET['comm']);

	

	$succes = "<div class=\"alert alert-success alert-dismissible\">

                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>

                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>

                Groupe à été supprimé avec succé

              </div> "; 

}



$listedescommerciaux = $myadmin->ListeCommerciaux();

?>

<style>

.user-row {

    margin-bottom: 14px;

}



.user-row:last-child {

    margin-bottom: 0;

}



.dropdown-user {

    margin: 13px 0;

    padding: 5px;

    height: 100%;

}



.dropdown-user:hover {

    cursor: pointer;

}



.table-user-information > tbody > tr {

    border-top: 1px solid rgb(221, 221, 221);

}



.table-user-information > tbody > tr:first-child {

    border-top: 0;

}





.table-user-information > tbody > tr > td {

    border-top: 0;

}



</style>

<div class="content-wrapper">

 <section class="content-header">

      <h1>

        Liste des Commercials

        <small>Commercials</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="#">Liste des Commercials</a></li>

        <li class="active"></li>

      </ol>

    </section>

	<br><br>

	<!-- Main container -->

    <section class="container">

	<?= $succes  ?>

 <div class="well col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">

        

             

			               <?php

							$listedescommerciaux = $myadmin->ListeCommerciaux();

							foreach($listedescommerciaux as $lcom)

							{

							?>	

			 

                <div class="row user-row">

            <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">

                <img class="img-circle"

                     src="img/<?= $lcom['avatar'] ?>"

                     alt="User Pic" style=" width:50px ;height: 50px; ">

            </div>

            <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">

                <strong><?= $lcom['nom_comm'].' '.$lcom['pnom_comm']?></strong><br>

                <span class="text-muted"><?php if($lcom['level_comm'] ==1) { echo 'Administrateur'; } else { echo 'Commercial'; } ?></span>

            </div>

            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".<?= $lcom['id_comm']?>">

                <i class="glyphicon glyphicon-chevron-down text-muted"></i>

            </div>

        </div>

        <div class="row user-infos <?= $lcom['id_comm']?>">

            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">

                <div class="panel panel-primary">

                    <div class="panel-heading">

                        <h3 class="panel-title">User information</h3>

                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">

                                <img class="img-circle"

                                     src="img/<?= $lcom['avatar'] ?>"

                                     alt="User Pic" style=" width:100px ;height: 100px;">

                            </div>

                            <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">

                                <img class="img-circle"

                                     src="img/<?= $lcom['avatar'] ?>"

                                     alt="User Pic"

									 style=" width:50px ; height: 50px; " >

                            </div>

                            <div class="col-xs-10 col-sm-10 hidden-md hidden-lg">

                                <strong><?= $lcom['nom_comm'].' '.$lcom['pnom_comm']?></strong><br>

                                <dl>

                                    <dt>Niveau :</dt>

                                    <dd><?php if($lcom['level_comm'] ==1) { echo 'Administrateur'; } else { echo 'Commercial'; } ?></dd>

                                    <dt>Dérniére connexion</dt>

                                    <dd><?= $lcom['last_connect']?></dd>

                                    <dt>Login</dt>

                                    <dd><?= stripslashes($lcom['login_comm'])?></dd>

                                    <dt>Mot de Passe</dt>

                                    <dd><?= base64_decode( stripslashes($lcom['passw_comm']))?></dd>

                                </dl>

                            </div>

                            <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">

                                <strong><?= $lcom['nom_comm'].' '.$lcom['pnom_comm']?></strong><br>

                                <table class="table table-user-information">

                                    <tbody>

                                    <tr>

                                        <td>Niveau :</td>

                                        <td><?php if($lcom['level_comm'] ==1) { echo 'Administrateur'; } else { echo 'Commercial'; } ?></td>

                                    </tr>

                                    <tr>

                                        <td>Dérniére connexion</td>

                                        <td><?= $lcom['last_connect']?></td>

                                    </tr>

                                    <tr>

                                        <td>Login</td>

                                        <td><?= stripslashes($lcom['login_comm']) ?></td>

                                    </tr>

                                    <tr>

                                        <td>Mot de Passe</td>

                                        <td><?= base64_decode(stripslashes($lcom['passw_comm'])) ?></td>

                                    </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="panel-footer">

                        <button class="btn btn-sm btn-primary" type="button"

                                data-toggle="tooltip"

                                data-original-title="Send message to user"><i class="glyphicon glyphicon-envelope"></i></button>

                          <span class="pull-right">
<a href="profile.php?comm=<?= $lcom['id_comm'] ?>">
                            <button class="btn btn-sm btn-warning" type="button" ><i class="glyphicon glyphicon-edit"></i></button></a>

                            

							<button class="btn btn-sm btn-danger" type="button"

									data-toggle="modal" data-target="#2<?= $lcom['id_comm'] ?>"

                                    data-original-title="Remove this user"><i class="glyphicon glyphicon-remove"></i></button>

									

<div class="modal modal-danger fade " id="2<?= $lcom['id_comm'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

            

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $lcom['nom_comm'].' '.$lcom['pnom_comm']?> </h4>

                </div>

            

                <div class="modal-body">

                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>

                    <p>Vous voulez confirmer</p>

                    <p class="debug-url"></p>

                </div>

                

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>

                    <a href="comm_profile.php?cdr=ok&comm=<?= $lcom['id_comm']?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>

                </div>

            </div>

        </div>

    </div>  

                        </span>

                    </div>

                </div>

            </div>

        </div>

                

                             <?php

							}

							?>	

    </div>

	</section>

</div>



<?php

$page = 15;

require_once("_footer.php");

?>