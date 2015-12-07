<?php
include "../../application.php";

$appx= new app();
$appx->load_lib('url');
$dbu = new db();
$urlx = new url();
$dbu->connect();

$tnt = explode("|",$_POST[tnt]);
//print_r($tnt);exit;
$app[act] = $tnt[0];
$app[p_id] =  $tnt[1];;
$prop[id]=  $tnt[2];;
$limit = $_POST[awal];

$sql = "SELECT id, nama , thumb from ".$app[table][kota]." where id_provinsi ='".$prop[id]."'  order by nama asc limit ".$limit.",8";
//echo $sql;
$dbu->query($sql,$rskota,$nrkota); 
$response ='';
while($kota = $dbu->fetch($rskota)){ 
	$response .='<li>
		<div class="img_box">
			<img src="'.$app[data_www].'/kota/thumb/'.$kota[thumb].'">
		</div>
		<div class="text">
			<h1>'.$kota[nama].'</h1>
			<p>'.$dbu->lookup('deskripsi',$app[table][kota_bahasa],"id_kota ='".$kota[id]."' AND id_bahasa='".$_SESSION[bhs]."'").'</p>									
		</div>
		<a href="'.$app[www]."/".$app[act]."/".$app[p_id]."/".$urlx->shortLink($kota[nama])."_".$urlx->shortLink($dbu->lookup('nama',"provinsi","id ='".$prop[id]."'"))."/".'"><div class="explore">EXPLORE MORE</div></a>
	</li>';

}
unset($dbu);
echo  $response;
?>