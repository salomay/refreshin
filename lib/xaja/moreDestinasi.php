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
$kota[id]=  $tnt[2];
$bhs= $_SESSION[bhs];
$limit = $_POST[awal];

$p_idx = explode("-",$app[p_id]);
	$p_idcount = count($p_idx);
	$hit = 0;
	$sqlkey_kat="";
	while($hit < $p_idcount){
		$sqlkey_kat .= $p_idx[$hit]."%";
		$hit++;
	}
	$sql = "SELECT id FROM ".$app[table][destinasi_kategori]." WHERE kategori LIKE '".$sqlkey_kat."'";
	$kat = $dbu->get_recordmix($sql);

$sql = "SELECT a.id ,a.id_reff, b.nama,b.deskripsi, a.thumb FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON (a.id_reff = b.id_reff) WHERE a.id_kat='".$kat[id]."' AND id_kota ='".$kota[id]."' AND b.id_bahasa ='".$bhs."'  order by b.nama asc limit ".$limit.",8";
//echo $sql;
$dbu->query($sql,$rskota,$nrkota); 
$response ='';
while($desty = $dbu->fetch($rskota)){ 
	if ($desty[thumb]){ 
			$filename = $app['data_path']."/destinasi/thumb/".$desty[thumb];
		if (!file_exists($filename)) {
			$desty[thumb]="default.jpg"; 
		}
	}else{
		$desty[thumb]="default.jpg";
	}
		
	$response .='<li>
		<div class="img_box">
			<img src="'.$app[data_www].'/destinasi/thumb/'.$desty[thumb].'">
		</div>
		<div class="text">
			<h1>'.$desty[nama].'</h1>
			<p>'.$desty[deskripsi].'</p>									
		</div>
		<a href="'.$app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($desty[nama])."/".'"><div class="explore">EXPLORE MORE</div></a>
	</li>';

}
unset($dbu);
echo  $response;
?>