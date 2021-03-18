<?php
require_once("../../_top.php");
$keyword = '%'.$_POST['recherche'].'%';
$list =  $myadmin->SearchClient($keyword);
foreach ($list as $rs) {
	// put in bold the written text
	$entreprise_cl = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['entreprise_cl']);
	// add new option
    echo '<li onclick="set_item(\''.$rs['entreprise_cl'].'\')">'.$entreprise_cl.'</li>';
}
?>