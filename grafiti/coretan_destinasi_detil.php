<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];

$p_idx = explode("-",$p_id);
$p_idcount = count($p_idx);
$hit = 0;
$sqlkey="";
while($hit < $p_idcount){
	$sqlkey .= $p_idx[$hit]."%";
	$hit++;
}
$sql = "SELECT a.*,b.id as iddes,b.id_kat, b.logo,b.gambar,b.website,b.tgl_post as diposting ,b.pos_lat as latitude ,b.pos_long as longitude, c.nama as kota, d.nama as provinsi, e.nama as negara, f.username , b.id_user as userid FROM ".$app[table][destinasi_bahasa]." as a LEFT JOIN ".$app[table][destinasi]." as b ON(a.id_reff = b.id_reff) LEFT JOIN ".$app[table][kota]." as c ON (b.id_kota = c.id) LEFT JOIN ".$app[table][provinsi]." as d ON (c.id_provinsi = d.id) LEFT JOIN ".$app[table][negara]." as e ON (d.id_negara = e.id) LEFT JOIN ".$app[table][pengguna]." as f ON(b.id_user=f.id) WHERE a.nama LIKE '".$sqlkey."' AND a.id_bahasa = '".$_SESSION[bhs]."'";
//echo $sql; exit;
$desbhs = $dbu->get_recordmix($sql);

include "fill/fill_detil_destinasi.php";
?>