<?php
$stats = new stats();
$dbu = new db();
$appx = new app();
$appx->load_lib('feed');
$feedex = new feed();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
//echo $p_id;exit;
$pid=str_replace("-","%",$p_id);
$idnya = $dbu->lookup("id",$app[table][pengguna],"username LIKE '%".$pid."%'");
$dprof=$dbu->get_record("pengguna", "id = '".$idnya."'");
$dprof[avatar] = $appx->cekFile("/pengguna/avatar/",$dprof[avatar]);
$rsact=$dbu->get_recordset("pengguna_feed", "id_user='".$idnya."' and status='aktif' ORDER BY tgl_post desc LIMIT 10");
//$rsnegara=$dbu->get_recordset("negara", "status ='aktif'");
$feed = "";
while($dfeed = $dbu->fetch($rsact)){
	if($dfeed[tabel]=="cekin"){
		$feed = $feedex->feedCheckIn($dfeed,$_SESSION[bhs],$dprof);
	}
}
//exit;
include "fill/fill_profil.php"; 
?>
