<!DOCTYPE html>

<html lang="en">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- Make IE8 behave like IE7, necessary for charts -->

		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

		

		<title>Gestion Commerciale</title>

		

		<!-- CSS -->

		<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css" />

		<link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />

		<link rel="stylesheet" type="text/css" media="screen" href="css/custom-theme/jquery-ui-1.8.1.custom.css" />

		

		<!-- IE specific CSS stylesheet -->

		<!--[if IE]>

			<link rel="stylesheet" type="text/css" media="screen" href="css/ie.css" />

		<![endif]-->

		

		<!-- This stylesheet contains advanced CSS3 features that do not validate yet -->

		<link rel="stylesheet" type="text/css" media="screen" href="css/css3.css" />

		

		<!-- JavaScript -->

		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        	

		<script type="text/javascript" src="js/jquery-ui.min.js"></script>

		<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>

		<script type="text/javascript" src="js/jquery.rounded.js"></script>

		<script type="text/javascript" src="js/excanvas.js"></script>

		<script type="text/javascript" src="js/jquery.visualize.js"></script>

		<script type="text/javascript" src="js/script.js"></script>
        
        
        
        


<?php
if(isset($custom_includes)) echo $custom_includes;
?>

	</head>

    

 	<body>

		<div id="bokeh"><div id="container">

			

			<div id="header">

				<h1 id="logo">Gestion Commerciale</h1>

				

				<div id="header_buttons">

				<?php
				$logger = $myadmin->InfoLogger($_SESSION['loginadmin']);
				$namelogger = $logger['pnom_comm'].' '.$logger['nom_comm'];
				
				?>	

				<!--	<a href="#modal" rel="modal"><img src="images/icons/envelope.png" alt="3 Messages" />3</a>				

					<a href="#modal2" rel="modal">modal box test</a>-->		

					<a rel="modal"> Bienvenue : <a href="monprofil.php"><?= $namelogger ?></a></a>

					<a href="logout.php">Déconnexion</a>

					

					

				</div><!-- end #header_buttons -->

				

				<!-- Modal box -->

				<!--<div id="modal">	

					<div class="modalbox">

						<div class="modalhead">

							<img src="images/modaltop.png" alt="Modal arrow" />

							Mailbox

						</div>

						

						<div class="modalcontent">

							<div class="message">

								<div class="author"><a href="#">Teun</a></div>

								<div class="content">This skin can be easily styled!</div>

								<div class="datetime">16-05 - 08:16</div>

							</div>

							

							<div class="message">

								<div class="author"><a href="#">Pieter</a></div>

								<div class="content">It can also be styled very easily.</div>

								<div class="datetime">11-05 - 16:27</div>

							</div>

								

							<div class="message">

								<div class="author"><a href="#">Jane Doe</a></div>

								<div class="content">This template uses a lot of nice CSS3 effects.</div>

								<div class="datetime">10-05 - 18:42</div>

							</div>

						</div>

							

						<div class="modalfoot">

							<img src="images/icons/newmessage.png" alt="New message" /> New message

						</div>

					</div>

				</div>

				

				

				<div id="modal2">	

					<div class="modalbox">

						<div class="modalhead">

							<img src="images/modaltop.png" alt="Modal arrow" />

							Mailbox 2

						</div>

						

						<div class="modalcontent">

							<div class="message">

								<div class="author"><a href="#">Pieter</a></div>

								<div class="content">It can also be styled very easily.</div>

								<div class="datetime">11-05 - 16:27</div>

							</div>

								

							<div class="message">

								<div class="author"><a href="#">Jane Doe</a></div>

								<div class="content">This template uses a lot of nice CSS3 effects.</div>

								<div class="datetime">10-05 - 18:42</div>

							</div>

						</div>

							

						<div class="modalfoot">

							<img src="images/icons/newmessage.png" alt="New message" /> New message

						</div>

					</div>

				</div>-->



				

				<!-- Navigation -->

				<ul id="main-nav">

					<li>

						<a href="home.php" class="<?= $menu[0]; ?>">

							Accueil

						</a>

					</li>

						

					<li>

						<a href="mesclients.php" class="<?= $menu[1]; ?>"><!-- use href="#" to indicate there's a submenu -->

							Mes clients

						</a>

						

					</li>
                    
                    <li>

						<a href="search.php" class="<?= $menu[5]; ?>"><!-- use href="#" to indicate there's a submenu -->

							Recherche

						</a>

						

					</li>

						

					<li>

						<a href="clients.php" class="<?= $menu[2]; ?>">

							Nouveau client

						</a>

						

						

					</li>
                    
                    <li>

						<a href="calendrier_rappels.php" class="<?= $menu[3]; ?>">

							Mes rappels

						</a>

						

						

					</li>
                    
                    
                 

					
					<?php
					if($_SESSION['loginadmin'] == '1')
					{
					?>
               
                     <li>

						<a href="param.php" class="<?= $menu[4]; ?>">

							Paramêtres

						</a>
                
						

					</li>
                    
                    <?php
					}
					?>

				</ul><!-- end #nav -->

				

			</div><!-- end #header -->   
            
     