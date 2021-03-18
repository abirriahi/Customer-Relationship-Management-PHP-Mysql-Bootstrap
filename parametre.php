<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[4]="current";

     if(isset($_GET['comm']))
{
	$comm = $_GET['comm'];
	$cm = $myadmin->commercial_by_id($comm);
}

$commercialclient = $cl['id_comm'];

if(($commercialclient == $_SESSION['loginadmin']) || ($_SESSION['loginadmin'] == '1'))
{
	


require_once("_header.php");




?>


<script type="text/javascript" src="includes/scripts/select_ajax.js"></script>
			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Modifier Commercial  </h2>
                

                
                 <?php
				if($_SESSION['loginadmin'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="notification error" >
					Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a>
					</div>';
				}
				
				?>
                
                
				<div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>

				

							<?php
				if(isset($_POST['udpatecls']))
				{
				
					$myadmin->UpdateCommercialInfo($comm ,$_POST['nom'], $_POST['pnom'], $_POST['login'], $_POST['password']);
								
					echo '<div class="notification information">

					Mise &agrave; jour effectu&eacute;. 

				</div>';
				}
	$cm = $myadmin->commercial_by_id($comm);

				?>
				

                
                <div class="clear"></div>
                
                
                
                <div class="content-box">

					<div class="content-box-header">

						<h3>Editer le commercial : <?= $cm['nom_comm']?></h3>

					</div>

					<span style="float:right"><a href="param.php?part=com"><img src="images/icon/back.png" width="64" height="64" alt="Retour" title="Retour" /></a></span>


					<div class="content-box-content">

						<form action="" method="post" >

							<fieldset>

								<p>

									<label></label>

									<input name="nom" id="nom" type="text" class="small" required value="<?= stripslashes($cm['nom_comm'])?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">nom du commercial .....</span>

								</p>
                                
                                	<p>

									<label></label>

									<input name="pnom" id="pnom" type="text" class="small" required value="<?= stripslashes($cm['pnom_comm'])?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">pr&eacute;nom du commercial .....</span>

								</p>
                                
                                
                                  <p>

									<label></label>

									<input name="login" type="text" class="small" required value="<?= stripslashes($cm['login_comm'])?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">login .....</span>

								</p>
                                
                                
                                
                                   	<p>

									<label></label>

									<input name="password" id="password" type="text" class="small" required value="<?=base64_decode( stripslashes($cm['passw_comm']))?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">mot de passe .....</span>

								</p>

						
                                <hr />
                	

							</fieldset>

						<input name="udpatecls" type="hidden" value="">

							<input type="submit" value="Mise &agrave; jour" />

						</form>

					</div>

				</div>
				

				

							

			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");
}
?>		