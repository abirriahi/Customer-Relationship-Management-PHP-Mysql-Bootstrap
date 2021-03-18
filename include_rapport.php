<?php
$listeclients = $myadmin->RapportCommercialParPeriode($_SESSION['loginadmin'],$datedeb, $datefin);
echo sizeof($listeclients);
?>


<div class="content-box column-left main" style="width:100%;">

					<div class="content-box-header">

						<h3>Liste des client contacté dans cette période du <?= date("d/m/Y", strtotime($datedeb)) ?> au <?= date("d/m/Y", strtotime($datefin)) ?></h3>

					</div><!-- end .content-box-header -->

					

					<div class="content-box-content">

						
		<div id="accordion">
        <?php 
		foreach($listeclients as $lcls)
		{
			$detailsCl = $myadmin->DetailsClient($lcls['id_cl']);
			$entreprise = $detailsCl['entreprise_cl'];
			echo $lcls['id_cl'];
			
		?>
			<h1><?= $entreprise?></h1>
		<div>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</div>
		<?php
		}
		?>
</div>
						

					</div><!-- end .content-box-content -->

					

</div>
                
<div class="clear"></div>

<script src="includes/accordion/external/jquery/jquery.js"></script>
<script src="includes/accordion/jquery-ui.js"></script>
<script>

$( "#accordion" ).accordion();

// Hover states on the static widgets
$( "#dialog-link, #icons li" ).hover(
	function() {
		$( this ).addClass( "ui-state-hover" );
	},
	function() {
		$( this ).removeClass( "ui-state-hover" );
	}
);
</script>