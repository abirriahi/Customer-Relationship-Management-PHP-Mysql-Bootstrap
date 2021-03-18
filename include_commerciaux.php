<?php>
require_once("_top.php");
if(isset($_GET['cdr']) && isset($_GET['comm']))
{
	$myadmin->DeleteCommercial($_GET['comm']);
	
	$msgdel = '<div class="notification warning" >
	Votre demande de suppression a été transmise à l\'administrateur elle sera validée prochainement (d\'ici là vous voyez le client coloré en rouge)					
</div>';
}

?>

<div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>Liste des commerciaux</h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						<table class="pagination" rel="5"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->

							<thead>

								<tr>

									<th>Nom / Prénom</th>

									<th>Dérniére connexion</th>
									
									<th>Actions</th>
									

								</tr>

							</thead>

							

							<tfoot>

								<tr>

									<td colspan="3">			

										

									</td>

								</tr>

							</tfoot>

									

							<tbody>

							<?php
				if(isset($_POST['addcom']))
				{
					$myadmin->AjoutCommercial($_POST['nom'],$_POST['pnom'],$_POST['login'],$_POST['password']);
					
					echo '<div class="notification information">

					L\'enregistrement à été ajouté.

				</div>';
	
				}
				?>
                
                
							<?php
							$listedescommerciaux = $myadmin->ListeCommerciaux();
							foreach($listedescommerciaux as $lcom)
							{
							?>		

								<tr>

									<td><?= $lcom['nom_comm'].' '.$lcom['pnom_comm']?></td>

									<td><?= $lcom['last_connect']?></td>

									<td>

										<a href="parametre.php?comm=<?= $lcom['id_comm']?>"><img src="images/icons/pencil.png" alt="Edit" /></a>

										<a href="param.php?part=com&cdr=ok&comm=<?= $lcom['id_comm']?>" class="confirmation"><img src="images/icons/cross.png" alt="Delete" /></a><!-- to create a tooltip-style confirmation, just add .confirmation to the <a>-tag -->

									</td>

								</tr>
							<?php
							}
							?>	
										

							</tbody>

						</table>

						

					</div><!-- end .content-box-content -->

					

				</div>
                
                <div class="clear"></div>
  
                
                <div class="content-box">

					<div class="content-box-header">

						<h3>Ajouter un commercial</h3>

					</div>

					

					<div class="content-box-content">

						<form action="param.php?part=com" method="post" >

							<fieldset>

								<p>

									<label></label>

									<input name="nom" id="nom" type="text" class="small" required placeholder="Nom commercial" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez entrer le nom du commercial .....</span>

								</p>
                                
                                	<p>

									<label></label>

									<input name="pnom" id="pnom" type="text" class="small" required placeholder="Prénom commercial" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez entrer le prénom du commercial .....</span>

								</p>
                                
                                
                                  <p>

									<label></label>

									<input name="login"  type="text" class="small" required placeholder="Login" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez entrer le login .....</span>

								</p>
                                
                                
                                
                                   	<p>

									<label></label>

									<input name="password" id="password" type="text" class="small" required placeholder="Mot de passe" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez entrer le mot de passe .....</span>

								</p>

						


							</fieldset>

						<input name="addcom" type="hidden" value="">

							<input type="submit" value="Submit" />

						</form>

					</div>

				</div>