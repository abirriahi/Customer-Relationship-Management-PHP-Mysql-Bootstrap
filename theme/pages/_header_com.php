<!DOCTYPE html>
<html>

	<?php 
	if($page==6 || $page==9) { 
	?> 
	<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gestion Commercial</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" href="../dist/img/logo-titv.png" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/skin-black-light.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- jvectormap --> 
  <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	
 <?php } else {  ?> 

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gestion Commercial</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" href="../dist/img/logo-titv.png" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/skin-black-light.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">  

  
  <!-- Morris chart -->
  <link rel="stylesheet" href="../plugins/morris/morris.css">

  <?php if(($page==1) || ($page==2)|| ($page==4)|| ($page==12)|| ($page==17)) {  ?>
    <!-- DataTables -->
       <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <?php }
    if($page==5) { 
	?>
      <!-- Bootstrap Core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />


    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 1px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<?php }  ?> 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <?php }  ?> 
</head>
<body class="hold-transition skin-black-light sidebar-mini">
<div class="wrapper">

                 <?php
				$me = $myadmin->InfoLogger($_SESSION['comm']);
				 ?>	


  <header class="main-header">
    <!-- Logo -->
    <a href="../index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
	  	<img src="../dist/img/logo-titv.png" class="logo-mini" width="50px" height=" auto"  />
      <!-- logo for regular state and mobile devices -->
	   <img src="../dist/img/logo.png" class="logo-lg" width="auto" height=" 50px" />

    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
     
	  
        <span class="sr-only">Toggle navigation</span>
      </a>
	   <!-- Collect the nav links, forms, and other content for toggling -->
	   
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  <!--****************************************************************** -->
		 <?php
				if($_SESSION['comm'] == 1)
				{ ?>
			<li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-heart"></i>
			<?php   $demande = $myadmin->AlertAdminForCm_demande_clients(); 
			        $nbrdmd =  $demande; 
					 
						if(!empty($nbrdmd))
						{
							$nbrdmd = sizeof($nbrdmd);
								}
					else
		               {
			            $nbrdmd = 0;
		                   }
			?>
              <span class="label bg-maroon"><?= $nbrdmd ; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez <span style="font-weight:bold; font-size:14px;"><?= $nbrdmd ;?></span> Demande(s) de Affectation </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php
				foreach($demande as $dmd)
					{
					$cl = $myadmin->DetailsClient($dmd['id_cl']);
						$comm = $myadmin->InfoLogger($cl['id_comm']);
					?>
                  <li><!-- Task item -->
                    
					<a href="client.php?client=<?= $cl['id_cl'];?>">
                      <i class="fa fa-heart text-maroon"></i>&nbsp;&nbsp;&nbsp;<?= '  '.stripslashes($cl['entreprise_cl']).'  ';?>   <?= $comm['nom_comm'].' '.$comm['pnom_comm'];?>
                    </a>
                  </li>
				  <?php
			             }
				
				?>
                  <!-- end task item -->
                  
                </ul>
              </li>
              <li class="footer">
                <a href="cm_demande_clients.php">Voir tout </a>
              </li>
            </ul>
          </li>	
				<?php } ?>
		  <!--****************************************************************** -->
           <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-calendar"></i>
			<?php   $events = $myadmin->Aujourdevent($_SESSION['comm'],date("Y-m-d")); 
			        $nbreven =  $events; 
					 
						if(!empty($nbreven))
						{
							$nbreven = sizeof($nbreven);
								}
					else
		               {
			            $nbreven = 0;
		                   }
			?>
              <span class="label label-info"><?= $nbreven ; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez <span style="font-weight:bold; font-size:14px;"><?= $nbreven ;?></span> Evennement(s) pour Aujourd'hui </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php
				foreach($events as $ev)
					{
					?>
					<li>
                    <a href="evennement.php">
                      <h5>
					  <?= $ev['title'];?> 
                        <small class="pull-right"><i class="fa fa-clock-o"></i> <?= $ev['start'];?></small>
                      </h5>
                      
                    </a>
                  </li>
				  <?php
			             }
				
				?>
                  <!-- end task item -->
                  
                </ul>
              </li>
              <li class="footer">
                <a href="evennement.php">Voir tout </a>
              </li>
            </ul>
          </li>	
		  
		  <!--****************************************************************** -->
		           <?php
				if($_SESSION['comm'] == 1)
				{
					  $request = $myadmin->AlertAdminForClientDeleteRequest();
					  $asupp =  $myadmin->ListeClientsASupprimer();
					 
						if(!empty($asupp))
						{
							$supreq = sizeof($asupp);
								}
					else
		               {
			            $supreq = 0;
		                   }
         
				
				?>
		  <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-times"></i>
              <span class="label label-danger"><?=$supreq ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez <span style="font-weight:bold; font-size:14px;"><?=$supreq ?></span> demandes de suppression client </li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php
				foreach($asupp as $cf)
					{
						$cl = $myadmin->DetailsClient($cf['id_cl']);
						$comm = $myadmin->InfoLogger($cf['id_comm']);
					?>
                  <li><!-- Task item -->
                    
					<a href="client.php?client=<?= $cf['id_cl'];?>">
                      <i class="fa fa-user-times text-red"></i>  <?= '  '.stripslashes($cl['entreprise_cl']).'  ';?>   <?= $comm['nom_comm'].' '.$comm['pnom_comm'];?>
                    </a>
                  </li>
				  <?php
			             }
				
				?>
                  <!-- end task item -->
                  
                </ul>
              </li>
              <li class="footer">
                <a href="clientdeleterequest.php">Voir les demandes</a>
              </li>
            </ul>
          </li>	

		  
               <?php
			  }
				
				?>
			  
			  
			  
			  
			  <?php
						$rappels =  $myadmin->AfficherMesRappel($_SESSION['comm'],date("Y-m-d"));
						if(!empty($rappels))
						{
							$nbrrapps = sizeof($rappels);
								}
					else
		{
			            $nbrrapps = 0;
		}
         ?>
					
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?=$nbrrapps ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez <span style="font-weight:bold; font-size:14px;"><?=$nbrrapps ?></span> rappels aujourd'hui </span></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
				<?php
                  //Afficahge des rappel du jour
		
				if(!empty($rappels))
						{
						foreach($rappels as $rapp)
						{
							
							
							$quiclient = $myadmin->DetailsClient($rapp['id_cl']);
							$quiclient = $quiclient['entreprise_cl'];
							$vueornot = $rapp['etat_rapp'];
							
						
							
							if($vueornot == '0' && ($rapp['time_rapp'] > date("H:i")))
							{
								$classnotif="rappelnotification";
							}
							if($vueornot == '0' && ($rapp['time_rapp'] < date("H:i")))
							{
								$classnotif="rappeloubliernotification";
							}
							if($vueornot == '1' && ($rapp['time_rapp'] > date("H:i")))
							{
								$classnotif="rappelvuenotification";
							}
							
							if($vueornot == '1' && ($rapp['time_rapp'] < date("H:i")))
							{
								$classnotif="rappeloubliernotification";
							}
							
							
							
							
						?>
                  <li>
                    <a href="client.php?client=<?= $rapp['id_cl'];?>&commentaire=<?= $rapp['id_cm'];?>&statut=read#commentslist">
                      <i class="fa fa-warning text-yellow"></i> Rappel : <?= stripslashes($quiclient) ?> à <?= $rapp['time_rapp']?>

                    </a>
                  </li>
				  <?php
						}
						}
						
						?>
                  
                </ul>
              </li>
              <li class="footer"><a href="rappels.php">Voir tout</a></li>
            </ul>
          </li>      

                        <?php
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['comm'],date("Y-m-d"));
						if(!empty($oldrappels))
						{
							$nbroldrapps = sizeof($oldrappels);
													
						}
					else
						{
							$nbroldrapps =0 ; 
						}
						?>
           <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-hourglass-end"></i>
              <span class="label label-success"><?=$nbroldrapps ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Vous avez anciens <span style="font-weight:bold; font-size:14px;"><?=$nbroldrapps ?></span> rappels </li>
              <li>
                <!-- inner menu: contains the actual data -->
                
              </li>
              <li class="footer"><a href="rappels.php">Voir Tout </a></li>
            </ul>
          </li>

		  
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="img/<?= $me['avatar'] ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $me['nom_comm'].' '.$me['pnom_comm'] ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="img/<?= $me['avatar'] ?>" class="img-circle" alt="User Image">
                <p>
                 <?= $me['nom_comm'].' '.$me['pnom_comm'] ?>
                </p>
              </li>
            
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="profile.php?comm=<?= $me['id_comm'] ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Déconnexion</a>
                </div>
              </li>
            </ul>
          </li>
          
		  
		  
		  <!-- Control Sidebar Toggle Button -->
		   
        
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>
			<?php
				if($me['level_comm'] == 1)
				{
					 ?>
			    <ul class="dropdown-menu" style="color: #000;" role="menu">
			    <li><a href="groupes.php"><i class="fa fa-pie-chart"></i> Groupes</a></li>
                <li><a href="fonctions.php"><i class="fa fa-cog"></i> Fonctions</a></li>
                <li><a href="secteurs.php"> <i class="fa fa-sitemap"></i> Secteurs</a></li>
				<li class="divider"></li>
                <li><a href="comm_profile.php"><i class="fa fa-user"></i> Commercials</a></li>
                <li class="divider"></li>
                <li><a href="add_commerciaux.php"><i class="fa fa-user-plus"></i>Ajout</a></li>
                <li><a href="comm_profile.php"><i class="fa fa-users"></i>Liste Commercials</a></li>
				<li class="divider"></li>
				<li><a href="" data-toggle="modal" data-target="#listecommercial"  title="Connecter Au tant que commercial !" ><i class="fa fa-users"></i>Connecter Comme ...</a></li>
		

              </ul>
			   <?php
				           }
						 ?>
          </li>
		  
		            
        </ul>
      </div>
    </nav>
	 
	 
	  <?php if($page==4) { 
    echo '<style>
	<.example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    } 
     </style>';
     
	  } 
	  ?>
  </header>
    
    	<div class="modal modal-default fade " id="listecommercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Changer le commercial de <?= stripslashes($cl['entreprise_cl']);?></strong></h4>
                </div>
            <form action='page_comm.php' method='post'>
                <div class="modal-body">
                    <p>Connecter Comme, </p>
<div class="form-group">					 
<select name='commerciaux' id='commerciaux' class="form-control">
<option value=''>-- Commercial ? --</option>
<?php
$commerciaux = $myadmin->ListeCommerciaux();
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
                </div>
				</form>
            </div>
        </div>
    </div>
        <?php
        // put your code here
        ?>
