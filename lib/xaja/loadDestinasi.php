<?php
	include "../../application.php";
	$appx= new app();
	$appx->load_lib('url');
	$dbu = new db();
	$urlx = new url();
	$dbu->connect();
	$cast = $_POST['cast'];
	$cast = $app[www]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."$cast";
	unset($appx);
	unset($dbu);
	unset($urlx);
	echo $cast;
?>