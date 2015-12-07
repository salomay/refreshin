<?php
	include "../../application.php";
	$appx= new app();
	$dbu = new db();
	$appx->load_lib('url');
	$urlx = new url();
	$dbu->connect();
	if($_POST['komen'] AND $_POST[idc]){
		$komen = strip_tags($_POST[komen]);
		$komen = $appx->badWord($komen);
		$tgl_post = date("Y-m-d H:i:s");
		$idca = explode("_", $_POST[idc]);
		$idc = $idca[1];

		$sql = "INSERT INTO ".$app[table][cekin_komen]." (id_cekin,id_user,komen,tgl_post) VALUES('".$idc."','".$_SESSION[member][id]."','".$komen."','".$tgl_post."')";
	$dbu->qry($sql);
	$idcek = $dbu->lookup("id","cekin_komen","id_user ='".$_SESSION[member][id]."'AND id_cekin='".$idc."' AND tgl_post ='".$tgl_post."' ORDER BY tgl_post desc");
		$sql = "INSERT INTO ".$app[table][pengguna_feed]." (id_user,tabel,id_tabel,keterangan,tgl_post) VALUES('".$_SESSION[member][id]."','".$app[table][cekin_komen]."','".$idcek."','".$cekin[2]."','".$tgl_post."')";
	$dbu->qry($sql);

	$dkomen[nama] = $dbu->lookup("nama","pengguna","id ='".$_SESSION[member][id]."'");
	$dkomen[avatar] = $appx->cekFile("/pengguna/avatar/",$_SESSION[member][ava]);
	$other_avatar = $app[data_www].'/pengguna/avatar/'.$dkomen[avatar];
	$other_linkAva = $app["www"]."/".$dbu->lookup('nama','action',"action='8' and id_bahasa ='".$sBahasa."'")."/".$urlx->shortLink($_SESSION[member][id])."/";
	$fcek_in .='<li>		
				<div class="circle_pict circle_pict_nf"><a href="'.$other_linkAva.'"><img src="'.$other_avatar.'"></a></div>
				<div class="text_box_c">
					<h1>'.$dkomen[nama].'</h1>
					<p>'.$komen.'</p>
				</div>					
			</li>';
	unset($dbu);
	unset($appx);
	echo $fcek_in;
}
?>