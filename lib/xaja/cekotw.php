<?php
	include "../../application.php";
	$appx= new app();
	$dbu = new db();
	$dbu->connect();
	if($_POST['cast']){
		$cekin = explode("-", $_POST['cast']);
		$tgl_post = date("Y-m-d H:i:s");
		$sql = "INSERT INTO ".$app[table][cekin]." (id_destinasi,id_user,tipe,tgl_post) VALUES('".$cekin[0]."','".$cekin[1]."','".$cekin[2]."','".$tgl_post."')";
	$dbu->qry($sql);
	$idcek = $dbu->lookup("id","cekin","id_user ='".$_SESSION[member][id]."' AND tgl_post ='".$tgl_post."' ORDER BY tgl_post desc");
		$sql = "INSERT INTO ".$app[table][pengguna_feed]." (id_user,tabel,id_tabel,keterangan,tgl_post) VALUES('".$cekin[1]."','".$app[table][cekin]."','".$idcek."','".$cekin[2]."','".$tgl_post."')";
	$dbu->qry($sql);
	unset($dbu);
	unset($appx);
	echo ".";
}
?>