<?php
	include "../../application.php";
	$appx= new app();
	$dbu = new db();
	$dbu->connect();

	$cast = $_POST[castx];
	$iddes =  $_POST[iddesx];
	$revi = $_POST[revix];
	$idu = $_POST[idux];
	$ada="";

	//print_r($_POST);exit;
	if($idu!=""){
		$ada = $dbu->lookup("id","destinasi_respon","id_destinasi ='".$iddes."' AND id_user ='".$idu."'");

		#kalau ada
			if($ada!=""){
				$sql= "UPDATE ".$app[table][destinasi_respon]." SET bintang ='".$cast."', komen='".$revi."', tgl_post =now() WHERE id='".$ada."'";
			}else{
				$sql ="INSERT INTO ".$app[table][destinasi_respon]." (id_destinasi,id_user,bintang,komen,tgl_post) VALUES('".$iddes."', '".$idu."','".$cast."','".$revi."',now())";
			}
			//echo $sql;
			$dbu->qry($sql);
		
		$data="thanks for the riview.";
		//$_SESSION[msg]= $data;
		//echo $sql;
	}
	
unset($dbu);
?>