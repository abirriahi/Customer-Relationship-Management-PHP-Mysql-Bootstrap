
<?php
// script PHP interrogation Base de donnees pour reponse a la requete AJAX
require_once("../../_top.php");
			
?>


                       <hr />
                      
                           <div class="form-group">
                                   <label class="col-sm-3 control-label">Nom et prénom.</label>
								   <div class="col-sm-7">
                                   <input name="nompnom2" id="nompnom2" type="text"  class="form-control" required placeholder="Nom et prénom" >
								   <span class="notification information" id="telverif"></span>
								   </div>
                                </div>

                                
                                  <div class="form-group">
                                   <label class="col-sm-3 control-label">Email du contact.</label>
								   <div class="col-sm-7">
                                   <input name="emailcontact2" id="emailcontact2" type="email"  class="form-control" required placeholder="Email" >
									<span class="notification information" id="verifemailcontact">Email du contact.</span>
								   </div>
                                </div>
								
                                <div class="form-group">
                                   <label class="col-sm-3 control-label">Email du contact.</label>
								   <div class="col-sm-7">
                                   <input name="telcontact2" id="telcontact2" type="text" pattern="[0-9]{2}[0-9]{6}" class="form-control" required placeholder="Téléphone" >
									<span class="notification information" id="veriftelcontact">Téléphone. (Format : Sans espace)</span>
								   </div>
                                </div>
								
                                
                                
								
								
								<div class="form-group">
                                   <label class="col-sm-3 control-label">Groupe</label>
								   <div class="col-sm-7">
								   
                                    <select name="fonctioncontact2" class="form-control">
                                      <?php $fct = $myadmin->ListeFonction(); foreach($fct as $fc) { ?>
			                         <option value="<?= $fc['id_fct']?>"><?= $fc['libelle_fct']?></option> <?php } ?>
									</select>  
                                     <span class="notification information">Fonction du contact.</span>									
                                </div>
                                </div>
                                
                                
                                <a style="cursor:pointer;" onClick="makeRequest('repPhpAjax_addcontact3.php','nompnom2','infocontact3')">Ajouter un nouveau contact</a>