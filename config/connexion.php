<?php

$database_host="localhost";

$database_login="root";

$database_pass="";

$database_db="gestionclient";





$site_url = "";

$site_name = "";

$email_notifications = "aa@gmail.com";


 $connexion = mysql_connect($database_host,$database_login,$database_pass);

   if (!$connexion)

     {

         echo "Impossible d'effectuer la connexion";

	     exit;

	       }

	         $selectdb = mysql_select_db($database_db, $connexion);

		   if (!$selectdb)

		     {

		         mysql_close($connexion);

			     echo "Impossible de sélectionner cette base données";

			         exit;

				   }

?>