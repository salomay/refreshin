<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];

if($p_id=='article'){
	if($sub!="" AND $sub!="search"){
		$subx = str_replace("-","%",$sub);
		$subx = $dbu->lookup("id_reff",$app[table][destinasi_bahasa],"nama LIKE '".$subx."'");
		$subx = "AND d.id_reff ='".$subx."'";
	}
	$sql = "SELECT a.id, a.judul, a.tgl_post, b.username, b.avatar, d.nama as destinasi FROM ".$app[table][forum]." as a LEFT JOIN ".$app[table][pengguna ]." as b ON (a.id_user = b.id) LEFT JOIN ".$app[table][destinasi]." as c ON (a.id_destinasi = c.id) LEFT JOIN ".$app[table][destinasi_bahasa]." as d ON (c.id_reff = d.id_reff) WHERE a.tipe LIKE '$p_id' ".$subx." ORDER BY a.tgl_post DESC";
	//echo $sql;exit;
	$dbu->query($sql,$rforum,$nof);
	include "fill/fill_thread_article.php";
}elseif($p_id=='trip'){
	include "fill/fill_thread_trip.php";
}elseif($p_id=='store'){
	include "fill/fill_thread_store.php";
}elseif($p_id=='articles'){
	include "fill/fill_thread_add_article.php";
}elseif($p_id=='trips'){
	include "fill/fill_thread_add_trip.php";
}elseif($p_id=='sells'){
	include "fill/fill_thread_add_product.php";
}else{
	header("location:".$defaultURL);
}
?>