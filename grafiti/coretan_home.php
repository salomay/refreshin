<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
$rskat=$dbu->get_recordset("destinasi_kategori", "id_bahasa ='".$_SESSION[bhs]."'");
$rstip=$dbu->get_recordset("berita", "status = 'aktif' order by tgl_post desc limit 9");
include "fill/fill_home.php";
?>