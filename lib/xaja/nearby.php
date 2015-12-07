<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();
 $appx->load_lib('url');
$uly = new url();
//Get our locations from the database.
$radius = 10000;
// Search the rows in the markers table
$kat ="";
if($_POST[kate]!=""){
	$kat = '%'.str_replace("-","%",$_POST[kate])."%";
	$kat = " WHERE a.id_kat = '".$dbu->lookup("id",$app[table][destinasi_kategori],"kategori LIKE '%".$kat."%'")."'";
}

$lat = $_POST[lat];
$lng = $_POST[lng];
//$alamat = $_POST[alamat];
$urlnya = $dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'");

$query = "SELECT a.website, b.nama as dest, b.slogan, b.alamat, a.pos_lat as lat , a.pos_long as lng, ( 3959 * acos( cos( radians('".$lat."') ) * cos( radians( a.pos_lat ) ) * cos( radians( a.pos_long ) - radians('".$lng."') ) + sin( radians('".$lat."') ) * sin( radians( a.pos_lat ) ) ) ) AS distance, a.thumb, a.icon_map ,LTRIM(' url') as urlc FROM ".$app[table][destinasi]." as a LEFT JOIN ".$app[table][destinasi_bahasa]." as b ON(a.id_reff = b.id_reff) ".$kat." HAVING distance < '".$radius."' ORDER BY distance asc";

$dbu->query($query,$rnear,$hit_near);
$dnear="";
if($hit_near>0){
	$hit = 0;
	while($nea = $dbu->fetch($rnear)){
		$nea[urlc] = $app[www]."/".$urlnya."/".$uly->shortLink($nea[dest])."/";
		$nea[thumb] = $appx->cekFile('/destinasi/thumb/',$nea[thumb],'default.jpg');
		$nea[thumb] = $app[data_www].'/destinasi/thumb/'.$nea[thumb];
		$nea[icon_map] = $appx->cekFile('/destinasi/icon/',$nea[icon_map],'default.png');
		$nea[icon_map] = $app[data_www].'/destinasi/icon/'.$nea[icon_map];
		$dnear[$hit]=$nea;
		$hit++;
	}
}
header('Content-Type: application/json');
echo json_encode($dnear);
?>