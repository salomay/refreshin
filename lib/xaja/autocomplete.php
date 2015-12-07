<?php
include "../../application.php";
$appx= new app();
$dbu = new db();
$urlx = new url();
$dbu->connect();
$hasil="";
if($_POST['keyword']){$keyword = $_POST['keyword'];
    
    $boldy = $keyword;
    $keyword = "'%". $keyword . "%'";
    $sql = "SELECT nama FROM ".$app[table][destinasi_bahasa]." WHERE nama LIKE $keyword and id_bahasa='".$_SESSION[bhs]."'ORDER BY nama";
    //echo $sql;
    
    $dbu->query($sql,$rs,$nr);
    //echo $nr;
    if ($nr){
    		$hasil='<ul id="daftar_destinasi">';
      while($results = $dbu->fetch($rs)){
      	$bold = str_replace($_POST['keyword'], '<span style="font-weight:bold;color:#6475F5;">'.$boldy."</span>", $results[nama]);
      	$hasil.='<li onclick="pilihDestinasi(\''.$results[nama].'\',\''.$app[www]."/".$dbu->lookup('nama','action',"action='21' and id_bahasa='".$_SESSION[bhs]."'")."/".$urlx->shortLink($results[nama])."/".'\')">'.$bold.'</li>';
      }
      	$hasil .="</ul>";
    } 


echo $hasil;
unset($dbu);
unset($appx);
}
?>