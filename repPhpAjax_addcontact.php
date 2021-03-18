
<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");


			
?>


 <hr />
                      
                          <p>

									<label></label>

									<input name="nompnom2" id="nompnom2" type="text" class="small" required placeholder="Nom et prénom" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Nom et prénom.</span>

								</p>
                                
                                  <p>

									<label></label>

									<input name="emailcontact2" id="emailcontact2" type="email" class="small" required placeholder="Email" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Email du contact.</span>

								</p>
                                
                                
                                
                                  <p>

									<label></label>

									<input name="telcontact2" id="telcontact2" type="text" pattern="[1-9]{2}[0-9]{6}" class="small" required placeholder="Téléphone" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Téléphone.</span>

								</p>
                                
                                
                                  <p>

									<select name="fonctioncontact2">
                                    
                                 
                                    
                                    <?php
									$fct = $myadmin->ListeFonction();
									foreach($fct as $fc)
									{
									?>
			
										<option value="<?= $fc['id_fct']?>"><?= $fc['libelle_fct']?></option>
                                        
                                        <?php
										}
										?>

									</select>

									<span class="notification information">Fonction du contact.</span>

								</p>
                                
                                
                                <a style="cursor:pointer;" onClick="makeRequest('repPhpAjax_addanothercontact.php','nompnom2','infocontact3')">Ajouter un nouveau contact</a>