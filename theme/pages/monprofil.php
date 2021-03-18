<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}

require_once("../../_top.php");



$page = 0;
require_once("_header.php");
$page = 0;
require_once("_side.php");

$connected = $myadmin->InfoLogger($_SESSION['loginadmin']);

?>



			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Mon profil</h2>
				<div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>

				

				<div class="content-box">

					<div class="content-box-header">

						<h3>Mes informations</h3>

					</div>

					<?php
					if(isset($_POST['updateme']))
					{
						$myadmin->UpdateCommercialInfo($_SESSION['loginadmin'],$_POST['nom'],$_POST['pnom'],$_POST['login'],$_POST['password']);
						
						$connected = $myadmin->InfoLogger($_SESSION['loginadmin']);
						echo '<div class="notification information">

					Les informations ont été mise à jour.

				</div>';
					}
					?>

					<div class="content-box-content">

						<form action="" method="post">

							<fieldset>

								<p>

									<label></label>

									<input name="nom" id="nom" type="text" class="small" required placeholder="Nom commercial" value="<?= $connected['nom_comm']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Mon nom .....</span>

								</p>
                                
                                	<p>

									<label></label>

									<input name="pnom" id="pnom" type="text" class="small" required placeholder="Prénom commercial" value="<?= $connected['pnom_comm']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Mon prénom .....</span>

								</p>
                                
                                
                                  <p>

									<label></label>

									<input name="login"  type="text" class="small" required value="<?= $connected['login_comm']?>" />
									<!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Login .....</span>

								</p>
                                
                                
                                
                           	  <p>

								<label></label>

								<input name="password" id="password" type="password" class="small" value="<?= base64_decode($connected['passw_comm'])?>" required placeholder="Mot de passe" />
								<!-- add .align-right to align the input elements to the right -->

								<span class="notification information">Mot de passe .....</span>

								</p>

						


							</fieldset>

						<input name="updateme" type="hidden" value="">

							<input type="submit" value="Mettre à jour" />

						</form>

					</div>

				</div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

$page = 6;
require_once("_footer.php");
?>		