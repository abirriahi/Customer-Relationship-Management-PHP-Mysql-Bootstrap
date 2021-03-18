<?php session_start();

if(empty($_SESSION['loginadmin']))

{

echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';

}

require_once("_top.php");


//current
$menu[0]="current";




$custom_includes = '
<link href="includes/accordion/jquery-ui.css" rel="stylesheet">
';


require_once("_header.php");



?>

<script src="includes/calender/src/js/jscal2.js"></script>
 <script src="includes/calender/src/js/lang/fr.js"></script>
 <link rel="stylesheet" type="text/css" href="includes/calender/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="includes/calender/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="includes/calender/src/css/steel/steel.css" />

			

			<!--<div id="content">-->

			

				<h2><img src="images/icons/tools_32.png" alt="Manage Users" />Rapport</h2>

			

				<div class="notification information">

					Veuillez sélectionnez la période du rapport

				</div>
				<div class="clear"></div><!-- end .content-box -->

				

				<div class="content-box column-right sidebar" style="width:100%;">

					<div class="content-box-header">

						<h3>Période du rapport</h3>

					</div>

					

					<div class="content-box-content">

						<p> 
                          <div class="rappelnotification" id="info">

					Cliquer pour sélectionner la date de départ

				</div>
                
          <div id="cont"></div>
          
        
          
       
       
    <script type="text/javascript">//<![CDATA[

      var SELECTED_RANGE = null;
      function getSelectionHandler() {
              var startDate = null;
              var ignoreEvent = false;
              return function(cal) {
                      var selectionObject = cal.selection;

                      // avoid recursion, since selectRange triggers onSelect
                      if (ignoreEvent)
                              return;

                      var selectedDate = selectionObject.get();
                      if (startDate == null) {
                              startDate = selectedDate;
                              SELECTED_RANGE = null;
                              document.getElementById("info").innerHTML = "Cliquer pour sélectionner la date de fin";

                              // comment out the following two lines and the ones marked (*) in the else branch
                              // if you wish to allow selection of an older date (will still select range)
                              cal.args.min = Calendar.intToDate(selectedDate);
                              cal.refresh();
                      } else {
                              ignoreEvent = true;
                              selectionObject.selectRange(startDate, selectedDate);
                              ignoreEvent = false;
                              SELECTED_RANGE = selectionObject.sel[0];

                              // alert(SELECTED_RANGE.toSource());
                              //
                              // here SELECTED_RANGE contains two integer numbers: start date and end date.
                              // you can get JS Date objects from them using Calendar.intToDate(number)

                              startDate = null;
                              document.getElementById("info").innerHTML = "La date sélectionné est : "+selectionObject.print("%Y-%m-%d") +
                                      " | Cliquer pour sélectionner une autre fois";
document.getElementById("a").value = selectionObject.print("%Y-%m-%d");
                              // (*)
                              cal.args.min = null;
                              cal.refresh();
                      }
              };
      };

      Calendar.setup({
              cont          : "cont",
              fdow          : 1,
			  selectionType : Calendar.SEL_SINGLE,
              onSelect      : getSelectionHandler()
      });

    //]]></script></p>

						<small>Veuillez sélectionner votre période désiré!</small>
                        
                   <form action="" method="post">
                   <input name="datedebfin" type="hidden" id="a" />
                   <input name="save" type="submit" value=" Suivant " />
                   </form>

					</div>

				</div>

				  
              <?php
				   if(isset($_POST['save']))
				   {
					   $periode = $_POST['datedebfin'];
					   $datedeb = substr($periode, 0, 10);
					   $datefin = substr($periode, -10);  
						require_once("include_rapport.php");

				   }
			  ?>

				<div class="clear"></div>
			</div><!-- end #content -->

			

		</div>
        
        <!--</div>--><!-- end #bokeh and #container -->

		



<?php 

require_once("_footer.php");

?>		