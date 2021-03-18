<?php

require_once("_top.php");
                
     if(isset($_GET['comm']))
{
	$comm = $_GET['comm'];
	$cm = $myadmin->commercial_by_id($comm);
}


?>
           
                
                <div class="content-box">

					<div class="content-box-header">

						<h3>Modifier les parametres de <?= $cm['nom_comm']?> <?= $cm['pnom_comm']?></h3>

					</div>

					

					<div class="content-box-content">

						<form action="param.php?part=com" method="post" >

							<fieldset>

								<p>

									<label></label>

									<input name="nom" id="nom" type="text" class="small" required value="<?= $cm['nom_comm']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">nom du commercial .....</span>

								</p>
                                
                                	<p>

									<label></label>

									<input name="pnom" id="pnom" type="text" class="small" required value="<?= $cm['pnom_comm']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">prénom du commercial .....</span>

								</p>
                                
                                
                                  <p>

									<label></label>

									<input name="login"  type="text" class="small" required value="<?= $cm['login_comm']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">login .....</span>

								</p>
                                
                                
                                
                                   	<p>

									<label></label>

									<input name="password" id="password" type="text" class="small" required value="<?= $cm['passw_comm']?>" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">mot de passe .....</span>

								</p>

						


							</fieldset>

						<input name="addcom" type="hidden" value="">

							<input type="submit" value="Submit" />

						</form>

					</div>

				</div>