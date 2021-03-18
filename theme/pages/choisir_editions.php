<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';

}

require_once("../../_top.php");
require_once("_header.php");
$page = 6;
require_once("_side.php");

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
	echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="client.php?client='.$_GET['client'].'"</SCRIPT>';
}



$AD = $myadmin->ActiveEdition();
// $month = date("m",strtotime($AD['dat']));
// echo date('M Y');
// SELECT YEAR(yourDateField) select month(dateField)
// SELECT * FROM table WHERE SUBSTR(datetime_column, starting_position, number_of_strings)=required_year_and_month;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Choisir les éditions pour <a href="client.php?client=<?= $client ?>"><?= $cl['entreprise_cl']?></a>
        </h1>
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
	                 <form method="post" action="">
					  <div class="row">
				  <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Veuillez choisir les éditions que le client a choisi pour afficher ces apparitions au magazine</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
				          <thead>

								<tr>

									<th><input type="checkbox" /></th>

									<th>Edition magazine n°</th>

									<th>Date Sortie</th>

								</tr>

							</thead>
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
                    <td><input name="editions[]" type="checkbox" value="<?= $mag['num_mag']?>" <?= $chek ?> ></td>
                    <td class="mailbox-name"><a href="#"><?= $mag['num_mag']?></a></td>
                    <td class="mailbox-subject"><b><?= date("d/m/Y", strtotime($mag['sortie_mag']))?></b> </td>

                  </tr>
                           <?php
							}
							?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /. box -->
       
        <!-- /.col -->
              <div class="box-footer no-padding">
              <div class="mailbox-controls pull-right" style="margin-right: 50px;" >
                <!-- Check all button -->
				<a href="client.php?client=<?= $client ?>"><button type="button" class="btn btn-default" style="margin-right: 100px;"><i class="fa fa-refresh"></i> Fiche client</button></a>
                <button type="submit" name="saveme"  class="btn btn-primary ">Enregistrer</button>
					  

			</div>		
                  </div>			
            </form>
           </div>              
        <!-- /.row -->
    </section>
 </div>			


		



<?php 

require_once("_footer.php");

?>		