<?php
session_start();

if (empty($_SESSION['loginadmin'])) {

    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="../index.php"</SCRIPT>';
}

require_once("../../_top.php");

if (isset($_GET['action'])&& $_GET['action']== 'mesclient') {
  //... ci dessus j'ai la connexion a ma base, et la requête.
  $result = $myadmin->ListeClientsParCommercial($_SESSION['loginadmin']);
    // Entêtes des colonnes dans le fichier Excel
    $excel .="Entreprise \t Activite \t Ville \t Responsable \t Tel \t Email \n";
    //Les resultats de la requette
	foreach ($result as $row) 
    {   
	    $cts = $myadmin->PrincipalContact($row['id_cl']);
		$contact = html_entity_decode(htmlentities($cts['nom_ctc'],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$tel = html_entity_decode(htmlentities($cts['tel_ctc'],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$mail = $cts['email_ctc'] ;
		$secteur = $myadmin->AfficherSecteur($row['id_clcat']) ;
		$sec = html_entity_decode(htmlentities($secteur,ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$ville = $myadmin->NomVille($row['id_ville']);
	    $entreprise_cl= html_entity_decode(htmlentities($row[entreprise_cl],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
        $excel .= "$entreprise_cl \t $sec \t $ville \t $contact \t $tel \t $mail \n";
    }
    header("Content-type: text/csv;charset=utf-8");
    header("Content-disposition: attachment; filename=Mes_clients.xls");
    print $excel;
    exit;
	echo '<SCRIPT>javascript:window.close()</SCRIPT>';
	}

if (isset($_GET['action'])&& $_GET['action']== 'total') {
	
	$result = $myadmin->ListeClients();
    // Entêtes des colonnes dans le fichier Excel
    $excel .="Entreprise \t Activite \t Ville \t Responsable \t Tel \t Email \n";
    //Les resultats de la requette
	foreach ($result as $row) 
    {   
	    $cts = $myadmin->PrincipalContact($row['id_cl']);
		$contact = html_entity_decode(htmlentities($cts['nom_ctc'],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$tel = html_entity_decode(htmlentities($cts['tel_ctc'],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$mail = $cts['email_ctc'] ;
		$secteur = $myadmin->AfficherSecteur($row['id_clcat']) ;
		$sec = html_entity_decode(htmlentities($secteur,ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$ville = $myadmin->NomVille($row['id_ville']);
	    $entreprise_cl= html_entity_decode(htmlentities($row[entreprise_cl],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
        $excel .= "$entreprise_cl \t $sec \t $ville \t $contact \t $tel \t $mail \n";
    }
    header("Content-type: text/csv;charset=utf-8");
    header("Content-disposition: attachment; filename=Total_clients.xls");
    print $excel;
    exit;
	echo '<SCRIPT>javascript:window.close()</SCRIPT>';
}	
if (isset($_GET['action'])&& $_GET['action']== 'li_ouv') {
	
	$result = $myadmin->Liste_Ouv() ;
    // Entêtes des colonnes dans le fichier Excel
    $excel .="Entreprise \t Activite \t Ville \t Responsable \t Tel \t Email \n";
    //Les resultats de la requette
	foreach ($result as $client) 
    {   $row = $myadmin->DetailsClient($client['id_cl']);
	    $cts = $myadmin->PrincipalContact($row['id_cl']);
		$contact = html_entity_decode(htmlentities($cts['nom_ctc'],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$tel = html_entity_decode(htmlentities($cts['tel_ctc'],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$mail = $cts['email_ctc'] ;
		$secteur = $myadmin->AfficherSecteur($row['id_clcat']) ;
		$sec = html_entity_decode(htmlentities($secteur,ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
		$ville = $myadmin->NomVille($row['id_ville']);
	    $entreprise_cl= html_entity_decode(htmlentities($row[entreprise_cl],ENT_NOQUOTES, "UTF-8"),ENT_COMPAT,"iso-8859-1");
        $excel .= "$entreprise_cl \t $sec \t $ville \t $contact \t $tel \t $mail \n";
    }
    header("Content-type: text/csv;charset=utf-8");
    header("Content-disposition: attachment; filename=Liste_ouverte.xls");
    print $excel;
    exit;
	echo '<SCRIPT>javascript:window.close()</SCRIPT>';
}	
?>
