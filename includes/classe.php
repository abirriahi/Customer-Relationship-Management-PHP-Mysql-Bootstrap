<?php 

class GestionContactCommerciale

{
	
	
	//Table commerciaux
	function LoginAdmin($u,$p)
	{
		$p = base64_encode($p);
		$sql = mysql_query("select * from cm_commerciaux where login_comm = '$u' and passw_comm = '$p'");
		
		$rep = mysql_fetch_array($sql);

		if(!empty($rep)) return $rep['id_comm'];

		else return false;
		
	}
	
	function InfoLogger($i)
	{
		$ilo= mysql_query("select * from cm_commerciaux where id_comm = '$i'");
		$pol=mysql_fetch_assoc($ilo);
		return $pol;
	}
	
	function UpdateLogin($logger)
	{
		$date = date("Y-m-d H:i:s");
		$req = mysql_query("update cm_commerciaux set last_connect = '$date' where id_comm = '$logger'");
	}
	
	
	function UpdateCommercialInfo($logger,$n,$p,$l,$m)
	{
		$n = mysql_real_escape_string(addslashes($n));
		$p = mysql_real_escape_string(addslashes($p));
		$l = mysql_real_escape_string(addslashes($l));
		$m = mysql_real_escape_string(addslashes($m));
		$pass = base64_encode($m);
		
		$req = mysql_query("update cm_commerciaux set nom_comm = '$n', pnom_comm ='$p', login_comm = '$l', passw_comm = '$pass' where id_comm = '$logger'");
		return true;
	}
	function UpdateCommercialAvatar($logger,$a)
	{
		$a = mysql_real_escape_string(addslashes($a));
		
		$req = mysql_query("update cm_commerciaux set avatar = '$a' where id_comm = '$logger'");
		return true;
	}
	
	function ListeCommerciaux()
	{
		$sql = mysql_query("select * from cm_commerciaux order by id_comm DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function commercial_by_id($cm)
	{
		$sql = mysql_query("select * from cm_commerciaux where id_comm = '$cm'");
		$rep = mysql_fetch_assoc($sql);
		return $rep;
	}
	
	function DeleteCommercial($idcm)
	{
		$sql = mysql_query("delete from cm_commerciaux where id_comm = '$idcm'");
		return true;
		
	}
	
	function AjoutCommercial($n,$p,$l,$pass,$level,$a)
	{
		$n = mysql_real_escape_string(addslashes($n));
		$p = mysql_real_escape_string(addslashes($p));
		$l = mysql_real_escape_string(addslashes($l));
		$a = mysql_real_escape_string(addslashes($a));
		$pass = mysql_real_escape_string(addslashes($pass));
		$pass = base64_encode($pass);
		$date = date("0000-00-00 00:00:00");
		
		$sql = mysql_query("insert into cm_commerciaux (`id_comm`, `nom_comm`, `pnom_comm`, `login_comm`, `passw_comm`, `last_connect`, `level_comm`,`avatar`) 
		values (NULL,'$n','$p','$l','$pass','$date','$level','$a')");
		$id = mysql_insert_id();
		return $id;
	}
	
	
	//Table ville
	function ListeVille()
	{
		$sql = mysql_query("select * from cm_ville order by id_ville ASC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function NomVille($v)
	{
		$sql = mysql_query("select * from cm_ville where id_ville = '$v'");
		$pol= mysql_fetch_assoc($sql);
		return $pol['nom_ville'];		
	}
	
	
	//Table fonctions
	function AjoutFonction($ik)
	{
		$fonction = mysql_real_escape_string(addslashes($ik));
		$sql = mysql_query("insert into cm_fonctions values (NULL,'$fonction')");
		return true;
	}
	
	function ListeFonction()
	{
		$sql = mysql_query("select * from cm_fonctions order by libelle_fct ASC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function AfficherFonctionContact($idfonction)
	{
		$sql = mysql_query("select * from cm_fonctions where id_fct = '$idfonction' ");
		
		$rep=mysql_fetch_assoc($sql);
		
		return $rep['libelle_fct'];
		
	}
	
	
	
	function DeleteFonction($idf)
	{
		$sql = mysql_query("delete from cm_fonctions where id_fct = '$idf'");
		return true;
		
	}
	
	
	//Table Groupe
	function AjoutGroupe($gr)
	{
		$groupe = mysql_real_escape_string(addslashes($gr));
		$sql = mysql_query("insert into cm_groupe values (NULL,'$groupe')");
		return true;
	}
	
	function ListeGroupe()
	{
		$sql = mysql_query("select * from cm_groupe order by id_gr DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function GroupeParId($idgr)
	{
		$sql = mysql_query("select * from cm_groupe where id_gr = '$idgr' ");
		$rep = mysql_fetch_assoc($sql);
		return $rep;
		
	} 
	
	function DeleteGroupe($idgr)
	{
		$sql = mysql_query("delete from cm_groupe where id_gr = '$idgr'");
		return true;
		
	}
	
	
	//Table clients
	function ExistClient($entreprise,$telcontact,$emailc)
	{
		$sql = mysql_query("select * from cm_clients where entreprise_cl = '$entreprise'");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		$sqll = mysql_query("select * from cm_contact where (tel_ctc = '$telcontact' OR email_ctc = '$emailc')");
		$repp = array();
		while($rr=mysql_fetch_array($sqll))
		{
			$repp[] = $rr;
		}
		
		if((sizeof($reponse) == 0) && (sizeof($repp) == 0))
		return 1;
		else
		return 0;
		
		
}

function IdClientExisted($entreprise,$telcontact,$emailc)
	{
		$sql = mysql_query("select * from cm_clients where entreprise_cl = '$entreprise'");
		$reponse = array();
		$rep=mysql_fetch_assoc($sql);
		return $rep['id_cl'];
		
		
}

     function ExistContact($telcontact,$emailc)
	{
		$sqll = mysql_query("select * from cm_contact where (tel_ctc = '$telcontact' OR email_ctc = '$emailc')");
		$repp = array();
		while($rr=mysql_fetch_array($sqll))
		{
			$repp[] = $rr;
		}
		
		if(sizeof($repp) == 0)
		return 1;
		else
		return 0;
		
		
} 

	function VerifTelephone($tel)
	{
		$sql = mysql_query("select * from cm_clients where tel1_cl = '$tel' or tel2_cl = '$tel'");
		
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		if(!empty($reponse))
		return 1;
		else
		return 0;
	}
	
	function AjoutClient($entreprise,$secteuractivite, $adresse, $region, $ville, $groupe,$siteweb,$tel1,$tel2,$fax,$commerical,$activite,$statut)
	{
		$entreprise = mysql_real_escape_string(addslashes($entreprise));
		$secteuractivite = mysql_real_escape_string(addslashes($secteuractivite));
		$adresse = mysql_real_escape_string(addslashes($adresse));
		$region = mysql_real_escape_string(addslashes($region));
		$ville = mysql_real_escape_string(addslashes($ville));
		$groupe = mysql_real_escape_string(addslashes($groupe));
		$siteweb = mysql_real_escape_string(addslashes($siteweb));
		$tel1 = mysql_real_escape_string(addslashes($tel1));
		$tel2 = mysql_real_escape_string(addslashes($tel2));
		$fax = mysql_real_escape_string(addslashes($fax));
		$commerical = mysql_real_escape_string(addslashes($commerical));
		$activite = mysql_real_escape_string(addslashes($activite));
		$statut = mysql_real_escape_string(addslashes($statut));
		
		$sql = mysql_query("insert into cm_clients values (NULL,'$entreprise','$secteuractivite','$adresse','$region','$ville','$groupe','$siteweb','$tel1','$tel2','$fax','$commerical','$activite','0',NULL)");
		$id = mysql_insert_id();
		return $id;
	}
	
	
	function UpdateClient($entreprise,$secteuractivite, $adresse, $region, $ville, $groupe,$siteweb,$tel1,$tel2,$fax,$commerical,$activite,$client)
	{
		$entreprise = mysql_real_escape_string(addslashes($entreprise));
		$secteuractivite = mysql_real_escape_string(addslashes($secteuractivite));
		$adresse = mysql_real_escape_string(addslashes($adresse));
		$region = mysql_real_escape_string(addslashes($region));
		$ville = mysql_real_escape_string(addslashes($ville));
		$groupe = mysql_real_escape_string(addslashes($groupe));
		$siteweb = mysql_real_escape_string(addslashes($siteweb));
		$tel1 = mysql_real_escape_string(addslashes($tel1));
		$tel2 = mysql_real_escape_string(addslashes($tel2));
		$fax = mysql_real_escape_string(addslashes($fax));
		$commerical = mysql_real_escape_string(addslashes($commerical));
		$activite = mysql_real_escape_string(addslashes($activite));
		
		$sql = mysql_query("update cm_clients set entreprise_cl='$entreprise', id_clcat='$secteuractivite', adresse_cl='$adresse', region_cl='$region', id_ville='$ville',id_gr='$groupe', siteweb_cl='$siteweb',tel1_cl='$tel1',tel2_cl='$tel2',fax_cl= '$fax',id_comm= '$commerical', activite_cl='$activite' where id_cl = '$client'");
		
		return true;
	}
	
	function ListeClients()
	{
		$sql = mysql_query("select * from cm_clients order by id_cl DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function ListeClientsParCommercial($commerical)
	{
		$sql = mysql_query("select * from cm_clients where id_comm = '$commerical' order by id_cl DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function ListeClientsParSecteurs($sect)
	{
		$sql = mysql_query("select * from cm_clients where id_clcat = '$sect' order by id_cl DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
		function ListeClientsParGroupe($groupe)
	{
		$sql = mysql_query("select * from cm_clients where id_gr = '$groupe' order by id_gr DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function ListeClientsASupprimer()
	{
		$sql = mysql_query("select * from cm_clients_delete_request");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function DeleteListeClientsASupprimer($idcl)
	{
		$sql = mysql_query("delete from cm_clients_delete_request where id_cl = '$idcl'");
		return true;
		
	}
	
	
	function DeleteClient($idcl)
	{
		$sql = mysql_query("delete from cm_clients where id_cl = '$idcl'");
		return true;
		
	}
	
	function DetailsClient($i)
	{
		$sql = mysql_query("select * from cm_clients where id_cl = '$i'");
		$rep = mysql_fetch_assoc($sql);
		return $rep;
	}
	
	function SearchClient($texte)
	{
		$texte = mysql_real_escape_string(addslashes($texte));
		
		$sql = mysql_query("select * from cm_clients where entreprise_cl like '%$texte%' or tel1_cl like '%$texte%'  or tel2_cl like '%$texte%' ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	
	function SearchContact($texte)
	{
		$texte = mysql_real_escape_string(addslashes($texte));
		
		$sql = mysql_query("select * from cm_clients where entreprise_cl like '%$texte%' or tel1_cl like '%$texte%'  or tel2_cl like '%$texte%' ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function UpdateCommercialClient($cc,$lo)
	{
		$mysql = mysql_query("update cm_clients set id_comm = '$lo' where id_cl = '$cc'");
		return true;
	}
	// **************************
	function Update_Li_Ouv($id_cl,$date)
	{
		$mysql = mysql_query("update cm_liste_ouverte set `date`='$date' where id_cl = '$id_cl'");
		return true;
	}
	
	function Liste_Ouv()
	{		
		$sql = mysql_query("SELECT * FROM `cm_liste_ouverte` order by id_li_ouv DESC ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function Liste_Huit_Ouv()
	{		
		$sql = mysql_query("SELECT * FROM `cm_liste_ouverte` order by id_li_ouv DESC limit 8 ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function Ajouter_Liste_Ouv($id_cl,$date)
	{
		$sql = mysql_query("INSERT INTO cm_liste_ouverte(`id_cl`) VALUES ('$id_cl')");
		return true;
	}
	
	function Delete_liste_Ouv($idcl)
	{
		$sql = mysql_query("DELETE FROM `cm_liste_ouverte` WHERE `id_cl`='$idcl'");
		return true;
		
	}
		function Exist_Li_Ouv($idcl)
	{
		$sql = mysql_query("select * from cm_liste_ouverte where `id_cl`='$idcl' ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		if(sizeof($reponse) == 0)
		return 1;
		else
		return 0;
     }
	 
	// **************************
	function UpdateLiOuvClient($cc,$lo)
	{
		$mysql = mysql_query("update cm_clients set `li_ouv`='$lo', id_comm = NULL where id_cl = '$cc'");
		return true;
	}
	
	function DmdListeOuv()
	{		
		$sql = mysql_query("SELECT * FROM `cm_li_ouv_demande` ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function AjouterDmd_Liste_Ouv($id_cl,$id_comm)
	{
		$sql = mysql_query("INSERT INTO `cm_li_ouv_demande`(`id_cl`, `id_comm`) VALUES ('$id_cl','$id_comm')");
		return true;
	}
	
	function Delete_dmd_liste_Ouv($idcl,$id_comm)
	{
		$sql = mysql_query("delete from `cm_li_ouv_demande` where id_cl = '$idcl' and id_comm='$id_comm'");
		return true;
		
	}function Delete_dmd_liste_Ouv_multiple($idcl)
	{
		$sql = mysql_query("delete from `cm_li_ouv_demande` where id_cl = '$idcl' ");
		return true;
		
	}
	
	function UpdateStatutClient($stat,$cl)
	{
		$mysql = mysql_query("update cm_clients set id_cls = '$stat' where id_cl = '$cl'");
		return true;
	}
	
	
	function ClientInteresse($cls)
	{
		$cls = mysql_real_escape_string(addslashes($cls));
		
		$sql = mysql_query("select * from cm_clients where id_cls = '$cls'");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function ClientInteresseParCommercial($cls,$commercial)
	{
		$cls = mysql_real_escape_string(addslashes($cls));
		
		$sql = mysql_query("select * from cm_clients where id_cls = '$cls' and id_comm = '$commercial'");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function ClientHuitParCommercial($commerical)
	{
		$sql = mysql_query("select * from cm_clients where id_comm = '$commerical' order by id_cl DESC limit 8 ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}	
	
		function ClientListeNoire()
	{
		$cls = mysql_real_escape_string(addslashes($cls));
		
		$sql = mysql_query("select * from cm_clients where id_cls = 4 ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function UpdateListeNoire($c)
	{
		$ilo= mysql_query("UPDATE `cm_clients` SET `id_cls`= 4 WHERE `id_cl`=$c");
		return $pol;
	}
	
	function OutOfListeNoire($c)
	{
		$ilo= mysql_query("UPDATE `cm_clients` SET `id_cls`= 0 WHERE `id_cl`=$c");
		return $pol;
	} 
	
	function FiltreCategorieVille($c,$v,$comm)
	{
		$c = mysql_real_escape_string(addslashes($c));
		$v = mysql_real_escape_string(addslashes($v));
		
		$sel = mysql_query("select * from cm_clients where id_clcat = '$c' and id_ville ='$v' and id_comm = '$comm'");		
		
		$reponse = array();
		while($rep=mysql_fetch_array($sel))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
		function FiltreParCategorie($c,$comm)
	{
		$c = mysql_real_escape_string(addslashes($c));
	
		$sel = mysql_query("select * from cm_clients where id_clcat = '$c' and id_comm = '$comm'");		
		
		$reponse = array();
		while($rep=mysql_fetch_array($sel))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
		function FiltreParVille($v,$comm)
	{
		$v = mysql_real_escape_string(addslashes($v));
		
		$sel = mysql_query("select * from cm_clients where id_ville ='$v' and id_comm = '$comm'");		
		
		$reponse = array();
		while($rep=mysql_fetch_array($sel))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	// Table contact
	function AjouterContact($nom,$email,$tel,$fct,$client)
	{
		$nom = mysql_real_escape_string(addslashes($nom));
		$email = mysql_real_escape_string(addslashes($email));
		$tel = mysql_real_escape_string(addslashes($tel));
		$fct = mysql_real_escape_string(addslashes($fct));
		$client = mysql_real_escape_string(addslashes($client));
		
		$sql = mysql_query("insert into cm_contact values (NULL,'$nom','$email','$tel','$fct','$client')");
		return true;
	}
	
	function UpdateContact($nom,$email,$tel,$fct,$client,$contact)
	{
		$nom = mysql_real_escape_string(addslashes($nom));
		$email = mysql_real_escape_string(addslashes($email));
		$tel = mysql_real_escape_string(addslashes($tel));
		$fct = mysql_real_escape_string(addslashes($fct));
		$client = mysql_real_escape_string(addslashes($client));
		
		$sql = mysql_query("update cm_contact set nom_ctc='$nom', email_ctc='$email', tel_ctc='$tel', id_fct='$fct', id_cl='$client' where id_ctc = '$contact'");
		return true;
	}
	
	
	function ListeContactParClient($client)
	{
		$sql = mysql_query("select * from cm_contact where id_cl = '$client'");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function DetailsContact($o)
	{
		$sql = mysql_query("select * from cm_contact where id_ctc = '$o'");
		$rep = mysql_fetch_assoc($sql);
		return $rep;
	}
	
	
	function PrincipalContact($cl)
	{
		$sql = mysql_query("select * from cm_contact where id_cl = '$cl'");
		$rep = mysql_fetch_assoc($sql);
		return $rep;
	}
	
	
	function VerifContactTel($tel)
	{
		$sql = mysql_query("select * from cm_contact where tel_ctc = '$tel'");
		
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		if(!empty($reponse))
		return 1;
		else
		return 0;
	}
	
	
	function VerifContactEmail($mail)
	{
		$sql = mysql_query("select * from cm_contact where email_ctc = '$mail'");
		
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		if(!empty($reponse))
		return 1;
		else
		return 0;
	}
	
	
	//Table commentaires
	
	function InsererCommentaire($comm,$cl,$ctc,$commercial)
	{
		$comm = mysql_real_escape_string(addslashes($comm));
		$cl = mysql_real_escape_string(addslashes($cl));
		$ctc = mysql_real_escape_string(addslashes($ctc));
		$commercial = mysql_real_escape_string(addslashes($commercial));
		
		date_default_timezone_set('Europe/Paris');
		$aujourdui = date("Y-m-d H:i:s");
		$sql = mysql_query("insert into cm_commentaires values (NULL,'$comm','$cl','$ctc','$commercial','$aujourdui')");
		
		$id = mysql_insert_id();
		
		return $id;
		
	}
	
	function CommentaireClient($i)
	{
		$sql = mysql_query("select * from cm_commentaires where id_cl = '$i' order by id_cm DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function CommentaireClientContact($i, $ctc)
	{
		$sql = mysql_query("select * from cm_commentaires where id_cl = '$i' and id_ctc = '$ctc' order by id_cm DESC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	
	function NbrTousLesNotes()
	{
		$sql = mysql_query("select * from cm_commentaires");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		$nbr = sizeof($reponse);
		return $nbr;
	}
	
	function RapportCommercialParPeriode($comm,$datedeb, $datefin)
	{
		$sql = mysql_query("select distinct * from cm_commentaires where id_comm = '$comm' and date_cm between '$datedeb' and '$datefin'");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	
	//Table clients_categorie
	function AjoutSecteur($sec)
	{
		$secteur = mysql_real_escape_string(addslashes($sec));
		$sql = mysql_query("insert into cm_clients_categorie values (NULL,'$secteur')");
		return true;
	}
	
	function DeleteSecteur($sec)
	{
		$sql = mysql_query("delete from cm_clients_categorie where id_clcat = '$sec'");
		return true;
		
	}
	
	function ListeSecteur()
	{
		$sql = mysql_query("select * from cm_clients_categorie order by libelle_clcat ASC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function AfficherSecteur($i)
	{
		$sql = mysql_query("select * from cm_clients_categorie where id_clcat = '$i'");
		$rep = mysql_fetch_assoc($sql);
		return $rep['libelle_clcat'];
	}
	
	
	
	//Table logs
	function LogMe($contenu, $connected)
	{
		$contenu = mysql_real_escape_string(addslashes($contenu));
		$connected = mysql_real_escape_string(addslashes($connected));
		$date = date("Y-m-d H:i:s");
		$ip=$_SERVER['REMOTE_ADDR']; 
		
		$sql = mysql_query("insert into cm_logs values (NULL,'$contenu','$date','$ip','$connected')");
		return true;
	}
	
	function ListeDesLogs($nbr)
	{
		$sql = mysql_query("select * from cm_logs order by id_log DESC limit 0,$nbr");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		return $reponse;
		
	}
	
	
	function ListeDesLogsParCommercial($nbr,$comm)
	{
		$sql = mysql_query("select * from cm_logs where id_comm = '$comm' order by id_log DESC limit 0,$nbr");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		return $reponse;
		
	}
	
	//Table cm_demande_clients
	function cm_demande_clients($comm,$cl)
	{
		$cl = mysql_real_escape_string(addslashes($cl));
		$sql = mysql_query("insert into cm_demande_clients values (NULL,'$cl','$comm')");
	}
	function AlertAdminForCm_demande_clients()
	{
		$sql = mysql_query("select * from cm_demande_clients");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function Liste_cm_demande_clients()
	{
		$sql = mysql_query("select * from cm_demande_clients");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function Delete_cm_demande_clients($idcl,$id_comm)
	{
		$sql = mysql_query("delete from cm_demande_clients where id_cl = '$idcl' and id_comm='$id_comm'");
		return true;
		
	}
	
	//Table clients_delete_request
	function ClientDeleteRequest($comm,$cl)
	{
		$cl = mysql_real_escape_string(addslashes($cl));
		$sql = mysql_query("insert into cm_clients_delete_request values ('$cl','$comm')");
	}
	
	
	function VerifierClientOnDeleteRequest($c)
	{
		$sql = mysql_query("select * from cm_clients_delete_request where id_cl = '$c'");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		
		if(sizeof($reponse) == 1)
		return 1;
		else
		return 0;
	}
	
	function AlertAdminForClientDeleteRequest()
	{
		$sql = mysql_query("select * from cm_clients_delete_request");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	// function ListeOuverte()
	// {
		// $sql = mysql_query("select * from cm_clients where `li_ouv`=1 ");
		// $reponse = array();
		// while($rep=mysql_fetch_array($sql))
		// {
			// $reponse[] = $rep;
		// }
		// return $reponse;
	// }
	// function ListeDixOuverte()
	// {
		// $sql = mysql_query("select * from cm_clients where `li_ouv`=1 order by id_cl DESC  ");
		// $reponse = array();
		// while($rep=mysql_fetch_array($sql))
		// {
			// $reponse[] = $rep;
		// }
		// return $reponse;
	// }
	
	
	//Table event 
	
	function Afficherevent($com)
	{
		$sql = mysql_query("SELECT * FROM events where id_comm = '$com' order by start ASC");
		$reponse = array();  
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function Aujourdevent($com,$dat)
	{
		$sql = mysql_query("SELECT * FROM events where id_comm = '$com' and start like '%$dat%' order by start ASC");
		$reponse = array();  
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function AjouterEvent($comm,$title,$start, $end, $color)
	{
		//$comm = mysql_real_escape_string(addslashes($comm));
		$title = mysql_real_escape_string(addslashes($title));
		$start = mysql_real_escape_string(addslashes($start));
		$end = mysql_real_escape_string(addslashes($end));
		$color = mysql_real_escape_string(addslashes($color));
		
		$sql = mysql_query("INSERT INTO events(title, start, end, color,id_comm) values ('$title', '$start', '$end', '$color','$comm')");
		$iddernierrappel = mysql_insert_id();
		return $iddernierrappel;		
	}
	function MiseAJourEvent($id,$start,$end)
	{
		$ilo= mysql_query("UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ");
		return $pol;
	}
	
	function MiseAJourTitleEvent($id,$title,$color)
	{
		$ilo= mysql_query("UPDATE events SET  title = '$title', color = '$color' WHERE id = $id ");
		return $pol;
	}
	
	function DeleteEvent($id)
	{
		$ilo= mysql_query("DELETE FROM events WHERE id = $id");
		return $pol;
	}
	
	//Table rappel
	
	function AjouterRappel($comm,$client,$commentaire, $date, $time)
	{
		$comm = mysql_real_escape_string(addslashes($comm));
		$date = mysql_real_escape_string(addslashes($date));
		$time = mysql_real_escape_string(addslashes($time));
		$commentaire = mysql_real_escape_string(addslashes($commentaire));
		$client = mysql_real_escape_string(addslashes($client));
		
		$sql = mysql_query("insert into cm_rappel (`id_rapp`, `date_rapp`, `time_rapp`, `id_comm`, `id_cl`, `id_cm`, `etat_rapp`) values (NULL,'$date','$time','$comm','$client','$commentaire','0')");
		$iddernierrappel = mysql_insert_id();
		return $iddernierrappel;		
	}
	
	/*function AfficherRappel($com)
	{
		$sql = mysql_query("select * from cm_rappel where id_comm = '$com' order by time_rapp ASC");
		$reponse = array();  
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	} */
	
	function AfficherMesRappel($com,$date)
	{
		$sql = mysql_query("select * from cm_rappel where id_comm = '$com' and date_rapp = '$date' and (etat_rapp = '0' OR etat_rapp = '1') order by time_rapp ASC");
		$reponse = array();  
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function AfficherRappelClient($cl)
	{
		$sql = mysql_query("select * from cm_rappel where id_cl = '$cl' and (etat_rapp = '0' OR etat_rapp = '1') order by time_rapp ASC");
		$reponse = array();  
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function AfficherLesRappelAncienne($com,$date)
	{
		$sql = mysql_query("select * from cm_rappel where id_comm = '$com' and date_rapp < '$date' and (etat_rapp = '0' OR etat_rapp = '1') order by time_rapp ASC");
		$reponse = array();  
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	
	function RappelParCommentaire($client , $commentaire)
	{		
		$ilo= mysql_query("select * from cm_rappel where id_cl = '$client' and id_cm = '$commentaire' ");
		$pol=mysql_fetch_assoc($ilo);
		return $pol;
	}
	
	function MiseAJourRappelRead($client, $commetaire, $nouveletat)
	{
		$cejour = date("Y-m-d");
		$ilo= mysql_query("update cm_rappel set etat_rapp = '$nouveletat' where id_cl = '$client' and id_cm = '$commetaire' and date_rapp = '$cejour'");
		return $pol;
	}
	
	function MiseAJourRappelComm($client, $comm,$id)
	{
		$ilo= mysql_query("update cm_rappel set id_comm = '$comm' where id_cl = '$client' and id_rapp='$id' ");
		return $pol;
	}
	
	function MiseAJourAncienRappel($client, $newrappel, $nouveletat)
	{
		$cejour = date("Y-m-d");
		$ilo= mysql_query("update cm_rappel set etat_rapp = '$nouveletat' where id_cl = '$client' and id_rapp != '$newrappel'");
		return $pol;
	}
	
	function DeleteRappelsClient($idcl)
	{
		$sql = mysql_query("delete from cm_rappel where id_cl = '$idcl'");
		return true;
		
	}
	
	
	//Table clients_statut
	function ListeStatutInteresse()
	{
		$sql = mysql_query("select * from cm_clients_statut where id_cls!= 4 order by id_cls ASC");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function AfficheLigneStatutCl($lki)
	{
		$sql = mysql_query("select * from cm_clients_statut where id_cls = '$lki'");
		$mpo= mysql_fetch_assoc($sql);
		return $mpo;
	}
	
	function AfficheCodeCouleurClient($cli)
	{
		$sql = mysql_query("select couleur_cls from cm_clients_statut where id_cls = '$cli'");
		$mpo= mysql_fetch_assoc($sql);
		return $mpo['couleur_cls'];
	}
	
	//Table Client signe
	
	function AjoutEditionsToClient($idc, $numag)
	{
		$idc = mysql_real_escape_string(addslashes($idc));
		$numag = mysql_real_escape_string(addslashes($numag));
		
		$sql = mysql_query("insert into cm_clients_signe values ('$idc','$numag')");
		return true;
	}
	function DeleteEditionsToClient($idc)
	{
			$delete = mysql_query("delete from cm_clients_signe where id_cl = '$idc'");
	}
	
	function EditionClient($client,$mag)
	{
		$sql = mysql_query("select * from cm_clients_signe where id_cl = '$client' and num_mag = '$mag'");
		$xedf= mysql_fetch_assoc($sql);
		return $xedf;
		
	}
	
	function Edition_Client($client)
	{
		$sql = mysql_query("select num_mag from cm_clients_signe where id_cl = '$client' and active= 1 ");
		$xedf= mysql_fetch_assoc($sql);
		$sql1 = mysql_query("select * from cm_clients_signe where id_cl = '$client' and num_mag BETWEEN  '$xedf'+4 and  '$xedf'-4 ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql1))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	
	function ListeEditionsClient($client)
	{
		$sql = mysql_query("select * from cm_clients_signe where id_cl = '$client' ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
		
	}
	//Table Editions
	
	function ListeEditions($date)
	{
		$sql = mysql_query("select * from cm_editions where num_mag >= (select num_mag FROM cm_editions WHERE active='1' LIMIT 1)-7 order by num_mag ASC LIMIT 12 ");
		$reponse = array();
		while($rep=mysql_fetch_array($sql))
		{
			$reponse[] = $rep;
		}
		return $reponse;
	}
	
	function ActiveEdition()
	{
		$sql = mysql_query("select * from cm_editions where active= 1 ");
		$pol=mysql_fetch_assoc($sql);
		return $pol;
	}
	
	function MiseAJourAvtiveEdition($client)
	{
		$cejour = date("Y-m-d");
		$ilo= mysql_query("update cm_editions set active = NULL where active = 1 ");
		return $pol;
	}
	
	
	




}



?>