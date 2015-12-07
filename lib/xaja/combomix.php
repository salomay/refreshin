<?php
	include "../../application.php";
	$appx= new app();
	$dbu = new db();
	$dbu->connect();
	//print_r($_POST);exit;
	if($_POST['id_negara']){
		$kueri = "select id, nama from ".$app[table][provinsi]." where id_negara ='".$_POST[id_negara]."' order by nama";

	}elseif ($_POST['id_provinsi']) {
		$kueri ="select id, nama from ".$app[table][kota]." where id_provinsi ='".$_POST[id_provinsi]."' order by nama";
	}
	
	if($kueri!=""){
		$data = $dbu->negprovkot($kueri);
		echo $data;
	}
	unset($dbu);
	unset($appx);
?>