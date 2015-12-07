<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
if($p_id!=""){

	$berita = explode("_", $p_id);
	$sql = "UPDATE ".$app[table][berita]." SET hit = hit + 1 WHERE id ='".$berita[1]."'";
	$dbu->qry($sql);
	$sql = "SELECT a.id, a.id_reff, a.ket_id, b.username , a.tgl_post , c.sinopsis, c.judul, c.isi, c.gambar  FROM ".$app[table][berita]." as a LEFT JOIN ".$app[table][pengguna]." as b ON (a.id_user = b.id) LEFT JOIN ".$app[table][berita_bahasa]." as c ON (c.id_berita = a.id) WHERE a.id='".$berita[1]."'";
	//echo $sql;exit;
	$dnews=$dbu->get_recordmix($sql);	
	include "fill/fill_news_detail.php";	
}else{
	header("location:".$app["www"]."/".$dbu->lookup('nama','action',"action='1' and id_bahasa ='".$_SESSION[bhs]."'")."/");
}
unset($dbu);
?>