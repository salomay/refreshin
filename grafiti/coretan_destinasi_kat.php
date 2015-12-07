<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
$rkat = $dbu->get_recordset($app[table][destinasi_kategori], " status = 'aktif' AND id_bahasa = '".$_SESSION[bhs]."' ORDER BY kategori asc");
if($sub=="" || !$sub){
	$sql="SELECT id, nama FROM ".$app[table][provinsi]." WHERE status ='aktif'";
	$dbu->query($sql, $rsprop,$nrprop);
	include "fill/fill_destinasi_kat.php";
}elseif($sub || $sub !=""){
	/*kategori search*/
	$sqlkey_kat = str_replace("-","%",$p_id);
		$sql = "SELECT id FROM ".$app[table][destinasi_kategori]." WHERE kategori LIKE '".$sqlkey_kat."'";
	$kat = $dbu->get_recordmix($sql);

	/*kota search*/
	$p_idx = explode("_",$sub);
	$sqlkey_kota = str_replace("-","%",$p_idx[0]);
	$sql = "SELECT id, nama, id_provinsi FROM ".$app[table][kota]." WHERE nama LIKE '".$sqlkey_kota."'";
	$kotax = $dbu->get_recordmix($sql);
	$sql = "SELECT id ,id_reff, thumb FROM ".$app[table][destinasi]." WHERE id_kat='".$kat[id]."' AND id_kota ='".$kotax[id]."'";
	//print_r($sql);exit;
	$destkota = $dbu->get_recordsetmix($sql);
	
	//print_r($kat);exit;
	include "fill/fill_destinasi_kota.php";
}

?>