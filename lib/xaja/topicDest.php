<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$dbu->connect();
if($_POST['keyword']){
$keyword = $_POST['keyword'];
$keyword = "'%". $keyword . "%'";
$sql = "SELECT nama FROM ".$app[table][destinasi_bahasa]." WHERE nama LIKE $keyword and id_bahasa='".$_SESSION[bhs]."'ORDER BY nama";
//echo $sql;
$dbu->query($sql,$rs,$nr);
//echo $nr;
if ($nr){
		$hasil='<ul id="daftar_destinasi">';
  while($results = $dbu->fetch($rs)){
  	$bold = str_replace($_POST['keyword'], '<span style="font-weight:bold;color:#6475F5;">'.$_POST['keyword']."</span>", $results[nama]);
  	//echo $bold+keyword;
  	$hasil.='<li  onclick="topicDest(\''.$results[nama].'\')">'.$bold.'</li>';
  }
  	$hasil .="</ul>";
} 

unset($dbu);
unset($appx);
echo $hasil;
}
?>