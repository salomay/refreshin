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
$idnya = $dbu->lookup("id",$app[table][komunitas],"nama LIKE '%".$pid."%'");
$komm=$dbu->get_record($app[table][komunitas], "id = '".$idnya."'");
$komm[logo] = $appx->cekFile('/komunitas/logo/',$komm[logo],'default.png');
$komm[logo] = $app[data_www].'/komunitas/logo/'.$komm[logo];

include "fill/fill_community_detail.php"; 
?>
