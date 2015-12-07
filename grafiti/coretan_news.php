<?php
$stats = new stats();
$dbu = new db();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
$tabnya = 0;
if($p_id=="" || !$p_id){
	//echo " location: ".$app["www"]."/".$dbu->lookup('nama','action',"action='5' and id_bahasa ='".$_SESSION[bhs]."'")."/all/";exit;
	header("location:".$app["www"]."/".$dbu->lookup('nama','action',"action='5' and id_bahasa ='".$_SESSION[bhs]."'")."/all/");
}else{
	$sql = "SELECT id, kategori FROM ".$app[table][berita_kategori]." WHERE id_bahasa ='".$_SESSION[bhs]."' ORDER BY kategori asc";
	//echo $sql;
	$tabKat = $dbu->get_recordsetmix($sql); 

	if($p_id!='all'){
		$p_id=str_replace("-","%",$p_id);
		$tabnya = $dbu->lookup("id",$app[table][berita_kategori]," kategori LIKE '".$p_id."'");
		//echo $tabnya;exit;
	}
	if($tabnya!=0){
		$tambahan = "AND a.id_kat = '".$tabnya."'";
	}
	
	$sql = "SELECT a.id, a.id_reff, a.ket_id as tabel, a.hit, b.username, a.tgl_post, c.kategori, c.icon, d.judul, d.thumb FROM ".$app[table][berita]." as a LEFT JOIN ".$app[table][pengguna]." as b ON(a.id_user = b.id) LEFT JOIN ".$app[table][berita_kategori]." as c ON(a.id_kat = c.id) LEFT JOIN ".$app[table][berita_bahasa]." as d ON(a.id = d.id_berita) WHERE d.id_bahasa ='".$_SESSION[bhs]."' $tambahan ORDER BY a.tgl_post DESC LIMIT 12";
	$rnews = $dbu->get_recordsetmix($sql);

include "fill/fill_news.php";
}
?>