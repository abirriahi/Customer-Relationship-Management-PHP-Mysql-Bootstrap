<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");



//current
$menu[0]="current";

if(isset($_GET['client']))
{
	$client = $_GET['client'];
	$cl = $myadmin->DetailsClient($client);
}


if(isset($_POST['saveme']))
{
	$ed_selectionne = $_POST['editions'];
	$myadmin->DeleteEditionsToClient($client); 
	foreach($ed_selectionne as $key=>$value)
	{
		$myadmin->AjoutEditionsToClient($client, $value);
	}
	echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="detailsclient.php?client='.$_GET['client'].'"</SCRIPT>';
}

require_once("_header.php");



?>
			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Choisir les éditions pour <a href="detailsclient.php?client=<?= $client ?>"><?= $cl['entreprise_cl']?></a></h2>

			

				<div class="notification information">

					Veuillez choisir les éditions que le client a choisi pour afficher ces apparitions au magazine

				</div>
				<div class="clear"></div>

							

				<div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>&nbsp;</h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						<form method="post" action="">
                        
                        <table class="pagination" rel="20"><!-- add the class .pagination to dynamically create a working pagination! The rel-attribute will tell how many items there are per page -->

							<thead>

								<tr>

									<th><input type="checkbox" /></th>

									<th>Edition magazine n°</th>

									<th>Date Sortie</th>

								</tr>

							</thead>

							

							<tfoot>

							</tfoot>

									

							<tbody>

							<?php
							
							$listeditions = $myadmin->ListeEditions(date("Y-m-d"));
							foreach($listeditions as $mag)
							{
								$verif = $myadmin->EditionClient($client,$mag['num_mag']);
								if(!empty($verif))
								{
									$chek = 'checked="checked"';
									$textcolor = '#ff0000';
								}
								else
								{
									$chek = '';
									$textcolor = '#000000';
								}
							?>		

								<tr style="color:<?= $textcolor?>">

									<td><input name="editions[]" type="checkbox" value="<?= $mag['num_mag']?>" <?= $chek ?>  /></td>

									<td><?= $mag['num_mag']?></td>

									<td><?= date("d/m/Y", strtotime($mag['sortie_mag']))?></td>

								</tr>
								
                                
                            <?php
							}
							?>
                            <tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td><input type="submit" name="saveme" value="Enregistrer" /></td>
								  <td>&nbsp;</td>
							  </tr>
								<tr>
								  <td colspan="3" style="text-align:center; font-size:15px;"><a href="detailsclient.php?client=<?= $client ?>">Fiche client</a></td>
							  </tr>

										

							</tbody>

						</table>
                        
                        </form>

						

					</div><!-- end .content-box-content -->

					

				</div><!-- end .content-box -->

				<div class="clear"></div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		