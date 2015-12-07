<?php
$stats = new stats();
$dbu = new db();
$appx = new app();
$stats->log_stats($rs_act["nama"], $act, $p_id,$sub,$step, $cat, $status,$tab);
$app['nopage'] = $rs_act["action"];
if($p_id!=""){
	$awal = 0;
	$limitx = 9;
	$xpid="";
	if($sub!=""){
		$xpid = str_replace("page-","",$sub);	
		$awal = ($xpid - 1)* $limitx;
		$limit = "LIMIT ".$awal.", ".$limitx;
	}else{
		header("location:".$app[www]."/".$dbu->lookup('nama','action',"action='41' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($p_id)."/page-1/");
		//exit;
	}
	
	$pid = str_replace("-","%",$p_id);
	$sql = "SELECT a.id, a.judul, a.id_destinasi, a.isi, a.tgl_post, a.tgl_modif as lastUpdate, b.username , b.avatar, b.tgl_post as tgljoin, c.nama as destinasi FROM ".$app[table][forum]." as a LEFT JOIN ".$app[table][pengguna]." as b ON(a.id_user = b.id) LEFT JOIN ".$app[table][destinasi]." as d ON(a.id_destinasi = d.id) LEFT JOIN ".$app[table][destinasi_bahasa]." as c ON(d.id_reff = c.id_reff) WHERE a.judul LIKE '".$pid."' AND c.id_bahasa ='".$_SESSION[bhs]."' AND a.tipe ='article' AND a.status ='aktif'";
	//echo $sql;exit;
	$dfa = $dbu->get_recordmix($sql);
	if($dfa[id]!=""){
		$tglpos = explode(" ",$dfa[tgl_post]);
		$tglpost = $appx->format_date($tglpos[0],$_SESSION[bhs],'N')." | ".$tglpos[1];
		$tgljoin = $appx->format_date($dfa[tgljoin],$_SESSION[bhs],'N');
		$dfa[avatar] = $appx->cekFile("/pengguna/avatar/",$dfa[avatar]);
		$dfa[avatar] = $app[data_www]."/pengguna/avatar/".$dfa[avatar];
		$linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$_SESSION[bhs]."'")."/".$urlx->shortLink($dfa[username])."/";
		$hitJml = $dbu->count_record("SELECT count(id) as jumlah FROM ".$app[table][forum]." WHERE id_user = '".$_SESSION[member][id]."'");
		if (($dfa[lastUpdate] != null)&&($dfa[lastUpdate] != '0000-00-00 00:00:00')){
				$tgledit = explode(" ",$dfa[lastUpdate]);
				$tglEdit = $appx->format_date($tgledit[0],$_SESSION[bhs],'N')." ".$tgledit[1];
                $dfa[lastUpdate] = $tglEdit;
            }else{
                $dfa[lastUpdate] = $tglpost;
            }
           #per page komen -----------------------
            $sql = "SELECT a.id,a.id_komen, a.isi , a.tgl_post, a.tgl_modif as lastUpdate, b.username , b.avatar, b.tgl_post as tgljoin FROM ".$app[table][forum_komen]." as a LEFT JOIN ".$app[table][pengguna]." as b ON(a.id_user = b.id) WHERE a.id_forum = '".$dfa[id]."' AND a.status ='aktif' ORDER BY tgl_post DESC ".$limit;
            //echo $sql; exit;
            $dbu->query($sql,$rkomen,$nkomen);
            #all komen ---------------------------
            $sql = "SELECT count(a.id) FROM ".$app[table][forum_komen]." as a WHERE a.id_forum = '".$dfa[id]."' AND a.status ='aktif' ";
            $hitmax = $dbu->count_record($sql);

		include "fill/fill_thread_article_detail.php";
	}else{
		header("location:".$defaultURL);
	}
}else{
	header("location:".$defaultURL);
}
?>