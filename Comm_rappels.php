<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

if(isset($_GET['comm']))
{
	$_SESSION['commercial']=$comm;

}


require_once("_top.php");


//current
$menu[3]="current";


if(!isset($_GET['date']))
{
	$daterappel = date("Y-m-d");
	$datemessage = 'aujourd\'hui ';
}
else
{
	$daterappel = $_GET['date'];
	$datemessage = '';
}



$rappels =  $myadmin->AfficherMesRappel($_SESSION['commercial'],$daterappel);

$nbrappels = sizeof($rappels);

require_once("_header.php");

        
				if($_SESSION['loginadmin'] == 1)
				{
				
				if(isset($_SESSION['commercial']))
                 {
$cm = $myadmin->commercial_by_id($_SESSION['commercial']);
                 } 
                 	

                }
				
?>

<script src="includes/calender/src/js/jscal2.js"></script>
 <script src="includes/calender/src/js/lang/fr.js"></script>
 <link rel="stylesheet" type="text/css" href="includes/calender/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="includes/calender/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="includes/calender/src/css/steel/steel.css" />

			

			<div id="content">
							<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Calendrier des rappels</h2>

                <?php

				if($_SESSION['loginadmin'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="notification error" >
					Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a>
					</div>';
                   
                if(isset($_SESSION['commercial']))
                 {
               	require_once("_headerr.php");
                 } 


                }
				if(isset($msgdel))
				echo $msgdel;
				?>
                <div class="notification information" style="font-weight:bold; font-size:14px">

					<?= $cm['nom_comm']?> <?= $cm['pnom_comm']?>

				 </div>
			
			

			<!--	<div class="notification information">

					This is an informative notification. Click me to hide me.

				</div>-->
                <div class="content-box column-right sidebar" style="width:100%;">

					<div class="content-box-header">

						<h3>
                        Calendrier
                        </h3>

					</div>

					

					<div class="content-box-content">
<div class="content-box-content">
 
 <form action="" method="get">
 
 <p>
                               Choisir la date :
                                
                                <input id="f_date1" type="hidden"  />
                                 <input size="10" name="date" id="f_date" required />
                                 <button id="f_btn1">...</button>
                                 <input type="submit" value="Voir" />         
                                 
                              

    <script type="text/javascript">//<![CDATA[
	 function updateFields(cal) {
              var date = cal.selection.get();
              if (date) {
                      date = Calendar.intToDate(date);
                      document.getElementById("f_date").value = Calendar.printDate(date, "%Y-%m-%d");
              }
             
      };

	
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d",
		onSelect     : updateFields,
        onTimeChange : updateFields
      });
    //]]></script>
                       
                                </p>
                                
                          
			
 
 </form>
  
</div>

						

					</div>

				</div>
                
                
                
			<div class="clear"></div><!-- end .content-box -->
            
            
            			<div class="content-box column-right sidebar" style="width:100%;">

					<div class="content-box-header">

						<h3 style=" color:#03F;">
                        Liste des rappels pour <?= $datemessage?> le : <?= date("d/m/Y", strtotime($daterappel))?>  ( Vous avez <span style="font-size:14pxpx; color:#F00; font-weight:bold;"><?= $nbrappels?></span> rappels )
                        </h3>

					</div>

					

					<div class="content-box-content">
<div class="content-box-content">
						 <?php
						
						if(!empty($rappels))
						{
						foreach($rappels as $rapp)
						{
							
							
							$quiclient = $myadmin->DetailsClient($rapp['id_cl']);
							$quiclient = $quiclient['entreprise_cl'];
							$vueornot = $rapp['etat_rapp'];
							
						
							
							if($vueornot == '0' && ($daterappel == date("Y-m-d")) && ($rapp['time_rapp'] > date("H:i"))) 
							{
								$classnotif="rappelnotification";
							}
							if($vueornot == '0' && ($daterappel == date("Y-m-d")) && ($rapp['time_rapp'] < date("H:i")))
							{
								$classnotif="rappeloubliernotification";
							}
							if($vueornot == '0' && ($daterappel != date("Y-m-d")))
							{
								$classnotif="rappelnotification";
							}
							if($vueornot == '1' && ($daterappel == date("Y-m-d")) && ($rapp['time_rapp'] > date("H:i")))
							{
								$classnotif="rappelvuenotification";
							}
							
							if(($vueornot == '1' && $daterappel == date("Y-m-d")) && $rapp['time_rapp'] < date("H:i"))
							{
								$classnotif="rappeloubliernotification";
							}
							
							if(($vueornot == '1' && $daterappel != date("Y-m-d")))
							{
								$classnotif="rappelnotification";
							}
							
							
							
							
						?>
						<p>
                        <div class="<?= $classnotif ?>">
                       Rappel avec le client : <?= stripslashes($quiclient) ?> à <?= $rapp['time_rapp']?> --- <a href="detailsclient.php?client=<?= $rapp['id_cl'];?>&commentaire=<?= $rapp['id_cm'];?>&statut=read#commentslist">Voir la fiche client</a>
                        </div>
                        </p>
                        <?php
						
						}
						}
					else
		{
			echo '<span class="messagenoclient"> Il n\'y a pas des rappels pour '.$datemessage.' le '.$daterappel.'</span>';
		}
						?>

						

					</div>

						

					</div>

				</div>
                
                

				<div class="content-box column-right sidebar" style="width:100%;">

					<div class="content-box-header">

						<h3 style=" color:#03F;">
                        Liste des anciens rappels non commenté ou non appelé  </h3>

					</div>

					

					<div class="content-box-content">
<div class="content-box-content">
						 <?php
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['commercial'],date("Y-m-d"));
						if(!empty($oldrappels))
						{
						foreach($oldrappels as $oldrapp)
						{
							
							
							$quiclient = $myadmin->DetailsClient($oldrapp['id_cl']);
							$quiclient = $quiclient['entreprise_cl'];
							$vueornot = $oldrapp['etat_rapp'];
							
					
							
						
							$classnotif="rappeloubliernotification";
							
							
							
							
						?>
						<p>
                        <div class="<?= $classnotif ?>">
                       Rappel avec le client : <?= stripslashes($quiclient) ?> le <?=date("d/m/Y", strtotime($oldrapp['date_rapp'])) ?> à <?= $oldrapp['time_rapp']?> --- <a href="detailsclient.php?client=<?= $oldrapp['id_cl'];?>&commentaire=<?= $rapp['id_cm'];?>&statut=read#commentslist">Voir la fiche client</a>
                        </div>
                        </p>
                        <?php
						}
						}
					else
		{
			echo '<span class="messagenoclient"> Il n\'y a pas des anciens rappels</span>';
		}
						?>

						

					</div>

						

					</div>

				</div>

	

				

				<div class="clear"></div>
			</div><!-- end #content -->

			

		</div></div><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		