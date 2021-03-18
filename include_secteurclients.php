
<div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>Liste des Secteur d'activité</h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						<table class="pagination" rel="5"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->

							<thead>

								<tr>

									<th>Libelle</th>

									<th></th>

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
				if(isset($_POST['addsec']))
				{
					
					$myadmin->AjoutSecteur($_POST['secteur']);
					
					echo '<div class="notification information">

					L\'enregistrement à été ajouté.

				</div>';
	
				}
				?>
                
                
							<?php
							$listesect = $myadmin->ListeSecteur();
							foreach($listesect as $sect)
							{
							?>		

								<tr>

									<td><?= $sect['libelle_clcat']?></td>

									<td>&nbsp;</td>

									<td>

										<a href="#"><img src="images/icons/pencil.png" alt="Edit" /></a>

										<a href="" class="confirmation"><img src="images/icons/cross.png" alt="Delete" /></a><!-- to create a tooltip-style confirmation, just add .confirmation to the <a>-tag -->

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

						<h3>Ajouter un secteur d'activité</h3>

					</div>

					

					<div class="content-box-content">

						<form action="param.php?part=sec" method="post" >

							<fieldset>

								<p>

									<label></label>

									<input name="secteur" id="secteur" type="text" class="small" required placeholder="Secteur d'activité" />
									<!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Veuillez entrer le secteur d'activité</span>

								</p>

						


							</fieldset>

						<input name="addsec" type="hidden" value="">

							<input type="submit" value="Submit" />

						</form>

					</div>

				</div>