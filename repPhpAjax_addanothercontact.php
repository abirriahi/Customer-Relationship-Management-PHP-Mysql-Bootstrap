
<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("_top.php");


			
?>


 <hr />
                      
                          <p>

									<label></label>

									<input name="nompnom3" id="nompnom3" type="text" class="small" required placeholder="Nom et prénom" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Nom et prénom.</span>

								</p>
                                
                                  <p>

									<label></label>

									<input name="emailcontact3" id="emailcontact3" type="email" class="small" required placeholder="Email" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Email du contact.</span>

								</p>
                                
                                
                                
                                  <p>

									<label></label>

									<input name="telcontact3" id="telcontact3" type="text" pattern="[1-9]{2}[0-9]{6}" class="small" required placeholder="Téléphone" /><!-- add .align-right to align the input elements to the right -->

									<span class="notification information">Téléphone.</span>

								</p>
                                
                                
                                  <p>

									<select name="fonctioncontact3">
                                    
                                 
                                    
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
                                
                              