<style type="text/css">
<!--
table
{
    width:  92%;
    border: solid 1px #5544DD;
}

th
{
    text-align: center;
    border: solid 1px #113300;
    background: #EEFFEE;
}

td
{
    text-align: left;
    border: solid 1px #55DD44;
}

td.col1
{
    border: solid 1px red;
    text-align: right;
}

.title
{
	color:#F00;
	
}

.ctc
{
	color:#06F;
}

-->
</style>
<?php
 	require_once("_top.php");
   $client = $myadmin->ListeClients();
   $nbrall = sizeof($client);
?>
<span style="font-size: 20px; font-weight: bold; text-align:center">Liste des clients <?= '(Nbr total : '.$nbrall.' Clients)'?><br></span>
<br>
<br>
<table>
   
    <col style="width: 20%">
    <col style="width: 30%">
    <col style="width: 50%">
    <thead>
        <tr>
            <th>Client</th>
            <th>Coordonnées</th>
            <th>Contacts</th>
        </tr>
    </thead>
<?php
  
   foreach($client as $cl)
   {
?>
    <tr>
        <td><?= stripslashes($cl['entreprise_cl'])?> <br /> (<?= $myadmin->AfficherSecteur($cl['id_clcat'])?>)</td>
        <td><span class="title">Adresse :</span> <?= stripslashes($cl['adresse_cl'].' '.stripslashes($cl['region_cl']))?><br />
       <span class="title">Ville : </span><?= $myadmin->NomVille($cl['id_ville']);?><br />
       <span class="title"> Site web :</span><?= $cl['siteweb_cl'];?><br />
        <span class="title">Téléphone : </span> <?= $cl['tel1_cl']?> <?php if($cl['tel2_cl'] != '') echo ' / '.$cl['tel2_cl']?> <br />
     <span class="title">   Fax : </span><?= $cl['fax_cl']?><br />
        </td>
        <td>
        <?php
		$contactclient = $myadmin->ListeContactParClient($cl['id_cl']);
		foreach($contactclient as $lcc)
		{
		?>
       <span class="ctc"><?= $lcc['nom_ctc'] ?> (<?= $myadmin->AfficherFonctionContact($lcc['id_fct'])?>)</span> <br />
       <?=$lcc['email_ctc'] ?>  / <?= $lcc['tel_ctc']?><br />
       
       <?php
	   }
	   ?>
        </td>
    </tr>
<?php
    }
?>
    <tfoot>
        <tr>
            <th colspan="3" style="font-size: 16px;">&nbsp;</th>
        </tr>
    </tfoot>
</table>
