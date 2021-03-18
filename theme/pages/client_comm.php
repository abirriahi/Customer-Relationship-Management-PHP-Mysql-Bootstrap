<?php
session_start();

if (empty($_SESSION['comm'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");


//$clt = $_GET['idclient'];
$clt = $myadmin->DetailsClient($_GET['idclient']);
$grcl = $myadmin->GroupeParId($clt['id_gr']);
$commerciaux = $myadmin->ListeCommerciaux();

$commercialclient = $clt['id_comm'];


$page = 6;
require_once("_header_com.php");
$page = 6;
require_once("_side_comm.php");

if (isset($_POST['client'])) {
    // $client = $_POST['client'];
	 $client = $idclient;
      $cl = $myadmin->DetailsClient($client);
    $grcl = $myadmin->GroupeParId($cl['id_gr']);
}

if (isset($_GET['client'])) {
    // $client = $_GET['client'];
	 $client = $idclient;
      $cl = $myadmin->DetailsClient($client);
    $grcl = $myadmin->GroupeParId($cl['id_gr']);
}


$sitehttp = substr($cl['siteweb_cl'], 0, 7);
if ($sitehttp == 'http://') {
    $prefixe = '';
} else {
    $prefixe = 'http://';
}

if (isset($_POST['updatecommercial'])) {
    $myadmin->UpdateCommercialClient($client, $_POST['commerciaux']);
	$myadmin->DeleteListeClientsASupprimer($client);
    $cl = $myadmin->DetailsClient($client);
	$infocomm = $myadmin->InfoLogger($_POST['commerciaux']);
	$libelleclient = stripslashes($cl['entreprise_cl']);
	$myadmin->LogMe('a Transférer le client : <a href="client.php?client=' . $client . '">' . $libelleclient . '</a> à '.$infocomm['pnom_comm'].' '.$infocomm['nom_comm'].' ', $_SESSION['comm']);
}

//Mise à jour du statut de rappel
if (isset($_GET['statut']) && $_GET['statut'] == 'read' && isset($_GET['commentaire'])) {
    $myadmin->MiseAJourRappelRead($client, $_GET['commentaire'], '1');
}

$interretclient = $myadmin->AfficheLigneStatutCl($cl['id_cls']);

$commercialclient = $cl['id_comm'];
if ($commercialclient == $_SESSION['comm']) {
    $quiestlecommercial = 'Commercial : vous.';
} else {
    $infocommercial = $myadmin->InfoLogger($cl['id_comm']);
    $nomcommercial = $infocommercial['nom_comm'] . ' ' . $infocommercial['pnom_comm'];
    $quiestlecommercial = 'Commercial : ' . $nomcommercial;
}
?>

<?php
//Sauvgarde commentaire
if (isset($_POST['savecomments'])) {

    $idcommentaire = $myadmin->InsererCommentaire($_POST['comment'], $client, $_POST['contactclient'], $_SESSION['comm']);

    $timerappel = $_POST['heurerappel'] . ':' . $_POST['minuterappel'];

    $idnewrappel = $myadmin->AjouterRappel($_SESSION['comm'], $client, $idcommentaire, $_POST['daterappel'], $timerappel);

    $myadmin->MiseAJourAncienRappel($client, $idnewrappel, '2');

    echo '<div class="notification information">

L\'enregistrement à été ajouté.

</div>';

    $libelleclient = stripslashes($cl['entreprise_cl']);
    $myadmin->LogMe('a ajouté un commentaire dans la fiche du client : <a href="client.php?client=' . $client . '" style="color:'.$cl['couleur_cls'].'" >' . $libelleclient . '</a>', $_SESSION['comm']);
}

if(isset($_POST['listouvme']))
	{
    $myadmin->UpdateLiOuvClient($_POST['client'],1);
	$myadmin->DeleteListeClientsASupprimer($_POST['client']);
	$libelleclient = stripslashes($cl['entreprise_cl']);
	$myadmin->LogMe('a Transférer le client : <a href="client.php?client=' . $client . '"style="color:'.$cl['couleur_cls'].'">' . $libelleclient . '</a> à la liste Ouverte', $_SESSION['comm']);
	
	$succes = "<div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Le Client à été Transmis à la liste Ouverte avec succé
              </div> "; 
	}

if (isset($_GET['cdr']) && isset($_GET['c'])) {
    $myadmin->ClientDeleteRequest($_SESSION['comm'], $_GET['c']);
    $succes = "<div class=\"alert alert-warning alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <h4><i class=\"icon fa fa-check\"></i> Alert!</h4>
                Votre demande de suppression a été transmis avec succés            
				</div> "; 
	$libelleclient = stripslashes($cl['entreprise_cl']);
	$myadmin->LogMe('a Demander de Supprimer le client : <a href="client.php?client=' . $client . '" style="color:'.$cl['couleur_cls'].'">' . $libelleclient . '</a> ', $_SESSION['comm']);			
			}
 $cl = $myadmin->DetailsClient($client);			
?>
<script type="text/javascript" src="../includes/scripts/select_ajax.js"></script>

<script src="../includes/calender/src/js/jscal2.js"></script>
<script src="../includes/calender/src/js/lang/fr.js"></script>
<!-- Date Picker -->
<link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 420px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
			<?php
			     if ($cl['id_gr']!=0) {
                    $listeclientpargroupe = $myadmin->ListeClientsParGroupe($cl['id_gr']);
                    foreach ($listeclientpargroupe as $lcgr) {
              ?> 
                 <li class="active"><a href="client.php?client=<?= $lcgr['id_cl']  ?>" ><?= stripslashes($lcgr['entreprise_cl'])  ?></a></li>
              
          <?php
				 } }
               ?>
			   <li class="pull-left header"><i class="fa fa-th"></i> Profile Client   *****  <?php if (isset($grcl['libelle_gr'])) { echo 'Groupe '.$grcl['libelle_gr']; } else {echo 'Pas de Groupe '.$lcgr['id_gr'] ;}  ?></li>
            </ul> 
	     </div>		
    </section>

    <!-- Main content -->
    <section class="content">
	 <?= $succes  ?>
	<?php
			   
			  
			   
				if($_SESSION['comm'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><h4><i class="icon fa fa-info"></i> Alert!</h4>Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a></p>
					
					</div>';
				}
				
				 if($cl['id_cls'] == '5')
				{
					$listemagazine = $myadmin->ListeEditionsClient($client);
					$listmag = '';
					if(!empty($listemagazine))
					{
						foreach($listemagazine as $lmag)
						{
							$listmag .= $lmag['num_mag'].' ; ';
						}
					}
					
					echo '<div class="callout bg-maroon">
                <p><i class="icon fa fa-check"></i> Le client a signé pour les éditions : <span style="font-size:20px;">'.$listmag.'</span></p>
              </div>';
				}
				
				?>
           
        <div class="row">
		
		 <div class="col-md-<?php
                        if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') { ?>4<?php }else { ?>6<?php } ?> ">

          <!-- Profile Image -->
          <div class="box box-primary">
		  <div class="box-header">
		  <div class="pull-right box-tools">
				<button type="button" class="btn btn-default btn-sm" title="Rediriger clients Vers liste ouverte !" data-toggle="modal" data-target="#listouv" ><i class="fa fa-caret-square-o-left text-yellow"></i></button>
                <button type="button" class="btn btn-default btn-sm" title="Supprimer Client !" data-toggle="modal" data-target="#supprimer" ><i class="fa fa-trash-o text-red"></i></button>
                  <?php if(($_SESSION['comm'] == '1'))
                                    { ?>
				 <button type="button" class="btn btn-default btn-sm" title="Rediriger client à un Commercial !" data-toggle="modal" data-target="#listecommercial"  title="Changer le commercial de client !" ><i class="fa fa-share text-purple"></i></button>
				  <?php } ?>
            
           </div>
		   
		    <p class="text-muted"><?= $quiestlecommercial ?> </p>
		   
		   </div>
		   
		   
<div class="modal modal-default fade " id="listecommercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Changer le commercial de <?= stripslashes($cl['entreprise_cl']);?></strong></h4>
                </div>
            <form action='client.php' method='post'>
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
					<input name='client' type='hidden' value='<?= $cl['id_cl'] ?>'>
					<input name='updatecommercial' type='hidden' value='1'>
                </div>
				</form>
            </div>
        </div>
</div>
	 <div class="modal modal-default fade " id="listouv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action='client.php' method='post'>
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
					<input name='client' type='hidden' value='<?= $cl['id_cl'] ?>'>
					<input name='listouvme' type='hidden' value='<?= $cl['id_cl'] ?>'>
                    <button type="submit" class="btn btn-warning btn-ok">Confirmé</button>
               </div>
			   </form>
        </div>
    </div> 
	</div>
	
<div class="modal modal-danger fade " id="supprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Supprimer <?= $cl['entreprise_cl'] ?> </h4>
                </div>
            
                <div class="modal-body">
                    <p>Vous êtes sur le point de supprimer une trace, cette procédure est irréversible</p>
                    <p>Vous voulez confirmer</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler </button>
                    <a href="client.php?cdr=ok&c=<?= $cl['id_cl'] ?>&client=<?= $cl['id_cl'] ?>"> <button type="button" class="btn btn-danger btn-ok">Confirmé</button></a>
                </div>
            </div>
        </div>
    </div> 		
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../dist/img/client.jpg" alt="User profile picture">

              <h3 class="profile-username text-center"><strong><a style="color:<?= $interretclient['couleur_cls'] ?>;"  href="<?php if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') { ?>editclient.php?client=<?= $client ?><?php } ?>">
                                    <?= stripslashes($cl['entreprise_cl']); ?> </a>
                            <?php
                            if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') {
                                ?>
                                <a href="editclient.php?idclient=<?= $cl['id_cl'] ?>" style="color:<?= $interretclient['couleur_cls'] ?>;" title="Modifier les données !" ><i class="fa fa-pencil"></i></a>
                                <?php
                            }
                            ?> 
						</strong></h3>
									
                         <?php if ($cl['id_clcat'] == 3) { ?> <p class="text text-center">
                            <?php echo '   '.$myadmin->AfficherSecteur($cl['id_clcat']) . ' (' . $cl['activite_cl'] . ')'; ?> </p>
							
                            <?php } else { ?> <p class="text text-center"> <?php echo '   '.$myadmin->AfficherSecteur($cl['id_clcat']); ?> </p>  <?php } ?> 
                                
				
              
	
			   <input name="commercialclient" id="commercialclient" type="hidden" value="<?= $commercialclient; ?>" />		
			       <!--	*************************************************************************************-->
         
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <?php
                            $contactclient = $myadmin->ListeContactParClient($client);
                            $nn = "in";
                            foreach ($contactclient as $lcc) {
                                ?>
                                <div class="panel box">
                                    <div class="box-header with-border text-center">
                                        <h4 class="box-title" >
                                          <strong>  <a  data-toggle="collapse" data-parent="#accordion" href="#<?= $lcc['id_ctc']; ?>"> <?= $lcc['nom_ctc']; ?> </a></strong>
                                        </h4>
                                    </div>
                                    <div id="<?= $lcc['id_ctc']; ?>" class="panel-collapse collapse <?php if ($nn == "in") {
                                echo 'in';
                            }
                            ?>">
                                        <div class="box-body text-center">
                                            <p> <h5><?= $myadmin->AfficherFonctionContact($lcc['id_fct']); ?> </h5></p>
                                            <p> <h5><a href="mailto:<?= $lcc['email_ctc']; ?> "><?= $lcc['email_ctc']; ?> </a></h5> </p>
                                            <p> <h5><?= $lcc['tel_ctc']; ?> </h5> </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $nn = $lcc['id_ctc'];
                            }
                            ?>
                                               
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Information de Client </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			         <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Adresse :</b> 
                </li>
				<li class="list-group-item" style="font-size: 13px; color: #3c8dbc ; ">
                 <p><?= stripslashes($cl['adresse_cl'] . ' ' . stripslashes($cl['region_cl'])) ?></p>
                </li>
                <li class="list-group-item">
                  <b>Ville :</b> <a class="pull-right"><?= $myadmin->NomVille($cl['id_ville']) ?></a>
                </li>
				<?php if ($cl['siteweb_cl']!= '') { ?>
                <li class="list-group-item">
                  <b>Site web :</b> 
                </li>
				<li class="list-group-item">
                 <b>...</b> <a class="pull-right"  href="<?= $prefixe . $cl['siteweb_cl']; ?>" target="_blank"><?= $cl['siteweb_cl']; ?></a>
                </li>
				<?php } ?>
				<li class="list-group-item">
                  <b>Téléphone :</b> <a class="pull-right" ><?= $cl['tel1_cl'] ?></a>
                </li>
				<?php if ($cl['tel2_cl'] != '') { ?> 
				<li class="list-group-item">
                  <b>Téléphone # :</b> <a class="pull-right" ><?= $cl['tel2_cl'] ?></a>
                </li>
				<?php } ?> 
				<?php if ($cl['fax_cl']!= '') { ?>
				<li class="list-group-item">
                  <b>Fax :</b> <a class="pull-right"><?= $cl['fax_cl'] ?></a>
                </li>
				<?php } ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
		
		
	            <!-- Box Comment -->
				
				
				 <?php
                        if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') {

                            //Mise a jour Statut client//
                            if (isset($_POST['etatinteresse'])) {
                                $myadmin->UpdateStatutClient($_POST['interesse'], $client);

                                $libelleclient = stripslashes($cl['entreprise_cl']);
                                $interretclient = $myadmin->AfficheLigneStatutCl($_POST['interesse']);
                                $couleurclient = $myadmin->AfficheCodeCouleurClient($_POST['interesse']);

                                $myadmin->LogMe('a changé le statut du client <a href="client.php?client=' . $client . '" style="color:' . $couleurclient . '">' . $libelleclient . '</a> en ' . $interretclient['libelle_cls'], $_SESSION['comm']);


                                $cl = $myadmin->DetailsClient($client);
                            }
                            ?>
							<div class="col-md-8">
                            <div class="box">
                                <div class="box-header with-border">
                                    <?php
                                    //Client Intéressé oui ou non

                                    if ($cl['id_cls'] == '0') {
                                        echo '<h3 class="box-title">Client intéressé ? Veuillez choisir</h3>';
                                    } else {
                                        echo '<h3 style="color:' . $interretclient['couleur_cls'] . '; " class="box-title" >Client ' . $interretclient['libelle_cls'] . '</h3>';
                                    }
                                    ?>

                                </div>
                                <!-- /.box-header -->
                                <form role="form" action="#interret" method="post">
                                    <div class="box-body">

                                        <a name="interret"></a>   
                                        <input name="etatinteresse" type="hidden" value="" />

                                        <div class="form-group">
                                            <select style="height: 40px" class="col-md-8" name="interesse" required>
                                                <option value="">Changer</option>
                                                <?php
                                                $statut = $cl['id_cls'];
                                                $listeinterr = $myadmin->ListeStatutInteresse();
                                                foreach ($listeinterr as $lint) {
                                                    if ($statut == $lint['id_cls'])
                                                        $selected = 'selected="selected"';
                                                    else
                                                        $selected = '';
                                                    ?>
                                                    <option value="<?= $lint['id_cls'] ?>" style="background-color:<?= $lint['couleur_cls'] ?>; color:#ffffff;" <?= $selected ?>  ><?= $lint['libelle_cls'] ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <button type="submit" style="margin: 0px 15px " class="btn btn-info pull-right" onclick="makeRequest('repPhpAjax_miseajourstatut.php', 'activite', 'monactivite')" >Mettre à jour</button>
                                        </div>

                                        <!--!<input type="submit" value="Mettre à jour" onclick="makeRequest('repPhpAjax_miseajourstatut.php', 'activite', 'monactivite')" /> -->
                                      <br><br>
                                        <?php
                                        if ($statut == '5') {
                                            if (!empty($listemagazine)) {
                                                echo '<p><span style="padding-left:10px; font-weight:bold;"><a href="choisir_editions.php?client=' . $client . '" style="color:#ff0000;">Mettre à jour les éditions signé</a></span></p>';
                                            } else {
                                                echo '<p><span style="padding-left:10px; font-weight:bold;"><a href="choisir_editions.php?client=' . $client . '" style="color:#ff0000;">Remplir les éditions signé</a></span></p>';
                                            }
                                        }
                                        ?>
                                        

                                    </div>
                                    <!-- /.box-body -->   
                                </form>
                            </div>
                            <!-- /.box -->
							</div>
                        <?php } ?>	
				
				
				
				
				

           <!--	*************************************************************************************-->        
                  <?php
                if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') {
                    ?>           
		<div class="col-md-8">
                <!--.................................................................................v-->
                    <!-- /.box-body -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Commentaires</h3>
                        </div>
                        <div class="box-body">
                                <div class="content-box">
                                    <div class="content-box-content">
									    <div class="pre-scrollable" style=" max-height: 320px;" >  
                                         <form action="client.php?client=<?= $client ?>#timeComments" method="post" style=" margin-right: 15px;">              
                                            <input name="client" id="client" type="hidden" value="<?= $client ?>" />
                                            <input name="savecomments" id="savecomments" type="hidden" value="1" />
                                            <?php
                                            if (isset($_GET['contactavec'])) {
                                                $marequete = $myadmin->CommentaireClientContact($client, $_GET['contactavec']);
                                            } else {
                                                $marequete = $myadmin->CommentaireClient($client);
                                            }

                                            $comm = $marequete;
                                            $nbrcomments = sizeof($comm);
                                            if (!empty($comm)) {
                                                foreach ($comm as $key => $com) {
                                                    $nbr = $nbrcomments - $key;
                                                    $ctc = $myadmin->DetailsContact($com['id_ctc']);
                                                    ?>			
                                                    <!--............................................................................-->
                                                    <div class="comment-text">
                                                        <span class="username">Contact le : <?php echo date("d/m/Y H:i:s", strtotime($com['date_cm'])); ?> <span>/ Avec : </span><?= $ctc['nom_ctc'] ?> (<?= $ctc['tel_ctc'] ?>) 
                                                            <span class="text-muted pull-right">Commentaire N° : <?php echo $nbr ?></span>
                                                           
															<p><span class="titre">Email :</span><a href="mailto: <?= $ctc['email_ctc'] ?>"> <?= $ctc['email_ctc'] ?></a></span>
															<!-- /.username  ***************************-->
                                                       
                                                        <span style="float:right; color:#06F;">
                                                            <?php
                                                            if ($com['id_comm'] != '0') {
                                                                echo 'Commercial : ';
                                                                $comemrcialquiacontacter = $myadmin->InfoLogger($com['id_comm']);
                                                                echo $comemrcialquiacontacter['nom_comm'] . ' ' . $comemrcialquiacontacter['pnom_comm'];
                                                                ?></span>
                                                            </p>
                                                            <p><strong>Note : </strong><span class="text-muted pull-right">
															<?php
                                                        //Verifier si il y a un rappel pour ce commentaire//
                                                        $rappelcommentaire = $myadmin->RappelParCommentaire($client, $com['id_cm']);
                                                        if (!empty($rappelcommentaire)) {
                                                            if ($rappelcommentaire['etat_rapp'] == '0')
                                                                $colornotif = 'color:#ff0000;';
                                                            if ($rappelcommentaire['etat_rapp'] == '1')
                                                                $colornotif = 'color:#ff0000;';
                                                            if ($rappelcommentaire['etat_rapp'] == '2')
                                                                $colornotif = 'color:#090;';
                                                            ?>
                                                            <span style="float:right; <?= $colornotif ?>  ">le : <?= $rappelcommentaire['date_rapp'] ?> à <?= $rappelcommentaire['time_rapp'] ?></span>
                                                            <?php
                                                        }
                                                        ?></span>
														<?= stripslashes($com['contenu_cm']) ?>
															 </p>

                                                            <hr />
                                                            <?php
                                                        }
														?>
														</div>
                                                         <!-- /.comment-text -->
														<?php
                                                    }
                                                } else {
                                                    echo '<span class="messagenoclient"> Il n\'y a pas des commentaires pour ce client</span>';
                                                    echo '<div class="space">&nbsp;</div>';
                                                    ?>

                                                    <?php } ?>
                                                <!--*****************************************-->
                                            

                                            <!-- /.box-comment -->
										</form>	
                                         </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /.box -->
                      
                     </div>
					 
                    <!--*****************************************-->
				</div>	 
           	 <?php } ?>
                <!--/***************************************************************************************v-->

		 <?php
        if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') {
            ?> 
        <div class="col-md-8">
                    <div class="box box-warning">
					<form action="client.php?client=<?= $client ?>" method="post"> 
                        <div class="box-header">
                            <h3 class="box-title"><?= stripslashes($cl['entreprise_cl']); ?>
                                <small>
                                    <?php
                                    if ($commercialclient == $_SESSION['comm'] || $_SESSION['comm'] == '1') {
                                        ?>
                                        <a href="editclient.php?idclient=<?= $cl['id_cl'] ?>"><strong><i class="fa fa-pencil"></i> Modifier</strong></a>
                                        <?php
                                    }
                                    ?> 
                                </small>
                            </h3>
                        </div> 
						
                        <div class="box-body pad">
						 

                            <?php
                            if (isset($_GET['contactavec'])) {
                                $marequete = $myadmin->CommentaireClientContact($client, $_GET['contactavec']);
                            } else {
                                $marequete = $myadmin->CommentaireClient($client);
                            }

                            $comm = $marequete;
                            $nbrcomments = sizeof($comm);
                            if (!empty($comm)) {
                                //Liste contact
                                $listecpcl = $myadmin->ListeContactParClient($client);
                                $listederoulante = "";
                                $listederoulante .= "

                <div class=\"form-group\">
                <label style=\"margin-top: 5px;\" class=\"col-sm-1 control-label\">Contact</label>
                <div class=\"col-sm-11\">
                <select name='contactclient' class=\"form-control\" id='contactclient' required>";

                                $listederoulante .= "<option value=''>-- Qui vous avez contacter ? --</option>";

                                foreach ($listecpcl as $lcc) {
                                    $fct = $myadmin->AfficherFonctionContact($lcc['id_fct']);

                                    $listederoulante .= "<option value=" . $lcc['id_ctc'] . ">" . $lcc['nom_ctc'] . " ( " . $fct . " )</option>";
                                }

                                $listederoulante .= "</select>
                </div>
                </div> ";
                                echo $listederoulante;
                            } else {

                                $listecpcl = $myadmin->ListeContactParClient($client);
                                $listederoulante = "";
                                $listederoulante .= "

                <p>  
                <div class=\"form-group\">
                <label style=\"margin-top: 5px;\" class=\"col-sm-1 control-label\">Contact</label>
                <div class=\"col-sm-11\">
                <select name='contactclient' class=\"form-control\" id='contactclient' required>";

                                $listederoulante .= "<option value=''>-- Qui vous avez contacter ? --</option>";

                                foreach ($listecpcl as $lcc) {
                                    $fct = $myadmin->AfficherFonctionContact($lcc['id_fct']);

                                    $listederoulante .= "<option value=" . $lcc['id_ctc'] . ">" . $lcc['nom_ctc'] . " ( " . $fct . " )</option>";
                                }

                                $listederoulante .= "</select>
                </div>
                </div>
                </p>";
                                echo $listederoulante;
                            }
                            ?>     
                            <a name="commentsbloc"></a>
                            <br />
                            <br>

                            <!-- /.box-header -->

                            <textarea class="textarea" name="comment" placeholder="Placer votre Note Ici" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                            <!-- <button type="submit" class="btn btn-danger">Submit</button>-->

                            Date de prochain rappel :
                            <br />
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="daterappel" class="form-control pull-right" id="datepicker" placeholder="Date">
                                    </div>
                                    <!-- /.input group -->  
                                </div>
                                <div class="col-xs-3">
                                    <input id="f_date1" type="hidden"  />									
						<select name="heurerappel" id="f_hour" class="form-control"  required>
							<option value="h">Heures : HH</option>	
							<?php for ($heure = 00 ; $heure <= 23 ; $heure++):
								$hour = sprintf("%02d", $heure);
							?>
							<option value="<?php echo $hour ?>"><?=$hour;?></option>
							<?php endfor; ?>							
						</select>
									
                                </div>
                                <div class="col-xs-3">
									
									<select name="minuterappel" id="f_minute" class="form-control" required >
							<option value="min">Minutes : mm</option>	
							<?php for ($minutes = 00 ; $minutes <= 59 ; $minutes++):
								$min = sprintf("%02d", $minutes);
							?>
							<option value="<?=$min ?>"><?=$min;?></option>
						<?php endfor; ?>							
						</select>
									
                                </div>
                                <br>                            
                                           <input name="client" id="client" type="hidden" value="<?= $client ?>" />
                                            <input name="savecomments" id="savecomments" type="hidden" value="1" />
                            </div>
							
							</div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-danger  pull-right" value="Enregistrer" />
                            </div>
                            

                        

                       </form>
					</div>
					
                </div>
                    <!-- /.col -->
         <?php } ?>
		 </div>
	</section>
    <!-- /.content -->
 </div>	
 			          

<!-- /.content-wrapper -->
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
                                            $(function () {
                                                //bootstrap WYSIHTML5 - text editor
                                                $(".textarea").wysihtml5();
                                            });
</script>
<!-- bootstrap datepicker --> 
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script> 


<script>
                                            $(function () {

                                                //Date picker
                                                $('#datepicker').datepicker({
                                                    autoclose: true
                                                });

                                            });
</script>
<?php
$page = 6;
require_once("_footer.php");
?>	








