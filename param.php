<?php session_start();

if(empty($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != '1')

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[4]="current";







require_once("_header.php");



?>



			

			<div id="content">

			

				<h2><img src="images/icons/tools_32.png" alt="Paramétres" />Paramétres</h2>

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

				<!--<div class="notification information">

					This is an informative notification. Click me to hide me.

				</div>
-->
				

			  <div class="content-box column-left sidebar" style="width:100%;"><!-- use the class .sidebar in combination with .column-left to create a sidebar --><!-- using .closed makes sure the content box is closed by default -->

					<div class="content-box-header">

						<h3>Gestion de :</h3>

					</div>

					

					<div class="content-box-content">

<p>
<a href="?part=fct"><img src="images/icon/fonctions.png" width="64" height="64" style="margin-right:25px;" />
</a>

<a href="?part=grc"><img src="images/icon/groups.png" width="64" height="64" style="margin-right:25px;" /></a>

<a href="?part=com"><img src="images/icon/clients.png" width="64" height="64" style="margin-right:25px;" /></a>

<a href="?part=sec"><img src="images/icon/category.png" width="64" height="64" style="margin-right:25px;" /></a>


</p>


<p>
<span style="margin-right:45px;">Fonctions</span>
<span style="margin-right:45px;">Groupes</span>
<span style="margin-right:45px;">Commerciaux</span>
<span style="margin-right:45px;">Secteur</span>



</p>


					</div>

				</div>

				

<?php
if(isset($_GET['part']))
{
	if($_GET['part'] == 'fct') require_once("include_fonctions.php");
	if($_GET['part'] == 'com') require_once("include_commerciaux.php");
	if($_GET['part'] == 'grc') require_once("include_groupeclients.php");
	if($_GET['part'] == 'sec') require_once("include_secteurclients.php");
}
?>
				

			  <div class="clear"></div><!-- end .content-box -->

				<div class="clear"></div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		