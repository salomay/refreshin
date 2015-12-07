<?php
include "../../application.php";

$appx= new app();
$appx->load_lib('url');
$dbu = new db();
$urlx = new url();
$dbu->connect();

$tnt = explode("_",$_POST[cast]);
//print_r($tnt);exit;
$varLoc = $tnt[0];
$limit = $_POST[limit];
$jml = $_POST[jml];
if($varLoc == "prov"){
	#tambah kota sesuai provinsi
	$prop[id] = $tnt[1];
	$sql = "SELECT id, nama , thumb from ".$app[table][kota]." where id_provinsi ='".$prop[id]."'  order by nama asc limit ".$limit.",".$jml;
	$dbu->query($sql,$rskota,$nrkota); 
	$prop[nama] = $dbu->lookup("nama","provinsi","id='".$prop[id]."'");
	$response ='';
	while($kota = $dbu->fetch($rskota)){ 
		if ($kota[thumb]){ 
			$filename = $app['data_path']."/kota/thumb/".$kota[thumb];
			if (!file_exists($filename)) {
				$kota[thumb]="default.jpg"; 
			}
		}else{
			$kota[thumb]="default.jpg";
		}
		$response .='<li>
			<div class="img_box">
				<img src="'.$app[data_www].'/kota/thumb/'.$kota[thumb].'">
			</div>
			<div class="text">
				<h1>'.$kota[nama].'</h1>
				<p>'.$dbu->lookup('deskripsi',$app[table][kota_bahasa],"id_kota ='".$kota[id]."' AND id_bahasa='".$_SESSION[bhs]."'").'</p>									
			</div>
			<a href="'.$app[www]."/".$dbu->lookup('nama','action',"action='2' and id_bahasa='".$_SESSION[bhs]."'")."/id_".$urlx->shortLink($kota[nama])."_".$urlx->shortLink($prop[nama])."/".'"><div class="explore">EXPLORE MORE</div></a>
		</li>';
	}
}elseif($varLoc == "all"){
	if($tnt[1]!=""){
		$ides = str_replace("_", " ", $tnt[1]);
		$ides = str_replace(" ", "%", $ides);
		$ides = " AND b.nama LIKE '%".$ides."%'";
	}
	$sql = "SELECT a.id ,a.id_reff, a.thumb , b.nama FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff )WHERE status='aktif'".$ides." ORDER BY b.nama asc LIMIT ".$limit.",".$jml;
	//echo $sql;exit;
	$destkota = $dbu->get_recordsetmix($sql);
	while($desty = $dbu->fetch($destkota)){ 
	$destinasi = $desty[nama];
	if ($desty[thumb]){ 
			$filename = $app['data_path']."/destinasi/thumb/".$desty[thumb];
			if (!file_exists($filename)) {
				$desty[thumb]="default.jpg"; 
			}
		}else{
			$desty[thumb]="default.jpg";
		}
		$response .= '<li>
						<div class="img_box">

							<img src="'.$app[data_www]."/destinasi/thumb/".$desty[thumb].'">
						</div>
						<div class="text">
							<h1>'.$destinasi.'</h1>
							<p>'.$dbu->lookup('deskripsi',$app[table][destinasi_bahasa],"id_reff ='".$desty[id_reff]."' AND id_bahasa='".$_SESSION[bhs]."'").'</p>									
						</div>
						<a href="'.$app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($destinasi)."/".'"><div class="explore">EXPLORE MORE</div></a>
					</li>';
	}

}elseif($varLoc == "kota"){
	if($tnt[1]!=""){
		$ides = str_replace("_", " ", $tnt[1]);
		$ides = str_replace(" ", "%", $ides);
		$ides = " AND b.nama LIKE '%".$ides."%'";
	}
}
//echo $sql;
unset($dbu);
echo  $response;
?>