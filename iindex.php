<?php session_start();

require_once("_top.php");

if(isset($_POST['sbt']))

{

	$log=$myadmin->LoginAdmin($_POST['username'],$_POST['password']);

	if($log == false)

	{

		$msg='Veuillez vérifier vos accées';

	}

	else

	{
		$_SESSION['loginadmin']=$log;
		$myadmin->UpdateLogin($log);

	}

}

if(!empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="home.php"</SCRIPT>';

}

?>

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

		<script type="text/javascript" src="js/excanvas.js"></script>

		<script type="text/javascript" src="js/jquery.visualize.js"></script>

		<script type="text/javascript" src="js/script.js"></script>

	</head>



	<body>

		<div id="bokeh"><div id="container">

			

			<div id="header">

				<h1 id="logo">Gestion Commerciale</h1>

			</div><!-- end #header -->

			

			<div id="content">

			

				<h2><img src="images/icons/user_32.png" alt="Login" />Connexion</h2>

			

				<div id="login">

					

					<div class="content-box">

						<div class="content-box-header">

							<h3>Connexion</h3>

						</div>

					

						<div class="content-box-content">

						

							<?php  if(isset($msg)) { ?><div class="notification information"><?php echo $msg; ?></div><?php } ?>

						

							<form action="" method="post">

								<p>

									<label>Nom d'utilisateur</label>

									<input id="username" name="username" type="text" />

								</p>

						

								<p>

									<label>Mot de passe</label>

									<input id="password" name="password" type="password" />

								</p>

						

								<input type="submit" name="sbt" value="Connexion" />

							</form>

						</div>

					</div><!-- end .content-box -->

				</div><!-- end #login -->

											

			</div><!-- end #content -->

			

			<div id="push"></div><!-- push footer down -->

			

		</div></div><!-- end #container -->

		

		<div id="footer">

			Gestion Commerciale |  &copy; <?= date("Y"); ?>

		</div><!-- end #footer and #bokeh -->

		

	</body>

</html>