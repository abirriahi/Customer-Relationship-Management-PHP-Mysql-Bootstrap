<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}
// $_SESSION['comm']= $_POST['comm'];
$_SESSION['comm']= $_GET['comm'];
require_once("../../_top.php");
//current
$page='page_comm' ;
require_once("_header.php");

$allclient = $myadmin->ListeClients();
$nbrallclient = sizeof($allclient);


$tousmesclients = $myadmin->ListeClientsParCommercial($_SESSION['loginadmin']);

$nbrmesclients = sizeof($tousmesclients);

$me = $myadmin->InfoLogger($_SESSION['loginadmin']);


       $page='home' ;
       require_once("_side.php");


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
<?php 
//include("/comm/home_comm.php"); 

if(isset($_GET['part']))
{
	if($_GET['part'] == 'home') require_once("home_comm.php");
	if($_GET['part'] == 'client') {
		$idclient= $_GET['client'] ;
		require_once("client_comm.php");
	}
	if($_GET['part'] == 'mesclient') require_once("mesclients_comm.php");
}

?>
 
  
  </div>
      <!-- /.row (main row) --> 
        <?php
		unset($_POST['recherche']);
		$page='home' ;
       require_once("_footer.php");
        ?>

