<?php
$stats = new stats();
$dbu = new db();
$appx = new app();
$urlx = new url();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
if(!$p_id){
	//echo "masuk";exit;
	$kat = $dbu->lookup("kategori",$app[table][destinasi_kategori],"status = 'aktif' AND id_bahasa='".$_SESSION[bhs]."' ORDER BY kategori asc");
	$p_id = $urlx->shortLink(strip_tags($kat));
	header("location: $app[www]/".$dbu->lookup('nama','action',"action='23' and id_bahasa='".$_SESSION[bhs]."'")."/".$p_id."/");
}else{
	$kat = "%".str_replace("-","%",$p_id)."%";
	$kat = $dbu->lookup("kategori",$app[table][destinasi_kategori],"kategori LIKE '".$kat."'");
}

$rkat = $dbu->get_recordset($app[table][destinasi_kategori], " status = 'aktif' AND id_bahasa = '".$_SESSION[bhs]."' ORDER BY kategori asc");

//echo $pid; exit;
include "fill/fill_nearby.php"; 
?>
