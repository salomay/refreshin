<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
$rscomm=$dbu->get_recordset($app[table][komunitas], "status ='aktif'");
include "fill/fill_contact.php";
?>