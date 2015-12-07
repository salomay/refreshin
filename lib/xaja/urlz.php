<?php
include "../../application.php";
$dbu = new db();
$appx= new app();
$dbu->connect();
$appx->load_lib('url');
$uly = new url();
$urlnya ="";
	if($_POST[urlx]!=""){
		$urlnya = $app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$uly->shortLink($_POST[urlx])."/";
	}
echo $urlnya;
?>