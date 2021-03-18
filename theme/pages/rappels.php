<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}

require_once("../../_top.php");
//current
$page=9 ;
require_once("_header.php");

$page=9 ;
require_once("_side.php");

if(!isset($_GET['date']))
{
	$daterappel = date("Y-m-d");
	$datemessage = 'aujourd\'hui ';
}
else
{
	$daterappel = $_GET['date'];
	$datemessage =  $_GET['date'] ;
}

$rappels =  $myadmin->AfficherMesRappel($_SESSION['loginadmin'],$daterappel);

$nbrappels = sizeof($rappels);


?>
  <!-- Date Picker -->
  <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
		  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Calendrier
        <small>Rappel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Rappel</a></li>
        <li class="active"></li>
      </ol>
    </section>

                      
    <!-- Main content -->
    <section class="content">
	<?php
			   
			  
			   
				if($_SESSION['loginadmin'] == 1)
				{
					$request = $myadmin->AlertAdminForClientDeleteRequest();
					if(sizeof($request) != 0)
					echo '<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><h4><i class="icon fa fa-info"></i> Alert!</h4>Il y a des demandes de suppression client <a href="clientdeleterequest.php">(Voir les demandes)</a></p>
					
					</div>';
				} 
				     ?>

      <!-- row -->
      <div class="row">
        <div class="col-md-12">
		 <form action="" method="get">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    <?= $datemessage?>
                  </span>
            </li>
			<li class="time-label">
                  <span class="bg-green">
                    <?= date("d/m/Y", strtotime($daterappel))?>
                  </span>
            </li>
			<li class="time-label">
		   <div class="input-group col-xs-2">
                <!-- /btn-group -->
                  <input id="f_date1" type="hidden"  />
                  <input type="text" name="date" class="form-control" id="datepicker">
				  <div class="input-group-btn date">
                  <button type="submit" class="btn btn-danger btn-flat">ok</button>
                </div>
           </div> 
			  
		  </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
     
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
            <li>
              <i class="fa fa-comments bg-yellow"></i>
                
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?= $rapp['time_rapp']?> </span>

                <div class="timeline-body <?= $classnotif ?>"> 
             Rappel avec le client :<strong style ="color :#ec2b2b ; "> <?= stripslashes($quiclient) ?> </strong>à <?= $rapp['time_rapp']?> --- <a href="client.php?client=<?= $rapp['id_cl'];?>&commentaire=<?= $rapp['id_cm'];?>&statut=read#commentslist">Voir la fiche client</a>

                </div>
              </div>
			  
            </li>
			 <?php
						
						}
						}
					else
		{ ?>
			<li>
              <i class="fa fa-comments bg-yellow"></i>
                
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?= $daterappel ?> </span>

                <h3 class="timeline-header"><a href="#">Il n'y a pas des rappels pour <?= $datemessage ?></a>  le <?= $daterappel ?></h3>

              </div>
            </li>
		<?php } 	?>
						
            <!-- END timeline item -->
		    <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
		   </form>
        </div>
        <!-- /.col -->
      </div>
<!-- **********************************************************************-->
 <!-- row --> 
 <br> 
      <div class="row">
        <div class="col-md-12">
		
          <!-- The time line -->
		  <h4>
         anciens rappels non commenté 
            </h4> 
          <ul class="timeline">
		  
	         <li class="time-label">
                  <span class="bg-red">
                    Timeline
                  </span>
            </li>
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
	
		   <?php
						$oldrappels =  $myadmin->AfficherLesRappelAncienne($_SESSION['loginadmin'],date("Y-m-d"));
						if(!empty($oldrappels))
						{
						foreach($oldrappels as $oldrapp)
						{
							$quiclient = $myadmin->DetailsClient($oldrapp['id_cl']);
							$quiclient = $quiclient['entreprise_cl'];
							$vueornot = $oldrapp['etat_rapp'];
							
							$classnotif="rappeloubliernotification";
							
						?>
            <!-- timeline item -->
            <li>
             <i class="fa fa-comments bg-yellow"></i>
              <div class="timeline-item">
			  <span class="time"><i class="fa fa-clock-o"></i> <?= $oldrapp['time_rapp'] ?> </span>
                <div class="timeline-body">
              Rappel avec le client :<strong style ="color :#ec2b2b ; "> <?= stripslashes($quiclient) ?> </strong> le <?=date("d/m/Y", strtotime($oldrapp['date_rapp'])) ?> à <?= $oldrapp['time_rapp']?> --- <a href="client.php?client=<?= $oldrapp['id_cl'];?>&commentaire=<?= $rapp['id_cm'];?>&statut=read#commentslist">Voir la fiche client</a>

                </div>
              </div>
            </li>
			 <div class="<?= $classnotif ?>">
                        </div>
                        <?php
						}
						}
					else
		              {
			?> 
				<li>
              <i class="fa fa-envelope bg-blue"></i>
                
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?= $daterappel ?> </span>

                <h3 class="timeline-header"><a href="#">Il n'y a pas des rappels pour <?= $datemessage ?></a>  le <?= $daterappel ?></h3>

              </div>
			  
             </li>
			<?php 
						
		             }
						?>
            <!-- END timeline item -->
            <!-- timeline item -->
			
			
			
            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
		  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
	 <!--  ************************************************************************************-->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->	
			

<!-- bootstrap datepicker --> 
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script> 

<script>
  $(function () {

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

  });
</script>
<?php
$page=9 ;
require_once("_footer.php");
?>
